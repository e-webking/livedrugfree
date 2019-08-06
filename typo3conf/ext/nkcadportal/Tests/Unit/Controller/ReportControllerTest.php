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
 * Test case for class Netkyngs\Nkcadportal\Controller\ReportController.
 *
 * @author Roel Krottje <roel@netkyngs.com>
 */
class ReportControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Netkyngs\Nkcadportal\Controller\ReportController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Netkyngs\\Nkcadportal\\Controller\\ReportController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllReportsFromRepositoryAndAssignsThemToView()
	{

		$allReports = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$reportRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\ReportRepository', array('findAll'), array(), '', FALSE);
		$reportRepository->expects($this->once())->method('findAll')->will($this->returnValue($allReports));
		$this->inject($this->subject, 'reportRepository', $reportRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('reports', $allReports);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenReportToView()
	{
		$report = new \Netkyngs\Nkcadportal\Domain\Model\Report();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('report', $report);

		$this->subject->showAction($report);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenReportToReportRepository()
	{
		$report = new \Netkyngs\Nkcadportal\Domain\Model\Report();

		$reportRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\ReportRepository', array('add'), array(), '', FALSE);
		$reportRepository->expects($this->once())->method('add')->with($report);
		$this->inject($this->subject, 'reportRepository', $reportRepository);

		$this->subject->createAction($report);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenReportToView()
	{
		$report = new \Netkyngs\Nkcadportal\Domain\Model\Report();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('report', $report);

		$this->subject->editAction($report);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenReportInReportRepository()
	{
		$report = new \Netkyngs\Nkcadportal\Domain\Model\Report();

		$reportRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\ReportRepository', array('update'), array(), '', FALSE);
		$reportRepository->expects($this->once())->method('update')->with($report);
		$this->inject($this->subject, 'reportRepository', $reportRepository);

		$this->subject->updateAction($report);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenReportFromReportRepository()
	{
		$report = new \Netkyngs\Nkcadportal\Domain\Model\Report();

		$reportRepository = $this->getMock('Netkyngs\\Nkcadportal\\Domain\\Repository\\ReportRepository', array('remove'), array(), '', FALSE);
		$reportRepository->expects($this->once())->method('remove')->with($report);
		$this->inject($this->subject, 'reportRepository', $reportRepository);

		$this->subject->deleteAction($report);
	}
}
