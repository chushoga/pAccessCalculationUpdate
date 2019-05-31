<?php
header("Content-type: application/json; charset=utf-8");
date_default_timezone_set("Asia/Tokyo");
require_once("../../master/dbConnect.php");

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

if(isset($_POST['tableName'])){
    $tableName = $_POST['tableName'];
} else {
    $tableName = "";
}

if(isset($_POST['listName'])){
    $listName = $_POST['listName'];
} else {
    $listName = "";
}

if(isset($_POST['id'])){
    $id = $_POST['id'];
} else {
    $id = "NO ID";
}

// ----------------------------
// close
// ----------------------------

// ----------------------------
// ACTIONS
// ----------------------------
switch($action){
    case "AddProductId":
        AddProductId($tableName);
        break;
    case "CleanTformNoFromTable":
        CleanTformNoFromTable($tableName);
        break;
    case "CleanDoubles":
        CleanDoubles($listName);
        break;
    case "DeleteFromTable";
        DeleteFromTable($listName, $id);
        break;
    default:
        ChangeTformNo();
        break;
}

function CleanTformNoFromTable($table){
    
    $rows = [];
    $r = []; // for showing the delete items as feedback.
    
    $tableName = $table; // table to search for non-existant tformNo in the MAIN table.
    
    if($tableName != '' AND $tableName != ''){
    
        $result = mysql_query("SELECT tformNo FROM `$tableName`"); // select all the tformNo from the target table

        // Iterate over the table and search for tformNo that do not exist in the MAIN table.
        while($row = mysql_fetch_assoc($result)){

            $tformNo = $row["tformNo"]; // set the tform number

            $innerResult = mysql_query("SELECT tformNo FROM main WHERE tformNo = '$tformNo'"); // Select all tformNo that match

            // if there is no match add the unmached tformNo to the array for deletion.
            if(mysql_num_rows($innerResult) == 0){
                $rows[] = [
                    "tformNo" => $tformNo
                ];
            }

        }

        // Loop through the tformNo set for deletion.
        for($i = 0; $i < count($rows); $i++){

            // if the tformNo is not empty then delete
            if($rows[$i]["tformNo"] != ""){

                $tformNo = $rows[$i]["tformNo"]; // set the tform no

                // array for user feedback only.
                $r[] = [
                    "tformNo" => $tformNo
                ];

                // =========================
                // ** UNCOMMENT TO DELETE **

                //$query = mysql_query("DELETE FROM `$tableName` WHERE `tformNo` = '$tformNo'");

                // ** UNCOMMENT TO DELETE **
                // =========================
            }
        }
        
        if(count($rows) == 0){
            $r[] = [
                    "tformNo" => "All tformNo are in the MAIN table"
            ];
        }
        echo json_encode($r);
    } else {
        echo json_encode("The table name was empty");
    }
    
}

