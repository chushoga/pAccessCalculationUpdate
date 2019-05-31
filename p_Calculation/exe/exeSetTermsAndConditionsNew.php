<?php
header("Content-type: application/json; charset=utf-8");
date_default_timezone_set("Asia/Tokyo");
require_once("../../master/dbconnectMysqli.php");


// -----------------------
// SET THE POST VARIABLES
// start
// -----------------------
//ACTION - What action do i do?
if(isset($_POST['action'])){
    $action = $_POST["action"];
} else {
    $action = ""; 
}
// ----------------------------
// close
// ----------------------------

// ----------------------------
// ACTIONS
// ----------------------------
switch($action){
    case "GetAllTermsAndConditions":
        GetAllTermsAndConditions($conn);
        break;
    default:
        break;
}

function GetAllTermsAndConditions($conn){
  
    $SELECT = "SELECT * FROM `sp_disc_rate` ORDER BY `id` DESC";
    
    /* ------------------------------------------ */
	$result = mysqli_query($conn, $SELECT);

	$rows = array();
    
	if(mysqli_num_rows($result) > 0) {
        // output now
        while($row = mysqli_fetch_assoc($result)){
            
            $rows[] = array(
                "id" => $row['id'],
                "year" => $row['year'],
                "memo" => $row['memo'],
                "maker" => $row['maker'],
                "netTerm" => $row['netTerm'],
                "currency" => $row['currency'],
                "created" => $row['created'],
                "modified" => $row['modified'],
                "rate" => $row['rate'],
                "percent" => $row['percent'],
                "discount" => $row['discount'],
                "discountPar" => $row['discountPar'],
                "sp1" => $row['sp1'],
                "sp2" => $row['sp2'],
                "sp3" => $row['sp3'],
                "sp4" => $row['sp4'],
                "sp5" => $row['sp5'],
                "sp1Par" => $row['sp1Par'],
                "sp2Par" => $row['sp2Par'],
                "sp3Par" => $row['sp3Par'],
                "sp4Par" => $row['sp4Par'],
                "sp5Par" => $row['sp5Par'],
                "colorId" => $row['colorId']
            );
        }
        echo json_encode($rows);
        
    } else {
        
        echo json_encode("");
        
    }
}

    ?>