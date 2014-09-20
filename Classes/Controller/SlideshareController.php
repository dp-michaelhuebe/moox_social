<?php
namespace TYPO3\MooxSocial\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Dominic Martin <dm@dcn.de>, DCN GmbH
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package moox_social
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class SlideshareController extends \TYPO3\MooxSocial\Controller\PostController {

	/**
	 * slideshareRepository
	 *
	 * @var \TYPO3\MooxSocial\Domain\Repository\SlideshareRepository
	 * @inject
	 */
	protected $slideshareRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		
		if($this->settings['use_ajax']){
			$this->settings['limit'] = $this->settings['ajax_limit'];
		}
		
		if(!$this->settings['sort_by']){
			$this->settings['sort_by'] = "updated";
		}
		
		if(!$this->settings['sort_direction']){
			$this->settings['sort_direction'] = "DESC";
		}
		
		if(!$this->settings['limit']){
			$this->settings['limit'] = 25;
		}
		
		if($this->settings['source']=="api"){
			
			// Get the extensions's configuration
			$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['moox_social']);
			if($this->settings['api_slideshare_key']==""){
				$this->settings['api_slideshare_key'] = $extConf['fallbackSlideshareApiKey'];
			}
			if($this->settings['api_slideshare_secret_key']==""){
				$this->settings['api_slideshare_secret_key'] = $extConf['fallbackSlideshareApiSecretKey'];
			}
			
			if($this->settings['api_slideshare_key']!="" && $this->settings['api_slideshare_secret_key']!=""){
				
				$posts = $this->slideshareRepository->requestAllBySettings($this->settings);				
			}
			
		} else {
		
			$count 	= $this->slideshareRepository->findAll($this->settings['user_id'])->count();

			$posts 	= $this->slideshareRepository->findAllBySettings($this->settings);
		}
		
		$this->view->assign('currentpid', $GLOBALS['TSFE']->id);
		$this->view->assign('posts', $posts);
		$this->view->assign('count', $count);
		$pages = array();
		for($i=1;$i<=ceil($count/$this->settings['limit']);$i++){
			$pages[] = array("id" => $i, "offset" => (($i-1)*$this->settings['limit']));
		}
		$this->view->assign('pages', $pages);
		$this->view->assign('pagesCount', count($pages));
		$this->view->assign('maxOffset', (($i-2)*$this->settings['limit']));
		
	}
	
	/**
	 * action listAjax
	 *
	 * @return void
	 */
	public function listAjaxAction() {
				
		if(!$this->settings['sort_by']){
			$this->settings['sort_by'] = "updated";
		}
		
		if(!$this->settings['sort_direction']){
			$this->settings['sort_direction'] = "DESC";
		}
		
		if(!$this->settings['limit']){
			$this->settings['limit'] = 25;
		}
		
		if($this->request->hasArgument('perrequest')){			
			$this->settings['limit'] = $this->request->getArgument('perrequest');				
		}
		
		if($this->request->hasArgument('offset')){			
			$this->settings['offset'] = $this->request->getArgument('offset');			
		}
		
		if($this->request->hasArgument('source')){			
			$this->settings['source'] = $this->request->getArgument('source');				
		}	

		if($this->request->hasArgument('page')){			
			$this->settings['api_page_id'] = $this->request->getArgument('page');				
		}
				
		if($this->settings['source']=="api"){
			
			// Get the extensions's configuration
			$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['moox_social']);		
			if($this->settings['api_slideshare_key']==""){
				$this->settings['api_slideshare_key'] = $extConf['fallbackSlideshareApiKey'];
			}
			if($this->settings['api_slideshare_secret_key']==""){
				$this->settings['api_slideshare_secret_key'] = $extConf['fallbackSlideshareApiSecretKey'];
			}
                        
			if($this->settings['api_slideshare_key']!="" && $this->settings['api_slideshare_secret_key']!=""){
				
				$posts = $this->slideshareRepository->requestAllBySettings($this->settings);				
			}								
						
		} else {
		
			$posts 	= $this->slideshareRepository->findAllBySettings($this->settings);
		}
		
		$this->view->assign('currentpid', $GLOBALS['TSFE']->id);
		$this->view->assign('posts', $posts);		
	}

	/**
	 * action show
	 *
	 * @param \TYPO3\MooxSocial\Domain\Model\Slideshare $slideshare
	 * @return void
	 */
	public function showAction(\TYPO3\MooxSocial\Domain\Model\Slideshare $slideshare = NULL) {				
		
		if(!$slideshare && $this->settings['source']!="api"){
			$slideshare	= $this->slideshareRepository->findRandomOne($this->settings['user_id']);
			$this->view->assign('israndom', TRUE);			
		}
		
		$this->view->assign('slideshare', $slideshare);
	}
	
	/**
	 * execute slideshare api request
	 *
	 * @param string $apiKey
	 * @param string $apiSecretKey
	 * @param string $userId
	 * @param string $request
	 * @return array feedData
	 */
	public function slideshare($apiKey,$apiSecretKey,$userId) {
		$rawFeed = array();
		
		// Get the extensions's configuration
		$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['moox_social']);
		if($apiKey==""){
			$apiKey = $extConf['fallbackSlideshareApiKey'];
		}
		if($apiSecretKey==""){
			$apiSecretKey = $extConf['fallbackSlideshareApiSecretKey'];
		}

		if($apiKey!="" && $apiSecretKey!="" && $userId!=""){
			
			$config = array(
				'api_key' => $apiKey,
				'api_secret_key' => $apiSecretKey,
				'user_id' => $userId,
				'allowSignedRequest' => false
			);
                        
                        $key = $apiKey;
                        $secret = $apiSecretKey;
                        $apiurl='https://www.slideshare.net/api/2/';
                        $call = 'get_slideshows_by_user';
                        $params = '&username_for='.$userId.'&offset=0&limit=450';
                        $ts = time();
                        $hash = sha1($secret.$ts);
                        
                        $slideshare = file_get_contents($apiurl.$call."?api_key=$key&ts=$ts&hash=$hash".$params);
                        
                        $parser = xml_parser_create();
                        xml_parse_into_struct($parser, $slideshare, $values, $tags);
                        xml_parser_free($parser);
                        foreach ($tags as $key=>$val) {
                                if(strtoupper($key) == "SLIDESHARESERVICEERROR") {
                                        $finarr[0]["Error"]="true";
                                        $finarr[0]["Message"]=$values[$tags["MESSAGE"][0]]["value"];
                                        return $finarr;
                                }     
                                if ((strtolower($key) != "slideshow") &&  (strtolower($key) != "slideshows") && (strtolower($key) != "slideshowdeleted") && (strtolower($key) != "slideshowuploaded") && (strtolower($key) != "tags")  && (strtolower($key) != "group") && (strtolower($key) != "name") && (strtolower($key) != "count") && (strtolower($key) != "user")) {
                        for($i = 0;$i < count($val);$i++) {
                              $finarr[$i][$key]=$values[$val[$i]]["value"];
                        }
                                }
                                else {
                                        continue;
                                }
                        }
			
			$rawFeed = $finarr;
		}
		return $rawFeed;
	}

	/**
	 * prepare slideshare post
	 *
	 * @param array $item	
	 * @return array post
	 */
	public function slidesharePost($item) {
		
		if(is_array($item)){
			
			$post = array();	
					
			$post['pid'] 				= $item['pid'];
			$post['created'] 			= strtotime($item['CREATED']);
			$post['updated'] 			= strtotime($item['UPDATED']);
			$post['type'] 				= "slideshow";
			$post['statusType'] 			= $item['STATUS'];
			$post['page'] 				= $item['userId'];
			$post['action'] 			= "";	// no match				
			$post['summary'] 			= "";	// no match
			$post['title'] 				= $item['TITLE'];
			$post['description'] 			= $item['DESCRIPTION'];
			$post['caption'] 			= "";   // no match
			$post['text'] 				= "";	// no match
			$post['sharedUrl'] 			= "";	// no match
			$post['sharedTitle'] 			= "";	// no match
			$post['sharedCaption'] 			= "";	// no match
			$post['author'] 			= "";	// no match
			$post['authorId'] 			= "";	// no match
			$post['url'] 				= $item['URL'];
			$post['linkName'] 			= $item['FORMAT'];	
			$post['linkUrl'] 			= $item['DOWNLOADURL'];	
			$post['imageUrl'] 			= $item['THUMBNAILURL'];
			//$post['imageEmbedcode'] 		= $item['EMBED'];	
			$post['videoUrl'] 			= "";	// no match
			$post['videoEmbedcode'] 		= "";	// no match				
			$post['likes'] 				= "";   // no match
			$post['shares'] 			= ""; 	// no match
			$post['comments'] 			= "";   // no match
			$post['apiUid'] 			= $item['id'];		
			$post['apiHash'] 			= md5(print_r($post,TRUE));
						
			return $post;
			
		} else {
		
			return false;
		}
	}
}
?>