<?php
/***************************************************************
* Copyright notice
*
* (c) 2008-2014 Saskia Metzler <saskia@merlin.owl.de>
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
 * This class sends e-mails.
 *
 * Regarding the Strategy pattern, sendEmail() represents one concrete behavior.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Saskia Metzler <saskia@merlin.owl.de>
 */
class Tx_Oelib_RealMailer extends Tx_Oelib_AbstractMailer {
	/**
	 * Sends a plain-text e-mail.
	 *
	 * Note: This function cannot handle multi-part e-mails.
	 *
	 * @param string $emailAddress the recipient's e-mail address, will not be validated, must not be empty
	 * @param string $subject e-mail subject, must not be empty
	 * @param string $message message to send, must not be empty
	 * @param string $headers headers, separated by linefeed, may be empty
	 * @param string $encodingType encoding type: "quoted-printable" or "8bit"
	 * @param string $charset
	 *        charset to use for encoding headers (only if $encodingType is set to a valid value which produces such a header)
	 * @param boolean $doNotEncodeHeader if set, the header content will not be encoded
	 *
	 * @return boolean TRUE if the e-mail was sent, FALSE otherwise
	 */
	public function sendEmail(
		$emailAddress,
		$subject,
		$message,
		$headers = '',
		$encodingType = '',
		$charset = '',
		$doNotEncodeHeader = FALSE
	) {
		return t3lib_div::plainMailEncoded(
			$emailAddress,
			$subject,
			$this->formatEmailBody($message),
			$headers,
			$encodingType,
			$charset,
			$doNotEncodeHeader
		);
	}

	/**
	 * Sends an e-mail.
	 *
	 * This function can handle plain-text and multi-part e-mails.
	 *
	 * @param string $emailAddress
	 *        the recipient's e-mail address, will not be validated, must not be
	 *        empty
	 * @param string $subject e-mail subject, must not be empty
	 * @param string $message message to send, must not be empty
	 * @param string $headers headers, separated by linefeed, may be empty
	 * @param string $additionalParameters
	 *        additional parameters to pass to the mail program as command line
	 *        arguments
	 *
	 * @return boolean TRUE if the e-mail was sent, FALSE otherwise
	 */
	public function mail(
		$emailAddress, $subject, $message, $headers = '',
		$additionalParameters = ''
	) {
		$this->checkParameters($emailAddress, $subject, $message);

		if (!ini_get('safe_mode')) {
			return @mail(
				$emailAddress, $subject, $message, $headers,
				$additionalParameters
			);
		} else {
			return @mail($emailAddress, $subject, $message, $headers);
		}
	}
}