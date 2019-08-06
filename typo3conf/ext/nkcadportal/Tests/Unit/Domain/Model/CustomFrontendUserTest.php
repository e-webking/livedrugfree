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
 * Test case for class \Netkyngs\Nkcadportal\Domain\Model\CustomFrontendUser.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Roel Krottje <roel@netkyngs.com>
 */
class CustomFrontendUserTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \Netkyngs\Nkcadportal\Domain\Model\CustomFrontendUser
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \Netkyngs\Nkcadportal\Domain\Model\CustomFrontendUser();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getFeinReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getFein()
		);
	}

	/**
	 * @test
	 */
	public function setFeinForStringSetsFein()
	{
		$this->subject->setFein('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'fein',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getNumberofemployeesReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setNumberofemployeesForIntSetsNumberofemployees()
	{	}

	/**
	 * @test
	 */
	public function getNumberofcdldriversReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setNumberofcdldriversForIntSetsNumberofcdldrivers()
	{	}

	/**
	 * @test
	 */
	public function getBusinesstypeReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getBusinesstype()
		);
	}

	/**
	 * @test
	 */
	public function setBusinesstypeForStringSetsBusinesstype()
	{
		$this->subject->setBusinesstype('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'businesstype',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getInsurancecarrierReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getInsurancecarrier()
		);
	}

	/**
	 * @test
	 */
	public function setInsurancecarrierForStringSetsInsurancecarrier()
	{
		$this->subject->setInsurancecarrier('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'insurancecarrier',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getInsuranceagentReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getInsuranceagent()
		);
	}

	/**
	 * @test
	 */
	public function setInsuranceagentForStringSetsInsuranceagent()
	{
		$this->subject->setInsuranceagent('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'insuranceagent',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getHearaboutusReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setHearaboutusForIntSetsHearaboutus()
	{	}

	/**
	 * @test
	 */
	public function getStaffcommentsReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getStaffcomments()
		);
	}

	/**
	 * @test
	 */
	public function setStaffcommentsForStringSetsStaffcomments()
	{
		$this->subject->setStaffcomments('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'staffcomments',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getMembercommentsReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getMembercomments()
		);
	}

	/**
	 * @test
	 */
	public function setMembercommentsForStringSetsMembercomments()
	{
		$this->subject->setMembercomments('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'membercomments',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getMembershipsReturnsInitialValueForMembership()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getMemberships()
		);
	}

	/**
	 * @test
	 */
	public function setMembershipsForObjectStorageContainingMembershipSetsMemberships()
	{
		$membership = new \Netkyngs\Nkcadportal\Domain\Model\Membership();
		$objectStorageHoldingExactlyOneMemberships = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneMemberships->attach($membership);
		$this->subject->setMemberships($objectStorageHoldingExactlyOneMemberships);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneMemberships,
			'memberships',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addMembershipToObjectStorageHoldingMemberships()
	{
		$membership = new \Netkyngs\Nkcadportal\Domain\Model\Membership();
		$membershipsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$membershipsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($membership));
		$this->inject($this->subject, 'memberships', $membershipsObjectStorageMock);

		$this->subject->addMembership($membership);
	}

	/**
	 * @test
	 */
	public function removeMembershipFromObjectStorageHoldingMemberships()
	{
		$membership = new \Netkyngs\Nkcadportal\Domain\Model\Membership();
		$membershipsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$membershipsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($membership));
		$this->inject($this->subject, 'memberships', $membershipsObjectStorageMock);

		$this->subject->removeMembership($membership);

	}

	/**
	 * @test
	 */
	public function getContactsReturnsInitialValueForContact()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getContacts()
		);
	}

	/**
	 * @test
	 */
	public function setContactsForObjectStorageContainingContactSetsContacts()
	{
		$contact = new \Netkyngs\Nkcadportal\Domain\Model\Contact();
		$objectStorageHoldingExactlyOneContacts = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneContacts->attach($contact);
		$this->subject->setContacts($objectStorageHoldingExactlyOneContacts);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneContacts,
			'contacts',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addContactToObjectStorageHoldingContacts()
	{
		$contact = new \Netkyngs\Nkcadportal\Domain\Model\Contact();
		$contactsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$contactsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($contact));
		$this->inject($this->subject, 'contacts', $contactsObjectStorageMock);

		$this->subject->addContact($contact);
	}

	/**
	 * @test
	 */
	public function removeContactFromObjectStorageHoldingContacts()
	{
		$contact = new \Netkyngs\Nkcadportal\Domain\Model\Contact();
		$contactsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$contactsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($contact));
		$this->inject($this->subject, 'contacts', $contactsObjectStorageMock);

		$this->subject->removeContact($contact);

	}
}
