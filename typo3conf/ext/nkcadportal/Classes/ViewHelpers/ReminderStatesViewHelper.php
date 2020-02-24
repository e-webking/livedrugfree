<?php
namespace Netkyngs\Nkcadportal\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * 
 */
class ReminderStatesViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    
    /**
     * @param int $reminder
     * @return string
     */
    public function render($reminder) {
        
        $return = '';
        
        $foreign = 'tx_nkcadportal_domain_model_state';
        $mm = 'tx_nkcadportal_reminder_state_mm';
        $local = 'tx_nkcadportal_domain_model_reminder';
        
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($foreign);
        $expr = $queryBuilder->expr();
        
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder->select('foreign.state')
            ->from($foreign, 'foreign')
            ->innerJoin('foreign', $mm, 'mm', $expr->eq('foreign.uid','mm.uid_foreign'))
            ->innerJoin('mm', $local, 'local', $expr->eq('mm.uid_local', 'local.uid'))
            ->where(
                $expr->eq('local.uid', $reminder)
            )
            ->execute()
            ->fetchAll();
        if (count($rows) > 0) {
            foreach ($rows as $ndata) {
                 $return .= $ndata['state'].', ';
            }
            
            $return = substr($return, 0, -2);
        }
        
        return $return;
    }
}
