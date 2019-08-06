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
 * Test case for class Netkyngs\Nkcadportal\Controller\ContactController.
 *
 * @author Roel Krottje <roel@netkyngs.com>
 */
class ContactControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Netkyngs\Nkcadportal\Controller\ContactController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Netkyngs\\Nkcadportal\\Controller\\ContactController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllContactsFromRepositoryAndAssignsThemToView()
	{

		$allContacts = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$contactRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\ContactRepository', array('findAll'), array(), '', FALSE);
		$contactRepository->expects($this->once())->method('findAll')->will($this->returnValue($allContacts));
		$this->inject($this->subject, 'contactRepository', $contactRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('contacts', $allContacts);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenContactToView()
	{
		$contact = new \Netkyngs\Nkcadportal\Domain\Model\Contact();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('contact', $contact);

		$this->subject->showAction($contact);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenContactToContactRepository()
	{
		$contact = new \Netkyngs\Nkcadportal\Domain\Model\Contact();

		$contactRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\ContactRepository', array('add'), array(), '', FALSE);
		$contactRepository->expects($this->once())->method('add')->with($contact);
		$this->inject($this->subject, 'contactRepository', $contactRepository);

		$this->subject->createAction($contact);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenContactToView()
	{
		$contact = new \Netkyngs\Nkcadportal\Domain\Model\Contact();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('contact', $contact);

		$this->subject->editAction($contact);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenContactInContactRepository()
	{
		$contact = new \Netkyngs\Nkcadportal\Domain\Model\Contact();

		$contactRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\ContactRepository', array('update'), array(), '', FALSE);
		$contactRepository->expects($this->once())->method('update')->with($contact);
		$this->inject($this->subject, 'contactRepository', $contactRepository);

		$this->subject->updateAction($contact);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenContactFromContactRepository()
	{
		$contact = new \Netkyngs\Nkcadportal\Domain\Model\Contact();

		$contactRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\ContactRepository', array('remove'), array(), '', FALSE);
		$contactRepository->expects($this->once())->method('remove')->with($contact);
		$this->inject($this->subject, 'contactRepository', $contactRepository);

		$this->subject->deleteAction($contact);
	}
}
