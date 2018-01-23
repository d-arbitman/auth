<?php
/*
 * Basic config
 */

// set up database settings for constructor
define ("MySQL_HOST", "127.0.0.1");
define ("MySQL_USER", "login");
define ("MySQL_PASS", "login");
define ("MySQL_DATABASE", "login");
define ("MySQL_CHARACTER_SET", "utf8");

//error_reporting(E_ALL ^ E_STRICT);
error_reporting (E_ALL);
// display errors until production
ini_set('display_errors', 1);
//write errors to log
ini_set('log_errors', 1);
ini_set("error_log", __DIR__ . DIRECTORY_SEPARATOR . "error_log");
header_remove("X-Powered-By");

define ('DS', DIRECTORY_SEPARATOR);
define ('ROOT_PATH', dirname(__FILE__) . DS);
define ("INC_PATH", ROOT_PATH . DS . "inc" . DS);
define ('DEFAULT_LOCALE', 'en_US');
define ('DEFAULT_ENCODING', 'UTF-8');

setlocale (LC_MONETARY, 'en_US');
putenv ("TZ=America/Chicago");

// include composer requires
require_once (ROOT_PATH . "/vendor/autoload.php");

// include client and database classes
require_once (INC_PATH . "database.php");
require_once (INC_PATH . "client.php");

// include system_functions.php
require_once (INC_PATH . "system_functions.php");

$db=new Database ();
$client=new Client ($db->get_instance());
