<?php
header("Content-type: application/json; charset=utf-8");
require_once '../../master/dbconnect.php'; // CONNECT TO THE DATABASE


// ----------------------------
// GET POST VAIRIALBES
// ----------------------------

$listName = $_POST['listName'];
$action = $_POST['action'];

if (isset($_POST['tformNo'])){
	$tformNo = $_POST['tformNo'];
} else {
	$tformNo = "";
}

if (isset($_POST['itemToAdd'])){
	$itemToAdd = $_POST['itemToAdd'];
} else {
	$itemToAdd = "";
}

if (isset($_POST['itemToRemove'])){
	$itemToRemove = $_POST['itemToRemove'];
} else {
	$itemToRemove = "";
}

if(isset($_POST['newPrice'])){
	$newPrice = $_POST['newPrice'];
} else {
	$newPrice = "";
}

// ------------------------------------
// TAKE ACTIONS BASED ON action post
// ------------------------------------
switch($action){
	case "GetListContents":
		GetListContents($listName);
		break;
	case "GetSpecialItems":
		GetSpecialItems($listName, $tformNo);
		break;
	case "GetSpecialItemsAll":
		GetSpecialItemsAll($listName);
		break;
	case "SpecialItemAdd":
		SpecialItemAdd($listName, $tformNo, $itemToAdd);
		break;
	case "SpecialItemRemove":
		SpecialItemRemove($listName, $tformNo, $itemToRemove);
		break;
	case "HideItem":
		HideItem($listName, $tformNo);
		break;
	case "UpdateMakerPrice":
		UpdateMakerPrice($listName, $tformNo, $newPrice);
		break;
	case "SearchForSpecialItems":
		SearchForSpecialItems($tformNo);
		break;
}

// ------------------------------------
// GET All Special Items That are
// are attached to the list
// makerlistcontents => specialItems
// SELECT
// ------------------------------------
function GetSpecialItemsAll($listName){
	$query = mysql_query("SELECT specialItems FROM makerlistcontents WHERE listName = '$listName'");
	$rows = "";
	while ($row = mysql_fetch_assoc($query)){
		$rows = $row["specialItems"];
	}
	
	echo json_encode($rows);
}

