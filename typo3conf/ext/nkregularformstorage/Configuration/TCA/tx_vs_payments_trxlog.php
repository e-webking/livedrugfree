<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:nkregularformstorage/Resources/Private/Language/locallang_db.xlf:tx_vs_payments_trxlog',
		'label' => 'amount',
                'label_alt' => 'invoiceno,cardno,cardholder',
                'label_alt_force' => true,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 0,
		'versioning_followPages' => FALSE,
                'readOnly' => true,
		'delete' => 'deleted',
		'enablecolumns' => array(
                    'disabled' => 'hidden',
		),
		'searchFields' => 'refid,profileid,amount,cardno,cardholder,address,city,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('nkregularformstorage') . 'Resources/Public/Icons/tx_nkregularformstorage_domain_model_formresult.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'success, trxtype, status, refid, authcode, profileid, message, rawresult, amount, cardno, expires, csc, description, invoiceno, cardholder, address, city, state, zip',
	),
	'types' => array(
		'1' => array('showitem' => 'invoiceno, amount, cardno, success, trxtype, status, refid, authcode, cardholder, csc, address, city, state, zip, description,--div--;Additional Data, profileid, message, rawresult'),
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
		'success' => array(
			'exclude' => 1,
			'label' => 'Payment Status',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('Incomplete/Failed', 0),
                                        array('Successfull', 1),
				),
			),
		),
                'trxtype' => array(
			'exclude' => 1,
			'label' => 'Transaction type',
			'config' => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'trim'
			),
		),
                'status' => array(
			'exclude' => 1,
			'label' => 'Status',
			'config' => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'trim'
			),
		),
                'refid' => array(
			'exclude' => 1,
			'label' => 'Ref. ID',
			'config' => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'trim'
			),
		),
                'authcode' => array(
			'exclude' => 1,
			'label' => 'Auth Code',
			'config' => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'trim'
			),
		),
		'message' => array(
			'exclude' => 1,
			'label' => 'Message',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'rawresult' => array(
			'exclude' => 1,
			'label' => 'Raw log',
			'config' => array(
				'type' => 'text'
			),
		),
		'amount' => array(
			'exclude' => 1,
			'label' => 'Amount',
			'config' => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'float'
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
                'expires'=> array(
			'exclude' => 1,
			'label' => 'Expiry',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim'
			),
		),
                'csc'=> array(
			'exclude' => 1,
			'label' => 'CVV',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim'
			),
		),
		'invoiceno' => array(
			'exclude' => 1,
			'label' => 'Invoice No',
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
		'cardholder' => array(
			'exclude' => 1,
			'label' => 'Card holder',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim'
			),
		),
		'address' => array(
			'exclude' => 1,
			'label' => 'Address',
			'config' => array(
				'type' => 'input',
				'size' => 30
			),
		),
		'city' => array(
			'exclude' => 1,
			'label' => 'City',
			'config' => array(
				'type' => 'input',
				'size' => 15
			),
		),
                'state' => array(
			'exclude' => 1,
			'label' => 'State',
			'config' => array(
				'type' => 'input',
				'size' => 5
			),
		),
                'zip' => array(
			'exclude' => 1,
			'label' => 'Zip',
			'config' => array(
				'type' => 'input',
				'size' => 10
			),
		),
		
	),
);