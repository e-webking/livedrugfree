<?php
namespace Netkyngs\Nkcadportal\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2020 Anisur R Mullick <anisur.mullick@gmail.com>
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
 * Invoice
 */
class Invoice extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Member
     * 
     * @var int
     */
    protected $customfrontenduser;
    
    /**
     * Membership
     * 
     * @var string
     */
    protected $membership = '';
    
    
    /**
     * Payment
     *
     * @var int
     */
    protected $payment = 0;
    
    /**
     * Invoice No.
     *
     * @var int
     */
    protected $invoicenum = 0;


    /**
     * Description
     * 
     * @var string
     */
    protected $invoicedata = '';


    /**
     * Returns the customfrontenduser
     * 
     * @return int $customfrontenduser
     */
    public function getCustomfrontenduser()
    {
        return $this->customfrontenduser;
    }
    
    /**
     * Sets the customfrontenduser
     * 
     * @param int $customfrontenduser
     * @return void
     */
    public function setCustomfrontenduser($customfrontenduser)
    {
        $this->customfrontenduser = $customfrontenduser;
    }
    
    /**
     * Returns the membership
     * 
     * @return string $membership
     */
    public function getMembership()
    {
        return $this->membership;
    }
    
    /**
     * Sets the membership
     * 
     * @param string $membership
     * @return void
     */
    public function setMembership($membership)
    {
        $this->membership = $membership;
    }
    
    /**
     * Returns the invoicedata
     * 
     * @return string $invoicedata
     */
    public function getInvoicedata()
    {
        return $this->invoicedata;
    }
    
    /**
     * Sets the invoicedata
     * 
     * @param string $invoicedata
     * @return void
     */
    public function setInvoicedata($invoicedata)
    {
        $this->invoicedata = $invoicedata;
    }
    
    /**
     * Returns the payment
     * 
     * @return int $payment
     */
    public function getPayment()
    {
        return $this->payment;
    }
    
    /**
     * Sets the payment
     * 
     * @param int $payment
     * @return void
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }
    
    /**
     * Returns the invoicenum
     * 
     * @return int $invoicenum
     */
    public function getInvoicenum()
    {
        return $this->invoicenum;
    }
    
    /**
     * Sets the invoicenum
     * 
     * @param int $invoicenum
     * @return void
     */
    public function setInvoicenum($invoicenum)
    {
        $this->invoicenum = $invoicenum;
    }

}