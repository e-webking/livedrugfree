<?php
namespace Netkyngs\Nkcadportal\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * 
 */
class DocLinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    
    /**
     * @param int $document
     * @return string
     */
    public function render($document) {
        
        $return = '';
        
        $foreign = 'sys_file_reference';
        $local = 'tx_nkcadportal_domain_model_document';
        
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($foreign);
        $expr = $queryBuilder->expr();
        
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder->select('foreign.uid_local')
            ->from($foreign, 'foreign')
            ->innerJoin('foreign', $local, 'local', $expr->eq('foreign.uid_foreign','local.uid'))
            ->where(
                $expr->eq('local.uid', $document),
                $expr->eq('foreign.deleted', 0),
                $expr->eq('foreign.hidden', 0),
                $expr->eq('foreign.tablenames', $queryBuilder->createNamedParameter($local)),
                $expr->eq('foreign.fieldname', $queryBuilder->createNamedParameter('file'))
            )
            ->execute()
            ->fetchAll();
        
        if (count($rows) > 0) {
            
            $fdata = $rows[0];
            $resFac = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
            $fileObj = $resFac->getFileObject($fdata['uid_local']);
            
            if (!is_null($fileObj)) {
                
                $url = $fileObj->getPublicUrl();
                $fname = $fileObj->getName();
                
                $return = '<a href="/index.php?id=36&action=serve-download&filepath='. $url .'&friendlyfilename='. $fname.'">'.$fname.'</a>';
            }
        }
        
        return $return;
    }
}
