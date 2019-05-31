<?php
header("Content-type: application/json; charset=utf-8");
require_once '../../master/dbconnect.php'; // CONNECT TO THE DATABASE

// action
if(isset($_POST["action"])){
	$action = $_POST["action"];
} else {
	$action = "ERROR";
}

// from
	$from = $_POST["searchFrom"];

// to
	$to = $_POST["searchTo"];


	//$from = "2015-10-01"; // default date from
	//$to = "2016-11-31"; // defaut date to

// ------------------------------------------------
// CREATE the main query here depending on the POST
// ------------------------------------------------

// ----------
// DATE
// ----------
/*
$date = "
	date_1 BETWEEN '$from' AND '$to' OR 
	date_2 BETWEEN '$from' AND '$to' OR 
	date_3 BETWEEN '$from' AND '$to' OR 
	date_4 BETWEEN '$from' AND '$to' OR 
	date_5 BETWEEN '$from' AND '$to' OR 
	date_6 BETWEEN '$from' AND '$to' OR 
	date_7 BETWEEN '$from' AND '$to' OR 
	date_8 BETWEEN '$from' AND '$to' OR 
	date_9 BETWEEN '$from' AND '$to' OR 
	date_10 BETWEEN '$from' AND '$to' OR 
	date_11 BETWEEN '$from' AND '$to' OR 
	date_12 BETWEEN '$from' AND '$to' OR 
	date_13 BETWEEN '$from' AND '$to' OR 
	date_14 BETWEEN '$from' AND '$to' OR 
	date_15 BETWEEN '$from' AND '$to' OR 
	date_16 BETWEEN '$from' AND '$to' OR 
	date_17 BETWEEN '$from' AND '$to' OR 
	date_18 BETWEEN '$from' AND '$to' OR 
	date_19 BETWEEN '$from' AND '$to' OR 
	date_20 BETWEEN '$from' AND '$to'
	";

*/

$date = "";

if($action == "getMain"){
	
	for($i = 1; $i < 21; $i++){
		if ($i == 20) {
			//$date .= "date_".$i." BETWEEN '$from' AND '$to' OR date BETWEEN '$from' AND '$to'";
			$date .= "date_".$i." BETWEEN '$from' AND '$to'";
		} else {
			//$date .= "date_".$i." BETWEEN '$from' AND '$to' OR date BETWEEN '$from' AND '$to' OR ";
			$date .= "date_".$i." BETWEEN '$from' AND '$to' OR ";
		}
	}
	
	$sth = mysql_query("SELECT * FROM `expense` WHERE $date");
	$rows = array();

	while ($r = mysql_fetch_assoc($sth)){
		$rows[] = $r;
	}

	echo json_encode($rows);
}


?>