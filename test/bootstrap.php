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
 * A limitation in the OpenLDAP libraries linked to PHP requires that if a
 * client certificate/key will be used in any ldap bind, the environment must
 * point to them before the first bind made by the process, even if that first
 * bind is not client certificate-based.
 *
 * Therefore, configure this aspect of the environment here in bootstrap.
 * Applications using a client cert with zend-ldap should similarly ensure their
 * environment variables are set before the first ldap connect/bind.
 */
putenv(sprintf("LDAPTLS_CERT=%s", getenv('TESTS_ZEND_LDAP_SASL_CERTIFICATE')));
putenv(sprintf("LDAPTLS_KEY=%s", getenv('TESTS_ZEND_LDAP_SASL_KEY')));
