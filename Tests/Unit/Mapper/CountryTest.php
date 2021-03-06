<?php
/***************************************************************
* Copyright notice
*
* (c) 2009-2013 Niels Pardon (mail@niels-pardon.de)
* All rights reserved
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Test case.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class Tx_Oelib_Mapper_CountryTest extends Tx_Phpunit_TestCase {
	/**
	 * @var tx_oelib_Mapper_Country
	 */
	private $subject;

	public function setUp() {
		$this->subject = new tx_oelib_Mapper_Country();
	}

	public function tearDown() {
		unset($this->subject);
	}


	///////////////////////////
	// Tests concerning find.
	///////////////////////////

	/**
	 * @test
	 */
	public function findWithUidOfExistingRecordReturnsCountryInstance() {
		$this->assertTrue(
			$this->subject->find(54) instanceof Tx_Oelib_Model_Country
		);
	}

	/**
	 * @test
	 */
	public function findWithUidOfExistingRecordReturnsRecordAsModel() {
		$this->assertSame(
			'DE',
			$this->subject->find(54)->getIsoAlpha2Code()
		);
	}


	/////////////////////////////////////////
	// Tests regarding findByIsoAlpha2Code.
	/////////////////////////////////////////

	/**
	 * @test
	 */
	public function findByIsoAlpha2CodeWithIsoAlpha2CodeOfExistingRecordReturnsCountryInstance() {
		$this->assertTrue(
			$this->subject->findByIsoAlpha2Code('DE')
				instanceof Tx_Oelib_Model_Country
		);
	}

	/**
	 * @test
	 */
	public function findByIsoAlpha2CodeWithIsoAlpha2CodeOfExistingRecordReturnsRecordAsModel() {
		$this->assertSame(
			'DE',
			$this->subject->findByIsoAlpha2Code('DE')->getIsoAlpha2Code()
		);
	}


	/////////////////////////////////////////
	// Tests regarding findByIsoAlpha3Code.
	/////////////////////////////////////////

	/**
	 * @test
	 */
	public function findByIsoAlpha3CodeWithIsoAlpha3CodeOfExistingRecordReturnsCountryInstance() {
		$this->assertTrue(
			$this->subject->findByIsoAlpha3Code('DEU')
				instanceof Tx_Oelib_Model_Country
		);
	}

	/**
	 * @test
	 */
	public function findByIsoAlpha3CodeWithIsoAlpha3CodeOfExistingRecordReturnsRecordAsModel() {
		$this->assertSame(
			'DE',
			$this->subject->findByIsoAlpha3Code('DEU')->getIsoAlpha2Code()
		);
	}
}