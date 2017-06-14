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
class LdapReusableMocks
{
    public static $ldap_connect_mock = null;
    public static $ldap_bind_mock = null;
    public static $ldap_set_option_mock = null;

    public static function createMocks()
    {
        $ldap_connect_mock = new \phpmock\Mock(
            'Zend\\Ldap',
            'ldap_connect',
            function () {
                static $a_resource = null;
                if ($a_resource == null) {
                    $a_resource = fopen(__FILE__, 'r');
                }
                return $a_resource;
            }
        );

        $ldap_bind_mock = new \phpmock\Mock(
            'Zend\\Ldap',
            'ldap_bind',
            function () {
                return true;
            }
        );

        $ldap_set_option_mock = new \phpmock\Mock(
            'Zend\\Ldap',
            'ldap_set_option',
            function () {
                return true;
            }
        );

        $ldap_connect_mock->define();
        $ldap_bind_mock->define();
        $ldap_set_option_mock->define();

        static::$ldap_connect_mock = $ldap_connect_mock;
        static::$ldap_bind_mock = $ldap_bind_mock;
        static::$ldap_set_option_mock = $ldap_set_option_mock;
    }
}
LdapReusableMocks::createMocks();
