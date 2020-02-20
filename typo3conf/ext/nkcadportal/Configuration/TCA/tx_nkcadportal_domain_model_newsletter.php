<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_newsletter',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
                'default_sortby' => 'forperiod DESC',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,file,forperiod,newslettertype,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('nkcadportal') . 'Resources/Public/Icons/tx_nkcadportal_domain_model_newsletter.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, title, forperiod, newslettertype, file, t6uid',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, title, forperiod, newslettertype, file, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, starttime, endtime, t6uid'),
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
				'foreign_table' => 'tx_nkcadportal_domain_model_newsletter',
				'foreign_table_where' => 'AND tx_nkcadportal_domain_model_newsletter.pid=###CURRENT_PID### AND tx_nkcadportal_domain_model_newsletter.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
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
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_newsletter.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'file' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_newsletter.file',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'file',
				array(
					'appearance' => array(
						'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:media.addFileReference'
					),
					'foreign_types' => array(
						'0' => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						)
					),
					'maxitems' => 1,
					'minitems' => 1
				)
			),
		),
		'forperiod' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_newsletter.forperiod',
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
		'newslettertype' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:nkcadportal/Resources/Private/Language/locallang_db.xlf:tx_nkcadportal_domain_model_newsletter.newslettertype',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_nkcadportal_domain_model_newslettertype',
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