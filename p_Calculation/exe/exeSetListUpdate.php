<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
/*
 * 1. check if tformNo already exists in list
 * 1a. if already exists add to $message variable adf70-111 + adf70 ++++
 * 2. if it does not AND not listId insert into list
 * 3. send back to edit page with any errors
 */
$listId = $_POST['listId'];
    
    foreach ($_POST as $key => $value){
        if ($key != "listId"){
            $result = mysql_query("SELECT * FROM `makerlistinfo` WHERE `tformNo` =  '$key' AND `listName` = '$listId'");//query
        
            if(mysql_num_rows($result) == 0) {
                $ins = "INSERT INTO `makerlistinfo` (`tformNo`,`listName`) VALUES ('$key','$listId')";
                mysql_query($ins) or die(mysql_error());
        } else {
          }
        }
    }
header("location: ../list_edit_contents.php?pr=1&message=success&id=$listId");
?>