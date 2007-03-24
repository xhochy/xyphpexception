<?php
/**
 * The General Testsuite, executes all Tests
 * 
 * @author Uwe L. Korn <uwelk@xhochy.org>
 * @package XYException-Tests
 * @license http://opensource.org/licenses/mit-license.php MIT
 */

## Defines ##
 
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'AllTests::main');
}

## Test Includes ##

require_once dirname(__FILE__).'/xyexception.test.php';

## PHPUnit Includes ##

require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

## The Testsuite ##
 
class AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }
 
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PHPUnit');
 
        $suite->addTestSuite('XYExceptionTest');
 
        return $suite;
    }
}
 
if (PHPUnit_MAIN_METHOD == 'AllTests::main') {
    AllTests::main();
}