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
 * CustomFrontendUser
 */
class CustomFrontendUser extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
{

    /**
     * FEIN
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $fein = '';
    
    /**
     * Number of Employees
     * 
     * @var int
     */
    protected $numberofemployees = 0;
	
	/**
     * Hidden
     * 
     * @var int
     */
    protected $hidden = 0;
    
    /**
     * Number of CDL Drivers
     * 
     * @var int
     */
    protected $numberofcdldrivers = 0;
    
    /**
     * Business Type
     * 
     * @var string
     */
    protected $businesstype = '';
	
	/**
     * cellphone
     * 
     * @var string
     */
    protected $cellphone = '';
	
	/**
     * state
     * 
     * @var string
     */
    protected $state = '';
    
    /**
     * Insurance Carrier
     * 
     * @var string
     */
    protected $insurancecarrier = '';
    
    /**
     * Insurance Agent
     * 
     * @var string
     */
    protected $insuranceagent = '';
    
    /**
     * How did you hear about us?
     * 
     * @var string
     */
    protected $hearaboutus = '';
    
    /**
     * Staff Comments
     * 
     * @var string
     */
    protected $staffcomments = '';
	
	/**
     * County
     * 
     * @var string
     */
    protected $county = '';
	
	/**
     * Additionaladdress
     * 
     * @var string
     */
    protected $additionaladdress = '';
    
    /**
     * Member Comments
     * 
     * @var string
     */
    protected $membercomments = '';
	
	/**
     * txExtbaseType
     * 
     * @var string
     */
    protected $txExtbaseType = '';
	
    
    /**
     * memberships
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netkyngs\Nkcadportal\Domain\Model\Membership>
     * @lazy
     */
    protected $memberships = null;
    
    /**
     * contacts
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netkyngs\Nkcadportal\Domain\Model\Contact>
     * @cascade remove
     * @lazy
     */
    protected $contacts = null;
    
    /**
     * Returns the fein
     * 
     * @return string $fein
     */
    public function getFein()
    {
        return $this->fein;
    }
    
    /**
     * Sets the fein
     * 
     * @param string $fein
     * @return void
     */
    public function setFein($fein)
    {
        $this->fein = $fein;
    }
    
    /**
     * Returns the numberofemployees
     * 
     * @return int $numberofemployees
     */
    public function getNumberofemployees()
    {
        return $this->numberofemployees;
    }
    
    /**
     * Sets the numberofemployees
     * 
     * @param int $numberofemployees
     * @return void
     */
    public function setNumberofemployees($numberofemployees)
    {
        $this->numberofemployees = $numberofemployees;
    }
	
	/**
     * Returns the hidden
     * 
     * @return int $hidden
     */
    public function getHidden()
    {
        return $this->hidden;
    }
    
    /**
     * Sets the hidden
     * 
     * @param int $hidden
     * @return void
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }
    
    /**
     * Returns the numberofcdldrivers
     * 
     * @return int $numberofcdldrivers
     */
    public function getNumberofcdldrivers()
    {
        return $this->numberofcdldrivers;
    }
    
    /**
     * Sets the numberofcdldrivers
     * 
     * @param int $numberofcdldrivers
     * @return void
     */
    public function setNumberofcdldrivers($numberofcdldrivers)
    {
        $this->numberofcdldrivers = $numberofcdldrivers;
    }
    
    /**
     * Returns the businesstype
     * 
     * @return string $businesstype
     */
    public function getBusinesstype()
    {
        return $this->businesstype;
    }
    
    /**
     * Sets the businesstype
     * 
     * @param string $businesstype
     * @return void
     */
    public function setBusinesstype($businesstype)
    {
        $this->businesstype = $businesstype;
    }
	
	/**
     * Returns the state
     * 
     * @return string $state
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * Sets the state
     * 
     * @param string $state
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
    }
    
	
	/**
     * Returns the cellphone
     * 
     * @return string $cellphone
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }
    
    /**
     * Sets the cellphone
     * 
     * @param string $cellphone
     * @return void
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;
    }
    
    
    /**
     * Returns the insurancecarrier
     * 
     * @return string $insurancecarrier
     */
    public function getInsurancecarrier()
    {
        return $this->insurancecarrier;
    }
    
    /**
     * Sets the insurancecarrier
     * 
     * @param string $insurancecarrier
     * @return void
     */
    public function setInsurancecarrier($insurancecarrier)
    {
        $this->insurancecarrier = $insurancecarrier;
    }
    
