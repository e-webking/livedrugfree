<?php
namespace Netkyngs\Nkregularformstorage\Domain\Repository;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2020 Roel Krottje <roel@netkyngs.com>, Netkyngs
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * The repository for Paymentprofile
 */
class PaymentprofileRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    
    /**
     * 
     * @param int $feuser
     * @param int $cusprofile
     * @param string $card
     * @param string $email
     * @return \Netkyngs\Nkregularformstorage\Domain\Model\Paymentprofile
     */
    public function getProfile($feuser, $cusprofile, $card, $email=NULL) {
        
        $query = $this->createQuery();
        
        $constraints = array();
        $constraints[] = $query->equals('feuser', $feuser);
        $constraints[] = $query->equals('cusprofile', $cusprofile);
        $constraints[] = $query->equals('card', md5($card));
        if (!is_null($email)) {
             $constraints[] = $query->equals('email', $email);
        }
        
        $query->matching(
            $query->logicalAnd($constraints)
        );
        
        return $query->execute()->getFirst();
    }
    
    /**
     * 
     * @param int $paymentprof
     */
    public function getProfileByPay($paymentprof) {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd($query->equals('payprofile', $paymentprof))
        );
        
        return $query->execute()->getFirst();
    }
}