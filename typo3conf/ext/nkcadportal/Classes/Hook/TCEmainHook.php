<?php
namespace Netkyngs\Nkcadportal\Hook;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

class TCEmainHook {
    
    public function processCmdmap_postProcess($command, $table, $id, $value, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {}
    
    public function processCmdmap_preProcess($command, $table, $id, $value, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {}
    public function processDatamap_preProcessFieldArray(array &$fieldArray, $table, $id, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {
    
        if ($table == 'tx_nkcadportal_domain_model_membership') {
            $muid = intval($fieldArray['membershiptemplate']);
            if ($muid > 0) {
                $mshipTpl = 'tx_nkcadportal_domain_model_membershiptemplate';
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($mshipTpl);
                $queryBuilder->getRestrictions()->removeAll();
                $expr = $queryBuilder->expr();

                $dbMmTplRw = $queryBuilder->select('description','term')
                                ->from($mshipTpl)
                                ->where(
                                        $expr->eq('uid', $muid)
                                )->execute()->fetchAll();
                $fieldArray['mtitle'] = $dbMmTplRw[0]['description'];
                $fieldArray['term'] = $dbMmTplRw[0]['term'];
            }
        }
    }
    public function processCmdmap_deleteAction($table, $id, $recordToDelete, $recordWasDeleted=NULL, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {}
    public function processDatamap_afterAllOperations(\TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {}
    public function processDatamap_postProcessFieldArray($status, $table, $id, array &$fieldArray, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {}
    public function processDatamap_afterDatabaseOperations($status, $table, $id, array $fieldArray, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {
        if ($table == 'tx_nkcadportal_domain_model_membership') {
            $muid = intval($fieldArray['membershiptemplate']);
            if ($muid > 0) {
                $mshipTpl = 'tx_nkcadportal_domain_model_membershiptemplate';
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($mshipTpl);
                $queryBuilder->getRestrictions()->removeAll();
                $expr = $queryBuilder->expr();

                $dbMmTplRw = $queryBuilder->select('description','term')
                                ->from($mshipTpl)
                                ->where(
                                        $expr->eq('uid', $muid)
                                )->execute()->fetchAll();
                $fieldArray['mtitle'] = $dbMmTplRw[0]['description'];
                $fieldArray['term'] = $dbMmTplRw[0]['term'];
                GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_nkcadportal_domain_model_membership')
                    ->update(
                        'tx_nkcadportal_domain_model_membership',
                        [ 'mtitle' => $fieldArray['mtitle'], 'term'=> $fieldArray['term'] ],
                        [ 'uid' => $id ]
                    );
                
               // $fieldArray['endtimecustom'] = strtotime("+".$dbMmTplRw[0]['term']." year", mktime(0, 0, 1, $dateArr[0], $dateArr[1], $dateArr[2]));
            }
        }
    }

}