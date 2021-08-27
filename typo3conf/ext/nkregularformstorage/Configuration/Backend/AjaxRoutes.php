<?php

return [
    'nkregularformstorage_payments' => [
        'path' => '/nkregularformstorage/payments',
        'access' => 'public',
        'target' => \Netkyngs\Nkregularformstorage\Controller\FormresultController::class . '::getPaymentAction'
    ],
    'nkregularformstorage_printinv' => [
        'path' => '/nkregularformstorage/printinv',
        'access' => 'public',
        'target' => \Netkyngs\Nkregularformstorage\Controller\FormresultController::class . '::printInvoiceBeAction'
    ],
    'nkregularformstorage_download' => [
        'path' => '/nkregularformstorage/download',
        'access' => 'public',
        'target' => \Netkyngs\Nkregularformstorage\Controller\FormresultController::class . '::downloadFileAction'
    ]
];

