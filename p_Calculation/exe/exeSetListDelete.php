<?php require_once "../../master/dbconnect.php";

$id = $_GET['id'];
$listName = $_GET['listName'];


//delete discount from the table
$order = sprintf ('DELETE FROM `makerlistcontents` WHERE id=%d',
         mysql_real_escape_string($id)
                 );
$result = mysql_query($order);  //order executes

if($result){
    $order2 = mysql_query("DELETE FROM `makerlistinfo` WHERE `listName` = '$listName'");
$result2 = mysql_query($order2);  //order2 executes
    
    header("location: ../list_allFiles.php?pr=1&message=success");
}else{
    header ("location: ../list_allFiles.php?pr=1&message=error");

}

?>