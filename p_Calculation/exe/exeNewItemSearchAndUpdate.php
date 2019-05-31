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
		case "SearchForNewItems":
			SearchForNewItems($listName, $tformNo);
			break;
		case "AddNewItems":
			AddNewItems($listName, $tformNo);
			break;
	}


	// ------------------------------------
	// Search for new items to add to the 
	// special items list
	// main => tformNo, type
	// ------------------------------------

	function SearchForNewItems($listName, $tformNo){
		
		// get list of tform numbers from list
		$rowsList = array();
		
		$sthList = mysql_query("SELECT tformNo FROM makerlistinfo WHERE tformNo LIKE '%$tformNo%' AND listName = '$listName'");
		while ($rList = mysql_fetch_assoc($sthList)){
			$rowsList[] = array(
				"tformNo" => $rList['tformNo']
			);
		}
		
		// search for only hinban first in main if there are no current matches in the list
		
		
		
		$rows = array();
		$sth = mysql_query("SELECT tformNo, `type`, thumb, makerNo, orderNo, web, webVariation, cancelMaker, cancelTform, cancelSelling  FROM main WHERE tformNo LIKE '%$tformNo%'");
		while ($r = mysql_fetch_assoc($sth))
		{
           
			// convert web and webVariation into one variable.
			// if one or both of the items is true then return true.
			if($r['web'] == '1' || $r['webVariation'] == '1'){
				$web = 1;
			} else {
				$web = 0;
			}
			
			// convert haiban into one variable
			// if any of cancelMaker, cancelTform, or cancelSelling is true the return true
			if($r['cancelMaker'] == '1' || $r['cancelTform'] == '1' || $r['cancelSelling'] == '1'){
				$haiban = 1;
			} else {
				$haiban = 0;
			}
			
			$rows[] = array(
				"tformNo" => $r['tformNo'],
				"type" => $r['type'],
				"thumb" => $r['thumb'],
				"makerNo" => $r['makerNo'],
				"orderNo" => $r['orderNo'],
				"web" => $web,
				"haiban" => $haiban
			);
		}
		
		// COMPARE 2 types
		
		// search array function
		function in_array_r($item, $array){
			return preg_match('/"'.$item.'"/i', json_encode($array));
		}
				
		$newArray = array();
		for($i = 0; $i < count($rows); $i++){
			
			if (!in_array_r($rows[$i]["tformNo"], $rowsList)){
				 array_push($newArray,	$rows[$i]);
			}
			
		}
		
		// SEND RESUTLS
		echo json_encode($newArray, JSON_PRETTY_PRINT);
	}

	// ------------------------------------
	// ADD NEW ITEMS
	// Add New Items to the maker list
	// makerlistinfo => tformNo
	// ------------------------------------

    // checks if in list or not already
    function checkIfInList($listName, $item){

        $inList = false; // flag for checking if in list or not

       
        $result = array(); // hold results of the query

        $query = mysql_query("SELECT tformNo FROM makerlistinfo WHERE listName = '$listName'");
        
        while ($r = mysql_fetch_assoc($query)){
            array_push($result, $r['tformNo']);
        }
            if (in_array($item, $result)) {
                $inList = true;
            }
        
        // return the flag
        return $inList;
    }

	function AddNewItems($listName, $tformNo){
        
		// if not in list already add to list
        $apple = "";
        $passedList = explode(",", $tformNo);
        
        for($i = 0; $i < count($passedList); $i++){
            if(!checkIfInList($listName, $passedList[$i])){
                $apple.="INSERT " . $passedList[$i];
                $apple.= " | ";
                
                $result = "INSERT INTO makerlistinfo (
								`tformNo`,
								`listName`
								)
									 VALUE
								 (
								 '$passedList[$i]',
								 '$listName'
								 )"; 
				
				$resultCheck = mysql_query("SELECT tformNo FROM makerlistinfo WHERE tformNo = '$passedList[$i]' AND listName = '$listName'");
				
				
				if(!mysql_num_rows($resultCheck)){
					mysql_query($result) or die(mysql_error());
				}
                
                
            } else {
                $apple.= $passedList[$i] . " Already in list!";
            }
        }
        
		// SEND RESUTLS
		echo json_encode($apple." <-- hmmmmm");
		
	}

	// ------------------------------------
	// Search for new items to add to the 
	// special items list
	// main => tformNo, type
	// ------------------------------------
/*
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
*/
	// ------------------------------------
	// Insert new items to the special items
	// makerlistcontents => listName, tformNo
	// ------------------------------------
/*
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
*/
/*
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
*/
?>