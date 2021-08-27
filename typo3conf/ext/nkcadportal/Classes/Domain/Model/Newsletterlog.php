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
 * Newsletterlog
 */
class Newsletterlog extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    
    /**
     * 
     * @var \DateTime
     */
    protected $sdate;

    /**
     *
     * @var string
     */
    protected $email;
    
    /**
     * Newsletter
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Model\Newsletter
     */
    protected $newsletter;
    
    /**
     * Returns the newsletter
     * 
     * @return \Netkyngs\Nkcadportal\Domain\Model\Newsletter
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }
    
    /**
     * Sets the newsletter
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\Newsletter $newsletter
     * @return void
     */
    public function setNewsletter(\Netkyngs\Nkcadportal\Domain\Model\Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }
    
    /**
     * Returns the email
     * 
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Sets the email
     * 
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * Returns the sdate
     * 
     * @return \DateTime $sdate
     */
    public function getSdate()
    {
        return $this->sdate;
    }
    
    /**
     * Sets the sdate
     * 
     * @param \DateTime $sdate
     * @return void
     */
    public function setSdate($sdate)
    {
        $this->sdate = $sdate;
    }

}