<?php
namespace Netkyngs\Nkcadportal\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2018 Roel Krottje <roel@netkyngs.com>, Netkyngs
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
 * The repository for Newsletters
 */
class NewsletterRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    
    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'starttime' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );
    
    /**
     * Ignore storage pid
     */
    public function initializeObject() {

        /**
         * @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings
         */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);
        $querySettings->setIgnoreEnableFields(TRUE);
        $this->setDefaultQuerySettings($querySettings);
    }

    
    public function findByNewslettertypes ($aNewslettertypes){

		//Set query:
        $query = $this->createQuery();
		
		//Create usergroup constraints:
		$constraints = [];
		foreach($aNewslettertypes as $newslettertype){
			$constraints[] = $query->equals('newslettertype', $newslettertype);
		}
		
        //Apply filtering
		$query->matching(
			$query->logicalOr(
				$constraints
			)
		);

        //Execute and return query:
        return $query->execute();
	}
}