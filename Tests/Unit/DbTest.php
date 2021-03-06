<?php
/***************************************************************
* Copyright notice
*
* (c) 2008-2014 Oliver Klee (typo3-coding@oliverklee.de)
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

if (!defined('OELIB_TESTTABLE')) {
	define('OELIB_TESTTABLE', 'tx_oelib_test');
}
if (!defined('OELIB_TESTTABLE_MM')) {
	define('OELIB_TESTTABLE_MM', 'tx_oelib_test_article_mm');
}

/**
 * Test case.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class Tx_Oelib_DbTest extends Tx_Phpunit_TestCase {
	/**
	 * @var Tx_Oelib_TestingFramework
	 */
	private $testingFramework;

	public function setUp() {
		$this->testingFramework = new Tx_Oelib_TestingFramework('tx_oelib');
	}

	public function tearDown() {
		$this->testingFramework->cleanUp();

		unset($this->testingFramework);
	}


	/*
	 * Utility functions
	 */

	/**
	 * Explodes a comma-separated list of integer values and sorts them
	 * numerically.
	 *
	 * @param string $valueList
	 *        comma-separated list of values, may be empty
	 *
	 * @return array the separate values, sorted numerically, may be empty
	 */
	private function sortExplode($valueList) {
		if ($valueList == '') {
			return array();
		}

		$numbers = t3lib_div::intExplode(',', $valueList);
		sort($numbers, SORT_NUMERIC);

		return ($numbers);
	}


	/*
	 * Tests for the utility functions
	 */

	/**
	 * @test
	 */
	public function sortExplodeWithEmptyStringReturnsEmptyArray() {
		$this->assertSame(
			array(),
			$this->sortExplode('')
		);
	}

	/**
	 * @test
	 */
	public function sortExplodeWithOneNumberReturnsArrayWithNumber() {
		$this->assertSame(
			array(42),
			$this->sortExplode('42')
		);
	}

	/**
	 * @test
	 */
	public function sortExplodeWithTwoAscendingNumbersReturnsArrayWithBothNumbers() {
		$this->assertSame(
			array(1, 2),
			$this->sortExplode('1,2')
		);
	}

	/**
	 * @test
	 */
	public function sortExplodeWithTwoDescendingNumbersReturnsSortedArrayWithBothNumbers() {
		$this->assertSame(
			array(1, 2),
			$this->sortExplode('2,1')
		);
	}


	/*
	 * Tests for enableFields
	 */

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function enableFieldsThrowsExceptionForTooSmallShowHidden() {
		Tx_Oelib_Db::enableFields(OELIB_TESTTABLE, -2);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function enableFieldsThrowsExceptionForTooBigShowHidden() {
		Tx_Oelib_Db::enableFields(OELIB_TESTTABLE, 2);
	}

	/**
	 * @test
	 */
	public function enableFieldsIsDifferentForDifferentTables() {
		$this->assertNotSame(
			Tx_Oelib_Db::enableFields(OELIB_TESTTABLE),
			Tx_Oelib_Db::enableFields('pages')
		);
	}

	/**
	 * @test
	 */
	public function enableFieldsCanBeDifferentForShowHiddenZeroAndOne() {
		$this->assertNotSame(
			Tx_Oelib_Db::enableFields(OELIB_TESTTABLE, 0),
			Tx_Oelib_Db::enableFields(OELIB_TESTTABLE, 1)
		);
	}

	/**
	 * @test
	 */
	public function enableFieldsAreTheSameForShowHiddenZeroAndMinusOne() {
		$this->assertSame(
			Tx_Oelib_Db::enableFields(OELIB_TESTTABLE, 0),
			Tx_Oelib_Db::enableFields(OELIB_TESTTABLE, -1)
		);
	}

	/**
	 * @test
	 */
	public function enableFieldsCanBeDifferentForShowHiddenOneAndMinusOne() {
		$this->assertNotSame(
			Tx_Oelib_Db::enableFields(OELIB_TESTTABLE, 1),
			Tx_Oelib_Db::enableFields(OELIB_TESTTABLE, -1)
		);
	}

	/**
	 * @test
	 */
	public function enableFieldsCanBeDifferentForDifferentIgnores() {
		$this->assertNotSame(
			Tx_Oelib_Db::enableFields(OELIB_TESTTABLE, 0, array()),
			Tx_Oelib_Db::enableFields(
				OELIB_TESTTABLE, 0, array('endtime' => TRUE)
			)
		);
	}


	/*
	 * Tests concerning createRecursivePageList
	 */

	/**
	 * @test
	 */
	public function createRecursivePageListReturnsAnEmptyStringForNoPagesWithDefaultRecursion() {
		$this->assertSame(
			'',
			Tx_Oelib_Db::createRecursivePageList('')
		);
	}

	/**
	 * @test
	 */
	public function createRecursivePageListReturnsAnEmptyStringForNoPagesWithZeroRecursion() {
		$this->assertSame(
			'',
			Tx_Oelib_Db::createRecursivePageList('', 0)
		);
	}

	/**
	 * @test
	 */
	public function createRecursivePageListReturnsAnEmptyStringForNoPagesWithNonZeroRecursion() {
		$this->assertSame(
			'',
			Tx_Oelib_Db::createRecursivePageList('', 1)
		);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function createRecursivePageListThrowsWithNegativeRecursion() {
		Tx_Oelib_Db::createRecursivePageList('', -1);
	}

	/**
	 * @test
	 */
	public function createRecursivePageListDoesNotContainSubpagesForOnePageWithZeroRecursion() {
		$uid = $this->testingFramework->createSystemFolder();
		$this->testingFramework->createSystemFolder($uid);

		$this->assertSame(
			(string) $uid,
			Tx_Oelib_Db::createRecursivePageList((string) $uid, 0)
		);
	}

	/**
	 * @test
	 */
	public function createRecursivePageListDoesNotContainSubpagesForTwoPagesWithZeroRecursion() {
		$uid1 = $this->testingFramework->createSystemFolder();
		$this->testingFramework->createSystemFolder($uid1);
		$uid2 = $this->testingFramework->createSystemFolder();

		$this->assertSame(
			$this->sortExplode($uid1 . ',' . $uid2),
			$this->sortExplode(
				Tx_Oelib_Db::createRecursivePageList($uid1.','.$uid2, 0)
			)
		);
	}

	/**
	 * @test
	 */
	public function createRecursivePageListDoesNotContainSubsubpagesForRecursionOfOne() {
		$uid = $this->testingFramework->createSystemFolder();
		$subFolderUid = $this->testingFramework->createSystemFolder($uid);
		$this->testingFramework->createSystemFolder($subFolderUid);

		$this->assertSame(
			$this->sortExplode($uid.','.$subFolderUid),
			$this->sortExplode(Tx_Oelib_Db::createRecursivePageList($uid, 1))
		);
	}

	/**
	 * @test
	 */
	public function createRecursivePageListDoesNotContainUnrelatedPages() {
		$uid = $this->testingFramework->createSystemFolder();
		$this->testingFramework->createSystemFolder();

		$this->assertSame(
			(string) $uid,
			Tx_Oelib_Db::createRecursivePageList($uid, 0)
		);
	}

	/**
	 * @test
	 */
	public function createRecursivePageListCanContainTwoSubpagesOfOnePage() {
		$uid = $this->testingFramework->createSystemFolder();
		$subFolderUid1 = $this->testingFramework->createSystemFolder($uid);
		$subFolderUid2 = $this->testingFramework->createSystemFolder($uid);

		$this->assertSame(
			$this->sortExplode($uid.','.$subFolderUid1.','.$subFolderUid2),
			$this->sortExplode(Tx_Oelib_Db::createRecursivePageList($uid, 1))
		);
	}

	/**
	 * @test
	 */
	public function createRecursivePageListCanContainSubpagesOfTwoPages() {
		$uid1 = $this->testingFramework->createSystemFolder();
		$uid2 = $this->testingFramework->createSystemFolder();
		$subFolderUid1 = $this->testingFramework->createSystemFolder($uid1);
		$subFolderUid2 = $this->testingFramework->createSystemFolder($uid2);

		$this->assertSame(
			$this->sortExplode(
				$uid1.','.$uid2.','.$subFolderUid1.','.$subFolderUid2
			),
			$this->sortExplode(
				Tx_Oelib_Db::createRecursivePageList($uid1.','.$uid2, 1)
			)
		);
	}

	/**
	 * @test
	 */
	public function createRecursivePageListHeedsIncreasingRecursionDepthOnSubsequentCalls() {
		$uid = $this->testingFramework->createSystemFolder();
		$subFolderUid = $this->testingFramework->createSystemFolder($uid);

		$this->assertSame(
			(string) $uid,
			Tx_Oelib_Db::createRecursivePageList($uid, 0)
		);
		$this->assertSame(
			$this->sortExplode($uid.','.$subFolderUid),
			$this->sortExplode(Tx_Oelib_Db::createRecursivePageList($uid, 1))
		);
	}

	/**
	 * @test
	 */
	public function createRecursivePageListHeedsDecreasingRecursionDepthOnSubsequentCalls() {
		$uid = $this->testingFramework->createSystemFolder();
		$subFolderUid = $this->testingFramework->createSystemFolder($uid);

		$this->assertSame(
			$this->sortExplode($uid.','.$subFolderUid),
			$this->sortExplode(Tx_Oelib_Db::createRecursivePageList($uid, 1))
		);
		$this->assertSame(
			(string) $uid,
			Tx_Oelib_Db::createRecursivePageList($uid, 0)
		);
	}


	/*
	 * Tests concerning getColumnsInTable
	 */

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function getColumnsInTableForEmptyTableNameThrowsException() {
		Tx_Oelib_Db::getColumnsInTable('');
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function getColumnsInTableForInexistentTableNameThrowsException() {
		Tx_Oelib_Db::getColumnsInTable('tx_oelib_doesnotexist');
	}

	/**
	 * @test
	 */
	public function getColumnsInTableReturnsArrayThatContainsExistingColumn() {
		$columns = Tx_Oelib_Db::getColumnsInTable(OELIB_TESTTABLE);

		$this->assertTrue(
			isset($columns['title'])
		);
	}

	/**
	 * @test
	 */
	public function getColumnsInTableReturnsArrayThatNotContainsInexistentColumn() {
		$columns = Tx_Oelib_Db::getColumnsInTable(OELIB_TESTTABLE);

		$this->assertFalse(
			isset($columns['does_not_exist'])
		);
	}


	/*
	 * Tests concerning getColumnDefinition
	 */

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function getColumnDefinitionForEmptyTableNameThrowsException() {
		Tx_Oelib_Db::getColumnDefinition('', 'uid');
	}

	/**
	 * @test
	 */
	public function getColumnDefinitionReturnsArrayThatContainsFieldName() {
		$definition = Tx_Oelib_Db::getColumnDefinition(OELIB_TESTTABLE, 'title');

		$this->assertTrue(
			$definition['Field'] == 'title'
		);
	}


	/*
	 * Tests regarding tableHasColumnUid()
	 */

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function tableHasColumnUidForEmptyTableNameThrowsException() {
		Tx_Oelib_Db::tableHasColumnUid('');
	}

	/**
	 * @test
	 */
	public function tableHasColumnUidIsTrueOnTableWithColumnUid() {
		$this->assertTrue(
			Tx_Oelib_Db::tableHasColumnUid(OELIB_TESTTABLE)
		);
	}

	/**
	 * @test
	 */
	public function tableHasColumnUidIsFalseOnTableWithoutColumnUid() {
		$this->assertFalse(
			Tx_Oelib_Db::tableHasColumnUid(OELIB_TESTTABLE_MM)
		);
	}

	/**
	 * @test
	 */
	public function tableHasColumnUidCanReturnDifferentResultsForDifferentTables() {
		$this->assertNotSame(
			Tx_Oelib_Db::tableHasColumnUid(OELIB_TESTTABLE),
			Tx_Oelib_Db::tableHasColumnUid(OELIB_TESTTABLE_MM)
		);
	}


	/*
	 * Tests regarding tableHasColumn()
	 */

	/**
	 * @test
	 */
	public function tableHasColumnReturnsTrueOnTableWithColumn() {
		$this->assertTrue(
			Tx_Oelib_Db::tableHasColumn(
				OELIB_TESTTABLE, 'title'
			)
		);
	}

	/**
	 * @test
	 */
	public function tableHasColumnReturnsFalseOnTableWithoutColumn() {
		$this->assertFalse(
			Tx_Oelib_Db::tableHasColumn(
				OELIB_TESTTABLE, 'inexistent_column'
			)
		);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function tableHasColumnThrowsExceptionOnEmptyTableName() {
		Tx_Oelib_Db::tableHasColumn(
			'', 'title'
		);
	}

	/**
	 * @test
	 */
	public function tableHasColumnReturnsFalseOnEmptyColumnName() {
		$this->assertFalse(
			Tx_Oelib_Db::tableHasColumn(
				OELIB_TESTTABLE, ''
			)
		);
	}


	/*
	 * Tests for delete
	 */

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function deleteForEmptyTableNameThrowsException() {
		Tx_Oelib_Db::delete(
			'', 'uid = 0'
		);
	}

	/**
	 * @test
	 */
	public function deleteDeletesRecord() {
		$uid = $this->testingFramework->createRecord(OELIB_TESTTABLE);

		Tx_Oelib_Db::delete(
			OELIB_TESTTABLE, 'uid = ' . $uid
		);

		$this->assertFalse(
			$this->testingFramework->existsRecordWithUid(
				OELIB_TESTTABLE, $uid
			)
		);
	}

	/**
	 * @test
	 */
	public function deleteForNoDeletedRecordReturnsZero() {
		$this->assertSame(
			0,
			Tx_Oelib_Db::delete(
				OELIB_TESTTABLE, 'uid = 0'
			)
		);
	}

	/**
	 * @test
	 */
	public function deleteForOneDeletedRecordReturnsOne() {
		$uid = $this->testingFramework->createRecord(OELIB_TESTTABLE);

		$this->assertSame(
			1,
			Tx_Oelib_Db::delete(
				OELIB_TESTTABLE, 'uid = ' . $uid
			)
		);
	}

	/**
	 * @test
	 */
	public function deleteForTwoDeletedRecordsReturnsTwo() {
		$uid1 = $this->testingFramework->createRecord(OELIB_TESTTABLE);
		$uid2 = $this->testingFramework->createRecord(OELIB_TESTTABLE);

		$this->assertSame(
			2,
			Tx_Oelib_Db::delete(
				OELIB_TESTTABLE,
				'uid IN(' . $uid1 . ',' . $uid2 . ')'
			)
		);
	}


	/*
	 * Tests for update
	 */

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function updateForEmptyTableNameThrowsException() {
		Tx_Oelib_Db::update(
			'', 'uid = 0', array()
		);
	}

	/**
	 * @test
	 */
	public function updateChangesRecord() {
		$uid = $this->testingFramework->createRecord(OELIB_TESTTABLE);

		Tx_Oelib_Db::update(
			OELIB_TESTTABLE, 'uid = ' . $uid, array('title' => 'foo')
		);

		$this->assertTrue(
			$this->testingFramework->existsRecord(
				OELIB_TESTTABLE, 'title = "foo"'
			)
		);
	}

	/**
	 * @test
	 */
	public function updateForNoChangedRecordReturnsZero() {
		$this->assertSame(
			0,
			Tx_Oelib_Db::update(
				OELIB_TESTTABLE, 'uid = 0', array('title' => 'foo')
			)
		);
	}

	/**
	 * @test
	 */
	public function updateForOneChangedRecordReturnsOne() {
		$uid = $this->testingFramework->createRecord(OELIB_TESTTABLE);

		$this->assertSame(
			1,
			Tx_Oelib_Db::update(
				OELIB_TESTTABLE, 'uid = ' . $uid, array('title' => 'foo')
			)
		);
	}

	/**
	 * @test
	 */
	public function updateForTwoChangedRecordsReturnsTwo() {
		$uid1 = $this->testingFramework->createRecord(OELIB_TESTTABLE);
		$uid2 = $this->testingFramework->createRecord(OELIB_TESTTABLE);

		$this->assertSame(
			2,
			Tx_Oelib_Db::update(
				OELIB_TESTTABLE,
				'uid IN(' . $uid1 . ',' . $uid2 . ')',
				array('title' => 'foo')
			)
		);
	}


	/*
	 * Tests for insert
	 */

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function insertForEmptyTableNameThrowsException() {
		Tx_Oelib_Db::insert(
			'', array('is_dummy_record' => 1)
		);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function insertForEmptyRecordDataThrowsException() {
		Tx_Oelib_Db::insert(
			OELIB_TESTTABLE, array()
		);
	}

	/**
	 * @test
	 */
	public function insertInsertsRecord() {
		Tx_Oelib_Db::insert(
			OELIB_TESTTABLE, array('title' => 'foo', 'is_dummy_record' => 1)
		);
		$this->testingFramework->markTableAsDirty(OELIB_TESTTABLE);

		$this->assertTrue(
			$this->testingFramework->existsRecord(
				OELIB_TESTTABLE, 'title = "foo"'
			)
		);
	}

	/**
	 * @test
	 */
	public function insertForTableWithUidReturnsUidOfCreatedRecord() {
		$uid = Tx_Oelib_Db::insert(
			OELIB_TESTTABLE, array('is_dummy_record' => 1)
		);
		$this->testingFramework->markTableAsDirty(OELIB_TESTTABLE);

		$this->assertTrue(
			$this->testingFramework->existsRecordWithUid(
				OELIB_TESTTABLE, $uid
			)
		);
	}

	/**
	 * @test
	 */
	public function insertForTableWithoutUidReturnsZero() {
		$this->testingFramework->markTableAsDirty(OELIB_TESTTABLE_MM);

		$this->assertSame(
			0,
			Tx_Oelib_Db::insert(
				OELIB_TESTTABLE_MM, array('is_dummy_record' => 1)
			)
		);
	}


	/*
	 * Tests concerning select, selectSingle, selectMultiple
	 */

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function selectForEmptyTableNameThrowsException() {
		Tx_Oelib_Db::select('*', '');
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function selectForEmptyFieldListThrowsException() {
		Tx_Oelib_Db::select('', OELIB_TESTTABLE);
	}

	/**
	 * @test
	 */
	public function selectReturnsResource() {
		if (t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) >= 6001000) {
			$this->markTestSkipped('This test only applies to TYPO3 CMS < 6.1.');
		}

		$this->assertTrue(
			is_resource(Tx_Phpunit_Service_Database::select('title', 'tx_phpunit_test'))
		);
	}

	/**
	 * @test
	 */
	public function selectReturnsMySqliResult() {
		if (t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) < 6001000) {
			$this->markTestSkipped('This test is available in TYPO3 6.1 and above.');
		}

		$this->assertInstanceOf(
			'mysqli_result',
			Tx_Phpunit_Service_Database::select('title', 'tx_phpunit_test')
		);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function selectSingleForEmptyTableNameThrowsException() {
		Tx_Oelib_Db::selectSingle('*', '');
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function selectSingleForEmptyFieldListThrowsException() {
		Tx_Oelib_Db::selectSingle('', OELIB_TESTTABLE);
	}

	/**
	 * @test
	 */
	public function selectSingleCanFindOneRow() {
		$uid = $this->testingFramework->createRecord(
			OELIB_TESTTABLE
		);

		$this->assertSame(
			array('uid' => (string) $uid),
			Tx_Oelib_Db::selectSingle('uid', OELIB_TESTTABLE, 'uid = ' . $uid)
		);
	}

	/**
	 * @test
	 *
	 * @expectedException tx_oelib_Exception_EmptyQueryResult
	 */
	public function selectSingleForNoResultsThrowsEmptyQueryResultException() {
		Tx_Oelib_Db::selectSingle('uid', OELIB_TESTTABLE, 'title = "nothing"');
	}

	/**
	 * @test
	 */
	public function selectSingleCanOrderTheResults() {
		$this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('title' => 'Title A')
		);
		$uid = $this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('title' => 'Title B')
		);

		$this->assertSame(
			array('uid' => (string) $uid),
			Tx_Oelib_Db::selectSingle('uid', OELIB_TESTTABLE, '', '', 'title DESC')
		);
	}

	/**
	 * @test
	 */
	public function selectSingleCanUseOffset() {
		$this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('title' => 'Title A')
		);
		$uid = $this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('title' => 'Title B')
		);

		$this->assertSame(
			array('uid' => (string) $uid),
			Tx_Oelib_Db::selectSingle('uid', OELIB_TESTTABLE, '', '', 'title', 1)
		);
	}


	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function selectMultipleForEmptyTableNameThrowsException() {
		Tx_Oelib_Db::selectMultiple('*', '');
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function selectMultipleForEmptyFieldListThrowsException() {
		Tx_Oelib_Db::selectMultiple('', OELIB_TESTTABLE);
	}

	/**
	 * @test
	 */
	public function selectMultipleForNoResultsReturnsEmptyArray() {
		$this->assertSame(
			array(),
			Tx_Oelib_Db::selectMultiple(
				'uid', OELIB_TESTTABLE, 'title = "nothing"'
			)
		);
	}

	/**
	 * @test
	 */
	public function selectMultipleCanFindOneRow() {
		$uid = $this->testingFramework->createRecord(
			OELIB_TESTTABLE
		);

		$this->assertSame(
			array(array('uid' => (string) $uid)),
			Tx_Oelib_Db::selectMultiple('uid', OELIB_TESTTABLE, 'uid = ' . $uid)
		);
	}

	/**
	 * @test
	 */
	public function selectMultipleCanFindTwoRows() {
		$this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('title' => 'foo')
		);
		$this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('title' => 'foo')
		);

		$this->assertSame(
			array(
				array('title' => 'foo'),
				array('title' => 'foo'),
			),
			Tx_Oelib_Db::selectMultiple(
				'title', OELIB_TESTTABLE, 'title = "foo"'
			)
		);
	}

	/**
	 * @test
	 */
	public function selectColumnForMultipleForNoMatchesReturnsEmptyArray() {
		$this->assertSame(
			array(),
			Tx_Oelib_Db::selectColumnForMultiple(
				'title', OELIB_TESTTABLE, 'title = "nothing"'
			)
		);
	}

	/**
	 * @test
	 */
	public function selectColumnForMultipleForOneMatchReturnsArrayWithColumnContent() {
		$uid = $this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('title' => 'foo')
		);

		$this->assertSame(
			array('foo'),
			Tx_Oelib_Db::selectColumnForMultiple(
				'title', OELIB_TESTTABLE, 'uid = ' . $uid
			)
		);
	}

	/**
	 * @test
	 */
	public function selectColumnForMultipleForTwoMatchReturnsArrayWithColumnContents() {
		$uid1 = $this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('title' => 'foo')
		);
		$uid2 = $this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('title' => 'bar')
		);

		$result = Tx_Oelib_Db::selectColumnForMultiple(
			'title', OELIB_TESTTABLE, 'uid = ' . $uid1 . ' OR uid = ' . $uid2
		);
		sort($result);
		$this->assertSame(
			array('bar', 'foo'),
			$result
		);
	}


	/*
	 * Tests concerning getAllTableNames
	 */

	/**
	 * @test
	 */
	public function getAllTableNamesContainsExistingTable() {
		$this->assertTrue(
			in_array(OELIB_TESTTABLE, Tx_Oelib_Db::getAllTableNames())
		);
	}

	/**
	 * @test
	 */
	public function getAllTableNamesNotContainsInexistentTable() {
		$this->assertFalse(
			in_array('tx_oelib_doesnotexist', Tx_Oelib_Db::getAllTableNames())
		);
	}


	/*
	 * Tests concerning existsTable
	 */

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function existsTableWithEmptyTableNameThrowsException() {
		Tx_Oelib_Db::existsTable('');
	}

	/**
	 * @test
	 */
	public function existsTableForExistingTableReturnsTrue() {
		$this->assertTrue(
			Tx_Oelib_Db::existsTable(OELIB_TESTTABLE)
		);
	}

	/**
	 * @test
	 */
	public function existsTableForInexistentTableReturnsFalse() {
		$this->assertFalse(
			Tx_Oelib_Db::existsTable('tx_oelib_doesnotexist')
		);
	}


	/*
	 * Tests concerning getTcaForTable
	 */

	/**
	 * @test
	 */
	public function getTcaForTableReturnsValidTcaArray() {
		$tca = Tx_Oelib_Db::getTcaForTable(OELIB_TESTTABLE);

		$this->assertTrue(is_array($tca['ctrl']));
		$this->assertTrue(is_array($tca['interface']));
		$this->assertTrue(is_array($tca['columns']));
		$this->assertTrue(is_array($tca['types']));
		$this->assertTrue(is_array($tca['palettes']));
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function getTcaForTableWithEmptyTableNameThrowsExceptionTca() {
		Tx_Oelib_Db::getTcaForTable('');
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function getTcaForTableWithInexistentTableNameThrowsExceptionTca() {
		Tx_Oelib_Db::getTcaForTable('tx_oelib_doesnotexist');
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function getTcaForTableThrowsExceptionOnTableWithoutTca() {
		Tx_Oelib_Db::getTcaForTable(OELIB_TESTTABLE_MM);
	}

	/**
	 * @test
	 */
	public function getTcaForTableCanLoadFieldsAddedByExtensions() {
		if (!Tx_Oelib_Model_FrontEndUser::hasGenderField()) {
			$this->markTestSkipped(
				'This test is only applicable if the FrontEndUser.gender field exists.'
			);
		}
		$tca = Tx_Oelib_Db::getTcaForTable('fe_users');

		$this->assertTrue(isset($tca['columns']['gender']));
	}


	/*
	 * Tests concerning count
	 */

	/**
	 * @test
	 */
	public function countCanBeCalledWithEmptyWhereClause() {
		Tx_Oelib_Db::count(OELIB_TESTTABLE, '');
	}

	/**
	 * @test
	 */
	public function countCanBeCalledWithMissingWhereClause() {
		Tx_Oelib_Db::count(OELIB_TESTTABLE);
	}

	/**
	 * @test
	 */
	public function countForNoMatchesReturnsZero() {
		$this->assertSame(
			0,
			Tx_Oelib_Db::count(
				OELIB_TESTTABLE,
				'uid = 42'
			)
		);
	}

	/**
	 * @test
	 */
	public function countForOneMatchReturnsOne() {
		$this->assertSame(
			1,
			Tx_Oelib_Db::count(
				OELIB_TESTTABLE,
				'uid = ' . $this->testingFramework->createRecord(OELIB_TESTTABLE)
			)
		);
	}

	/**
	 * @test
	 */
	public function countForTwoMatchesReturnsTwo() {
		$uid1 = $this->testingFramework->createRecord(OELIB_TESTTABLE);
		$uid2 = $this->testingFramework->createRecord(OELIB_TESTTABLE);

		$this->assertSame(
			2,
			Tx_Oelib_Db::count(
				OELIB_TESTTABLE,
				'uid IN(' . $uid1 . ',' . $uid2 . ')'
			)
		);
	}

	/**
	 * @test
	 */
	public function countCanBeCalledForTableWithoutUid() {
		Tx_Oelib_Db::count(OELIB_TESTTABLE_MM);
	}

	/**
	 * @test
	 */
	public function countCanBeCalledWithMultipleTables() {
		Tx_Oelib_Db::count('tx_oelib_test, tx_oelib_testchild');
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function countWithInvalidTableNameThrowsException() {
		Tx_Oelib_Db::count('tx_oelib_doesnotexist', 'uid = 42');
	}

	/**
	 * @test
	 */
	public function countCanBeCalledWithJoinedTables() {
		Tx_Oelib_Db::count('tx_oelib_test JOIN tx_oelib_testchild');
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function countDoesNotAllowJoinWithoutTables() {
		Tx_Oelib_Db::count('JOIN');
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function countDoesNotAllowJoinWithOnlyOneTableOnTheLeft() {
		Tx_Oelib_Db::count('tx_oelib_test JOIN ');
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function countDoesNotAllowJoinWithOnlyOneTableOnTheRight() {
		Tx_Oelib_Db::count('JOIN tx_oelib_test');
	}


	/*
	 * Tests regarding existsRecord
	 */

	/**
	 * @test
	 */
	public function existsRecordWithEmptyWhereClauseIsAllowed() {
		Tx_Oelib_Db::existsRecord(OELIB_TESTTABLE, '');
	}

	/**
	 * @test
	 */
	public function existsRecordWithMissingWhereClauseIsAllowed() {
		Tx_Oelib_Db::existsRecord(OELIB_TESTTABLE);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function existsRecordWithEmptyTableNameThrowsException() {
		Tx_Oelib_Db::existsRecord('');
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function existsRecordWithInvalidTableNameThrowsException() {
		Tx_Oelib_Db::existsRecord('tx_oelib_doesnotexist');
	}

	/**
	 * @test
	 */
	public function existsRecordForNoMatchesReturnsFalse() {
		$this->assertFalse(
			Tx_Oelib_Db::existsRecord(OELIB_TESTTABLE, 'uid = 42')
		);
	}

	/**
	 * @test
	 */
	public function existsRecordForOneMatchReturnsTrue() {
		$uid = $this->testingFramework->createRecord(
			OELIB_TESTTABLE
		);

		$this->assertTrue(
			Tx_Oelib_Db::existsRecord(OELIB_TESTTABLE, 'uid = ' . $uid)
		);
	}

	/**
	 * @test
	 */
	public function existsRecordForTwoMatchesReturnsTrue() {
		$this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('title' => 'foo')
		);
		$this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('title' => 'foo')
		);

		$this->assertTrue(
			Tx_Oelib_Db::existsRecord(OELIB_TESTTABLE, 'title = "foo"')
		);
	}


	/*
	 * Tests regarding existsExactlyOneRecord
	 */

	/**
	 * @test
	 */
	public function existsExactlyOneRecordWithEmptyWhereClauseIsAllowed() {
		Tx_Oelib_Db::existsExactlyOneRecord(OELIB_TESTTABLE, '');
	}

	/**
	 * @test
	 */
	public function existsExactlyOneRecordWithMissingWhereClauseIsAllowed() {
		Tx_Oelib_Db::existsExactlyOneRecord(OELIB_TESTTABLE);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function existsExactlyOneRecordWithEmptyTableNameThrowsException() {
		Tx_Oelib_Db::existsExactlyOneRecord('');
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function existsExactlyOneRecordWithInvalidTableNameThrowsException() {
		Tx_Oelib_Db::existsExactlyOneRecord('tx_oelib_doesnotexist');
	}

	/**
	 * @test
	 */
	public function existsExactlyOneRecordForNoMatchesReturnsFalse() {
		$this->assertFalse(
			Tx_Oelib_Db::existsExactlyOneRecord(OELIB_TESTTABLE, 'uid = 42')
		);
	}

	/**
	 * @test
	 */
	public function existsExactlyOneRecordForOneMatchReturnsTrue() {
		$uid = $this->testingFramework->createRecord(
			OELIB_TESTTABLE
		);

		$this->assertTrue(
			Tx_Oelib_Db::existsExactlyOneRecord(OELIB_TESTTABLE, 'uid = ' . $uid)
		);
	}

	/**
	 * @test
	 */
	public function existsExactlyOneRecordForTwoMatchesReturnsFalse() {
		$this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('title' => 'foo')
		);
		$this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('title' => 'foo')
		);

		$this->assertFalse(
			Tx_Oelib_Db::existsExactlyOneRecord(OELIB_TESTTABLE, 'title = "foo"')
		);
	}


	/*
	 * Tests regarding existsRecordWithUid
	 */

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function existsRecordWithUidWithZeroUidThrowsException() {
		Tx_Oelib_Db::existsRecordWithUid(OELIB_TESTTABLE, 0);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function existsRecordWithUidWithNegativeUidThrowsException() {
		Tx_Oelib_Db::existsRecordWithUid(OELIB_TESTTABLE, -1);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function existsRecordWithUidWithEmptyTableNameThrowsException() {
		Tx_Oelib_Db::existsRecordWithUid('', 42);
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function existsRecordWithUidWithInvalidTableNameThrowsException() {
		Tx_Oelib_Db::existsRecordWithUid('tx_oelib_doesnotexist', 42);
	}

	/**
	 * @test
	 */
	public function existsRecordWithUidForNoMatchReturnsFalse() {
		$this->assertFalse(
			Tx_Oelib_Db::existsRecordWithUid(OELIB_TESTTABLE, 42)
		);
	}

	/**
	 * @test
	 */
	public function existsRecordWithUidForMatchReturnsTrue() {
		$uid = $this->testingFramework->createRecord(
			OELIB_TESTTABLE
		);

		$this->assertTrue(
			Tx_Oelib_Db::existsRecordWithUid(OELIB_TESTTABLE, $uid)
		);
	}

	/**
	 * @test
	 */
	public function existsRecordWithUidUsesAdditionalNonEmptyWhereClause() {
		$uid = $this->testingFramework->createRecord(
			OELIB_TESTTABLE, array('deleted' => 1)
		);

		$this->assertFalse(
			Tx_Oelib_Db::existsRecordWithUid(
				OELIB_TESTTABLE, $uid, ' AND deleted = 0'
			)
		);
	}
}