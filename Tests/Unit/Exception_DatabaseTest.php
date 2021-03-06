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
 * @subpackage oelib
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class Tx_Oelib_Exception_DatabaseTest extends Tx_Phpunit_TestCase {
	/**
	 * @var boolean the saved content of $GLOBALS['TYPO3_DB']->debugOutput
	 */
	private $savedDebugOutput;

	/**
	 * @var boolean the saved content of
	 *              $GLOBALS['TYPO3_DB']->store_lastBuiltQuery
	 */
	private $savedStoreLastBuildQuery;

	public function setUp() {
		$this->savedDebugOutput = $GLOBALS['TYPO3_DB']->debugOutput;
		$this->savedStoreLastBuildQuery
			= $GLOBALS['TYPO3_DB']->store_lastBuiltQuery;

		$GLOBALS['TYPO3_DB']->debugOutput = FALSE;
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = TRUE;
	}

	public function tearDown() {
		$GLOBALS['TYPO3_DB']->debugOutput = $this->savedDebugOutput;
		$GLOBALS['TYPO3_DB']->store_lastBuiltQuery
			= $this->savedStoreLastBuildQuery;
	}

	/**
	 * @test
	 */
	public function messageForInvalidQueryContainsErrorMessageFromDatabase() {
		$GLOBALS['TYPO3_DB']->exec_SELECTquery('asdf', 'tx_oelib_test', '');
		$subject = new tx_oelib_Exception_Database();

		$this->assertContains(
			'asdf',
			$subject->getMessage()
		);
	}

	/**
	 * @test
	 */
	public function messageForInvalidQueryWithLastQueryEnabledContainsLastQuery() {
		$GLOBALS['TYPO3_DB']->exec_SELECTquery('asdf', 'tx_oelib_test', '');
		$subject = new tx_oelib_Exception_Database();

		$this->assertContains(
			'SELECT',
			$subject->getMessage()
		);
	}
}