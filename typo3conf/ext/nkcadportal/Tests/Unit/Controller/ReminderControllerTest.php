<?php
namespace Netkyngs\Nkcadportal\Tests\Unit\Controller;
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
 * Test case for class Netkyngs\Nkcadportal\Controller\ReminderController.
 *
 * @author Roel Krottje <roel@netkyngs.com>
 */
class ReminderControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Netkyngs\Nkcadportal\Controller\ReminderController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Netkyngs\\Nkcadportal\\Controller\\ReminderController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllRemindersFromRepositoryAndAssignsThemToView()
	{

		$allReminders = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$reminderRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\ReminderRepository', array('findAll'), array(), '', FALSE);
		$reminderRepository->expects($this->once())->method('findAll')->will($this->returnValue($allReminders));
		$this->inject($this->subject, 'reminderRepository', $reminderRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('reminders', $allReminders);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenReminderToView()
	{
		$reminder = new \Netkyngs\Nkcadportal\Domain\Model\Reminder();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('reminder', $reminder);

		$this->subject->showAction($reminder);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenReminderToReminderRepository()
	{
		$reminder = new \Netkyngs\Nkcadportal\Domain\Model\Reminder();

		$reminderRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\ReminderRepository', array('add'), array(), '', FALSE);
		$reminderRepository->expects($this->once())->method('add')->with($reminder);
		$this->inject($this->subject, 'reminderRepository', $reminderRepository);

		$this->subject->createAction($reminder);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenReminderToView()
	{
		$reminder = new \Netkyngs\Nkcadportal\Domain\Model\Reminder();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('reminder', $reminder);

		$this->subject->editAction($reminder);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenReminderInReminderRepository()
	{
		$reminder = new \Netkyngs\Nkcadportal\Domain\Model\Reminder();

		$reminderRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\ReminderRepository', array('update'), array(), '', FALSE);
		$reminderRepository->expects($this->once())->method('update')->with($reminder);
		$this->inject($this->subject, 'reminderRepository', $reminderRepository);

		$this->subject->updateAction($reminder);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenReminderFromReminderRepository()
	{
		$reminder = new \Netkyngs\Nkcadportal\Domain\Model\Reminder();

		$reminderRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\ReminderRepository', array('remove'), array(), '', FALSE);
		$reminderRepository->expects($this->once())->method('remove')->with($reminder);
		$this->inject($this->subject, 'reminderRepository', $reminderRepository);

		$this->subject->deleteAction($reminder);
	}
}
