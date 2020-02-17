<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "nkregularformstorage"
 *
 * Auto generated by Extension Builder 2017-05-10
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
    'title' => 'NK Regular Form Storage',
    'description' => 'Enables the storing of form data with regular TYPO3 forms',
    'category' => 'plugin',
    'author' => 'Roel Krottje',
    'author_email' => 'roel@netkyngs.com',
    'state' => 'alpha',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.1.0',
    'constraints' => array(
            'depends' => array(
                    'typo3' => '7.6.0-8.7.99',
                    'nkcadportal' => '0.0.0'
            ),
            'conflicts' => array(
            ),
            'suggests' => array(
            ),
    ),
);