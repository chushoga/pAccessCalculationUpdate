<?php
	date_default_timezone_set('Asia/Tokyo');
	require_once '../master/dbconnect.php';
	header('Content-Type: application/json');

/* ----------------------------------------------------------------- */
// DEBUGGER FUNCTIONS
/* ----------------------------------------------------------------- */
function queryDebug($resultVar){
	if (!$resultVar) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $query;
		die($message);
	}
}
/* ----------------------------------------------------------------- */
// HELPER FUNCTIONS
/* ----------------------------------------------------------------- */

/* ----------------------------------------------------------------- */

	/* POST VARIABLES GET AND CHECK IF NOT SET */
	
	if(isset($_POST["action"])){
		$action = $_POST["action"];
	} else {
		$action = "";
	}

	if(isset($_POST["orderNo"])){
		$orderNo = $_POST["orderNo"];
	} else {
		$orderNo = "";
	}

/* ----------------------------------------------------------------- */

/* *********************** */
/* LEFT SIDE QUERY */
/* *********************** */
	if($action == "getLeft") {
		
		// get distinct orderno and date from the order table
		$result = mysql_query("SELECT DISTINCT `orderNo`, `date` FROM `order` ORDER BY orderNo");
		
		$return_arr = array();
		$orderNo_arr = array();
		$makerName_arr = array();
			
		while($row = mysql_fetch_assoc($result)){
			
			$makerOrderNo = $row['orderNo'];
			
			
			// query the expense table to get the maker name.
			$resultM = mysql_query("SELECT 
			`orderNo_1`, `makerName_1`,
			`orderNo_2`, `makerName_2`,
			`orderNo_3`, `makerName_3`,
			`orderNo_4`, `makerName_4`,
			`orderNo_5`, `makerName_5`,
			`orderNo_6`, `makerName_6`,
			`orderNo_7`, `makerName_7`,
			`orderNo_8`, `makerName_8`,
			`orderNo_9`, `makerName_9`,
			`orderNo_10`, `makerName_10`
				FROM `expense` WHERE
			`orderNo_1` = '$makerOrderNo' OR
			`orderNo_2` = '$makerOrderNo' OR
			`orderNo_3` = '$makerOrderNo' OR
			`orderNo_4` = '$makerOrderNo' OR
			`orderNo_5` = '$makerOrderNo' OR
			`orderNo_6` = '$makerOrderNo' OR
			`orderNo_7` = '$makerOrderNo' OR
			`orderNo_8` = '$makerOrderNo' OR
			`orderNo_9` = '$makerOrderNo' OR
			`orderNo_10` = '$makerOrderNo'
			");
			
			while ($makerRow = mysql_fetch_assoc($resultM)){
				
				$makerName_arr = array(
					array($makerRow['orderNo_1'], $makerRow['makerName_1']),
					array($makerRow['orderNo_2'], $makerRow['makerName_2']),
					array($makerRow['orderNo_3'], $makerRow['makerName_3']),
					array($makerRow['orderNo_4'], $makerRow['makerName_4']),
					array($makerRow['orderNo_5'], $makerRow['makerName_5']),
					array($makerRow['orderNo_6'], $makerRow['makerName_6']),
					array($makerRow['orderNo_7'], $makerRow['makerName_7']),
					array($makerRow['orderNo_8'], $makerRow['makerName_8']),
					array($makerRow['orderNo_9'], $makerRow['makerName_9']),
					array($makerRow['orderNo_10'], $makerRow['makerName_10'])
				);
			 }
			
			for($i = 0; $i < 10; $i++) {
				if ($makerName_arr[$i][0] == $makerOrderNo){
					$orderNo_arr = $makerName_arr[$i][1];
				}
			}
			
			/* TEMP */
			$return_arr[] = array(
				"orderNo" => $row["orderNo"],
				"makerName" => strtoupper($orderNo_arr),
				"date" => $row["date"]
			);
			/* TEMP */
		}
		
		/* QUERY */
		
		echo json_encode($return_arr);
		
	} elseif($action == "getRight"){
		
/* *********************** */
/* RIGHT SIDE QUERY */
/* *********************** */
		$result = mysql_query("SELECT * FROM `order` WHERE orderNo = $orderNo ");

		$return_arr = array();

		while($row = mysql_fetch_assoc($result)){
			$return_arr[] = array(
				"id" => $row["id"],
				"tformNo" => $row["tformNo"],
				"makerNo" => $row["makerNo"],
				"orderNo" => $row["orderNo"],
				"priceList" => $row["priceList"],
				"discount" => $row["discount"],
				"rate" => $row["discount"],
				"quantity" => $row["quantity"],
				"date" => $row["date"],
				"currency" => $row["currency"],
				"finalUnitPrice" => $row["finalUnitPrice"]
			);
		}
		
		echo json_encode($return_arr);
	}
?>