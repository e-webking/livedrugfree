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
 * Document
 */
class Document extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Title
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';
	
    /**
     * @var \DateTime
     */
    protected $tstamp;
    
    /**
     * File
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @validate NotEmpty
     */
    protected $file = null;
    
    /**
     * States
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netkyngs\Nkcadportal\Domain\Model\State>
     * @lazy
     */
    protected $states = null;
	
    /**
     * States
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup>
     * @lazy
     */
    protected $groups = null;
    
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
		$this->groups = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Returns the title
     * 
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Sets the title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * Returns the file
     * 
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Sets the file
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     * @return void
     */
    public function setFile(\TYPO3\CMS\Extbase\Domain\Model\FileReference $file)
    {
        $this->file = $file;
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
	
	
	
	
    /**
     * Adds a FrontendUserGroup
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $group
     * @return void
     */
    public function addGroup(\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $group)
    {
        $this->groups->attach($group);
    }
    
    /**
     * Removes a FrontendUserGroup
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $groupToRemove The FrontendUserGroup to be removed
     * @return void
     */
    public function removeGroup(\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $groupToRemove)
    {
        $this->groups->detach($groupToRemove);
    }
    
    /**
     * Returns the groups
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup> $groups
     */
    public function getGroups()
    {
        return $this->groups;
    }
    
    /**
     * Sets the groups
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup> $groups
     * @return void
     */
    public function setGroups(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $groups)
    {
        $this->groups = $groups;
    }
	
	/**
     * Returns the tstamp
     * 
     * @return \DateTime $tstamp
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }
    
    /**
     * Sets the tstamp
     * 
     * @param \DateTime $tstamp
     * @return void
     */
    public function setTstamp($tstamp)
    {
        $this->tstamp = $tstamp;
    }

}