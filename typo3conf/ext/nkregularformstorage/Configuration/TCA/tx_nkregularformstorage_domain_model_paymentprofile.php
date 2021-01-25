<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:nkregularformstorage/Resources/Private/Language/locallang_db.xlf:tx_nkregularformstorage_domain_model_paymentprofile',
		'label' => 'feuser',
                'label_alt' => 'cusprofile,payprofile',
                'label_alt_force' => TRUE,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => FALSE,
		'versioningWS' => 0,
		'versioning_followPages' => FALSE,

		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),
		'searchFields' => 'feuser,cusprofile,payprofile,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('nkregularformstorage') . 'Resources/Public/Icons/tx_nkregularformstorage_domain_model_paymentprofile.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, feuser, cusprofile, payprofile, card',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, feuser, cusprofile, payprofile, card'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'cusprofile' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nkregularformstorage/Resources/Private/Language/locallang_db.xlf:tx_nkregularformstorage_domain_model_paymentprofile.cusprofile',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'int',
                                'readOnly' => 1,
			),
		),
		'payprofile' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nkregularformstorage/Resources/Private/Language/locallang_db.xlf:tx_nkregularformstorage_domain_model_paymentprofile.payprofile',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'int',
                                'readOnly' => 1,
			),
		),
		'feuser' => array(
			'exclude' => 1,
			'label' => 'FE User Uid',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'fe_users',
				'foreign_table_where' => 'ORDER BY fe_users.company',
                                'readOnly' => 1,
			),
		),
		'card' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nkregularformstorage/Resources/Private/Language/locallang_db.xlf:tx_nkregularformstorage_domain_model_paymentprofile.card',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
                                'readOnly' => 1,
			),
		),
		
	),
);