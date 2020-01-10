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

/*
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'fe_users',
	$GLOBALS['TCA']['fe_users']['ctrl']['type'],
	'',
	'after:' . $GLOBALS['TCA']['fe_users']['ctrl']['label']
);
*/

$tmp_nkcadportal_columns = array(
	'fein' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser.fein',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim,required'
		),
	),
	'numberofemployees' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser.numberofemployees',
		'config' => array(
			'type' => 'input',
			'size' => 4,
			'eval' => 'int'
		)
	),
	'numberofcdldrivers' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser.numberofcdldrivers',
		'config' => array(
			'type' => 'input',
			'size' => 4,
			'eval' => 'int'
		)
	),
	'businesstype' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser.businesstype',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'additionaladdress' => array(
		'exclude' => 0,
		'label' => 'Billing Address ',
		'config' => array(
			'type' => 'text',
			'cols' => 20,
			'rows' => 3,
			'eval' => 'trim'
		),
	),
	'county' => array(
		'exclude' => 0,
		'label' => 'County',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'insurancecarrier' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser.insurancecarrier',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'cellphone' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser.cellphone',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'state' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser.state',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'insuranceagent' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser.insuranceagent',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'hearaboutus' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser.hearaboutus',
		'config' => array(
			'type' => 'select',
			'renderType' => 'selectSingle',
			'items' => array(
				array('Insurance Company','INSURANCE COMPANY'),
				array('Mailer', 'MAILER'),
				array('Drug Free Workplace Help Website', 'Drug Free Workplace Help Website'),
				array('Referral', 'REFERRAL'),
				array('Phone Solicitation', 'Phone Solicitation'),
				array('Postcard', 'POSTCARD'),
				array('Web', 'WEB'),
				array('Renewal', 'Renewal'),
				array('Chuck', 'Chuck'),
				array('Karen', 'Karen'),
				array('Noy', 'Noy'),
				array('Staci', 'Staci'),
				array('Chamber', 'Chamber'),
				array('Other', 'OTHER'),
			),
			'size' => 1,
			'maxitems' => 1,
			'eval' => ''
		),
	),
	'staffcomments' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser.staffcomments',
		'config' => array(
			'type' => 'text',
			'cols' => 40,
			'rows' => 15,
			'eval' => 'trim'
		)
	),
	'membercomments' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser.membercomments',
		'config' => array(
			'type' => 'text',
			'cols' => 40,
			'rows' => 15,
			'eval' => 'trim'
		)
	),
	'memberships' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser.memberships',
		'config' => array(
			'type' => 'inline',
			'foreign_table' => 'tx_nkcadportal_domain_model_membership',
			'foreign_field' => 'customfrontenduser',
			'foreign_sortby' => 'sorting',
			'maxitems' => 9999,
			'appearance' => array(
				'collapseAll' => 1,
				'levelLinksPosition' => 'top',
				'showSynchronizationLink' => 1,
				'showPossibleLocalizationRecords' => 1,
				'useSortable' => 1,
				'showAllLocalizationLink' => 1
			),
		),

	),
	'contacts' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser.contacts',
		'config' => array(
			'type' => 'inline',
			'foreign_table' => 'tx_nkcadportal_domain_model_contact',
			'foreign_field' => 'customfrontenduser',
			'foreign_sortby' => 'sorting',
			'maxitems' => 9999,
			'appearance' => array(
				'collapseAll' => 1,
				'levelLinksPosition' => 'top',
				'showSynchronizationLink' => 1,
				'showPossibleLocalizationRecords' => 1,
				'useSortable' => 1,
				'showAllLocalizationLink' => 1
			),
		),

	),
        't6uid' => array(
		'exclude' => 0,
		'label' => 'Old T6 UID',
		'config' => array(
			'type' => 'input',
			'size' => 10,
			'eval' => 'int',
                        'readOnly' => true
		),
	),
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tmp_nkcadportal_columns);



/* inherit and extend the show items from the parent class */

if(isset($GLOBALS['TCA']['fe_users']['types']['0']['showitem'])) {
	$GLOBALS['TCA']['fe_users']['types']['Tx_Nkcadportal_CustomFrontendUser']['showitem'] = $GLOBALS['TCA']['fe_users']['types']['0']['showitem'];
} elseif(is_array($GLOBALS['TCA']['fe_users']['types'])) {
	// use first entry in types array
	$fe_users_type_definition = reset($GLOBALS['TCA']['fe_users']['types']);
	$GLOBALS['TCA']['fe_users']['types']['Tx_Nkcadportal_CustomFrontendUser']['showitem'] = $fe_users_type_definition['showitem'];
} else {
	$GLOBALS['TCA']['fe_users']['types']['Tx_Nkcadportal_CustomFrontendUser']['showitem'] = '';
}

#$GLOBALS['TCA']['fe_users']['types']['Tx_Nkcadportal_CustomFrontendUser']['showitem'] .= ',--div--;LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_customfrontenduser,';
#$GLOBALS['TCA']['fe_users']['types']['Tx_Nkcadportal_CustomFrontendUser']['showitem'] .= 'cellphone, state, fein, numberofemployees, numberofcdldrivers, businesstype, insurancecarrier, insuranceagent, hearaboutus, staffcomments, membercomments, memberships, contacts';

$GLOBALS['TCA']['fe_users']['columns'][$GLOBALS['TCA']['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_Nkcadportal_CustomFrontendUser','Tx_Nkcadportal_CustomFrontendUser');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
	'',
	'EXT:/Resources/Private/Language/locallang_csh_.xlf'
);


# PALLETS:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
        'fe_users',
        'employees',
        'numberofemployees,numberofcdldrivers,fein',
        ''
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
        'fe_users',
        'insurance',
        'insurancecarrier,insuranceagent',
        ''
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
        'fe_users',
        'references',
        'hearaboutus',
        ''
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'fe_users',
	'--div--;Business Info;;;;1-1-1,businesstype,--palette--;;employees,--palette--;;insurance,--palette--;;references',
	'',
	'after:www'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'fe_users',
	'--div--;Membership;;;;1-1-1,memberships',
	'',
	''
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'fe_users',
	'--div--;Contacts;;;;1-1-1,contacts',
	'',
	''
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'fe_users',
	'--div--;Comments;;;;1-1-1,membercomments,staffcomments',
	'',
	''
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'fe_users',
	'additionaladdress',
	'',
	'after:address'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'fe_users',
	'cellphone',
	'',
	'after:telephone'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'fe_users',
	'state,county,t6uid',
	'',
	'after:city'
);

