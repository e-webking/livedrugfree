<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Netkyngs.' . $_EXTKEY,
	'Nkcadportalfe',
	'NK CAD Portal (FE) Plugin'
);

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Netkyngs.' . $_EXTKEY,
		'web',	 // Make module a submodule of 'web'
		'nkcadportalbe',	// Submodule key
		'',						// Position
		array(
			'CustomFrontendUser' => 'list, show, new, create, edit, update, delete','MembershipTemplate' => 'list, show, new, create, edit, update, delete','Membership' => 'list, show, new, create, edit, update, delete','Newslettertype' => 'list','Contact' => 'list, show, new, create, edit, update, delete','Document' => 'list, show','State' => 'list','Reminder' => 'list, show, new, create, edit, update, delete','Report' => 'list, show, new, create, edit, update, delete','Discountcode' => 'list, show, new, create, edit, update, delete',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_nkcadportalbe.xlf',
			'navigationComponentId' => '',
		)
	);

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'NK CAD Portal');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nkcadportal_domain_model_membershiptemplate', 'EXT:nkcadportal/Resources/Private/Language/locallang_csh_tx_nkcadportal_domain_model_membershiptemplate.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nkcadportal_domain_model_membershiptemplate');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nkcadportal_domain_model_membership', 'EXT:nkcadportal/Resources/Private/Language/locallang_csh_tx_nkcadportal_domain_model_membership.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nkcadportal_domain_model_membership');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nkcadportal_domain_model_newslettertype', 'EXT:nkcadportal/Resources/Private/Language/locallang_csh_tx_nkcadportal_domain_model_newslettertype.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nkcadportal_domain_model_newslettertype');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nkcadportal_domain_model_newsletter', 'EXT:nkcadportal/Resources/Private/Language/locallang_csh_tx_nkcadportal_domain_model_newsletter.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nkcadportal_domain_model_newsletter');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nkcadportal_domain_model_contact', 'EXT:nkcadportal/Resources/Private/Language/locallang_csh_tx_nkcadportal_domain_model_contact.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nkcadportal_domain_model_contact');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nkcadportal_domain_model_document', 'EXT:nkcadportal/Resources/Private/Language/locallang_csh_tx_nkcadportal_domain_model_document.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nkcadportal_domain_model_document');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nkcadportal_domain_model_state', 'EXT:nkcadportal/Resources/Private/Language/locallang_csh_tx_nkcadportal_domain_model_state.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nkcadportal_domain_model_state');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nkcadportal_domain_model_reminder', 'EXT:nkcadportal/Resources/Private/Language/locallang_csh_tx_nkcadportal_domain_model_reminder.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nkcadportal_domain_model_reminder');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nkcadportal_domain_model_report', 'EXT:nkcadportal/Resources/Private/Language/locallang_csh_tx_nkcadportal_domain_model_report.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nkcadportal_domain_model_report');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nkcadportal_domain_model_discountcode', 'EXT:nkcadportal/Resources/Private/Language/locallang_csh_tx_nkcadportal_domain_model_discountcode.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nkcadportal_domain_model_discountcode');

$pluginSignature = str_replace('_', '', $_EXTKEY) . '_nkcadportalfe';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');


//$TCA['tx_nkcadportal_domain_model_contact']['ctrl']['hideTable'] = 1;
#$TCA['tx_nkcadportal_domain_model_membership']['ctrl']['hideTable'] = 1;