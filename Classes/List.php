<?php
/***************************************************************
* Copyright notice
*
* (c) 2009-2014 Oliver Klee <typo3-coding@oliverklee.de>
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
 * This class represents a list of models.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class Tx_Oelib_List extends SplObjectStorage {
	/**
	 * @var integer[] the UIDs in the list using the UIDs as both the keys and values
	 */
	private $uids = array();

	/**
	 * The model this List belongs to.
	 *
	 * This is used for modeling relations and will remain NULL in any other
	 * context.
	 *
	 * @var Tx_Oelib_Model
	 */
	private $parentModel = NULL;

	/**
	 * whether there is at least one item without a UID
	 *
	 * @var boolean
	 */
	private $hasItemWithoutUid = FALSE;

	/**
	 * Frees as much memory that has been used by this object as possible.
	 *
	 * Note: The models in this list are not destructed by this function (this
	 * should happen in the data mappers).
	 */
	public function __destruct() {
		$this->rewind();
		foreach ($this as $model) {
			$this->detach($model);
		}

		$this->uids = array();
		unset($this->parentModel);
	}

	/**
	 * Adds a model to this list (as last element) if it is not already in the
	 * list.
	 *
	 * The model to add need not necessarily have a UID.
	 *
	 * @param Tx_Oelib_Model $model the model to add, need not have a UID
	 *
	 * @return void
	 */
	public function add(Tx_Oelib_Model $model) {
		$this->attach($model);

		if ($model->hasUid()) {
			$uid = $model->getUid();
			$this->uids[$uid] = $uid;
		} else {
			$this->hasItemWithoutUid = TRUE;
		}

		// Initializes the Iterator.
		if ($this->count() == 1) {
			$this->rewind();
		}

		$this->markAsDirty();
	}

	/**
	 * Checks whether this list is empty.
	 *
	 * @return boolean TRUE if this list is empty, FALSE otherwise
	 */
	public function isEmpty() {
		return ($this->count() == 0);
	}

	/**
	 * Returns the first item.
	 *
	 * Note: This method rewinds the iterator.
	 *
	 * @return Tx_Oelib_Model the first item, will be NULL if this list is
	 *                        empty
	 */
	public function first() {
		$this->rewind();

		return $this->current();
	}

	/**
	 * Returns a comma-separted list of unique UIDs of the current items,
	 * ordered by first insertion.
	 *
	 * @return string comma-separated list of UIDs, will be empty if the list is
	 *                empty or no item has a UID
	 */
	public function getUids() {
		$this->checkUidCache();
		return implode(',', $this->uids);
	}

	/**
	 * Checks whether a model with a certain UID exists in this list
	 *
	 * @param integer $uid UID to test, must be > 0
	 *
	 * @return boolean TRUE if a model with the UID $uid exists in this list, FALSE otherwise
	 */
	public function hasUid($uid) {
		$this->checkUidCache();
		return isset($this->uids[$uid]);
	}

	/**
	 * Checks whether the UID list cache needs to be rebuild and does so if
	 * necessary.
	 *
	 * @return void
	 */
	private function checkUidCache() {
		if ($this->hasItemWithoutUid) {
			$this->rebuildUidCache();
		}
	}

	/**
	 * Rebuilds the UID cache.
	 *
	 * @return void
	 */
	private function rebuildUidCache() {
		$this->hasItemWithoutUid = FALSE;

		foreach ($this as $item) {
			if ($item->hasUid()) {
				$uid = $item->getUid();
				$this->uids[$uid] = $uid;
			} else {
				$this->hasItemWithoutUid = TRUE;
			}
		}
	}

	/**
	 * Sorts this list by using the given callback function.
	 *
	 * The callback function, must take 2 parameters and return -1, 0 or 1.
	 * The return value -1 means that the first parameter is sorted before the
	 * second one, 1 means that the second parameter is sorted before the first
	 * one and 0 means the parameters stay in order.
	 *
	 * @param mixed $callbackFunction a callback function to use with the models stored in the list, must not be empty
	 *
	 * @return void
	 */
	public function sort($callbackFunction) {
		$items = iterator_to_array($this, FALSE);
		usort($items, $callbackFunction);

		foreach ($items as $item) {
			$this->detach($item);
			$this->attach($item);
		}

		$this->markAsDirty();
	}

	/**
	 * Appends the contents of $list to this list.
	 *
	 * Note: Since Tx_Oelib_List extends SplObjectStorage this method is in most
	 * cases an synonym to appendUnique() as SplObjectStorage makes sure that
	 * no object is added more than once to it.
	 *
	 * @param Tx_Oelib_List $list the list to append, may be empty
	 *
	 * @return void
	 */
	public function append(Tx_Oelib_List $list) {
		foreach ($list as $item) {
			$this->add($item);
		}
	}

	/**
	 * Appends the contents of $list to this list. If an item with specific UID
	 * already exists in the list, the new item to append will be igored.
	 *
	 * @param Tx_Oelib_List $list the list to append, may be empty
	 *
	 * @deprecated 2010-05-27 use append() instead
	 *
	 * @return void
	 */
	public function appendUnique(Tx_Oelib_List $list) {
		t3lib_div::logDeprecatedFunction();

		foreach ($list as $item) {
			if (!$this->hasUid($item->getUid())) {
				$this->add($item);
			}
		}
	}

	/**
	 * Drops the current element from the list and sets the pointer to the
	 * next element.
	 *
	 * If the pointer does not point to a valid element, this function is a
	 * no-op.
	 *
	 * @return void
	 */
	public function purgeCurrent() {
		if (!$this->valid()) {
			return;
		}

		if ($this->current()->hasUid()) {
			$uid = $this->current()->getUid();
			if (isset($this->uids[$uid])) {
				unset($this->uids[$uid]);
			}
		}

		$this->detach($this->current());

		$this->markAsDirty();
	}

	/**
	 * Sets the model this list belongs to.
	 *
	 * @param Tx_Oelib_Model $model the model this list belongs to
	 *
	 * @return void
	 */
	public function setParentModel(Tx_Oelib_Model $model) {
		$this->parentModel = $model;
	}

	/**
	 * Marks the parent model as dirty.
	 *
	 * @return void
	 */
	protected function markAsDirty() {
		if ($this->parentModel instanceof Tx_Oelib_Model) {
			$this->parentModel->markAsDirty();
		}
	}

	/**
	 * Sorts this list item in ascending order by their sorting.
	 *
	 * This function may only be used if all items in this list implement the
	 * tx_oelib_Interface_Sortable interface.
	 *
	 * @return void
	 */
	public function sortBySorting() {
		$this->sort(array($this, 'compareSortings'));
	}

	/**
	 * Internal callback function for sorting two sortable objects.
	 *
	 * This function is not intended to be used from the outside.
	 *
	 * @param tx_oelib_Interface_Sortable $object1 the first object
	 * @param tx_oelib_Interface_Sortable $object2 the second object
	 *
	 * @return integer a negative number if $model1 should be before $model2,
	 *                 a positive number if $model1 should be after $model2,
	 *                 zero if both are equal for sorting
	 */
	public function compareSortings(
		tx_oelib_Interface_Sortable $object1,
		tx_oelib_Interface_Sortable $object2
	) {
		return $object1->getSorting() - $object2->getSorting();
	}

	/**
	 * Returns $length elements from this list starting at position $start.
	 *
	 * If $start after this list's end, this function will return an empty list.
	 *
	 * If this list's end lies within the requested range, all elements up to
	 * the list's end will be returned.
	 *
	 * @param integer $start the zero-based start position, must be >= 0
	 * @param integer $length the number of elements to return, must be >= 0
	 *
	 * @return Tx_Oelib_List<Tx_Oelib_Model>
	 *         the selected elements starting at $start
	 */
	public function inRange($start, $length) {
		if ($start < 0) {
			throw new InvalidArgumentException('$start must be >= 0.');
		}
		if ($length < 0) {
			throw new InvalidArgumentException('$length must be >= 0.');
		}

		$result = t3lib_div::makeInstance('Tx_Oelib_List');

		$lastPosition = $start + $length - 1;
		$currentIndex = 0;
		foreach ($this as $item) {
			if ($currentIndex > $lastPosition) {
				 break;
			}
			if ($currentIndex >= $start) {
				 $result->add($item);
			}
			$currentIndex++;
		}

		return $result;
	}

	/**
	 * Returns the model at position $position.
	 *
	 * @param integer $position
	 *        the zero-based position of the model to retrieve, must be >= 0
	 *
	 * @return Tx_Oelib_Model
	 *         the model at position $position, will be NULL if there are not
	 *         at least ($position + 1) models in this list
	 */
	public function at($position) {
		return $this->inRange($position, 1)->first();
	}

	/**
	 * Returns the elements of this list in an array.
	 *
	 * @return Tx_Oelib_Model[]
	 *         the elements of this list, might be empty
	 */
	public function toArray() {
		$elements = array();
		foreach ($this as $model) {
			$elements[] = $model;
		}

		return $elements;
	}
}