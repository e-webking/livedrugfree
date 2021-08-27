<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_invoice',
		'label' => 'customfrontenduser',
                'label_alt' => 'payment',
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
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'customfrontenduser,membership,payment,invoicenum,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('nkcadportal') . 'Resources/Public/Icons/tx_nkcadportal_domain_model_contact.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, customfrontenduser, membership, payment, invoicenum, invoicedata, t6uid',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, customfrontenduser, membership, payment, invoicenum, invoicedata, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, starttime, endtime, invoicedata, t6uid'),
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
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
                'customfrontenduser' => array(
                        'exclude' => 0,
			'label' => 'Company (Member)',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'fe_users',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'membership' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_invoice.membership',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'payment' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_invoice.payment',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int'
			),
		),
		'invoicenum' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_invoice.invoicenum',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'int'
			),
		),
		'invoicedata' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_invoice.invoicedata',
			'config' => array(
				'type' => 'text',
                                'readOnly' => true
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
	),
);