// ------------------------------------
// GET LIST ITEMS
// makerlistinfo => listName
// SELECT
// ------------------------------------
function GetListContents($listName){
	
	$sth = mysql_query ("SELECT 
								makerlistinfo.tformNo, 
								makerlistinfo.specialItems, 
								makerlistinfo.isHidden,
								main.cancelMaker,
								main.cancelTform,
								main.cancelSelling,
								main.web
							FROM makerlistinfo
							INNER JOIN main ON makerlistinfo.tformNo = main.tformNo
							WHERE makerlistinfo.listName = '$listName'
							ORDER BY makerlistinfo.tformNo
								 ");
	
	//$query = mysql_query("SELECT tformNo, specialItems, isHidden FROM makerlistinfo WHERE listName = '$listName' ORDER BY tformNo");
	$rows = array();
	while ($row = mysql_fetch_assoc($sth)){
		
		// check if haiban or not
		$isHaiban = false;
		if ($row['cancelMaker'] == 1 || $row['cancelTform'] == 1 || $row['cancelSelling'] == 1) {
			$isHaiban = true;
		}
		
		// check if web check or not.
		$isWeb = false;
		if($row['web'] == 1){
			$isWeb = true;
		}
		
		$rows[] = array( 
			"tformNo" => $row["tformNo"],
			"specialItems" => $row["specialItems"],
			"isHidden" => $row["isHidden"],
			"isHaiban" => $isHaiban,
			"isWeb" => $isWeb
		);
	}
	
	echo json_encode($rows);
}

// ------------------------------------
// GET SPECIAL ITEMS PER LIST and TFno
// makerlistinfo => specialItems
// SELECT
// ------------------------------------
function GetSpecialItems($listName, $tformNo){
	
	$query = mysql_query("SELECT specialItems FROM makerlistinfo WHERE listName = '$listName' AND tformNo = '$tformNo'");

	while ($row = mysql_fetch_assoc($query)){
		$rows = $row["specialItems"];
	}
	
	echo json_encode($rows);
}

// ------------------------------------
// Hide Tform No from the list
// makerlistinfo => isHidden
// SELECT/UPDATE
// ------------------------------------
function HideItem($listName, $tformNo){
	
	// Check what the current isHidden flag is set at and then update to the oppisite
	$qry = mysql_query("SELECT isHidden FROM makerlistinfo WHERE listName = '$listName' AND tformNo = '$tformNo'");

	while ($row = mysql_fetch_assoc($qry)){
		$rows = $row["isHidden"];
	}
	// -----------------------------------
	if ($rows == 1){
		// update to 0 here
		$query = "UPDATE `makerlistinfo` SET `isHidden` = 0 WHERE `tformNo` = '$tformNo' && `listName` = '$listName'";
	} else {
		// update to 1 here
		$query = "UPDATE `makerlistinfo` SET `isHidden` = 1 WHERE `tformNo` = '$tformNo' && `listName` = '$listName'";
	}
	
	// run the query
	mysql_query($query) or die(mysql_error());
	
	echo json_encode("OK");
}

// ------------------------------------
// update Special Item List
// makerlistinfo => specialItems
// UPDATE
// ------------------------------------
function SpecialItemUpdate(){
	/*
	print_r($_POST);

	$listName = $_POST['listName'];
	$tformNoToEdit = $_POST['insertTformNo'];
	$tformNo = $_POST['tformNo'];

	echo "<br><hr><br>";

	echo $listName."<br>";
	echo $tformNoToEdit."<br>";
	echo "---------<br>";
	foreach($tformNo as $key => $value){
		echo $value."<br>"; 
	}
	echo "---------<br>";

	$implodedInsert = implode(',', $tformNo);

	echo $implodedInsert;

	echo "<br><hr><br>";
*/
	/*
	$query = "UPDATE `makerlistinfo` SET `specialItems` = '$implodedInsert' WHERE `tformNo` = '$tformNoToEdit' && `listName` = '$listName'";

	echo $query;

	mysql_query($query) or die(mysql_error());
	*/
}

// ------------------------------------
// add a new special item into 
// makerlistcontents => specialItems
// UPDATE
// ------------------------------------
function SpecialItemAdd($listName, $tformNo, $itemToAdd){
	
	// get the current list contents first
	$qry = mysql_query("SELECT specialItems FROM makerlistinfo WHERE listName = '$listName' AND tformNo = '$tformNo'");

	while ($row = mysql_fetch_assoc($qry)){
		$rows = $row["specialItems"];
	}
	// -----------------------------------
	if($rows != ""){
		
		// If there are items already in the list explode it and push in the new one
		$explodeIt = explode(",", $rows); // explode the rows
		array_push($explodeIt, $itemToAdd); // join with the item to add
		$implodedInsert = implode(',', $explodeIt); // implode the list for insert
		$query = "UPDATE `makerlistinfo` SET `specialItems` = '$implodedInsert' WHERE `tformNo` = '$tformNo' && `listName` = '$listName'";
		
	} else {
		
		// if no current set add it singularly
		$query = "UPDATE `makerlistinfo` SET `specialItems` = '$itemToAdd' WHERE `tformNo` = '$tformNo' && `listName` = '$listName'";
		
	}
	
	// run the query
	mysql_query($query) or die(mysql_error());

	echo json_encode("OK!!");
}

// ------------------------------------
// remove an item from the list
// makerlistcontents => specialItems
// ------------------------------------
function SpecialItemRemove($listName, $tformNo, $itemToRemove){
		
	
	// get the current list contents first
	$qry = mysql_query("SELECT specialItems FROM makerlistinfo WHERE listName = '$listName' AND tformNo = '$tformNo'");

	while ($row = mysql_fetch_assoc($qry)){
		$rows = $row["specialItems"];
	}
	// -----------------------------------
	if($rows != ""){
		
		// If there are items already in the list explode it and push in the new one
		$explodeIt = explode(",", $rows); // explode the rows
		
		// search the array for the item to remove
		$key = array_search($itemToRemove, $explodeIt);
		array_splice($explodeIt, $key, 1);
		$implodedInsert = implode(',', $explodeIt); // implode the list for insert
		
		$query = "UPDATE `makerlistinfo` SET `specialItems` = '$implodedInsert' WHERE `tformNo` = '$tformNo' && `listName` = '$listName'";
		
		// run the query
		mysql_query($query) or die(mysql_error());
	}
	
	echo json_encode($query);
}

// ------------------------------------
// Update Maker Price
// sp_plcurrent => pl
// ------------------------------------
function UpdateMakerPrice($listName, $tformNo, $newPrice){
	
	$err = "default message";
	

    // check the sp_plcurrent table and see if the tformNo already exists.
	// check if empty
	
	if(
		$listName == "" ||
		$listName == " " ||
		$listName == NULL ||
		$tformNo == "" ||
		$tformNo == " " ||
		$tformNo == NULL ||
		$newPrice == "" ||
		$newPrice == " " ||
		$newPrice == NULL
	){
		
		$err = "Input is Empty";
		
	} else {
		
		// if not empty or blank then insert/update
		$created = date ("Y-m-d H:i:s"); // date created or modified

		$result = mysql_query("SELECT tformNo FROM `sp_plcurrent` WHERE `tformNo` = '$tformNo'"); // check if hinban exsists alreay in the plCurrent
		
		if(mysql_num_rows($result) == 0) {
			$err = $tformNo." does not exist: Inserting New into the sp_plcurrent with the newPL data";
			
			// create variable for insert
			$sql = "INSERT INTO `sp_plcurrent`
									(`tformNo`,
									`plCurrent`,
									`created`) 
									VALUES
									('$tformNo',
									'$newPrice',
									'$created'
									)";

			mysql_query($sql) or die(mysql_error()); // insert into the table
			
		} else {
			
			$err = $tformNo." already exists: Updating current value"; // set error msg to ok.
			
			//update if tformNo already exists
			$result = mysql_query("UPDATE sp_plcurrent SET `plCurrent` = '$newPrice', `created` = '$created' WHERE `tformNo` = '$tformNo'") or die(mysql_error());
			
		}

	
	}
	
	echo json_encode($err);
	
}

// ------------------------------------
// Search for special items
// main => tformNo, type, makerNo
// ------------------------------------
function SearchForSpecialItems($tformNo){
	
	$rows = array();
	$query = mysql_query("SELECT tformNo, type, makerNo FROM main WHERE tformNo = '$tformNo'");
	$rows = "";
	while ($row = mysql_fetch_assoc($query)){
		$rows[] = array( 
			"tformNo" => $row["tformNo"],
			"type" => $row["type"],
			"makerNo" => $row["makerNo"]
		);
	}
	
	echo json_encode($rows);
}
?>