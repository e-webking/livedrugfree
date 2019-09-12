<?php

return [
    'nkcadportal_members' => [
        'path' => '/nkcadportal/members',
        'access' => 'public',
        'target' => \Netkyngs\Nkcadportal\Controller\CustomFrontendUserController::class . '::getMembersAction'
    ],
    'nkcadportal_membership' => [
        'path' => '/nkcadportal/membership',
        'access' => 'public',
        'target' => \Netkyngs\Nkcadportal\Controller\CustomFrontendUserController::class . '::getMembershipAction'
    ],
    'nkcadportal_newsletter' => [
        'path' => '/nkcadportal/newsletter',
        'access' => 'public',
        'target' => \Netkyngs\Nkcadportal\Controller\CustomFrontendUserController::class . '::getNewsletterAction'
    ],
    'nkcadportal_document' => [
        'path' => '/nkcadportal/document',
        'access' => 'public',
        'target' => \Netkyngs\Nkcadportal\Controller\CustomFrontendUserController::class . '::getDocumentAction'
    ],
    'nkcadportal_reminder' => [
        'path' => '/nkcadportal/reminder',
        'access' => 'public',
        'target' => \Netkyngs\Nkcadportal\Controller\CustomFrontendUserController::class . '::getReminderAction'
    ],
    'nkcadportal_report' => [
        'path' => '/nkcadportal/report',
        'access' => 'public',
        'target' => \Netkyngs\Nkcadportal\Controller\CustomFrontendUserController::class . '::getReportAction'
    ],
    'nkcadportal_discount' => [
        'path' => '/nkcadportal/discount',
        'access' => 'public',
        'target' => \Netkyngs\Nkcadportal\Controller\CustomFrontendUserController::class . '::getDiscountAction'
    ]
];

