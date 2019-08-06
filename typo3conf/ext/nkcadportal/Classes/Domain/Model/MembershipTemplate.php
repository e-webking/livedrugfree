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
 * MembershipTemplate
 */
class MembershipTemplate extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Description
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $description = '';
    
    /**
     * Membership Type
     * 
     * @var int
     * @validate NotEmpty
     */
    protected $membershiptype = 0;
    
    /**
     * Price
     * 
     * @var float
     * @validate NotEmpty
     */
    protected $price = 0.0;
    
    /**
     * Term (Years)
     * 
     * @var int
     * @validate NotEmpty
     */
    protected $term = 0;
    
    /**
     * Included Newsletters
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netkyngs\Nkcadportal\Domain\Model\Newslettertype>
     * @lazy
     */
    protected $includednewsletters = null;
    
    /**
     * Returns the description
     * 
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Sets the description
     * 
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * Returns the membershiptype
     * 
     * @return int $membershiptype
     */
    public function getMembershiptype()
    {
        return $this->membershiptype;
    }
    
    /**
     * Sets the membershiptype
     * 
     * @param int $membershiptype
     * @return void
     */
    public function setMembershiptype($membershiptype)
    {
        $this->membershiptype = $membershiptype;
    }
    
    /**
     * Returns the price
     * 
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Sets the price
     * 
     * @param float $price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    /**
     * Returns the term
     * 
     * @return int $term
     */
    public function getTerm()
    {
        return $this->term;
    }
    
    /**
     * Sets the term
     * 
     * @param int $term
     * @return void
     */
    public function setTerm($term)
    {
        $this->term = $term;
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
        $this->includednewsletters = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Adds a Newslettertype
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\Newslettertype $includednewsletter
     * @return void
     */
    public function addIncludednewsletter(\Netkyngs\Nkcadportal\Domain\Model\Newslettertype $includednewsletter)
    {
        $this->includednewsletters->attach($includednewsletter);
    }
    
    /**
     * Removes a Newslettertype
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\Newslettertype $includednewsletterToRemove The Newslettertype to be removed
     * @return void
     */
    public function removeIncludednewsletter(\Netkyngs\Nkcadportal\Domain\Model\Newslettertype $includednewsletterToRemove)
    {
        $this->includednewsletters->detach($includednewsletterToRemove);
    }
    
    /**
     * Returns the includednewsletters
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netkyngs\Nkcadportal\Domain\Model\Newslettertype> $includednewsletters
     */
    public function getIncludednewsletters()
    {
        return $this->includednewsletters;
    }
    
    /**
     * Sets the includednewsletters
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netkyngs\Nkcadportal\Domain\Model\Newslettertype> $includednewsletters
     * @return void
     */
    public function setIncludednewsletters(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $includednewsletters)
    {
        $this->includednewsletters = $includednewsletters;
    }

}