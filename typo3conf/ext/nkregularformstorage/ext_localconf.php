<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.'); 
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Netkyngs.' . $_EXTKEY,
	'Nkregularformstoragefe',
	array(
		'Formresult' => 'process',
		
	),
	// non-cacheable actions
	array(
		'Formresult' => 'process',
		
	)
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['Netkyngs\\Nkcadportal\\Domain\\Model\\CustomFrontendUser'] = array(
   'className' => 'Netkyngs\\Nkregularformstorage\\Domain\\Model\\CustomFrontendUser'
);