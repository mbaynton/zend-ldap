<?php
/**
 * @link      http://github.com/zendframework/zend-ldap for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

/*
 * Set error reporting to the level to which Zend Framework code must comply.
 */
error_reporting(E_ALL | E_STRICT);

/**
 * Setup autoloading
 */
require __DIR__ . '/../vendor/autoload.php';

/**
 * Start output buffering, if enabled
 */
if (defined('TESTS_ZEND_OB_ENABLED') && constant('TESTS_ZEND_OB_ENABLED')) {
    ob_start();
}

/**
 * Work around https://bugs.php.net/bug.php?id=68541 by defining function
 * mocks early.
 *
 * The Mock instances need to be defined now, but accessible for enabling/
 * inspection by OfflineTest.
 * They are wrapped in a class because if they were simply declared globally,
 * phpunit would find them and error while attempting to serialize global
 * variables.
 */
\ZendTest\Ldap\TestAsset\BuiltinFunctionMocks::createMocks();
