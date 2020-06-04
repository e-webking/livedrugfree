<?php

if (!isset($GLOBALS['TCA']['fe_users']['ctrl']['type'])) {
	if (file_exists($GLOBALS['TCA']['fe_users']['ctrl']['dynamicConfigFile'])) {
		require_once($GLOBALS['TCA']['fe_users']['ctrl']['dynamicConfigFile']);
	}
	// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
	$GLOBALS['TCA']['fe_users']['ctrl']['type'] = 'tx_extbase_type';
	$tempColumnstx_nkcadportal_fe_users = array();
	$tempColumnstx_nkcadportal_fe_users[$GLOBALS['TCA']['fe_users']['ctrl']['type']] = array(
		'exclude' => 1,
		'label'   => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal.tx_extbase_type',
		'config' => array(
			'type' => 'select',
			'renderType' => 'selectSingle',
			'items' => array(
				array('CustomFrontendUser','Tx_Nkcadportal_CustomFrontendUser')
			),
			'default' => 'Tx_Nkcadportal_CustomFrontendUser',
			'size' => 1,
			'maxitems' => 1,
		)
	);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $tempColumnstx_nkcadportal_fe_users, 1);
}

$tmp_nkauthorize_columns = array(
	'authorize_customer_profile' => array(
		'exclude' => 0,
		'label' => 'Authorize.net Customer Profile',
		'config' => array(
			'type' => 'input',
			'size' => 20,
			'eval' => 'trim'
		),
	),
	'authorize_payment_profile' => array(
		'exclude' => 0,
		'label' => 'Authorize.net Payment Profile',
		'config' => array(
			'type' => 'input',
			'size' => 20,
			'eval' => 'trim'
		)
	),
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tmp_nkauthorize_columns);
/*
 * No need to show them in membership tab
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
        'fe_users',
        'tacess',
        'starttime, endtime--linebreak--,authorize_customer_profile, authorize_payment_profile',
        ''
);

 */