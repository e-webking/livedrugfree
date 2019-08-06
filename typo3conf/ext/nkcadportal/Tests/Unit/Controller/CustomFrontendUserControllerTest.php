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
 * Test case for class Netkyngs\Nkcadportal\Controller\CustomFrontendUserController.
 *
 * @author Roel Krottje <roel@netkyngs.com>
 */
class CustomFrontendUserControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Netkyngs\Nkcadportal\Controller\CustomFrontendUserController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Netkyngs\\Nkcadportal\\Controller\\CustomFrontendUserController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllCustomFrontendUsersFromRepositoryAndAssignsThemToView()
	{

		$allCustomFrontendUsers = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$customFrontendUserRepository = $this->getMock('', array('findAll'), array(), '', FALSE);
		$customFrontendUserRepository->expects($this->once())->method('findAll')->will($this->returnValue($allCustomFrontendUsers));
		$this->inject($this->subject, 'customFrontendUserRepository', $customFrontendUserRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('customFrontendUsers', $allCustomFrontendUsers);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenCustomFrontendUserToView()
	{
		$customFrontendUser = new \Netkyngs\Nkcadportal\Domain\Model\CustomFrontendUser();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('customFrontendUser', $customFrontendUser);

		$this->subject->showAction($customFrontendUser);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenCustomFrontendUserToCustomFrontendUserRepository()
	{
		$customFrontendUser = new \Netkyngs\Nkcadportal\Domain\Model\CustomFrontendUser();

		$customFrontendUserRepository = $this->getMock('', array('add'), array(), '', FALSE);
		$customFrontendUserRepository->expects($this->once())->method('add')->with($customFrontendUser);
		$this->inject($this->subject, 'customFrontendUserRepository', $customFrontendUserRepository);

		$this->subject->createAction($customFrontendUser);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenCustomFrontendUserToView()
	{
		$customFrontendUser = new \Netkyngs\Nkcadportal\Domain\Model\CustomFrontendUser();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('customFrontendUser', $customFrontendUser);

		$this->subject->editAction($customFrontendUser);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenCustomFrontendUserInCustomFrontendUserRepository()
	{
		$customFrontendUser = new \Netkyngs\Nkcadportal\Domain\Model\CustomFrontendUser();

		$customFrontendUserRepository = $this->getMock('', array('update'), array(), '', FALSE);
		$customFrontendUserRepository->expects($this->once())->method('update')->with($customFrontendUser);
		$this->inject($this->subject, 'customFrontendUserRepository', $customFrontendUserRepository);

		$this->subject->updateAction($customFrontendUser);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenCustomFrontendUserFromCustomFrontendUserRepository()
	{
		$customFrontendUser = new \Netkyngs\Nkcadportal\Domain\Model\CustomFrontendUser();

		$customFrontendUserRepository = $this->getMock('', array('remove'), array(), '', FALSE);
		$customFrontendUserRepository->expects($this->once())->method('remove')->with($customFrontendUser);
		$this->inject($this->subject, 'customFrontendUserRepository', $customFrontendUserRepository);

		$this->subject->deleteAction($customFrontendUser);
	}
}
