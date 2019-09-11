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
 * Report
 */
class Report extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Title
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';
    
    /**
     * filename
     * 
     * @var string
     */
    protected $filename = '';
    
    /**
     * SQL Query
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $sqlquery = '';
    
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
     * Returns the filename
     * 
     * @return string $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }
    
    /**
     * Sets the filename
     * 
     * @param string $filename
     * @return void
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }
    
    /**
     * Returns the sqlquery
     * 
     * @return string $sqlquery
     */
    public function getSqlquery()
    {
        return $this->sqlquery;
    }
    
    /**
     * Sets the sqlquery
     * 
     * @param string $sqlquery
     * @return void
     */
    public function setSqlquery($sqlquery)
    {
        $this->sqlquery = $sqlquery;
    }

}