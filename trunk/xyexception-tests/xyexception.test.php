<?php
/**
 * This file tests the XYException
 * 
 * @author Uwe L. Korn <uwelk@xhochy.org>
 * @package XYException-Tests
 * @license http://opensource.org/licenses/mit-license.php MIT
 */

## Main XYException Code Includes ##

/** Load the class definition */
require_once dirname(__FILE__).'/../xyexception-includes/xyexception.exception.php';

## PHPUnit Includes ##
 
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/Extensions/ExceptionTestCase.php';

## Test ##

/**
 * Testsuite for the XYException class
 * 
 * @package XYException-Tests
 * @author Uwe L. Korn <uwelk@xhochy.org>
 */ 
class XYExceptionTest extends PHPUnit_Extensions_ExceptionTestCase
{
	/**
	 * Checks is the Exception throws well
	 * 
	 * @author Uwe L. Korn <uwelk@xhochy.org>
	 */
	public function testStandard()
	{
		$this->setExpectedException('XYException');
		
		throw new XYException('testerror',0);
	}
	
	public function testAddVar()
	{
		$oException = new XYException('testerror',0);
		$oException->addVar('s','t');
		$sVars = $oException->VarsToString();
		if(empty($sVars)) {
			$this->fail();
		}
	}
	
	public function testAddTrace()
	{
		$oException = new XYException('testerror',0);
		$oException->addTrace(__FILE__, __LINE__, __FUNCTION__, __CLASS__);
		$sTrace = $oException->TraceToString();
		if(empty($sTrace)) {
			$this->fail();
		}
	}
}