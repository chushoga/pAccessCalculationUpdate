<?php require_once "../../master/dbconnect.php";
$orderNo = $_GET['orderNo'];
$sql = "DELETE FROM `order` WHERE `orderNo` = '$orderNo'";
$result = mysql_query($sql);

$sql_memo = "DELETE FROM `order_memo` WHERE `orderNo` = '$orderNo'";
$result_memo = mysql_query($sql_memo);

header("location: ../order.php?pr=4&message=success&info=オーダーNo.[$orderNo]削除しました!");
?>
