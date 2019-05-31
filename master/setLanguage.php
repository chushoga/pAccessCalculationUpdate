<?php date_default_timezone_set('Asia/Tokyo'); require_once 'dbconnect.php';
$value = $_GET['language'];
$sql = "UPDATE `settings` SET `language` = '$value'
			WHERE
				`id` = '1'
			";
$result = mysql_query($sql);

header('Location: ' . $_SERVER['HTTP_REFERER']);

