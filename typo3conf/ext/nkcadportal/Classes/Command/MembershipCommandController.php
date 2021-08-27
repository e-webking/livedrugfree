<?php
namespace Netkyngs\Nkcadportal\Command;
/***************************************************************
 *  Copyright notice
*
*  (c) 2020
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
 *
 *
 * @package typo3
 * @subpackage nkcadportal
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
*
*/
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

class MembershipCommandController 
    extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {
    
	/**
	 * @var \TYPO3\CMS\Extbase\Mvc\Cli\CommandManager
	 */
	protected $commandManager;

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
	 * @inject
	 */
	protected $configurationManager;

        /**
	 * @param \TYPO3\CMS\Extbase\Mvc\Cli\CommandManager $commandManager
	 * @return void
	 */
	public function injectCommandManager(\TYPO3\CMS\Extbase\Mvc\Cli\CommandManager $commandManager) {
		$this->commandManager = $commandManager;
	}

	public function processCommand() {
            
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nkcadportal_domain_model_membership');
            $queryBuilder->getRestrictions()->removeAll();
            $expr = $queryBuilder->expr();
            $rows =  $queryBuilder->select('uid','membershiptemplate')
                        ->from('tx_nkcadportal_domain_model_membership')
                        ->where(
                            $expr->eq('deleted', 0)
                        )->execute()->fetchAll();
            
            foreach ($rows as $row) {
                 $this->setTermsTitle($row);
            }
           
	}
        
        /**
         * 
         * @param array $row
         */
        protected function setTermsTitle($row) {
            
            $mtpl = $row['membershiptemplate'];
            
            if ($mtpl > 0) {
                
                $mshipTpl = 'tx_nkcadportal_domain_model_membershiptemplate';
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($mshipTpl);
                $queryBuilder->getRestrictions()->removeAll();
                $expr = $queryBuilder->expr();

                $dbMmTplRw = $queryBuilder->select('description','term')
                                ->from($mshipTpl)
                                ->where(
                                        $expr->eq('uid', $mtpl)
                                )->execute()->fetchAll();
                $fieldArray['mtitle'] = $dbMmTplRw[0]['description'];
                $fieldArray['term'] = $dbMmTplRw[0]['term'];
                
                GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_nkcadportal_domain_model_membership')
                    ->update(
                        'tx_nkcadportal_domain_model_membership',
                        [ 'mtitle' => $fieldArray['mtitle'], 'term'=> $fieldArray['term'] ],
                        [ 'uid' => $row['uid'] ]
                    );
            }
        }
}
