<?php
return array(
	'ctrl' => array(
		'title'	=> 'Pre-Transaction Log',
		'label' => 'cardno',
                'label_alt' => 'amount,feuser',
                'label_alt_force' => TRUE,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => FALSE,
		'versioningWS' => 0,
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),
                'default_sortby' => 'uid DESC',
                'readOnly' => TRUE,
		'searchFields' => 'cardno,feuser,amount,form,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('nkregularformstorage') . 'Resources/Public/Icons/tx_nkregularformstorage_domain_model_formresult.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, cardno, feuser, amount, form',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, feuser, cardno, amount, form'),
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
		
		'amount' => array(
			'exclude' => 1,
			'label' => 'Amount',
			'config' => array(
				'type' => 'input',
				'size' => 10,
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
		'feuser' => array(
			'exclude' => 1,
			'label' => 'FE User Uid',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
                                'foreign_table' => 'fe_users',
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
	),
);