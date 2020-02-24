<?php
namespace Netkyngs\Nkregularformstorage\Domain\Model;

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
class CustomFrontendUser extends \Netkyngs\Nkcadportal\Domain\Model\CustomFrontendUser
{
    /**
     * Authorize Customer Profile
     * 
     * @var string
     */
    protected $authorizeCustomerProfile = '';
    
    /**
     * Authorize Payment Profile
     * 
     * @var string
     */
    protected $authorizePaymentProfile = '';
    
    /**
     * Returns the authorizeCustomerProfile
     * 
     * @return string $authorizeCustomerProfile
     */
    public function getAuthorizeCustomerProfile()
    {
        return $this->authorizeCustomerProfile;
    }
    
    /**
     * 
     * @param string $cusprofile
     * @return void
     */
    public function setAuthorizeCustomerProfile($cusprofile)
    {
        $this->authorizeCustomerProfile = $cusprofile;
    }
    
    /**
     * Returns the authorize_payment_profile
     * 
     * @return string $authorizePaymentProfile
     */
    public function getAuthorizePaymentProfile()
    {
        return $this->authorizePaymentProfile;
    }
    
    /**
     * Sets the Authorize Payment Profile
     * 
     * @param string $authorizePaymentProfile
     * @return void
     */
    public function setAuthorizePaymentProfile($authorizePaymentProfile)
    {
        $this->authorizePaymentProfile = $authorizePaymentProfile;
    }

    /**
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\CustomFrontendUser $parent
     */
    public function loadFromParent(\Netkyngs\Nkcadportal\Domain\Model\CustomFrontendUser $parent)
    {
        $this->firstName = $parent->getFirstName();        
        $this->lastName = $parent->getLastName();
        $this->email = $parent->getEmail();
        $this->name = $parent->getName();
        $this->company = $parent->getCompany();
        $this->address = $parent->getAddress();
        $this->username = $parent->getUsername();
        $this->usergroup = $parent->getUsergroup();
        $this->telephone = $parent->getTelephone();
        $this->title = $parent->getTitle();
        $this->zip = $parent->getZip();
        $this->city = $parent->getCity();
        $this->country = $parent->getCountry();
        $this->www = $parent->getWww();        
        
        $this->fein = $parent->getFein();
        $this->hidden = $parent->getHidden();
        $this->numberofcdldrivers = $parent->getNumberofcdldrivers();
        $this->numberofemployees = $parent->getNumberofemployees();
        $this->businesstype = $parent->getBusinesstype();
        $this->cellphone = $parent->getCellphone();       
        $this->state = $parent->getState();
        $this->insuranceagent = $parent->getInsuranceagent();
        $this->insurancecarrier = $parent->getInsurancecarrier();
        $this->hearaboutus = $parent->getHearaboutus();
        $this->membercomments = $parent->getMembercomments();
        $this->staffcomments = $parent->getStaffcomments();
        $this->county = $parent->getCounty();
        $this->additionaladdress = $parent->getAdditionaladdress();
        $this->txExtbaseType = $parent->getTxExtbaseType();
        
        $this->contacts = $parent->getContacts();
        $this->memberships = $parent->getMemberships();
     
    }

}