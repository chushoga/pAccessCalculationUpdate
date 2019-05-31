<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
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

/*check if the new order no exists already*/
$resultExists = mysql_query("SELECT * FROM `order` WHERE `orderNo` = '$newOrderNo'");
while ($rowExists = mysql_fetch_assoc($resultExists)){
	header("location: ../order.php?pr=4&message=error&info=Record already exists..."); die();
}

/*check if the new order no exists already*/
$resultOrderExists = mysql_query("SELECT * FROM `order` WHERE `orderNo` = '$orderNo'");
$num_rows = mysql_num_rows($resultOrderExists);
if($num_rows == 0){
	header("location: ../order.php?pr=4&message=error&info=Record does not exist..."); die();
}

if($orderNo == $newOrderNo){
	header("location: ../order.php?pr=4&message=error&info=Same order No!"); die();
} else {

	// copy order
	
		$copyOrderArray = array();
		$result = mysql_query("SELECT * FROM `order` WHERE `orderNo` = '$orderNo'");
		while ($row = mysql_fetch_assoc($result)){
			$tformNo = $row['tformNo'];
			$makerNo = $row['makerNo'];
			$orderNo = $row['orderNo'];
			$priceList = $row['priceList'];
			$discount = $row['discount'];
			$rate = $row['rate']; //****
			$quantity = $row['quantity'];
			$date = $row['date'];
			$currency = $row['currency'];
			$finalUnitPrice = $row['finalUnitPrice']; //****

			$copyOrderArray[] = array($tformNo, $makerNo, $orderNo, $priceList, $discount, $rate, $quantity, $date, $currency, $finalUnitPrice);
			
			}
	
/* INSERT NEW COPY INTO THE ORDER TABLE*/
foreach($copyOrderArray as $key => $value){
	
	//Query for Inserting into Order
	$sql = "INSERT INTO `order`(
								`tformNo`,
								`makerNo`,
								`orderNo`,
								`priceList`,
								`discount`,
								`rate`,
								`quantity`,
								`date`,
								`currency`,
								`finalUnitPrice`
								 )
						VALUES (
								 '$value[0]',
								 '$value[1]',
								 '$newOrderNo',
								 '$value[3]',
								 '$value[4]',
								 '$value[5]',
								 '$value[6]',
								 '$value[7]',
								 '$value[8]',
								 '$value[9]'
								 )";
	
	mysql_query($sql) or die(mysql_error());
}


	// copy order_memo
	$resultOrderMemo = mysql_query("SELECT * FROM `order_memo` WHERE `orderNo` = '$orderNo'");
	while ($rowOrderMemo = mysql_fetch_assoc($resultOrderMemo)){
		$memo = $rowOrderMemo['memo'];
		
		$sql = "INSERT INTO `order_memo`(
								`orderNo`,
								`memo`
												 )
						VALUES (
								 '$newOrderNo',
								 '$memo'
								 )";
		
		mysql_query($sql) or die(mysql_error());
	}

header("location: ../order.php?pr=4&orderNo=$newOrderNo&message=success"); die();
}
?>