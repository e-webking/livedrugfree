<?php
namespace Netkyngs\Nkregularformstorage\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2020 Roel Krottje <roel@netkyngs.com>, Netkyngs
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
 * Paymentprofile
 */
class Paymentprofile extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * cusprofile
     *
     * @var int
     */
    protected $cusprofile = '';
    
    /**
     * payprofile
     *
     * @var int
     */
    protected $payprofile = '';
	
    /**
     * card
     *
     * @var string
     */
    protected $card = '';
    
    /**
     *
     * @var string
     */
    protected $email = '';

    /**
     * feuser
     *
     * @var int
     */
    protected $feuser;
    

    /**
     * Returns the cusprofile
     *
     * @return int $cusprofile
     */
    public function getCusprofile()
    {
        return $this->cusprofile;
    }
    
    /**
     * Sets the cusprofile
     *
     * @param int $cusprofile
     * @return void
     */
    public function setCusprofile($cusprofile)
    {
        $this->cusprofile = $cusprofile;
    }
    
    /**
     * Returns the payprofile
     *
     * @return int $payprofile
     */
    public function getPayprofile()
    {
        return $this->payprofile;
    }
    
    /**
     * Sets the payprofile
     *
     * @param int $payprofile
     * @return void
     */
    public function setPayprofile($payprofile)
    {
        $this->payprofile = $payprofile;
    }

    /**
     * Returns the card
     *
     * @return string $card
     */
    public function getCard()
    {
        return $this->card;
    }
    
    /**
     * Sets the card
     *
     * @param string $card
     * @return void
     */
    public function setCard($card)
    {
        $this->card = $card;
    }	
	
    /**
     * Returns the feuser
     *
     * @return int $feuser
     */
    public function getFeuser()
    {
        return $this->feuser;
    }
    
    /**
     * Sets the feuser
     *
     * @param int $feuser
     * @return void
     */
    public function setFeuser($feuser)
    {
        $this->feuser = $feuser;
    }
    
    /**
     * Returns the card
     *
     * @return string $card
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Sets the card
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }	
    
}