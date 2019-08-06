<?php

namespace Netkyngs\Nkcadportal\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Roel Krottje <roel@netkyngs.com>, Netkyngs
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \Netkyngs\Nkcadportal\Domain\Model\State.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Roel Krottje <roel@netkyngs.com>
 */
class StateTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \Netkyngs\Nkcadportal\Domain\Model\State
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \Netkyngs\Nkcadportal\Domain\Model\State();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getStateReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getState()
		);
	}

	/**
	 * @test
	 */
	public function setStateForStringSetsState()
	{
		$this->subject->setState('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'state',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getStateshortReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getStateshort()
		);
	}

	/**
	 * @test
	 */
	public function setStateshortForStringSetsStateshort()
	{
		$this->subject->setStateshort('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'stateshort',
			$this->subject
		);
	}
}
