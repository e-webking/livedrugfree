<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Netkyngs.' . $_EXTKEY,
	'Nkcadportalfe',
	array(
		'CustomFrontendUser' => 'list, show, new, create, edit, update, delete, ajaxbe, certdwn',
		'MembershipTemplate' => 'list, show, new, create, edit, update, delete',
		'Membership' => 'list, show, new, create, edit, update, delete',
		'Newslettertype' => 'list',
		'Newsletter' => 'list',
		'Contact' => 'list, show, new, create, edit, update, delete, dwfregistrationform, dotregistrationform, donationform',
		'Document' => 'list, show',
		'State' => 'list',
		'Reminder' => 'list, show, new, create, edit, update, delete',
		'Report' => 'list, show, new, create, edit, update, delete',
		'Discountcode' => 'list, show, new, create, edit, update, delete',
		
	),
	// non-cacheable actions
	array(
		'CustomFrontendUser' => 'create, update, delete, ajaxbe, certdwn',
		'MembershipTemplate' => 'create, update, delete',
		'Membership' => 'create, update, delete',
		'Newslettertype' => '',
		'Newsletter' => '',
		'Contact' => 'create, update, delete, dwfregistrationform, dotregistrationform, donationform',
		'Document' => '',
		'State' => '',
		'Reminder' => 'create, update, delete',
		'Report' => 'create, update, delete',
		'Discountcode' => 'create, update, delete',
		
	)
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1581921537] = [
    'nodeName' => 'usDate',
    'priority' => 40,
    'class' => \Netkyngs\Nkcadportal\Form\Element\UsDateElement::class,
];

if (TYPO3_MODE === 'BE') {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][$_EXTKEY.'_reminder'] =
        \Netkyngs\Nkcadportal\Command\ReminderCommandController::class;
}