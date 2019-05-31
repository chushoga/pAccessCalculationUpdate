<?php date_default_timezone_set('Asia/Tokyo'); session_start();
$path = "/pAccess";
$title = "pAccess";
require_once (dirname(__FILE__) . '/dbconnect.php');

$checkIfLoggedInNowOrNot = basename($_SERVER['PHP_SELF']);

	if (isset($_SESSION["loggedIn"]) == false && $checkIfLoggedInNowOrNot != 'index.php'){
		header('Location: '.$path.'/index.php');
	}
?>
