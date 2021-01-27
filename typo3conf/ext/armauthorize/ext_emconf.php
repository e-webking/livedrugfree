<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "armauthorize".
 *
 * Auto generated 20-02-2020 15:44
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'AuthorizeNet Payment',
	'description' => 'Online payment with Authorize.net',
	'category' => 'plugin',
	'author' => 'Anisur R Mullick',
	'author_email' => 'anisur.mullick@gmail.com',
	'author_company' => '',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.9.2',
	'constraints' => array(
		'depends' => array(
			'extbase' => '6.2',
			'fluid' => '6.2',
			'typo3' => '6.2-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	)
);
