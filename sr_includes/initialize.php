<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('MAX_FILE_SIZE') ? null : define('MAX_FILE_SIZE','15360 KB');
// For my Mac
defined('ROOT') ? null : define('ROOT', DS.'Users'.DS.'travisreeder'.DS.'Sites'.DS.'SurreyRidgeGoDaddy');
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'Users'.DS.'travisreeder'.DS.'Sites'.DS.'SurreyRidgeGoDaddy'.DS.'public_html');

// For my work PC
//defined('ROOT') ? null : define('ROOT', DS.'wamp'.DS.'www'.DS.'SurreyRidgeGoDaddy');
//defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'wamp'.DS.'www'.DS.'SurreyRidgeGoDaddy'.DS.'public_html');

// For my hosted site
//defined('ROOT') ? null : define('ROOT', DS.'home'.DS.'travisreeder');
//defined('SITE_ROOT') ? null: define('SITE_ROOT', DS.'home'.DS.'travisreeder'.DS.'public_html');

defined('LIB_PATH') ? null : define('LIB_PATH', ROOT.DS.'sr_includes');
defined('CSS_PATH') ? null : define('CSS_PATH', SITE_ROOT.DS.'css');

// load config file first
require_once(LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');

// load core objects
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'database_object.php');
//require_once(LIB_PATH.DS.'pagination.php');
require_once(LIB_PATH.DS."PHPMailer".DS."class.phpmailer.php");
require_once(LIB_PATH.DS."PHPMailer".DS."class.smtp.php");
//require_once(LIB_PATH.DS."phpMailer".DS."language".DS."phpmailer.lang-en.php");

// load database-related classes
require_once(LIB_PATH.DS.'user.php');
require_once(LIB_PATH.DS.'subject.php');
require_once(LIB_PATH.DS.'page.php');
require_once(LIB_PATH.DS.'navigation.php');
require_once(LIB_PATH.DS.'visitor.php');
require_once(LIB_PATH.DS.'document.php');
require_once(LIB_PATH.DS.'marquee.php');
require_once(LIB_PATH.DS.'descriptionlist.php');
require_once(LIB_PATH.DS.'descriptionvalue.php');
require_once(LIB_PATH.DS.'calendar_event.php');
//require_once(LIB_PATH.DS.'comment.php');

?>