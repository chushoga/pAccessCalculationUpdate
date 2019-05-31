<?php

// ------------------------------------------------
// SET DATABASE AND LOCATION
// ------------------------------------------------

date_default_timezone_set('Asia/Tokyo'); 
require_once '../../master/dbconnect.php';

// ------------------------------------------------
/* DEBUGGER FUNCTION */
// ------------------------------------------------

function debugger($array){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

// ------------------------------------------------
// GET POST INFO
// ------------------------------------------------

$err = "Order No Error Try again";

$orderNo = "1";
$newOrderNo = "2";

if(!empty($_POST['orderNo'])){
	$orderNo = $_POST['orderNo'];
} else {
	header("location: ../order.php?pr=4&message=error&info=$err"); die();
}

if(!empty($_POST['newOrderNo'])){
	$newOrderNo = $_POST['newOrderNo'];
} else {
	header("location: ../order.php?pr=4&message=error&info=$err"); die();
}

// ------------------------------------------------
/*check if the new order no exists already*/
// ------------------------------------------------

$resultExists = mysql_query("SELECT * FROM `order` WHERE `orderNo` = '$newOrderNo'");
while ($rowExists = mysql_fetch_assoc($resultExists)){
	header("location: ../order.php?pr=4&message=error&info=Record already exists..."); die();
}

// ------------------------------------------------
/*check if the new order no exists already*/
// ------------------------------------------------

$resultOrderExists = mysql_query("SELECT * FROM `order` WHERE `orderNo` = '$orderNo'");
$num_rows = mysql_num_rows($resultOrderExists);
if($num_rows == 0){
	header("location: ../order.php?pr=4&message=error&info=Record does not exist..."); die();
}

// ------------------------------------------------
// UPDATE DATABSE WITH NEW NAMES
// CHECK IF MEMO EXISTS WITH OLD NAME and if true update the orderNo with the new
// UPDATE database with new name
// ------------------------------------------------

if($orderNo == $newOrderNo){
	header("location: ../order.php?pr=4&message=error&info=Same order No!"); die();
} else {
	
	$result = mysql_query("UPDATE `order` SET `orderNo` = '$newOrderNo' WHERE orderNo = '$orderNo'") or die(mysql_error());
	$resultMemo = mysql_query("UPDATE `order_memo` SET `orderNo` = '$newOrderNo' WHERE orderNo = '$orderNo'") or die(mysql_error());
	
}

// ------------------------------------------------
// REDIRECT BACK TO PREVIOUS PAGE WITH NEW ORDER NO
// ------------------------------------------------

header("location: ../order.php?pr=4&orderNo=$newOrderNo&message=success"); die();

// ------------------------------------------------
?>

