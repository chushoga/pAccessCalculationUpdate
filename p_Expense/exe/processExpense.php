<?php
header("Content-type: application/json; charset=utf-8");
date_default_timezone_set("Asia/Tokyo");
require_once '../../master/dbconnect.php'; // CONNECT TO THE DATABASE

// ----------------------------
// GET POST VAIRIALBES
// ----------------------------
if (isset($_POST['action'])){
	$action = $_POST['action'];
} else {
	$action = "";
}

if (isset($_POST['id'])){
	$id = $_POST['id'];
} else {
	$id = "";
}

if(isset($_POST['orderNo'])){
    $orderNo = $_POST['orderNo'];
} else {
    $orderNo = "";
}

// ------------------------------------
// TAKE ACTIONS BASED ON action post
// ------------------------------------
switch($action){
	case "GetHiddenBlocks":
		GetHiddenBlocks($id);
		break;
    case "UpdateHiddenBlocks":
        UpdateHiddenBlocks($id, $orderNo);
        break;
}



// ------------------------------------
// Update Record
// UPDATE
// ------------------------------------
function UpdateHiddenBlocks($id, $orderNo){
	
	$sql = mysql_query("
            INSERT INTO hide_expense
                (recId,orderNo,isHidden)
            VALUES
                ('$id','$orderNo','1')
            ON DUPLICATE KEY UPDATE
			 isHidden = !isHidden
            ") 
		or die(mysql_error());
    
	echo json_encode("OK!! ".$id." ".$orderNo);
	
}

// ------------------------------------
// Get Record data
// SELECT
// ------------------------------------
function GetHiddenBlocks($id){

	$sql = mysql_query("SELECT * FROM hide_expense WHERE recId =".$id);
	
	$rows = array();
	
	while($row = mysql_fetch_assoc($sql)){
		$rows[] = array(
			"id" => $row['id'],
			"recId" => $row['recId'],
            "orderNo" => $row['orderNo'],
			"isHidden" => $row['isHidden']
		);
	}
	
	echo json_encode($rows);
	
}

?>