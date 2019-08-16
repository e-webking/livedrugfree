<?php
namespace Netkyngs\Nkcadportal\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * 
 */
class MembershipExpiredViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    
    /**
     * @param DateTime $date
     * @return bool
     */
    public function render(\DateTime $date) {
        
        $now = new \DateTime("now");
        $interval = $now->diff($date);
        
        return $interval->format('%R%m') < 0;
       
    }
}
