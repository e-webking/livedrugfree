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
class Formresult extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';
    
    /**
     * email
     *
     * @var string
     */
    protected $email = '';
	
    /**
     * trxid
     *
     * @var string
     */
    protected $trxid = '';
	
    /**
     * invoiceid
     *
     * @var string
     */
    protected $invoiceid = '';
	
    /**
     * trxamount
     *
     * @var string
     */
    protected $trxamount = '';
    
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
     * formserialized
     *
     * @var string
     */
    protected $formserialized = '';
	
    /**
     * customtstamp
     *
     * @var \int
     */
    protected $customtstamp = '';
	
    /**
     * feuseruid
     *
     * @var \int
     */
    protected $feuseruid = '';
    
    /**
     *
     * @var int
     */
    protected $ptype = 0;

    /**
     *
     * @var int
     */
    protected $pstatus = 0;

    /**
     *
     * @var string
     */
    protected $description = '';

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Returns the trxid
     *
     * @return string $trxid
     */
    public function getTrxid()
    {
        return $this->trxid;
    }
    
    /**
     * Sets the trxid
     *
     * @param string $trxid
     * @return void
     */
    public function setTrxid($trxid)
    {
        $this->trxid = $trxid;
    }
	
    /**
     * Returns the trxamount
     *
     * @return string $trxamount
     */
    public function getTrxamount()
    {
        return $this->trxamount;
    }
    
    /**
     * Sets the trxamount
     *
     * @param string $trxamount
     * @return void
     */
    public function setTrxamount($trxamount)
    {
        $this->trxamount = $trxamount;
    }
	
    /**
     * Returns the invoiceid
     *
     * @return string $invoiceid
     */
    public function getInvoiceid()
    {
        return $this->invoiceid;
    }
    
    /**
     * Sets the invoiceid
     *
     * @param string $invoiceid
     * @return void
     */
    public function setInvoiceid($invoiceid)
    {
        $this->invoiceid = $invoiceid;
    }

	/**
     * Returns the formserialized
     *
     * @return string $formserialized
     */
    public function getFormserialized()
    {
        return $this->formserialized;
    }
    
    /**
     * Sets the formserialized
     *
     * @param string $formserialized
     * @return void
     */
    public function setFormserialized($formserialized)
    {
        $this->formserialized = $formserialized;
    }
	
	/**
     * Returns the customtstamp
     *
     * @return \int $customtstamp
     */
    public function getCustomtstamp()
    {
        return $this->customtstamp;
    }
    
    /**
     * Sets the customtstamp
     *
     * @param \int $customtstamp
     * @return void
     */
    public function setCustomtstamp($customtstamp)
    {
        $this->customtstamp = $customtstamp;
    }
	
	
	/**
     * Returns the feuseruid
     *
     * @return \int $feuseruid
     */
    public function getFeuseruid()
    {
        return $this->feuseruid;
    }
    
    /**
     * Sets the feuseruid
     *
     * @param \int $feuseruid
     * @return void
     */
    public function setFeuseruid($feuseruid)
    {
        $this->feuseruid = $feuseruid;
    }

    /**
     * Returns the ptype
     *
     * @return int $ptype
     */
    public function getPtype()
    {
        return $this->ptype;
    }
    
    /**
     * Sets the ptype
     *
     * @param int $ptype
     * @return void
     */
    public function setPtype($ptype)
    {
        $this->ptype = $ptype;
    }
    
    /**
     * Returns the pstatus
     *
     * @return int $pstatus
     */
    public function getPstatus()
    {
        return $this->pstatus;
    }
    
    /**
     * Sets the pstatus
     *
     * @param int $pstatus
     * @return void
     */
    public function setPstatus($pstatus)
    {
        $this->pstatus = $pstatus;
    }
	
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