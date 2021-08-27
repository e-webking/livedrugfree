<?php
namespace Netkyngs\Nkregularformstorage\Domain\Model;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Roel Krottje <roel@netkyngs.com>, Netkyngs
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
 * Formresult
 */
class Log extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	
    /**
     * amount
     *
     * @var string
     */
    protected $amount = '';
    
    /**
     * cardno
     *
     * @var string
     */
    protected $cardno = '';
    
    /**
     * form
     *
     * @var string
     */
    protected $form = '';
	
	
    /**
     * feuseruid
     *
     * @var \int
     */
    protected $feuser;
    
    /**
     * Returns the form
     *
     * @return string $form
     */
    public function getForm()
    {
        return $this->form;
    }
    
    /**
     * Sets the form
     *
     * @param string $form
     * @return void
     */
    public function setForm($form)
    {
        $this->form = $form;
    }
	
    /**
     * Returns the amount
     *
     * @return string $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }
    
    /**
     * Sets the amount
     *
     * @param string $amount
     * @return void
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
	
    /**
     * Returns the feuser
     *
     * @return \int $feuser
     */
    public function getFeuser()
    {
        return $this->feuser;
    }
    
    /**
     * Sets the feuser
     *
     * @param \int $feuser
     * @return void
     */
    public function setFeuser($feuseruid)
    {
        $this->feuser = $feuseruid;
    }
    
    /**
     * Returns the cardno
     *
     * @return string $cardno
     */
    public function getCardno()
    {
        return $this->cardno;
    }
    
    /**
     * Sets the cardno
     *
     * @param string $cardno
     * @return void
     */
    public function setCardno($cardno)
    {
        $this->cardno = $cardno;
    }
}