<?php
header("Content-type: application/json; charset=utf-8");
date_default_timezone_set("Asia/Tokyo");
require_once '../../master/dbconnect.php'; // CONNECT TO THE DATABASE

// ----------------------------
// GET POST VAIRIALBES
// ----------------------------


$data = $_POST['result'];
$data = json_decode($data, true);




RemoveData($data);

// REMOVE FROM MAIN TABLE
function RemoveFromSystem($tformNo){
	$query = mysql_query("DELETE FROM `main` WHERE `tformNo` = '$tformNo'");
	$query2 = mysql_query("DELETE FROM `makerlistinfo` WHERE `tformNo` = '$tformNo'");
}


// Initialization function
function RemoveData($data){
	
	for($i = 0; $i < count($data); $i++){
		
		$tformNo = $data[$i];
		
		RemoveFromSystem($tformNo);
		
	}
	
	echo json_encode("FINISHED");
	
}

?>
