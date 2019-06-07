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
use PHP_CodeSniffer\Files\File;

use PHP_CodeSniffer\Util\Common;
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
			$functionName = substr($functionName, 1);
		}

		if (CustomCommon::isSnakeCase($functionName) === false) {
			$error = 'Function name "%s" is not in camel case format';
			$phpcsFile->addError($error, $stackPtr, 'NotCamelCase', $errorData);
		}
	}

	/**
	 * Processes the tokens within the scope.
	 *
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being processed.
	 * @param int                         $stackPtr  The position where this token was
	 *                                               found.
	 * @param int                         $currScope The position of the current scope.
	 *
	 * @return void
	 */
	protected function processTokenWithinScope (File $phpcsFile, $stackPtr, $currScope) {
		$tokens = $phpcsFile->getTokens();

		// Determine if this is a function which needs to be examined.
		$conditions = $tokens[$stackPtr]['conditions'];
		end($conditions);
		$deepestScope = key($conditions);
		if ($deepestScope !== $currScope) {
			return;
		}

		$methodName = $phpcsFile->getDeclarationName($stackPtr);
		if ($methodName === null) {
			// Ignore closures.
			return;
		}

		$className = $phpcsFile->getDeclarationName($currScope);
		if (isset($className) === false) {
			$className = '[Anonymous Class]';
		}

		$errorData = [$className . '::' . $methodName];

		$methodNameLc = strtolower($methodName);
		$classNameLc  = strtolower($className);

		// Is this a magic method. i.e., is prefixed with "__" ?
		if (preg_match('|^__[^_]|', $methodName) !== 0) {
			$magicPart = substr($methodNameLc, 2);
			if (isset($this->magicMethods[$magicPart]) === true) {
				return;
			}

			$error = 'Method name "%s" is invalid; only PHP magic methods should be prefixed with a double underscore';
			$phpcsFile->addError($error, $stackPtr, 'MethodDoubleUnderscore', $errorData);
		}

		// PHP4 constructors are allowed to break our rules.
		if ($methodNameLc === $classNameLc) {
			return;
		}

		// PHP4 destructors are allowed to break our rules.
		if ($methodNameLc === '_' . $classNameLc) {
			return;
		}

		$methodProps    = $phpcsFile->getMethodProperties($stackPtr);
		$scope          = $methodProps['scope'];
		$scopeSpecified = $methodProps['scope_specified'];

		if ($methodProps['scope'] === 'private') {
			$isPublic = false;
		} else {
			$isPublic = true;
		}

		// // If it's a private method, it must have an underscore on the front.
		// if ($isPublic === false) {
		// 	if ($methodName{0} !== '_') {
		// 		$error = 'Private method name "%s" must be prefixed with an underscore';
		// 		$phpcsFile->addError($error, $stackPtr, 'PrivateNoUnderscore', $errorData);
		// 		$phpcsFile->recordMetric($stackPtr, 'Private method prefixed with underscore', 'no');
		// 	} else {
		// 		$phpcsFile->recordMetric($stackPtr, 'Private method prefixed with underscore', 'yes');
		// 	}
		// }

		// If it's not a private method, it must not have an underscore on the front.
		if ($isPublic === true && $scopeSpecified === true && $methodName{0} === '_') {
			$error = '%s method name "%s" must not be prefixed with an underscore';
			$data  = [
				ucfirst($scope),
				$errorData[0]
			];
			$phpcsFile->addError($error, $stackPtr, 'PublicUnderscore', $data);
		}

		$testMethodName = ltrim($methodName, '_');

		if (Common::isCamelCaps($testMethodName, false, true, false) === false) {
			if ($scopeSpecified === true) {
				$error = '%s method name "%s" is not in camel caps format';
				$data  = [
					ucfirst($scope),
					$errorData[0]
				];
				$phpcsFile->addError($error, $stackPtr, 'ScopeNotCamelCaps', $data);
			} else {
				$error = 'Method name "%s" is not in camel caps format';
				$phpcsFile->addError($error, $stackPtr, 'NotCamelCaps', $errorData);
			}
		}
	}
}
