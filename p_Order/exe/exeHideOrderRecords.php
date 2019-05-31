<?php
	date_default_timezone_set('Asia/Tokyo');
	require_once '../../master/dbconnect.php';

	// get current state of isFinishedHidden and then set the opposite
	$resultCurrent = mysql_query("SELECT isFinishedHidden FROM order_settings WHERE id = '1'");

	while($rowCurrent = mysql_fetch_assoc($resultCurrent)){
		$isHidden = $rowCurrent['isFinishedHidden'];
		
		if($isHidden == true) {
			$result = mysql_query("UPDATE `order_settings` SET `isFinishedHidden` = '0' WHERE id = '1'") or die(mysql_error());
		} else {
			$result = mysql_query("UPDATE `order_settings` SET `isFinishedHidden` = '1' WHERE id = '1'") or die(mysql_error());
		}
	}
	
header("location: ../order.php?pr=4&message=success"); die();
?>