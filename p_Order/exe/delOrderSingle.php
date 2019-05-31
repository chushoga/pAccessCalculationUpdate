<?php require_once "../../master/dbconnect.php";
$id = $_GET['id'];
$orderNo = $_GET['orderNo'];
$sql = "DELETE FROM `order` WHERE `id` = '$id'";
mysql_query($sql);
header("location: ../order.php?pr=4&message=success&orderNo=$orderNo");
?>