// ------------------------------------
// UPDATE the product ID from the main 
// table to the selected table.
// ------------------------------------
function AddProductId($table){
    $rows = [];
    $tableName = $table;
   
    /*
    $result = mysql_query("SELECT productId, tformNo FROM `main`");
    while($row = mysql_fetch_assoc($result)){
        $productId = $row["productId"];
        $tformNo = $row["tformNo"];
        $import = "UPDATE $tableName SET
                            `productId` = '$productId'
                        WHERE 
                            `tformNo` = '$tformNo'
                    ";
        $rows[] = [
            "UPDATE" => $import
        ];
        //mysql_query($import) or die(mysql_error());
    }
    */
    
    // OK WORKS GOOD 
    $a = $tableName.".tformNo";
    $result = mysql_query("
        SELECT $a, main.productId, main.tformNo 
        FROM $tableName INNER JOIN main 
        ON $a = main.tformNo
    ");
     

    while($row = mysql_fetch_assoc($result)){
      
    
        // ------------------------------------------
        $productId = $row["productId"];
        $tformNo = $row["tformNo"];

        $updateMe = "UPDATE $tableName SET
                    `productId` = '$productId'
                WHERE
                    `tformNo` = '$tformNo'
        ";
        
        mysql_query($updateMe) or die(mysql_error());
        
        $rows[] = [
            "productId" => $row['productId'],
            "tformNo" => $row['tformNo']
        ];
        
    }
    
    echo json_encode($rows);
   
}

// ------------------------------------
// CHANGE TFORM NO in the following tables where the productId = the csv $data[0] to $data[1]
// main
// sp_plcurrent
// sp_plupdate
// sp_history
// makerlistinfo
// ------------------------------------
function ChangeTformNo(){

    if (fopen($_FILES['filename']['tmp_name'], "r") == ''){
        echo json_encode("ERROR, no data");
    }

    $handle = fopen($_FILES['filename']['tmp_name'], "r");
    $tableName = 'main';
    $inserted = 0;
    $updated = 0;
    $total = $inserted + $updated;
    $date = date ("Y-m-d H:i:s");

    $rows[] = array();
    $rowsInner[] = array();

    $counter = 0;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

        // --------------------------------------------------------------------------------------------------------------
        // UPDATE MAIN TFORM NO
        // --------------------------------------------------------------------------------------------------------------
        
        $result = mysql_query("SELECT id, tformNo, productId FROM `$tableName` WHERE `productId` = '$data[0]'");
        while($row = mysql_fetch_assoc($result)){
            if($data[1] != $row['tformNo']){
                $rows[] = array(
                    "fromid" => $row['productId'],
                    "from" => $row['tformNo'],
                    "toid" => $data[0],
                    "to" => $data[1]
                );
            }
        }
        
        
        
        
        // --------------------------------------------------------------------------------------------------------------
        // UPDATE MAKERLISTINFO TFORM NO
        // --------------------------------------------------------------------------------------------------------------
        /*
        $result = mysql_query("SELECT tformNo FROM `makerlistinfo` WHERE `tformNo` = '$data[1]'");

        while($row = mysql_fetch_assoc($result)){
            //if($data[1] != $row['tformNo']){
                $rows[] = array(
                    "from" => $row['tformNo'],
                    "to" => $data[1]
                );
            //}
        }
        */


        /* ADDED productColor, actualQuantity, possibleQuantity 2018-4-4 */
    /*
        if ($num){

            $import="UPDATE $tableName SET
                                        `productId` = '$data[1]',
                                        `tformNo` = '$data[2]',
                                        `type` = '$data[3]',
                                        `maker` = '$data[4]',
                                        `series` = '$data[5]',
                                        `makerNo` = '$data[6]',
                                        `orderNo` = '$data[7]',
                                        `tformPriceNoTax` = '$data[8]',
                                        `setMatchedProductId` = '$data[9]',
                                        `setProductId` = '$data[10]',
                                        `set` = '$data[11]',
                                        `productColor` = '$data[12]',
                                        `actualQuantity` = '$data[13]',
                                        `possibleQuantity` = '$data[14]',
                                        `orderNoId` = '$data[15]',
                                        `expectedImportDate` = '$data[16]',
                                        `orderAmount` = '$data[17]',
                                        `img` = '$data[18]',
                                        `thumb` = '$data[19]',
                                        `memo` = '$data[20]',
                                        `web` = '$data[21]',
                                        `webVariation` = '$data[22]',
                                        `cancelMaker` = '$data[23]',
                                        `cancelTform` = '$data[24]',
                                        `cancelSelling` = '$data[25]',
                                        `productSize` = '$data[26]',
                                        `modified` = '$date'
                                    WHERE 
                                        `tformNo` = '$data[2]'
                                ";
            mysql_query($import) or die(mysql_error());
            $updated++;
        } else {
            //echo "<span style='color: red;'>INSERTER</span><br>";

            $import="INSERT INTO $tableName (
                                        `productId`,
                                        `tformNo`,
                                        `type`,
                                        `maker`,
                                        `series`,
                                        `makerNo`,
                                        `orderNo`,
                                        `tformPriceNoTax`,
                                        `setMatchedProductId`,
                                        `setProductId`,
                                        `set`,
                                        `productColor`,
                                        `actualQuantity`,
                                        `possibleQuantity`,
                                        `orderNoId`,
                                        `expectedImportDate`,
                                        `orderAmount`,
                                        `img`,
                                        `thumb`,
                                        `memo`,
                                        `web`,
                                        `webVariation`,
                                        `cancelMaker`,
                                        `cancelTform`,
                                        `cancelSelling`,
                                        `productSize`,
                                        `created`,
                                        `modified`)
                                    VALUES (
                                        '$data[1]',
                                        '$data[2]',
                                        '$data[3]',
                                        '$data[4]',
                                        '$data[5]',
                                        '$data[6]',
                                        '$data[7]',
                                        '$data[8]',
                                        '$data[9]',
                                        '$data[10]',
                                        '$data[11]',
                                        '$data[12]',
                                        '$data[13]',
                                        '$data[14]',
                                        '$data[15]',
                                        '$data[16]',
                                        '$data[17]',
                                        '$data[18]',
                                        '$data[19]',
                                        '$data[20]',
                                        '$data[21]',
                                        '$data[22]',
                                        '$data[23]',
                                        '$data[24]',
                                        '$data[25]',
                                        '$data[26]',
                                        '$date',
                                        '$date')
                                ";

            mysql_query($import) or die(mysql_error());
            $inserted++;
        }
    */

    }

    fclose($handle);
    
    // UPDATE TABLES HERE
   
    unset($rowsInner);
    $cnt = 0;
    
        foreach($rows as $key => $value) {
            foreach($value as $childkey) {
                
                    $to = $value["to"];
                    $from = $value["from"];

                    $update = "UPDATE `$tableName` SET
                        `tformNo` = '$to'
                        WHERE
                        `tformNo` = '$from'
                    ";

                    $rowsInner[] = array(
                        "query" => $update
                    );
                    
                    $cnt++;
                
                   mysql_query($update) or die(mysql_error());

                    break;
            }
        }

        echo json_encode($cnt);
}


