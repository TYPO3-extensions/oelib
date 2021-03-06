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
 * This class represents a language.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class Tx_Oelib_Model_Language extends Tx_Oelib_Model {
	/**
	 * @var boolean whether this model is read-only
	 */
	protected $readOnly = TRUE;

	/**
	 * Returns the language's local name.
	 *
	 * @return string the language's local name, will not be empty
	 */
	public function getLocalName() {
		return $this->getAsString('lg_name_local');
	}

	/**
	 * Returns the ISO 639-1 alpha-2 code for this language.
	 *
	 * @return string the ISO 639-1 alpha-2 code of this language, will not be empty
	 */
	public function getIsoAlpha2Code() {
		return $this->getAsString('lg_iso_2');
	}
}