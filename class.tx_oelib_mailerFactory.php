<?php
/***************************************************************
* Copyright notice
*
* (c) 2008 Saskia Metzler <saskia@merlin.owl.de> All rights reserved
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
 * Class 'tx_oelib_mailerFactory' for the 'oelib' extension.
 *
 * This class returns either an instance of the tx_oelib_realMailer which sends
 * e-mails or an instance of the tx_oelib_emailCollector. The collector stores
 * the data provided to sendEmail() and does not send it. This mode is for
 * testing purposes.
 *
 * @package		TYPO3
 * @subpackage	tx_oelib
 * @author		Saskia Metzler <saskia@merlin.owl.de>
 */
require_once(t3lib_extMgm::extPath('oelib').'class.tx_oelib_realMailer.php');
require_once(t3lib_extMgm::extPath('oelib').'class.tx_oelib_emailCollector.php');

class tx_oelib_mailerFactory {
	/** the singleton factory */
	private static $instance = null;

	/** whether the test mode is set */
	private $isTestMode = false;

	/** the mailer object */
	private $mailer = null;

	/**
	 * Don't call this constructor; use getInstance() instead.
	 */
	private function __construct() {
	}

	/**
	 * Retrieves the singleton instance of the factory.
	 *
	 * @return	tx_oelib_mailerFactory		the singleton factory
	 */
	public static function getInstance() {
		if (!is_object(self::$instance)) {
			self::$instance = new tx_oelib_mailerFactory();
		}

		return self::$instance;
	}

	/**
	 * Retrieves the singleton mailer instance. Depending on the mode, this
	 * instance is either an e-mail collector or a real mailer.
	 *
	 * @return	tx_oelib_abstractMailer		the singleton mailer object
	 */
	public function getMailer() {
		if ($this->isTestMode) {
			$className = 'tx_oelib_emailCollector';
		} else {
			$className = 'tx_oelib_realMailer';
		}

		if (!is_object($this->mailer)
			|| (get_class($this->mailer) != $className)
		) {
			$this->mailer = t3lib_div::makeInstance($className);
		}

		return $this->mailer;
	}

	/**
	 * Enables the test mode.
	 */
	public function enableTestMode() {
		$this->isTestMode = true;
	}

	/**
	 * Disables the test mode.
	 */
	public function disableTestMode() {
		$this->isTestMode = false;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/oelib/class.tx_oelib_mailerFactory.php']) {
	include_once ($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/oelib/class.tx_oelib_mailerFactory.php']);
}
?>