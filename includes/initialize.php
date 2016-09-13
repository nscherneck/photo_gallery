<?php

date_default_timezone_set('America/Los_Angeles');
// define the core paths
// define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? NULL : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? NULL : define('SITE_ROOT',DS . 'home' . DS . 'vagrant' . DS . 'Code' . DS . 'Project6');
defined('LIB_PATH') ? NULL : define('LIB_PATH', SITE_ROOT . DS . 'includes');

/* --------------------------------------------------- */
// load includes below

// load config file first
require_once (LIB_PATH . DS . "config.php");

// load basic functions so that everything can use them
require_once (LIB_PATH . DS . "functions.php");

// load core objects
require_once (LIB_PATH . DS . "session.php");
require_once (LIB_PATH . DS . "database.php");
require_once (LIB_PATH . DS . "database_object.php");

// load database-related classes
require_once (LIB_PATH . DS . "user.php");
require_once (LIB_PATH . DS . "photograph.php");


 ?>
