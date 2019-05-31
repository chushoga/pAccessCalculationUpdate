<?php
	header("Content-type: application/json; charset=utf-8");
	require_once '../../master/dbconnect.php'; // CONNECT TO THE DATABASE

	// action
	$action = $_POST["action"];

	// listName
	$listName = $_POST["listName"];
	$tformNo = $_POST['tformNo'];

	// check the action and run the correct function
	switch($action){
		case "SearchForSpecialItems":
			SearchForSpecialItems($tformNo);
			break;
		case "AddSpecialItems":
			AddSpecialItems($listName, $tformNo);
			break;
		case "RemoveSpecialItems":
			RemoveSpecialItems($listName, $tformNo);
			break;
	}

	// ------------------------------------
	// Search for new items to add to the 
	// special items list
	// main => tformNo, type
	// ------------------------------------
	function SearchForSpecialItems($tformNo){
		
		$rows = array();

		$sth = mysql_query("SELECT tformNo, `type` FROM main WHERE tformNo LIKE '%$tformNo%'");
		while ($r = mysql_fetch_assoc($sth))
		{
			$rows[] = array(
				"tformNo" => $r['tformNo'],
				"type" => $r['type']
			);
		}

		// SEND RESUTLS
		echo json_encode($rows);
	}

	// ------------------------------------
	// Insert new items to the special items
	// makerlistcontents => listName, tformNo
	// ------------------------------------
	function AddSpecialItems($listName, $tformNo){
		
		// Select the specialItems column from makerlistcontents
		// check if the $tformNo is already in list or not
		// check if being used by something in the list already
		// if not then insert into the $listName
		
		$empty = "FULL?";
		
		$result = "";
		$query = mysql_query("SELECT specialItems FROM makerlistcontents WHERE listName = '$listName'");
		while ($r = mysql_fetch_assoc($query)){
			$result = $r['specialItems'];
		}
		
		// dont do anything if its empty...
		if($result == ""){
			// insert
			// Update the database here
			$r = mysql_query("UPDATE makerlistcontents SET `specialItems` = '$tformNo' WHERE `listName` = '$listName'") or die(mysql_error());

			echo json_encode("UPDATED ");
			
		} else {
			$updateFlag = false;

			// Remove whitespace from the set array and special item array
			$explode = explode(',', preg_replace('/\s+/', '', $result));


			// check if tformNo is in results
			if(!in_array($tformNo, $explode)){
				$updateFlag = true;
			}

			// check the flag and update the specialItems list with the new array, adding the sent tformNo
			if($updateFlag){

				array_push($explode, $tformNo); // add the tformNo to the end of the array
				$implode = implode(',', $explode); // implode the array to prepar for database update

				// Update the database here
				$result = mysql_query("UPDATE makerlistcontents SET `specialItems` = '$implode' WHERE `listName` = '$listName'") or die(mysql_error());

				echo json_encode("UPDATED ");

			} else {

				// SEND RESUTLS
				echo json_encode("NOT UPDATED ");
			}
		}
	}

	function RemoveSpecialItems($listName, $tformNo){
		
		// get the contents of the current special items from the passed listName
		
		$result = "";
		$query = mysql_query("SELECT specialItems FROM makerlistcontents WHERE listName = '$listName'");
		while ($r = mysql_fetch_assoc($query)){
			$result = $r['specialItems'];
		}
		
		$updateFlag = false;
		
		// Remove whitespace from the set array and special item array
		$explode = explode(',', preg_replace('/\s+/', '', $result));
		$cleanArray = array();
		
		for($i = 0; $i < count($explode); $i++){
			
			if($explode[$i] == $tformNo){
				$updateFlag = true;
			} else {
				// add items to the clean array
				$cleanArray[] = $explode[$i];
			}
			
		}
		
		$implode = implode(',', $cleanArray);
		
		// check the flag and update the specialItems list with the new array, removing the sent tformNo
		if($updateFlag){
			
			// Update the database here
			$result = mysql_query("UPDATE makerlistcontents SET `specialItems` = '$implode' WHERE `listName` = '$listName'") or die(mysql_error());
			
			echo json_encode("UPDATED");
		} else {
			// SEND RESUTLS
			echo json_encode("NOT UPDATED");
		}
		
	}

?>