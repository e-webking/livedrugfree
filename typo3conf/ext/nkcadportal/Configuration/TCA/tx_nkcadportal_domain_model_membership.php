<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_membership',
                'label'=> 'state',
		'label_alt' => 'endtimecustom',
                'label_alt_force' => true,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
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
		'searchFields' => 'customfrontenduser,state,mtitle,membershiptype,price,t6uid,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('nkcadportal') . 'Resources/Public/Icons/tx_nkcadportal_domain_model_membership.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, membershiptemplate, customfrontenduser, state, mtitle, membershiptype, price, term, t6uid',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, mtitle, membershiptemplate, customfrontenduser,--palette--;;mtype,--palette--;;mdates, state,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, starttime, endtime, t6uid'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
                'mtype' => array('showitem' => 'membershiptype,price,term'),
                'mdates' => array('showitem' => 'starttimecustom,endtimecustom,--linebreak--,statestarttimecustom, stateendtimecustom'),
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
				'foreign_table' => 'tx_nkcadportal_domain_model_membership',
				'foreign_table_where' => 'AND tx_nkcadportal_domain_model_membership.pid=###CURRENT_PID### AND tx_nkcadportal_domain_model_membership.sys_language_uid IN (-1,0)',
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
			'label' => 'Start',
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
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'End',
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
		
		'starttimecustom' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'Purchased',
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
		'endtimecustom' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'Expire',
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
		'statestarttimecustom' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'State Certified',
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
		'stateendtimecustom' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'State Expire',
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
		'membershiptemplate' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_membership.membershiptemplate',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_nkcadportal_domain_model_membershiptemplate',
				'minitems' => 1,
				'maxitems' => 1,
			),
		),
		'state' => array(
			'exclude' => 0,
			'label' => 'Assistance in',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_nkcadportal_domain_model_state',
				'minitems' => 1,
				'maxitems' => 1,
			),
		),
		'mtitle' => array(
			'exclude' => 0,
			'label' => 'Title / Heading',
			'config' => array(
				'type' => 'input',
                                /*'renderType' => 'hidden',*/
				'size' => 50,
				'eval' => 'trim',
                                'readOnly' => true
			),
		),
                'membershiptype' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_membershiptemplate.membershiptype',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'fe_groups',
				'minitems' => 1,
				'maxitems' => 1,
			),
		),
                'price' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_membershiptemplate.price',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'double2,required'
			)
		),
		'term' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_membershiptemplate.term',
			'config' => array(
				'type' => 'input',
				'size' => 2,
				'eval' => 'int,required'
			)
		),
		'customfrontenduser' => array(
                        'exclude' => 0,
			'label' => 'Company',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'fe_users',
				'minitems' => 0,
				'maxitems' => 1,
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