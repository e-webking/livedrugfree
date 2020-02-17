<?php
namespace Netkyngs\Nkcadportal\Domain\Repository;

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
 * The repository for Documents
 */
class DocumentRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );
	
    
    /**
     * 
     * @param array $usergroups
     * @return @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByUsergroups ($usergroups){

        $query = $this->createQuery();
        $constraints = [];
        $constraints[] = $query->in('groups.uid', $usergroups);
        $query->matching(
            $query->logicalAnd(
                $constraints
            )
        );
        
	/*
        //Create usergroup constraints:
        $groupConstraints = [];
        foreach($usergroups as $usergroup){
                $query->logicalOr(
                        $groupConstraints[] = $query->contains('groups', $usergroup)
                );
        }
		
        //Apply filtering
		$query->matching(
			$query->logicalAnd(
				$groupConstraints
			)
		);
        */
        //Execute and return query:
        return $query->execute();
    }

}