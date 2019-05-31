<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
//VARIABLES
$orderNo = $_POST['orderNo'];
$memo = $_POST['memo'];
//Query 
$result = mysql_query("SELECT * FROM `order_memo` WHERE `orderNo` ='$orderNo' ");
if( mysql_num_rows($result) > 0) {
    $sql = "UPDATE `order_memo` SET
                 `memo` = '$memo'
                 WHERE 
                 `orderNo` = '$orderNo'
             ";
mysql_query($sql) or die(mysql_error());
} else {
$sql = "INSERT INTO `order_memo`(
                 `orderNo`,
                 `memo`
                 )
             VALUES (
                 '$orderNo',
                 '$memo'
             )";
mysql_query($sql) or die(mysql_error());
}// END Query
header("location: ../order.php?pr=4&orderNo=$orderNo&message=success"); die(); // redirect to order.php with the correct emssage and orderNo.
?>

