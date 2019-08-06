<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:nkregularformstorage/Resources/Private/Language/locallang_db.xlf:tx_nkregularformstorage_domain_model_formresult',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,email,form,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('nkregularformstorage') . 'Resources/Public/Icons/tx_nkregularformstorage_domain_model_formresult.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, email, trxid, feuseruid, trxamount, invoiceid, cardno, customtstamp, ptype, pstatus, description, form, formserialized',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, email, feuseruid, ptype, trxid, trxamount, cardno, invoiceid, pstatus, customtstamp, description, form, formserialized, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_nkregularformstorage_domain_model_formresult',
				'foreign_table_where' => 'AND tx_nkregularformstorage_domain_model_formresult.pid=###CURRENT_PID### AND tx_nkregularformstorage_domain_model_formresult.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
	
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

		'name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nkregularformstorage/Resources/Private/Language/locallang_db.xlf:tx_nkregularformstorage_domain_model_formresult.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'email' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nkregularformstorage/Resources/Private/Language/locallang_db.xlf:tx_nkregularformstorage_domain_model_formresult.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'trxid' => array(
			'exclude' => 1,
			'label' => 'Transaction ID',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
                'cardno' => array(
			'exclude' => 1,
			'label' => 'Credit Card',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'customtstamp' => array(
			'exclude' => 1,
			'label' => 'Custom Timestamp',
			'config' => array(
				'type' => 'input',
				'size' => 5,
				'eval' => 'trim,int'
			),
		),
		'feuseruid' => array(
			'exclude' => 1,
			'label' => 'FE User Uid',
			'config' => array(
				'type' => 'input',
				'size' => 1,
				'eval' => 'trim,int'
			),
		),
		'ptype' => array(
			'exclude' => 1,
			'label' => 'Payment Mode',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('Credit Card', 0),
                                        array('Invoice', 1),
				),
			),
		),
		'pstatus' => array(
			'exclude' => 1,
			'label' => 'Payment Status',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('Pending', 0),
                                        array('Paid', 1),
                                        array('Failed', -1),
				),
			),
		),
		'trxamount' => array(
			'exclude' => 1,
			'label' => 'Paid Amount',
			'config' => array(
				'type' => 'input',
				'size' => 5,
				'eval' => 'trim'
			),
		),
		'invoiceid' => array(
			'exclude' => 1,
			'label' => 'Invoice ID',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim'
			),
		),
                'description' => array(
			'exclude' => 1,
			'label' => 'Description',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'form' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nkregularformstorage/Resources/Private/Language/locallang_db.xlf:tx_nkregularformstorage_domain_model_formresult.form',
			'config' => array(
				'type' => 'text',
				'size' => 30,
				'rows' => 10,
				'eval' => 'trim'
			),
		),
		'formserialized' => array(
			'exclude' => 1,
			'label' => 'Form (serialized array)',
			'config' => array(
				'type' => 'text',
				'size' => 30,
				'rows' => 10,
				'eval' => 'trim'
			),
		),
		
		
	),
);