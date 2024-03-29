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
 * Test case for class \Netkyngs\Nkcadportal\Domain\Model\Reminder.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Roel Krottje <roel@netkyngs.com>
 */
class ReminderTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \Netkyngs\Nkcadportal\Domain\Model\Reminder
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \Netkyngs\Nkcadportal\Domain\Model\Reminder();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getDaysspanReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setDaysspanForIntSetsDaysspan()
	{	}

	/**
	 * @test
	 */
	public function getWhentosendReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setWhentosendForIntSetsWhentosend()
	{	}

	/**
	 * @test
	 */
	public function getFieldconditionReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setFieldconditionForIntSetsFieldcondition()
	{	}

	/**
	 * @test
	 */
	public function getSendtogroupReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setSendtogroupForIntSetsSendtogroup()
	{	}

	/**
	 * @test
	 */
	public function getSubjectReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getSubject()
		);
	}

	/**
	 * @test
	 */
	public function setSubjectForStringSetsSubject()
	{
		$this->subject->setSubject('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'subject',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getMessageReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getMessage()
		);
	}

	/**
	 * @test
	 */
	public function setMessageForStringSetsMessage()
	{
		$this->subject->setMessage('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'message',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getStatesReturnsInitialValueForState()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getStates()
		);
	}

	/**
	 * @test
	 */
	public function setStatesForObjectStorageContainingStateSetsStates()
	{
		$state = new \Netkyngs\Nkcadportal\Domain\Model\State();
		$objectStorageHoldingExactlyOneStates = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneStates->attach($state);
		$this->subject->setStates($objectStorageHoldingExactlyOneStates);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneStates,
			'states',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addStateToObjectStorageHoldingStates()
	{
		$state = new \Netkyngs\Nkcadportal\Domain\Model\State();
		$statesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$statesObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($state));
		$this->inject($this->subject, 'states', $statesObjectStorageMock);

		$this->subject->addState($state);
	}

	/**
	 * @test
	 */
	public function removeStateFromObjectStorageHoldingStates()
	{
		$state = new \Netkyngs\Nkcadportal\Domain\Model\State();
		$statesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$statesObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($state));
		$this->inject($this->subject, 'states', $statesObjectStorageMock);

		$this->subject->removeState($state);

	}
}
