<?php
namespace Netkyngs\Nkcadportal\Domain\Model;

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
 * Reminder
 */
class Reminder extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Days
     * 
     * @var int
     * @validate NotEmpty
     */
    protected $daysspan = 0;
    
    /**
     * When to Send
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $whentosend = '';
    
    /**
     * Field Condition
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $fieldcondition = '';
    
    /**
     * Send to Group
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $sendtogroup = '';
    
    /**
     * Subject
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $subject = '';
    
    /**
     * Message
     * 
     * @var string
     */
    protected $message = '';
    
    /**
     * States
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netkyngs\Nkcadportal\Domain\Model\State>
     * @lazy
     */
    protected $states = null;
    
    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }
    
    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->states = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Returns the daysspan
     * 
     * @return int $daysspan
     */
    public function getDaysspan()
    {
        return $this->daysspan;
    }
    
    /**
     * Sets the daysspan
     * 
     * @param int $daysspan
     * @return void
     */
    public function setDaysspan($daysspan)
    {
        $this->daysspan = $daysspan;
    }
    
    /**
     * Returns the whentosend
     * 
     * @return string $whentosend
     */
    public function getWhentosend()
    {
        return $this->whentosend;
    }
    
    /**
     * Sets the whentosend
     * 
     * @param string $whentosend
     * @return void
     */
    public function setWhentosend($whentosend)
    {
        $this->whentosend = $whentosend;
    }
    
    /**
     * Returns the fieldcondition
     * 
     * @return string $fieldcondition
     */
    public function getFieldcondition()
    {
        return $this->fieldcondition;
    }
    
    /**
     * Sets the fieldcondition
     * 
     * @param string $fieldcondition
     * @return void
     */
    public function setFieldcondition($fieldcondition)
    {
        $this->fieldcondition = $fieldcondition;
    }
    
    /**
     * Returns the sendtogroup
     * 
     * @return string $sendtogroup
     */
    public function getSendtogroup()
    {
        return $this->sendtogroup;
    }
    
    /**
     * Sets the sendtogroup
     * 
     * @param string $sendtogroup
     * @return void
     */
    public function setSendtogroup($sendtogroup)
    {
        $this->sendtogroup = $sendtogroup;
    }
    
    /**
     * Returns the subject
     * 
     * @return string $subject
     */
    public function getSubject()
    {
        return $this->subject;
    }
    
    /**
     * Sets the subject
     * 
     * @param string $subject
     * @return void
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
    
    /**
     * Returns the message
     * 
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * Sets the message
     * 
     * @param string $message
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
    
    /**
     * Adds a State
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\State $state
     * @return void
     */
    public function addState(\Netkyngs\Nkcadportal\Domain\Model\State $state)
    {
        $this->states->attach($state);
    }
    
    /**
     * Removes a State
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\State $stateToRemove The State to be removed
     * @return void
     */
    public function removeState(\Netkyngs\Nkcadportal\Domain\Model\State $stateToRemove)
    {
        $this->states->detach($stateToRemove);
    }
    
    /**
     * Returns the states
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netkyngs\Nkcadportal\Domain\Model\State> $states
     */
    public function getStates()
    {
        return $this->states;
    }
    
    /**
     * Sets the states
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netkyngs\Nkcadportal\Domain\Model\State> $states
     * @return void
     */
    public function setStates(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $states)
    {
        $this->states = $states;
    }

}