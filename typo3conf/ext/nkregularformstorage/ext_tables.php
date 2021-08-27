<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Netkyngs.' . $_EXTKEY,
    'Nkregularformstoragefe',
    'NK Regular Form Storage FE Plugin'
);

if (TYPO3_MODE === 'BE') {
    /**
     * Registers a Backend Module
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Netkyngs.' . $_EXTKEY,
        'web',	 // Make module a submodule of 'web'
        'nkregularformstoragebe', // Submodule key
        '',	// Position
        array(
            'Formresult' => 'txnlist, chargecard, fetchdetail, capturepay, deleteAuthorizeProfile, confirmDelete, deleteProfile'
        ),
        array(
            'access' => 'user,group',
            'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_nkregularformstoragebe.xlf',
            'navigationComponentId' => '',
        )
    );
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'NK Regular Form Storage');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nkregularformstorage_domain_model_formresult', 'EXT:nkregularformstorage/Resources/Private/Language/locallang_csh_tx_nkregularformstorage_domain_model_formresult.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nkregularformstorage_domain_model_formresult');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_vs_payments_trxlog', 'EXT:nkregularformstorage/Resources/Private/Language/locallang_csh_tx_vs_payments_trxlog.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_vs_payments_trxlog');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nkregularformstorage_domain_model_paymentprofile', 'EXT:nkregularformstorage/Resources/Private/Language/locallang_csh_tx_nkregularformstorage_domain_model_paymentprofile.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nkregularformstorage_domain_model_paymentprofile');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nkregularformstorage_domain_model_log', 'EXT:nkregularformstorage/Resources/Private/Language/locallang_csh_tx_nkregularformstorage_domain_model_log.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nkregularformstorage_domain_model_log');
