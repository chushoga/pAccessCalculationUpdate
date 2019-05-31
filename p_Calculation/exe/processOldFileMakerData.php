<?php
header("Content-type: application/json; charset=utf-8");
date_default_timezone_set("Asia/Tokyo");
require_once '../../master/dbconnect.php'; // CONNECT TO THE DATABASE

// ----------------------------
// GET POST VAIRIALBES
// ----------------------------

// get the ACTION
$action = $_POST['action'];

// get maker
//$maker = $_POST['maker'];
$maker = GetMaker();

// ------------------------------------
// TAKE ACTIONS BASED ON action post
// ------------------------------------

switch($action){
	case "GetFileMakerMatches":
		if(CheckListNames() == true){
			Compare($maker);
		} else {
			echo json_encode("error"); // send error if not true
		}
	break;
}

// ------------------------------------
// Get Maker prefex from the CSV
// ------------------------------------
function GetMaker(){
	$maker = null;
	
	/* Open the csv */

	if (fopen($_FILES['files']['tmp_name'], "r") == ''){
		echo json_encode("ERROR NO DATA >>>>");
	} else {
		
		$handle = fopen($_FILES['files']['tmp_name'], "r"); // set the handle to the csv data
		$rows = array();
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$string = preg_replace('/\s+/', '', $data[0]);
			$rows[] = $string;
	}
	
	$maker = substr($rows[0], 0, 3);
	
	}
	return $maker;
}

// ------------------------------------
// Check if all list start with the maker
// search
// ------------------------------------
function CheckListNames(){
	
	$flag = true;
	
	/* Open the csv */

	if (fopen($_FILES['files']['tmp_name'], "r") == ''){
		
		echo json_encode("ERROR NO DATA >>>>");
		
	} else {

		$handle = fopen($_FILES['files']['tmp_name'], "r"); // set the handle to the csv data
		$rows = array();
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$string = preg_replace('/\s+/', '', $data[0]);
			$rows[] = $string;
		}

		$check = substr($rows[0], 0, 3);

		// take $rows and check the first characters of each
		for ($i = 0; $i < count($rows); $i++){
			$j = substr($rows[$i], 0, 3);
			if($j != strtoupper($check)){
				$flag = false;
			}
		}
		
	}
	
	return $flag;
	
}

// ------------------------------------
// Get all the details about the old data
// main, makerlistinfo
// SELECT
// ------------------------------------
function GetDetails($data){
	
// ----------
// FUNCTIONS
// ----------
	// check the list to see if it is in any of them.
	function CheckListConnections($tfNo){

		$tformNo = "";

		$rowInner = array();

		$query = "SELECT listName FROM makerlistinfo WHERE tformNo = '$tfNo'";
		$result = mysql_query($query);

		while($row = mysql_fetch_assoc($result)){
			array_push($rowInner, $row['listName']);
		}

		return $rowInner;
	}

// ----------
// INIT
// ----------
	/* Get details from MAIN */
	$rows = array();
	
	for($i = 0; $i < count($data); $i++){
		
		$tfNo = $data[$i];
		
		// Check what lists it is conencted to.
		$listName = CheckListConnections($tfNo);

		$query = "SELECT id, tformNo, maker, type FROM main WHERE tformNo = '$tfNo'";
		$sql = mysql_query($query);

		while($row = mysql_fetch_assoc($sql)){
			$rows[] = array(
				"id" => $row['id'],
				"tformNo" => $row['tformNo'],
				"maker" => $row['maker'],
				"type" => $row['type'],
				"listName" => $listName
			);
		}
	}
	
	
	// -------------------------
	// RETURN FINAL ARRAY
	// -------------------------
	echo json_encode($rows);
	
}


// ------------------------------------
// ====================================
// Main function from checking The data
// ====================================
// ------------------------------------

function Compare($maker){

// ----------
// FUNCTIONS
// ----------

	// ------------------------------------
	// Get all Filemaker tformno into array
	// main
	// SELECT
	// ------------------------------------
	function GetAllFilemakerTFno($maker){
		$query = "SELECT id, tformNo, maker, thumb FROM main WHERE tformNo LIKE '$maker%'";
		$sql = mysql_query($query);

		$rows = array();
		while($row = mysql_fetch_assoc($sql)){
			$rows[] = $row['tformNo'];
		}

		return $rows;
	}

	// ------------------------------------
	// Check For the missing Tform No from CSV
	// main
	// SELECT
	// ------------------------------------
	function GetFilemakerMatches(){

		/* Open the csv */

		if (fopen($_FILES['files']['tmp_name'], "r") == ''){
			echo json_encode("ERROR NO DATA >>>>");
		} else {

			$handle = fopen($_FILES['files']['tmp_name'], "r"); // set the handle to the csv data
			$rows = array();
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$string = preg_replace('/\s+/', '', $data[0]);
				$rows[] = $string;
			}

			//echo json_encode($rows);
			return $rows;
		}

	}

	
	// helper function to get the difference and 
	//creates a clean array of missing numbers
	function arrayDiff($A, $B){
		$intersect = array_intersect($A, $B);
		return array_merge(array_diff($A, $intersect), array_diff($B, $intersect));
	}

// -----------------------------------------------------------------

// ----------
// INIT
// ----------
	
	$fm = GetAllFilemakerTFno($maker);
	$csv = GetFilemakerMatches();
	
	$result = arrayDiff($fm, $csv);
		
	// Get the details for the returned matches
	GetDetails($result);
}


?>
