<?php
/***************************************************************
* Copyright notice
*
* (c) 2009-2013 Oliver Klee (typo3-coding@oliverklee.de)
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
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class Tx_Oelib_ObjectFactoryTest extends Tx_Phpunit_TestCase {
	public function setUp() {
	}

	public function tearDown() {
	}


	/**
	 * @test
	 */
	public function canCreateInstanceOfClassWithConstructorWithoutParameters() {
		$this->assertTrue(
			Tx_Oelib_ObjectFactory::make('Tx_Oelib_Tests_Unit_Fixtures_TestingModel')
				instanceof Tx_Oelib_Tests_Unit_Fixtures_TestingModel
		);
	}

	/**
	 * @test
	 */
	public function canCreateInstanceOfClassWithConstructorWithParameters() {
		$object = Tx_Oelib_ObjectFactory::make(
			'Tx_Oelib_Translator', 'de', '', array()
		);

		$this->assertTrue(
			$object instanceof Tx_Oelib_Translator
		);

		$this->assertSame(
			'de',
			$object->getLanguageKey()
		);
	}

	/**
	 * @test
	 */
	public function makeInstantiatesSubclassIfXclassIsAvailable() {
		if (t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) >= 6001000) {
			$this->markTestSkipped('This test is skipped because the XCLASS handling has been changed in TYPO3 CMS 6.0');
		}


		$object = Tx_Oelib_ObjectFactory::make('Tx_Oelib_Tests_Unit_Fixtures_Empty');

		$this->assertSame(
			'ux_Tx_Oelib_Tests_Unit_Fixtures_Empty',
			get_class($object)
		);
	}
}