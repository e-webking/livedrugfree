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
 * Test case for class Netkyngs\Nkcadportal\Controller\MembershipController.
 *
 * @author Roel Krottje <roel@netkyngs.com>
 */
class MembershipControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Netkyngs\Nkcadportal\Controller\MembershipController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Netkyngs\\Nkcadportal\\Controller\\MembershipController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllMembershipsFromRepositoryAndAssignsThemToView()
	{

		$allMemberships = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$membershipRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\MembershipRepository', array('findAll'), array(), '', FALSE);
		$membershipRepository->expects($this->once())->method('findAll')->will($this->returnValue($allMemberships));
		$this->inject($this->subject, 'membershipRepository', $membershipRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('memberships', $allMemberships);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenMembershipToView()
	{
		$membership = new \Netkyngs\Nkcadportal\Domain\Model\Membership();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('membership', $membership);

		$this->subject->showAction($membership);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenMembershipToMembershipRepository()
	{
		$membership = new \Netkyngs\Nkcadportal\Domain\Model\Membership();

		$membershipRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\MembershipRepository', array('add'), array(), '', FALSE);
		$membershipRepository->expects($this->once())->method('add')->with($membership);
		$this->inject($this->subject, 'membershipRepository', $membershipRepository);

		$this->subject->createAction($membership);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenMembershipToView()
	{
		$membership = new \Netkyngs\Nkcadportal\Domain\Model\Membership();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('membership', $membership);

		$this->subject->editAction($membership);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenMembershipInMembershipRepository()
	{
		$membership = new \Netkyngs\Nkcadportal\Domain\Model\Membership();

		$membershipRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\MembershipRepository', array('update'), array(), '', FALSE);
		$membershipRepository->expects($this->once())->method('update')->with($membership);
		$this->inject($this->subject, 'membershipRepository', $membershipRepository);

		$this->subject->updateAction($membership);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenMembershipFromMembershipRepository()
	{
		$membership = new \Netkyngs\Nkcadportal\Domain\Model\Membership();

		$membershipRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\MembershipRepository', array('remove'), array(), '', FALSE);
		$membershipRepository->expects($this->once())->method('remove')->with($membership);
		$this->inject($this->subject, 'membershipRepository', $membershipRepository);

		$this->subject->deleteAction($membership);
	}
}