// ------------------------------------
// Find doubles and remove them in the 
// makerlistinfo table
// ------------------------------------
function CleanDoubles($listName){
    
    // grab the double productId items
    $query = "SELECT productId FROM makerlistinfo WHERE listName = '$listName' GROUP BY tformNo HAVING COUNT(*) > 1";
    $result = mysql_query($query);
        while($row = mysql_fetch_assoc($result)){
            $rows[] = array(
                "productId" => $row['productId']
        );
    }
    
    $rows2 = array();
    
    foreach($rows as $key => $value){
        // go trough each product ID and get all the doubles in the list and put it into an array
        
        $val = $value["productId"];
        
        $query2 = "SELECT * FROM makerlistinfo WHERE listName = '$listName' AND productId = '$val'";
        
        $result2 = mysql_query($query2);
        
        while($row2 = mysql_fetch_assoc($result2)){
                $rows2[] = array(
                "id" => $row2['id'],
                "listName" => $row2['listName'],
                "productId" => $row2['productId'],
                "tformNo" => $row2['tformNo'],
                "testPrice" => $row2['testPrice'],
                "haiban" => $row2['haiban'],
                "checked" => $row2['checked'],
                "memo" => $row2['memo'],
                "specialItems" => $row2['specialItems'],
                "isHidden" => $row2['isHidden']
            );
        }
           
    }
    
   
    echo json_encode($rows2);
}

// ------------------------------------
// DELETE items from LIST by table id
// ------------------------------------
function DeleteFromTable($listName, $id){
    
    $sql = "DELETE FROM `makerlistinfo` WHERE `listName` = '$listName' AND `id` = '$id'";
    $query = mysql_query($sql);
    
    echo json_encode($sql);
}

?>