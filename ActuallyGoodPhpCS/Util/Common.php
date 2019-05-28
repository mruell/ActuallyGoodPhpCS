<?php
/**
 * Basic util functions.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace ActuallyGoodPhpCS\Util;

class Common {
	/**
	 * Returns true if the specified string is in the underscore caps format.
	 *
	 * @param string $string The string to verify.
	 *
	 * @return boolean
	 */
	public static function isSnakeCase ($string) {
		// If there are space in the name, it can't be valid.
		if (strpos($string, ' ') !== false) {
			return false;
		}

		// Snake case has to be all lowercase
		if ($string !== strtolower($string)) {
			return false;
		}

		$validName = true;
		$nameBits  = explode('_', $string);

		if (preg_match('|^[a-z]|', $string) === 0) {
			// Name does not begin with a capital letter.
			$validName = false;
		} else {
			foreach ($nameBits as $bit) {
				if ($bit === '') {
					continue;
				}

				if ($bit{0} !== strtolower($bit{0})) {
					$validName = false;
					break;
				}
			}
		}

		return $validName;
	}
}
