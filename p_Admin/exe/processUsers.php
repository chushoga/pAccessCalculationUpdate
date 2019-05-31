<?php
	date_default_timezone_set('Asia/Tokyo');
	require_once '../../master/dbconnect.php';
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

/* ----------------------------------------------------------------- */
 if($action == "testData") {
		
/* *********************** */
/* RIGHT SIDE QUERY */
/* *********************** */
		$result = mysql_query("SELECT * FROM `users`");

		$return_arr = array();

		while($row = mysql_fetch_assoc($result)){
			$return_arr[] = array(
				"id" => $row["id"],
				"name" => $row["name"],
				"password" => $row["password"],
				"accessLevel" => $row["accessLevel"]
			);
		}
		
		echo json_encode($return_arr);
	}
?>