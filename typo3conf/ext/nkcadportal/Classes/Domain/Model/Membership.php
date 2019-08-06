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
 * Membership
 */
class Membership extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Membership Template
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Model\MembershipTemplate
     * @lazy
     */
    protected $membershiptemplate = null;
    
    /**
     * State
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Model\State
     * @lazy
     */
    protected $state = null;
	
	/**
	* @var \DateTime
	*/
	protected $endtime;
	
	/**
	* @var \DateTime
	*/
	protected $starttime;
	
	/**
	* @var \DateTime
	*/
	protected $endtimecustom;
	
	/**
	* @var \DateTime
	*/
	protected $starttimecustom;
	
	/**
	* @var \DateTime
	*/
	protected $stateendtimecustom;
	
	/**
	* @var \DateTime
	*/
	protected $statestarttimecustom;
    
    /**
     * Returns the membershiptemplate
     * 
     * @return \Netkyngs\Nkcadportal\Domain\Model\MembershipTemplate $membershiptemplate
     */
    public function getMembershiptemplate()
    {
        return $this->membershiptemplate;
    }
    
    /**
     * Sets the membershiptemplate
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\MembershipTemplate $membershiptemplate
     * @return void
     */
    public function setMembershiptemplate(\Netkyngs\Nkcadportal\Domain\Model\MembershipTemplate $membershiptemplate)
    {
        $this->membershiptemplate = $membershiptemplate;
    }
    
    /**
     * Returns the state
     * 
     * @return \Netkyngs\Nkcadportal\Domain\Model\State $state
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * Sets the state
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\State $state
     * @return void
     */
    public function setState(\Netkyngs\Nkcadportal\Domain\Model\State $state)
    {
        $this->state = $state;
    }
	
	/**
     * Returns the endtime
     * 
     * @return \DateTime $endtime
     */
    public function getEndtime()
    {
        return $this->endtime;
    }
    
    /**
     * Sets the endtime
     * 
     * @param \DateTime $endtime
     * @return void
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
    }
	
	/**
     * Returns the starttime
     * 
     * @return \DateTime $starttime
     */
    public function getStarttime()
    {
        return $this->starttime;
    }
    
    /**
     * Sets the starttime
     * 
     * @param \DateTime $starttime
     * @return void
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;
    }
	
	
	
	
	/**
     * Returns the endtimecustom
     * 
     * @return \DateTime $endtimecustom
     */
    public function getEndtimecustom()
    {
        return $this->endtimecustom;
    }
    
    /**
     * Sets the endtimecustom
     * 
     * @param \DateTime $endtimecustom
     * @return void
     */
    public function setEndtimecustom($endtimecustom)
    {
        $this->endtimecustom = $endtimecustom;
    }
	
	/**
     * Returns the starttimecustom
     * 
     * @return \DateTime $starttimecustom
     */
    public function getStarttimecustom()
    {
        return $this->starttimecustom;
    }
    
    /**
     * Sets the starttimecustom
     * 
     * @param \DateTime $starttimecustom
     * @return void
     */
    public function setStarttimecustom($starttimecustom)
    {
        $this->starttimecustom = $starttimecustom;
    }
	
	
	
	
	/**
     * Returns the stateendtimecustom
     * 
     * @return \DateTime $stateendtimecustom
     */
    public function getStateendtimecustom()
    {
        return $this->stateendtimecustom;
    }
    
    /**
     * Sets the stateendtimecustom
     * 
     * @param \DateTime $stateendtimecustom
     * @return void
     */
    public function setStateendtimecustom($stateendtimecustom)
    {
        $this->stateendtimecustom = $stateendtimecustom;
    }
	
	/**
     * Returns the statestarttimecustom
     * 
     * @return \DateTime $statestarttimecustom
     */
    public function getStatestarttimecustom()
    {
        return $this->statestarttimecustom;
    }
    
    /**
     * Sets the state
     * 
     * @param \DateTime $state
     * @return void
     */
    public function setStatestarttimecustom($state)
    {
        $this->state = $state;
    }

}