    /**
     * Returns the insuranceagent
     * 
     * @return string $insuranceagent
     */
    public function getInsuranceagent()
    {
        return $this->insuranceagent;
    }
    
    /**
     * Sets the insuranceagent
     * 
     * @param string $insuranceagent
     * @return void
     */
    public function setInsuranceagent($insuranceagent)
    {
        $this->insuranceagent = $insuranceagent;
    }
    
    /**
     * Returns the hearaboutus
     * 
     * @return string $hearaboutus
     */
    public function getHearaboutus()
    {
        return $this->hearaboutus;
    }
    
    /**
     * Sets the hearaboutus
     * 
     * @param string $hearaboutus
     * @return void
     */
    public function setHearaboutus($hearaboutus)
    {
        $this->hearaboutus = $hearaboutus;
    }
    
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
        $this->memberships = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->contacts = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Adds a Membership
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\Membership $membership
     * @return void
     */
    public function addMembership(\Netkyngs\Nkcadportal\Domain\Model\Membership $membership)
    {
        $this->memberships->attach($membership);
    }
    
    /**
     * Removes a Membership
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\Membership $membershipToRemove The Membership to be removed
     * @return void
     */
    public function removeMembership(\Netkyngs\Nkcadportal\Domain\Model\Membership $membershipToRemove)
    {
        $this->memberships->detach($membershipToRemove);
    }
    
    /**
     * Returns the memberships
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netkyngs\Nkcadportal\Domain\Model\Membership> $memberships
     */
    public function getMemberships()
    {
        return $this->memberships;
    }
    
    /**
     * Sets the memberships
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netkyngs\Nkcadportal\Domain\Model\Membership> $memberships
     * @return void
     */
    public function setMemberships(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $memberships)
    {
        $this->memberships = $memberships;
    }
    
    /**
     * Adds a Contact
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\Contact $contact
     * @return void
     */
    public function addContact(\Netkyngs\Nkcadportal\Domain\Model\Contact $contact)
    {
        $this->contacts->attach($contact);
    }
    
    /**
     * Removes a Contact
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\Contact $contactToRemove The Contact to be removed
     * @return void
     */
    public function removeContact(\Netkyngs\Nkcadportal\Domain\Model\Contact $contactToRemove)
    {
        $this->contacts->detach($contactToRemove);
    }
    
    /**
     * Returns the contacts
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netkyngs\Nkcadportal\Domain\Model\Contact> $contacts
     */
    public function getContacts()
    {
        return $this->contacts;
    }
    
    /**
     * Sets the contacts
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netkyngs\Nkcadportal\Domain\Model\Contact> $contacts
     * @return void
     */
    public function setContacts(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $contacts)
    {
        $this->contacts = $contacts;
    }
    
    /**
     * Returns the staffcomments
     * 
     * @return string $staffcomments
     */
    public function getStaffcomments()
    {
        return $this->staffcomments;
    }
    
    /**
     * Sets the staffcomments
     * 
     * @param string $staffcomments
     * @return void
     */
    public function setStaffcomments($staffcomments)
    {
        $this->staffcomments = $staffcomments;
    }
    
    /**
     * Returns the membercomments
     * 
     * @return string $membercomments
     */
    public function getMembercomments()
    {
        return $this->membercomments;
    }
    
    /**
     * Sets the membercomments
     * 
     * @param string $membercomments
     * @return void
     */
    public function setMembercomments($membercomments)
    {
        $this->membercomments = $membercomments;
    }
	
	/**
     * @param string $txExtbaseType
     * @return User
     */
    public function setTxExtbaseType($txExtbaseType)
    {
        $this->txExtbaseType = $txExtbaseType;
        return $this;
    }
    /**
     * @return string
     */
    public function getTxExtbaseType()
    {
        return $this->txExtbaseType;
    }
	
	
	/**
     * Returns the county
     * 
     * @return string $county
     */
    public function getCounty()
    {
        return $this->county;
    }
    
    /**
     * Sets the county
     * 
     * @param string $county
     * @return void
     */
    public function setCounty($county)
    {
        $this->county = $county;
    }
	
	
	/**
     * Returns the additionaladdress
     * 
     * @return string $additionaladdress
     */
    public function getAdditionaladdress()
    {
        return $this->additionaladdress;
    }
    
    /**
     * Sets the additionaladdress
     * 
     * @param string $additionaladdress
     * @return void
     */
    public function setAdditionaladdress($additionaladdress)
    {
        $this->additionaladdress = $additionaladdress;
    }
	

}