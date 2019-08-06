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
 * Test case for class \Netkyngs\Nkcadportal\Domain\Model\MembershipTemplate.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Roel Krottje <roel@netkyngs.com>
 */
class MembershipTemplateTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \Netkyngs\Nkcadportal\Domain\Model\MembershipTemplate
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \Netkyngs\Nkcadportal\Domain\Model\MembershipTemplate();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription()
	{
		$this->subject->setDescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'description',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getMembershiptypeReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setMembershiptypeForIntSetsMembershiptype()
	{	}

	/**
	 * @test
	 */
	public function getPriceReturnsInitialValueForFloat()
	{
		$this->assertSame(
			0.0,
			$this->subject->getPrice()
		);
	}

	/**
	 * @test
	 */
	public function setPriceForFloatSetsPrice()
	{
		$this->subject->setPrice(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'price',
			$this->subject,
			'',
			0.000000001
		);
	}

	/**
	 * @test
	 */
	public function getTermReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setTermForIntSetsTerm()
	{	}

	/**
	 * @test
	 */
	public function getIncludednewslettersReturnsInitialValueForNewslettertype()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getIncludednewsletters()
		);
	}

	/**
	 * @test
	 */
	public function setIncludednewslettersForObjectStorageContainingNewslettertypeSetsIncludednewsletters()
	{
		$includednewsletter = new \Netkyngs\Nkcadportal\Domain\Model\Newslettertype();
		$objectStorageHoldingExactlyOneIncludednewsletters = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneIncludednewsletters->attach($includednewsletter);
		$this->subject->setIncludednewsletters($objectStorageHoldingExactlyOneIncludednewsletters);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneIncludednewsletters,
			'includednewsletters',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addIncludednewsletterToObjectStorageHoldingIncludednewsletters()
	{
		$includednewsletter = new \Netkyngs\Nkcadportal\Domain\Model\Newslettertype();
		$includednewslettersObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$includednewslettersObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($includednewsletter));
		$this->inject($this->subject, 'includednewsletters', $includednewslettersObjectStorageMock);

		$this->subject->addIncludednewsletter($includednewsletter);
	}

	/**
	 * @test
	 */
	public function removeIncludednewsletterFromObjectStorageHoldingIncludednewsletters()
	{
		$includednewsletter = new \Netkyngs\Nkcadportal\Domain\Model\Newslettertype();
		$includednewslettersObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$includednewslettersObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($includednewsletter));
		$this->inject($this->subject, 'includednewsletters', $includednewslettersObjectStorageMock);

		$this->subject->removeIncludednewsletter($includednewsletter);

	}
}
