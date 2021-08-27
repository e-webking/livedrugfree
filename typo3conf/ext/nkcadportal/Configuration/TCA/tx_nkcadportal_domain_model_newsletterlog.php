<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_newsletterlog',
		'label' => 'email',
                'label_alt' => 'newsletter,sdate',
                'label_alt_force' => true,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 0,
		'versioning_followPages' => FALSE,
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),
		'searchFields' => 'email,newsletter,sdate,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('nkcadportal') . 'Resources/Public/Icons/tx_nkcadportal_domain_model_newsletter.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, newsletter, sdate, email',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, newsletter, email, sdate, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access'),
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
		'sdate' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_newsletterlog.sdate',
			'config' => array(
				'type' => 'input',
                                'renderType' => 'usDate',
                                'placeholder' => 'mm/dd/yyyy',
                                'eval' => 'date',
                                'format' => 'm/d/Y',
                                'max' => 20,
				'size' => 13,
				'checkbox' => 0,
				'default' => 0,
			),
		),
		'email' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_newsletterlog.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'newsletter' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_newsletterlog.newsletter',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_nkcadportal_domain_model_newsletter',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'tstamp' => [
		  'label' => 'tstamp',
		  'config' => [
		   'type' => 'passthrough',
		  ]
		],
	),
);