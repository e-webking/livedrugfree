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
 * Discountcode
 */
class Discountcode extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Agency
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $agency = '';
    
    /**
     * Code
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $code = '';
    
    /**
     * Description
     * 
     * @var string
     */
    protected $description = '';
    
    /**
     * Discount in USD
     * 
     * @var float
     * @validate NotEmpty
     */
    protected $discount = 0.0;
    
    /**
     * Returns the agency
     * 
     * @return string $agency
     */
    public function getAgency()
    {
        return $this->agency;
    }
    
    /**
     * Sets the agency
     * 
     * @param string $agency
     * @return void
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;
    }
    
    /**
     * Returns the code
     * 
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * Sets the code
     * 
     * @param string $code
     * @return void
     */
    public function setCode($code)
    {
        $this->code = $code;
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
     * Returns the discount
     * 
     * @return float $discount
     */
    public function getDiscount()
    {
        return $this->discount;
    }
    
    /**
     * Sets the discount
     * 
     * @param float $discount
     * @return void
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

}