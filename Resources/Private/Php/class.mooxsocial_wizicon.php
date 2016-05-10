<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2014 Dominic Martin <dm@dcn.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
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
 * Add news extension to the wizard in page module
 *
 * @package TYPO3
 * @subpackage tx_mooxsocial
 */
class mooxsocial_wizicon {

	const KEY = 'moox_social';

	/**
	 * Processing the wizard items array
	 *
	 * @param array $wizardItems The wizard items
	 * @return array array with wizard items
	 */
	public function proc($wizardItems) {
		$wizardItems['plugins_tx_' . self::KEY . 'pi1'] = array(
			'icon'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath(self::KEY) . 'ext_icon.svg',
			'title'			=> $GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_be.xml:pi1_title'),
			'description'	=> $GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_be.xml:pi1_plus_wiz_description'),
			'params'		=> '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=mooxsocial_pi1'
		);
		$wizardItems['plugins_tx_' . self::KEY . 'pi2'] = array(
			'icon'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath(self::KEY) . 'ext_icon.svg',
			'title'			=> $GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_be.xml:pi2_title'),
			'description'	=> $GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_be.xml:pi2_plus_wiz_description'),
			'params'		=> '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=mooxsocial_pi2'
		);
		$wizardItems['plugins_tx_' . self::KEY . 'pi3'] = array(
			'icon'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath(self::KEY) . 'ext_icon.svg',
			'title'			=> $GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_be.xml:pi3_title'),
			'description'	=> $GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_be.xml:pi3_plus_wiz_description'),
			'params'		=> '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=mooxsocial_pi3'
		);
		$wizardItems['plugins_tx_' . self::KEY . 'pi4'] = array(
			'icon'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath(self::KEY) . 'ext_icon.svg',
			'title'			=> $GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_be.xml:pi4_title'),
			'description'	=> $GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_be.xml:pi4_plus_wiz_description'),
			'params'		=> '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=mooxsocial_pi4'
		);
		$wizardItems['plugins_tx_' . self::KEY . 'pi5'] = array(
			'icon'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath(self::KEY) . 'ext_icon.svg',
			'title'			=> $GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_be.xml:pi5_title'),
			'description'	=> $GLOBALS['LANG']->sL('LLL:EXT:moox_social/Resources/Private/Language/locallang_be.xml:pi5_plus_wiz_description'),
			'params'		=> '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=mooxsocial_pi5'
		);

		return $wizardItems;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/moox_social/Resources/Private/Php/class.mooxsocial_wizicon.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/moox_social/Resources/Private/Php/class.mooxsocial_wizicon.php']);
}
