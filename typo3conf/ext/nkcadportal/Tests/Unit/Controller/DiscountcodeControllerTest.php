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
 * Test case for class Netkyngs\Nkcadportal\Controller\DiscountcodeController.
 *
 * @author Roel Krottje <roel@netkyngs.com>
 */
class DiscountcodeControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Netkyngs\Nkcadportal\Controller\DiscountcodeController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Netkyngs\\Nkcadportal\\Controller\\DiscountcodeController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllDiscountcodesFromRepositoryAndAssignsThemToView()
	{

		$allDiscountcodes = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$discountcodeRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\DiscountcodeRepository', array('findAll'), array(), '', FALSE);
		$discountcodeRepository->expects($this->once())->method('findAll')->will($this->returnValue($allDiscountcodes));
		$this->inject($this->subject, 'discountcodeRepository', $discountcodeRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('discountcodes', $allDiscountcodes);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenDiscountcodeToView()
	{
		$discountcode = new \Netkyngs\Nkcadportal\Domain\Model\Discountcode();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('discountcode', $discountcode);

		$this->subject->showAction($discountcode);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenDiscountcodeToDiscountcodeRepository()
	{
		$discountcode = new \Netkyngs\Nkcadportal\Domain\Model\Discountcode();

		$discountcodeRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\DiscountcodeRepository', array('add'), array(), '', FALSE);
		$discountcodeRepository->expects($this->once())->method('add')->with($discountcode);
		$this->inject($this->subject, 'discountcodeRepository', $discountcodeRepository);

		$this->subject->createAction($discountcode);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenDiscountcodeToView()
	{
		$discountcode = new \Netkyngs\Nkcadportal\Domain\Model\Discountcode();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('discountcode', $discountcode);

		$this->subject->editAction($discountcode);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenDiscountcodeInDiscountcodeRepository()
	{
		$discountcode = new \Netkyngs\Nkcadportal\Domain\Model\Discountcode();

		$discountcodeRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\DiscountcodeRepository', array('update'), array(), '', FALSE);
		$discountcodeRepository->expects($this->once())->method('update')->with($discountcode);
		$this->inject($this->subject, 'discountcodeRepository', $discountcodeRepository);

		$this->subject->updateAction($discountcode);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenDiscountcodeFromDiscountcodeRepository()
	{
		$discountcode = new \Netkyngs\Nkcadportal\Domain\Model\Discountcode();

		$discountcodeRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\DiscountcodeRepository', array('remove'), array(), '', FALSE);
		$discountcodeRepository->expects($this->once())->method('remove')->with($discountcode);
		$this->inject($this->subject, 'discountcodeRepository', $discountcodeRepository);

		$this->subject->deleteAction($discountcode);
	}
}
