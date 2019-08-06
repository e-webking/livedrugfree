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
 * State
 */
class State extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * State (Full)
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $state = '';
    
    /**
     * State (Short)
     * 
     * @var string
     */
    protected $stateshort = '';
	
    /**
     * Is actual state
     * 
     * @var int
     */
    protected $isactuallstate = 0;
	
    /**
     * Show in FE State List
     * 
     * @var int
     */
    protected $showinfestatelist = 0;

    /**
     * pdftpl
     *
     * @var string
     */
    protected $pdftpl;
    
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
     * Returns the stateshort
     * 
     * @return string $stateshort
     */
    public function getStateshort()
    {
        return $this->stateshort;
    }
    
    /**
     * Sets the stateshort
     * 
     * @param string $stateshort
     * @return void
     */
    public function setStateshort($stateshort)
    {
        $this->stateshort = $stateshort;
    }
	
    /**
     * Returns the isactuallstate
     * 
     * @return string $isactuallstate
     */
    public function getIsactuallstate()
    {
        return $this->stateshort;
    }
    
    /**
     * Sets the isactuallstate
     * 
     * @param string $isactuallstate
     * @return void
     */
    public function setIsactuallstate($stateshort)
    {
        $this->stateshort = $stateshort;
    }
	
    /**
     * Returns the showinfestatelist
     * 
     * @return string $showinfestatelist
     */
    public function getShowinfestatelist()
    {
        return $this->showinfestatelist;
    }
    
    /**
     * Sets the showinfestatelist
     * 
     * @param string $showinfestatelist
     * @return void
     */
    public function setShowinfestatelist($showinfestatelist)
    {
        $this->showinfestatelist = $showinfestatelist;
    }	

    /**
     * Returns the pdftpl
     *
     * @return string $pdftpl
     */
    public function getPdftpl() {
        return $this->pdftpl;
    }

    /**
     * Sets the pdftpl
     *
     * @param string $pdftpl
     * @return void
     */
    public function setPdftpl($pdftpl) {
        $this->pdftpl = $pdftpl;
    }
}