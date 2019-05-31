<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
$orderNo = $_POST['orderNo'];
$makerNo = $_POST['makerNo'];
$tformNo = $_POST['tformNo'];
$date = $_POST['date'];
$quantity = $_POST['quantity'];
$priceList = $_POST['priceList'];
$discount = $_POST['discount'];
$currency = $_POST['currency'];
//Query for Inserting into Order
$sql = "INSERT INTO `order`(
                 `orderNo`,
                 `makerNo`,
                 `tformNo`,
                 `date`,
                 `quantity`,
                 `priceList`,
                 `discount`,
                 `currency`
                 )
             VALUES (
                 '$orderNo',
                 '$makerNo',
                 '$tformNo',
                 '$date',
                 '$quantity',
                 '$priceList',
                 '$discount',
                 '$currency'
             )";
mysql_query($sql) or die(mysql_error());
// END Query

header("location: ../order.php?pr=4&orderNo=$orderNo&message=success"); die(); // redirect to order.php with the correct emssage and orderNo.
?>