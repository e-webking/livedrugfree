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
 * Test case for class Netkyngs\Nkcadportal\Controller\MembershipTemplateController.
 *
 * @author Roel Krottje <roel@netkyngs.com>
 */
class MembershipTemplateControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Netkyngs\Nkcadportal\Controller\MembershipTemplateController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Netkyngs\\Nkcadportal\\Controller\\MembershipTemplateController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllMembershipTemplatesFromRepositoryAndAssignsThemToView()
	{

		$allMembershipTemplates = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$membershipTemplateRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\MembershipTemplateRepository', array('findAll'), array(), '', FALSE);
		$membershipTemplateRepository->expects($this->once())->method('findAll')->will($this->returnValue($allMembershipTemplates));
		$this->inject($this->subject, 'membershipTemplateRepository', $membershipTemplateRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('membershipTemplates', $allMembershipTemplates);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenMembershipTemplateToView()
	{
		$membershipTemplate = new \Netkyngs\Nkcadportal\Domain\Model\MembershipTemplate();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('membershipTemplate', $membershipTemplate);

		$this->subject->showAction($membershipTemplate);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenMembershipTemplateToMembershipTemplateRepository()
	{
		$membershipTemplate = new \Netkyngs\Nkcadportal\Domain\Model\MembershipTemplate();

		$membershipTemplateRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\MembershipTemplateRepository', array('add'), array(), '', FALSE);
		$membershipTemplateRepository->expects($this->once())->method('add')->with($membershipTemplate);
		$this->inject($this->subject, 'membershipTemplateRepository', $membershipTemplateRepository);

		$this->subject->createAction($membershipTemplate);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenMembershipTemplateToView()
	{
		$membershipTemplate = new \Netkyngs\Nkcadportal\Domain\Model\MembershipTemplate();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('membershipTemplate', $membershipTemplate);

		$this->subject->editAction($membershipTemplate);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenMembershipTemplateInMembershipTemplateRepository()
	{
		$membershipTemplate = new \Netkyngs\Nkcadportal\Domain\Model\MembershipTemplate();

		$membershipTemplateRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\MembershipTemplateRepository', array('update'), array(), '', FALSE);
		$membershipTemplateRepository->expects($this->once())->method('update')->with($membershipTemplate);
		$this->inject($this->subject, 'membershipTemplateRepository', $membershipTemplateRepository);

		$this->subject->updateAction($membershipTemplate);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenMembershipTemplateFromMembershipTemplateRepository()
	{
		$membershipTemplate = new \Netkyngs\Nkcadportal\Domain\Model\MembershipTemplate();

		$membershipTemplateRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\MembershipTemplateRepository', array('remove'), array(), '', FALSE);
		$membershipTemplateRepository->expects($this->once())->method('remove')->with($membershipTemplate);
		$this->inject($this->subject, 'membershipTemplateRepository', $membershipTemplateRepository);

		$this->subject->deleteAction($membershipTemplate);
	}
}
