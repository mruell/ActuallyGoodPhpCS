<?php
/**
 * Ensures method names are correct.
 *
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace ActuallyGoodPhpCS\Sniffs\NamingConventions;

use PHP_CodeSniffer\Standards\PEAR\Sniffs\NamingConventions\ValidFunctionNameSniff as PEARValidFunctionNameSniff;
use PHP_CodeSniffer\Util\Common;
use PHP_CodeSniffer\Files\File;

use ActuallyGoodPhpCS\Util\Common as CustomCommon;

class ValidFunctionNameSniff extends PEARValidFunctionNameSniff {
	/**
	 * Processes the tokens outside the scope.
	 *
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being processed.
	 * @param int                         $stackPtr  The position where this token was
	 *                                               found.
	 *
	 * @return void
	 */
	protected function processTokenOutsideScope (File $phpcsFile, $stackPtr) {
		$functionName = $phpcsFile->getDeclarationName($stackPtr);
		if ($functionName === null) {
			return;
		}

		$errorData = [$functionName];

		// Allow single underscore before function name
		if (preg_match('|^_|', $functionName) !== 0) {
			$functionName =  substr($functionName, 1);
		}

		if (CustomCommon::isSnakeCase($functionName) === false) {
			$error = 'Function name "%s" is not in camel case format';
			$phpcsFile->addError($error, $stackPtr, 'NotCamelCase', $errorData);
		}
	}
}
