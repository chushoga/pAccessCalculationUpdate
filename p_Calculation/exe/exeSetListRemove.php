<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
$listId = $_GET['id'];
$tformNoId = $_GET['tformid'];
$sql = "DELETE FROM `makerlistinfo` WHERE `id` = '$tformNoId'";
$result = mysql_query($sql);
header("location: ../list_edit_contents.php?pr=1&message=success&id=$listId");
?>