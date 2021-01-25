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
 * Newsletter
 */
class Newsletter extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Title
     * 
     * @var string
     */
    protected $title = '';
    
    /**
     * File
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @validate NotEmpty
     */
    protected $file = null;
    
    /**
     * For Month/Year
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $forperiod = '';
	
	/**
	* @var \DateTime
	*/
	protected $tstamp;
    
    /**
     * Newsletter Type
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Model\Newslettertype
     * @lazy
     */
    protected $newslettertype = null;
    
    /**
     * Returns the newslettertype
     * 
     * @return \Netkyngs\Nkcadportal\Domain\Model\Newslettertype $newslettertype
     */
    public function getNewslettertype()
    {
        return $this->newslettertype;
    }
    
    /**
     * Sets the newslettertype
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\Newslettertype $newslettertype
     * @return void
     */
    public function setNewslettertype(\Netkyngs\Nkcadportal\Domain\Model\Newslettertype $newslettertype)
    {
        $this->newslettertype = $newslettertype;
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
     * Returns the forperiod
     * 
     * @return string $forperiod
     */
    public function getForperiod()
    {
        return $this->forperiod;
    }
    
    /**
     * Sets the forperiod
     * 
     * @param string $forperiod
     * @return void
     */
    public function setForperiod($forperiod)
    {
        $this->forperiod = $forperiod;
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