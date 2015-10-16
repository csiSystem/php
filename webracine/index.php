<?php 
define('WEBROOT',dirname(__FILE__));
define('ROOT',dirname(WEBROOT));
define('DS',DIRECTORY_SEPARATOR);
define('CORE',ROOT.DS.'core');
define('BASE_URL',dirname(dirname($_SERVER['SCRIPT_NAME'])));

/*echo "WEBROOT => ".WEBROOT.'<br>';
echo "ROOT => ".ROOT.'<br>';
echo "DS => ".DS.'<br>';
echo "CORE => ".CORE.'<br>';
echo "BASE_URL => ".BASE_URL.'<br>';



echo "################################ <br>";*/
require CORE.DS.'includes.php';
new Dispatcher();
?>
