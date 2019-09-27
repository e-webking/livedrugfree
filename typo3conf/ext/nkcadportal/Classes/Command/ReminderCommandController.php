<?php
namespace Netkyngs\Nkcadportal\Command;
/***************************************************************
 *  Copyright notice
*
*  (c) 2019
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

class ReminderCommandController 
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
            
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nkcadportal_domain_model_reminder');
            $queryBuilder->getRestrictions()->removeAll();
            $expr = $queryBuilder->expr();
            $rows =  $queryBuilder->select('uid','daysspan','whentosend','fieldcondition','sendtogroup','subject','message','starttime','endtime')
                        ->from('tx_nkcadportal_domain_model_reminder')
                        ->where(
                            $expr->eq('deleted', 0),
                            $expr->eq('hidden', 0)
                            /* $expr->eq('uid', 1) */
                        )->execute()->fetchAll();
            
            foreach ($rows as $row) {
                 $this->classifyReminder($row);
            }
           
	}
        
        /**
         * 
         * @param array $row
         */
        protected function classifyReminder($row) {
            
            $type = $row['fieldcondition'];
            
            switch ($type) {
                case 'membershipexpire':
                    $this->membershipExpiryReminders($row);
                    break;
                case 'statecertexpire':
                    $this->stateExpiryReminders($row);
                    break;
                case 'newsletterstartdate':
                    $this->newsletterReminders($row);
                    break;
            }
            
        }
        
        /**
         * 
         * @param array $data
         */
        protected function newsletterReminders($data) {
            
            $days = $data['daysspan'];
            $whentosend = $data['whentosend'];
            $mType = $data['sendtogroup'];
            $date = $this->determineDate($days, $whentosend);
            $today = date("d-m-Y");
            $activeTimestampArr = $this->convertDate($today);
            
            $grpUid = $this->getGroupUidByTitle($mType);
            //now get the membership templates
            $memTplArr = $this->getMembershipTemplatesByGrp($grpUid);
            
            if (count($memTplArr) > 0) {
                
                foreach ($memTplArr as $mtpluid) {
                    // Find the newletter type
                    $nlTypeArr = $this->getNewsletterTypeByMmtpl($mtpluid);
                    
                    if (count($nlTypeArr) > 0) {
                        //get all the newsletter within the date
                        foreach ($nlTypeArr as $nltypuid) {
                            
                            //Check whether there is newsletter for this date
                            $flag = $this->checkNewsLetter($nltypuid, $date);
                            
                            if ($flag) {   
                                $this->macroProcessNewsletter($data, $mType, $mtpluid, $activeTimestampArr);
                            }
                        }
                    }
                }
            }
        }
        
        /**
         * 
         * @param array $data
         * @param int $grpuid
         * @param int $mtpluid
         * @param array $activeTimestampArr
         */
        protected function macroProcessNewsletter($data, $grpuid, $mtpluid, $activeTimestampArr)
        {
            //Get all the active members of this membership
            //Check the states where the newsletter goes out
            if ($data['states'] !=  "-2") {
                $statesUidArr = $this->getStatesUid($data['uid']);
            }

            //now get all the membership that has the state and this memshiptemplate
            $foreign = 'fe_users';
            $local = 'tx_nkcadportal_domain_model_membership';
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($foreign);
            $queryBuilder->getRestrictions()->removeAll();
            $expr = $queryBuilder->expr();
            $andCond = $queryBuilder->expr()->andx();
            $andCond->add($expr->eq('foreign.deleted', 0));
            $andCond->add($expr->eq('foreign.disable', 0));
            $andCond->add($expr->eq('local.deleted', 0));
            $andCond->add($expr->eq('local.hidden', 0));
            $andCond->add($expr->eq('local.membershiptemplate',  $mtpluid));
            $andCond->add($expr->lt('local.starttimecustom', $activeTimestampArr[0]));
            $andCond->add($expr->gt('local.endtimecustom', $activeTimestampArr[1]));

            // Only send to these states
            if ($statesUidArr > 0) {
                $andCond->add($expr->in('local.state',  $statesUidArr));
            }

            $qbReady = $queryBuilder->select('foreign.uid', 'email','first_name', 'last_name')
                        ->from($foreign, 'foreign')
                        ->innerJoin('foreign', $local, 'local', $expr->eq('foreign.uid','local.customfrontenduser'))
                        ->andWhere($andCond);

            //echo __LINE__.':DEBUG:' . $queryBuilder->getSQL().'<br>';

            $rows = $qbReady->execute()->fetchAll();

            if (count($rows) > 0) {

                foreach ($rows as $row) {
                    //get all the contact
                    $this->sendMail($row['email'], $row['first_name'].' '.$row['last_name'], $data['subject'], $data['message']);
                    $contacts = $this->getContactRecords($row['uid'], $grpuid);

                    if (is_array($contacts) && isset($contacts)) {
                        if (count($contacts) > 0) {
                            foreach ($contacts as $contact) {
                                 $this->sendMail($contact['email'], $contact['firstname'].' '.$contact['lastname'], $data['subject'], $data['message']);
                            }
                        }
                    }
                }           

            }
        }

        /**
         * 
         * @param array $data
         */
        protected function stateExpiryReminders($data)
        {
            $days = $data['daysspan'];
            $whentosend = $data['whentosend'];
            $mType = $data['sendtogroup'];
            $date = $this->determineDate($days, $whentosend);
            $timestampArr = $this->convertDate($date);
            $grpUid = $this->getGroupUidByTitle($mType);
            //now get the membership templates
            $memTplArr = $this->getMembershipTemplatesByGrp($grpUid);
            
            //echo "Membership templates: ";
            //var_dump($memTplArr);
            //echo "States: ";
            if ($data['states'] !=  "-2") {
                $statesUidArr = $this->getStatesUid($data['uid']);
            }
            //var_dump($statesUidArr);
            
            if (count($memTplArr) > 0) {
                //now get all the membership that has the state and this memshiptemplate
                $foreign = 'fe_users';
                $local = 'tx_nkcadportal_domain_model_membership';
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($foreign);
                $queryBuilder->getRestrictions()->removeAll();
                $expr = $queryBuilder->expr();
                $andCond = $queryBuilder->expr()->andx();
                $andCond->add($expr->eq('foreign.deleted', 0));
                $andCond->add($expr->eq('foreign.disable', 0));
                $andCond->add($expr->eq('local.deleted', 0));
                $andCond->add($expr->eq('local.hidden', 0));
                $andCond->add($expr->in('local.membershiptemplate',  $memTplArr));
                $andCond->add($expr->gt('local.stateendtimecustom', $timestampArr[0]));
                $andCond->add($expr->lt('local.stateendtimecustom', $timestampArr[1]));
                
                if ($statesUidArr > 0) {
                    $andCond->add($expr->in('local.state',  $statesUidArr));
                }
                
                $qbReady = $queryBuilder->select('foreign.uid', 'email','first_name', 'last_name')
                            ->from($foreign, 'foreign')
                            ->innerJoin('foreign', $local, 'local', $expr->eq('foreign.uid','local.customfrontenduser'))
                            ->andWhere($andCond);

                //echo __LINE__.':DEBUG:' . $queryBuilder->getSQL().'<br>';

                $rows = $qbReady->execute()->fetchAll();

                if (count($rows) > 0) {
                    
                    foreach ($rows as $row) {
                        //get all the contact
                        $this->sendMail($row['email'], $row['first_name'].' '.$row['last_name'], $data['subject'], $data['message']);
                        $contacts = $this->getContactRecords($row['uid'], $mType);
                        
                        if (is_array($contacts) && isset($contacts)) {
                            if (count($contacts) > 0) {
                                foreach ($contacts as $contact) {
                                     $this->sendMail($contact['email'], $contact['firstname'].' '.$contact['lastname'], $data['subject'], $data['message']);
                                }
                            }
                        }
                    }
                }
            }
        }

        /**
         * 
         * @param array $data
         */
        protected function membershipExpiryReminders($data)
        {
            $days = $data['daysspan'];
            $whentosend = $data['whentosend'];
            $mType = $data['sendtogroup'];
            $date = $this->determineDate($days, $whentosend);
            $timestampArr = $this->convertDate($date);
            $grpUid = $this->getGroupUidByTitle($mType);
            //now get the membership templates
            $memTplArr = $this->getMembershipTemplatesByGrp($grpUid);
            
            //echo "Membership templates: ";
            //var_dump($memTplArr);
            //echo "States: ";
            if ($data['states'] !=  "-2") {
                $statesUidArr = $this->getStatesUid($data['uid']);
            }
            //var_dump($statesUidArr);
            
            if (count($memTplArr) > 0) {
                //now get all the membership that has the state and this memshiptemplate
                $foreign = 'fe_users';
                $local = 'tx_nkcadportal_domain_model_membership';
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($foreign);
                $queryBuilder->getRestrictions()->removeAll();
                $expr = $queryBuilder->expr();
                $andCond = $queryBuilder->expr()->andx();
                $andCond->add($expr->eq('foreign.deleted', 0));
                $andCond->add($expr->eq('foreign.disable', 0));
                $andCond->add($expr->eq('local.deleted', 0));
                $andCond->add($expr->eq('local.hidden', 0));
                $andCond->add($expr->in('local.membershiptemplate',  $memTplArr));
                $andCond->add($expr->gt('local.endtimecustom', $timestampArr[0]));
                $andCond->add($expr->lt('local.endtimecustom', $timestampArr[1]));
                
                if ($statesUidArr > 0) {
                    $andCond->add($expr->in('local.state',  $statesUidArr));
                }
                
                $qbReady = $queryBuilder->select('foreign.uid', 'email','first_name', 'last_name')
                            ->from($foreign, 'foreign')
                            ->innerJoin('foreign', $local, 'local', $expr->eq('foreign.uid','local.customfrontenduser'))
                            ->andWhere($andCond);

                //echo __LINE__.':DEBUG:' . $queryBuilder->getSQL().'<br>';

                $rows = $qbReady->execute()->fetchAll();

                if (count($rows) > 0) {
                    
                    foreach ($rows as $row) {
                        //get all the contact
                        $this->sendMail($row['email'], $row['first_name'].' '.$row['last_name'], $data['subject'], $data['message']);
                        $contacts = $this->getContactRecords($row['uid'], $mType);
                        
                        if (is_array($contacts) && isset($contacts)) {
                            if (count($contacts) > 0) {
                                foreach ($contacts as $contact) {
                                     $this->sendMail($contact['email'], $contact['firstname'].' '.$contact['lastname'], $data['subject'], $data['message']);
                                }
                            }
                        }
                    }
                }
            }
        }
        
        /**
         * 
         * @param int $nltype
         * @param string $date
         * @return bool
         */
        protected function checkNewsLetter($nltype, $date) {
            
            $flag = FALSE;
            $timestampArr = $this->convertDate($date);
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nkcadportal_domain_model_newsletter');
            $queryBuilder->getRestrictions()->removeAll();
            $expr = $queryBuilder->expr();
            $rows =  $queryBuilder->select('uid')->from('tx_nkcadportal_domain_model_newsletter')
                        ->where(
                            $expr->eq('deleted', 0),
                            $expr->eq('hidden', 0),
                            $expr->eq('newslettertype', $nltype),
                            $expr->gt('starttime', $timestampArr[0]),
                            $expr->lt('starttime', $timestampArr[1])
                        )->execute()->fetchAll();
            
            if (count($rows) > 0) {
                $flag = TRUE;
            }
            
            return $flag;
        }
        
        /**
         * 
         * @param int $feuser
         * @param string $type
         * @return mixed
         */
        protected function getContactRecords($feuser,$type) {
            
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nkcadportal_domain_model_contact');
            $queryBuilder->getRestrictions()->removeAll();
            $expr = $queryBuilder->expr();
            $rows =  $queryBuilder->select('firstname','lastname','email')
                        ->from('tx_nkcadportal_domain_model_contact')
                        ->where(
                            $expr->eq('deleted', 0),
                            $expr->eq('hidden', 0),
                            $expr->eq('customfrontenduser', $feuser),
                            $expr->eq('contacttype', $queryBuilder->createNamedParameter($type))
                        )->execute()->fetchAll();
            
            if (count($rows) > 0) {
               return $rows;
            }
        }
        
        /**
         * 
         * @param string $title
         * @return int
         */
        protected function getGroupUidByTitle($title) {
            
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_groups');
            $queryBuilder->getRestrictions()->removeAll();
            $expr = $queryBuilder->expr();
            
            $rows =  $queryBuilder->select('uid')
                        ->from('fe_groups')
                        ->where(
                            $expr->eq('deleted', 0),
                            $expr->eq('hidden', 0),
                            $expr->eq('title',  $queryBuilder->createNamedParameter($title))
                        )->execute()->fetchAll();
            
            return $rows[0]['uid'];
        }

        /**
         * 
         * @param int $mtplid
         */
        protected function getNewsletterTypeByMmtpl($mtplid) {
            
            $return = [];

            $local = 'tx_nkcadportal_domain_model_membershiptemplate';
            $mm = 'tx_nkcadportal_membershiptemplate_newslettertype_mm';
            $foreign = 'tx_nkcadportal_domain_model_newslettertype';
           
            if ($mtplid != '' && isset($mtplid)) { 
                
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($foreign);
                $expr = $queryBuilder->expr();

                $queryBuilder->getRestrictions()->removeAll();
                $rows = $queryBuilder->select('foreign.uid')
                    ->from($foreign, 'foreign')
                    ->innerJoin('foreign', $mm, 'mm', $expr->eq('foreign.uid','mm.uid_foreign'))
                    ->innerJoin('mm', $local, 'local', $expr->eq('mm.uid_local', 'local.uid'))
                    ->where(
                        $expr->eq('local.uid', $mtplid)
                    )
                    ->execute()
                    ->fetchAll();
                if (count($rows) > 0) {
                    foreach ($rows as $ndata) {
                         $return[] = $ndata['uid'];
                    }
                }
            }
            
            return $return;
        }
        
        /**
         * 
         * @param type $grpid
         * @return  array
         */
        protected function getMembershipTemplatesByGrp($grpid) {
            
            $return = [];
            
            if ($grpid != '' && isset($grpid)) {
                
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nkcadportal_domain_model_membershiptemplate');
                $queryBuilder->getRestrictions()->removeAll();
                $expr = $queryBuilder->expr();

                $rows =  $queryBuilder->select('uid')
                            ->from('tx_nkcadportal_domain_model_membershiptemplate')
                            ->where(
                                $expr->eq('deleted', 0),
                                $expr->eq('hidden', 0),
                                $expr->eq('membershiptype',  $grpid)
                            )->execute()->fetchAll();
                

                foreach($rows as $row) {
                    $return[] = $row['uid'];
                }
            }
            
            return $return;
        }
        
        /**
         * 
         * @param int $day
         * @param string $ltorgt
         * @return string
         */
        protected function determineDate($day, $ltorgt) {
            
            if ($ltorgt == 'after') {
                $time = strtotime("-$day days");
            } else {
                $time = strtotime("+$day days");
            }
            $date = date("d-m-Y", $time);
            
            //echo __LINE__.":DEBUG:".$date;
            
            return $date;
        }
        
        /**
	 *
	 * @param \string $date
	 * @return \array
	 */
	protected function convertDate($date) {
            
	    $dateArr = explode('-', $date);
	    $day = intval($dateArr[0]);
	    $month = intval($dateArr[1]);
	    $year = intval($dateArr[2]);
	    $timestamp1 = mktime(0,0,0, $month, $day, $year);
	    $timestamp2 = mktime(23,59,59, $month, $day, $year);
	
	    return [$timestamp1, $timestamp2];
	}
            
        /**
         * 
         * @param int $uid
         * @return array
         */
        protected function getStatesUid($uid) {

           $return = [];

           $foreign = 'tx_nkcadportal_domain_model_state';
           $mm = 'tx_nkcadportal_reminder_state_mm';
           $local = 'tx_nkcadportal_domain_model_reminder';

           $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($foreign);
           $expr = $queryBuilder->expr();

           $queryBuilder->getRestrictions()->removeAll();
           $rows = $queryBuilder->select('foreign.uid')
               ->from($foreign, 'foreign')
               ->innerJoin('foreign', $mm, 'mm', $expr->eq('foreign.uid','mm.uid_foreign'))
               ->innerJoin('mm', $local, 'local', $expr->eq('mm.uid_local', 'local.uid'))
               ->where(
                   $expr->eq('local.uid', $uid)
               )
               ->execute()
               ->fetchAll();
           if (count($rows) > 0) {
               foreach ($rows as $ndata) {
                    $return[] = $ndata['uid'];
               }
           }

           return $return;
        }
        
        /**
         * 
         * @param string $to
         * @param string $name
         * @param string $subject
         * @param string $body
         */
        protected function sendMail($to, $name, $subject, $body) {
            
            $mail = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
            $senderMail = 'system@livedrugfree.org';
            $senderName = 'LiveDrugFree';
            
           // echo "$subject for $to : $name<br>";
            
            $mail->setFrom(array($senderMail => $senderName))
                 ->setTo(array('roelkrottje@gmail.com' => $name))
                 ->setCc(array('anisur.mullick@gmail.com' => 'Tester'))
                 ->setSubject($subject.' for '.$to.':'.$name)
                 ->setBody($body, 'text/html')
                 ->send();
        }
}
