<?php
namespace DCNGmbH\MooxSocial\Tasks;

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

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;

/**
 * Include Twitter API Tools
 */
require_once \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('moox_social','Classes/Twitter/TwitterAPIExchange.php');

/**
 * Include Twitter Repository
 */
//require_once \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('moox_social','Classes/Domain/Repository/Twitter.php');

/**
 * Get Twitter posts
 *
 * @package moox_social
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class TwitterGetTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

	/**
	 * Sicherheitszeitraum f�r Zeit�berschneidungen w�hrend der zyklischen Ausf�hrung des Tasks
	 *
	 * @var integer
	 */
	public $intervalBuffer = 86400;

	/**
	 * PID der Seite/Ordner in dem die Posts dieses Tasks gespeichert werden sollen
	 *
	 * @var integer
	 */
	public $pid;

	/**
	 * OAUTH_ACCESS_TOKEN Ihrer Twitter Anwendung
	 *
	 * @var string
	 */
	public $oauthAccessToken;

	/**
	 * OAUTH_ACCESS_TOKEN_SECRET Ihrer Twitter Anwendung
	 *
	 * @var string
	 */
	public $oauthAccessTokenSecret;

	/**
	 * CONSUMER_KEY Ihrer Twitter Anwendung
	 *
	 * @var string
	 */
	public $consumerKey;

	/**
	 * CONSUMER_KEY_SECRET Ihrer Twitter Anwendung
	 *
	 * @var string
	 */
	public $consumerKeySecret;

	/**
	 * SCREEN_NAME Ihrer Twitter Timeline
	 *
	 * @var string
	 */
	public $screenName;

	/**
	 * flash message service
	 *
	 * @var \TYPO3\CMS\Core\Messaging\FlashMessageService
	 */
	public $flashMessageService;

	/**
	 * Works through the indexing queue and indexes the queued items into Solr.
	 *
	 * @return	boolean	Returns TRUE on success, FALSE if no items were indexed or none were found.
	 * @see	typo3/sysext/scheduler/tx_scheduler_Task#execute()
	 */
	public function execute() {

		$objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
		$flashMessageService = $objectManager->get(FlashMessageService::class);
		$flashMessageQueue = $flashMessageService->getMessageQueueByIdentifier();


		// Get the extensions's configuration
		$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['moox_social']);
		if($extConf['debugEmailSenderName']==""){
			$extConf['debugEmailSenderName'] = $extConf['debugEmailSenderAddress'];
		}
		if($this->email==""){
			$this->email = $extConf['debugEmailReceiverAddress'];
		}

		$executionSucceeded = FALSE;

		if(!$this->pid){
			$this->pid = 0;
		}

		if($this->oauthAccessToken!="" && $this->oauthAccessTokenSecret!="" && $this->consumerKey!="" && $this->consumerKeySecret!="" && $this->screenName!=""){

			$execution 	= $this->getExecution();
			$interval 	= $execution->getInterval();
			$time 		= time();
			$to			= $time;
			$from		= ($time-$interval-$this->intervalBuffer);

			try {
				if (!$twitterController instanceof \DCNGmbH\MooxSocial\Controller\TwitterController) {
					$twitterController = $objectManager->get('DCNGmbH\\MooxSocial\\Controller\\TwitterController');
				}
				$rawFeed = $twitterController->twitter($this->oauthAccessToken,$this->oauthAccessTokenSecret,$this->consumerKey,$this->consumerKeySecret,$this->screenName,'');
				$executionSucceeded = TRUE;
			} catch (\Exception $e) {
				$message = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
					$GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_scheduler.xlf:tx_mooxsocial_tasks_twittergettask.api_execution_error')." [". $e->getMessage()."]",
					 '',
					 FlashMessage::ERROR,
					 TRUE
				);
				$flashMessageQueue->addMessage($message);
				if($this->email && $extConf['debugEmailSenderAddress']){
					$lockfile = $_SERVER['DOCUMENT_ROOT']."/typo3temp/.lock-email-task-".md5($this->oauthAccessToken.$this->oauthAccessTokenSecret.$this->consumerKey.$this->consumerKeySecret.$this->screenName);
					if(file_exists($lockfile)){
						$lockfiletime = filemtime($lockfile);
						if($lockfiletime<(time()-86400)){
							unlink($lockfile);
						}
					}
					if(!file_exists($lockfile)){
						$message = (new \TYPO3\CMS\Core\Mail\MailMessage())
									->setFrom(array($extConf['debugEmailSenderAddress'] => $extConf['debugEmailSenderName']))
									->setTo(array($this->email => $this->email))
									->setSubject($GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_scheduler.xlf:tx_mooxsocial_tasks_twittergettask.api_error_mailsubject'))
									->setBody('ERROR: while requesting [oauth access token: '.$this->oauthAccessToken.' | oauth access token secret: '.$this->oauthAccessTokenSecret.' | consumer key: '.$this->consumerKey.' | consumer key secret: '.$this->consumerKeySecret.' | screen_name: '.$this->screenName."]");
									$message->send();
						touch($lockfile);
					}
				}
			}

			$posts 		= array();
			$postIds 	= array();

			foreach($rawFeed as $item) {

				if(!in_array($item['id'],$postIds)){

					$postIds[] 				= $item['id'];
					$postId 				= $item['id'];

					$item['postId'] 		= $postId;
					$item['screen_name'] 	= $item['user']['screen_name'];
					$item['pid'] 			= $this->pid;

					if (!$twitterController instanceof \DCNGmbH\MooxSocial\Controller\TwitterController) {
						$twitterController = $objectManager->get('DCNGmbH\\MooxSocial\\Controller\\TwitterController');
					}
					$post 					= $twitterController->twitterPost($item);

					if(is_array($post)){
						$posts[] 			= $post;
					}
				}

			}

			if(count($posts)){

				$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
				$twitterRepository = $objectManager->get('DCNGmbH\\MooxSocial\\Domain\\Repository\\TwitterRepository');

				$insertCnt = 0;
				$updateCnt = 0;

				foreach($posts AS $post){

					$twitterPost		= $twitterRepository->findOneByApiUid($post['apiUid'],$this->pid);

					if(!($twitterPost instanceof \DCNGmbH\MooxSocial\Domain\Model\Twitter)){
						$twitterPost = new \DCNGmbH\MooxSocial\Domain\Model\Twitter;
						$action	= "insert";
					}

					if($action=="insert"){
						$twitterPost->setPid($post['pid']);
						$twitterPost->setCreated($post['created']);
					}

					$twitterPost->setUpdated($post['updated']);
					$twitterPost->setType($post['type']);
					$twitterPost->setStatusType($post['statusType']);

					if($action=="insert"){
						$twitterPost->setPage($post['page']);
						$twitterPost->setModel("twitter");
					}

					$twitterPost->setAction($post['action']);
					$twitterPost->setTitle($post['title']);
					$twitterPost->setSummary($post['summary']);
					$twitterPost->setText($post['text']);
					$twitterPost->setAuthor($post['author']);
					$twitterPost->setAuthorId($post['authorId']);
					$twitterPost->setDescription($post['description']);
					$twitterPost->setCaption($post['caption']);
					$twitterPost->setUrl($post['url']);
					$twitterPost->setLinkName($post['linkName']);
					$twitterPost->setLinkUrl($post['linkUrl']);
					$twitterPost->setImageUrl($post['imageUrl']);
					$twitterPost->setImageEmbedcode($post['imageEmbedcode']);
					$twitterPost->setVideoUrl($post['videoUrl']);
					$twitterPost->setVideoEmbedcode($post['videoEmbedcode']);
					$twitterPost->setSharedUrl($post['sharedUrl']);
					$twitterPost->setSharedTitle($post['sharedTitle']);
					$twitterPost->setSharedDescription($post['sharedDescription']);
					$twitterPost->setSharedCaption($post['sharedCaption']);
					$twitterPost->setLikes($post['likes']);
					$twitterPost->setShares($post['shares']);
					$twitterPost->setComments($post['comments']);

					if($action=="insert"){
						$twitterPost->setApiUid($post['apiUid']);
					}

					$twitterPost->setApiHash($post['apiHash']);

					if($action=="insert"){
						$twitterRepository->add($twitterPost);
						$insertCnt++;
					} else {
						$twitterRepository->update($twitterPost);
						$updateCnt++;
					}
				}

				$objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface')->persistAll();

				$message = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
					$insertCnt." neue Tweets geladen | ".$updateCnt." bestehende Tweets aktualisiert",
					 '',
					 FlashMessage::OK,
					 TRUE
				);
				$flashMessageQueue->addMessage($message);
			} else {
				$message = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
					 "Keine neuen oder aktualisierten Tweets gefunden",
					 '',
					 FlashMessage::OK,
					 TRUE
				);
				$flashMessageQueue->addMessage($message);
			}
		}

		return $executionSucceeded;
	}

	/**
	 * This method returns the sleep duration as additional information
	 *
	 * @return string Information to display
	 */
	public function getAdditionalInformation() {
		$info = $GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_scheduler.xlf:tx_mooxsocial_tasks_twittergettask.pid_label') . ': ' . $this->pid;
		$info .= " | ".$GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_scheduler.xlf:tx_mooxsocial_tasks_twittergettask.screen_name_label') . ': ' . $this->screenName;
		if($this->email){
			$info .= " | ".$GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_scheduler.xlf:tx_mooxsocial_tasks_twittergettask.email_label') . ': ' . $this->email;
		}
		$detailInfo  = " | ".$GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_scheduler.xlf:tx_mooxsocial_tasks_twittergettask.oauth_access_token_label') . ': ' . $this->oauthAccessToken;
		$detailInfo .= " | ".$GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_scheduler.xlf:tx_mooxsocial_tasks_twittergettask.oauth_access_token_secret_label') . ': ' . $this->oauthAccessTokenSecret;
		$detailInfo .= " | ".$GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_scheduler.xlf:tx_mooxsocial_tasks_twittergettask.consumer_key_label') . ': ' . $this->consumerKey;
		$detailInfo .= " | ".$GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_scheduler.xlf:tx_mooxsocial_tasks_twittergettask.consumer_key_secret_label') . ': ' . $this->consumerKeySecret;

		return $info;
	}

	/**
	 * Returns the pid
	 *
	 * @return integer
	 */
	public function getPid() {
		return $this->pid;
	}

	/**
	 * Set the pid
	 *
	 * @param integer $pid pid
	 * @return void
	 */
	public function setPid($pid) {
		$this->pid = $pid;
	}

	/**
	 * Returns the oauth access token
	 *
	 * @return string
	 */
	public function getOauthAccessToken() {
		return $this->oauthAccessToken;
	}

	/**
	 * Set the oauth access token
	 *
	 * @param string $oauthAccessToken oauth access token
	 * @return void
	 */
	public function setOauthAccessToken($oauthAccessToken) {
		$this->oauthAccessToken = $oauthAccessToken;
	}

	/**
	 * Returns the oauth access token secret
	 *
	 * @return string
	 */
	public function getOauthAccessTokenSecret() {
		return $this->oauthAccessTokenSecret;
	}

	/**
	 * Set the oauth access token secret
	 *
	 * @param string $oauthAccessTokenSecret oauth access token secret
	 * @return void
	 */
	public function setOauthAccessTokenSecret($oauthAccessTokenSecret) {
		$this->oauthAccessTokenSecret = $oauthAccessTokenSecret;
	}

	/**
	 * Returns the consumer key
	 *
	 * @return string
	 */
	public function getConsumerKey() {
		return $this->consumerKey;
	}

	/**
	 * Set the consumer key
	 *
	 * @param string $consumerKey consumer key
	 * @return void
	 */
	public function setConsumerKey($consumerKey) {
		$this->consumerKey = $consumerKey;
	}

	/**
	 * Returns the consumer key secret
	 *
	 * @return string
	 */
	public function getConsumerKeySecret() {
		return $this->consumerKeySecret;
	}

	/**
	 * Set the consumer key secret
	 *
	 * @param string $consumerKeySecret consumer key secret
	 * @return void
	 */
	public function setConsumerKeySecret($consumerKeySecret) {
		$this->consumerKeySecret = $consumerKeySecret;
	}

	/**
	 * Returns the screen name
	 *
	 * @return string
	 */
	public function getScreenName() {
		return $this->screenName;
	}

	/**
	 * Set the screen name
	 *
	 * @param string $screenName screen name
	 * @return void
	 */
	public function setScreenName($screenName) {
		$this->screenName = $screenName;
	}

	/**
	 * Returns the page id
	 *
	 * @return string
	 */
	public function getPageId() {
		return $this->pageId;
	}

	/**
	 * Set the page id
	 *
	 * @param string $pageId page id
	 * @return void
	 */
	public function setPageId($pageId) {
		$this->pageId = $pageId;
	}
}
?>