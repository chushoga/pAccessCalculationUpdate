<?php require_once "../../master/dbconnect.php";

$id = $_GET['id'];
$locked = "";

$result = mysql_query("SELECT * FROM `makerlistcontents` WHERE `id` = '$id'");
while ($row = mysql_fetch_assoc($result)){
    $locked = $row['locked'];
}
if ($locked == 0){
    $status = 1;
} else if($locked == 1){
    $status = 0;
}

$ins = "UPDATE `makerlistcontents` SET `locked` = '$status' WHERE `id` = '$id'";
mysql_query($ins) or die(mysql_error());


header ("location: ../list_allFiles.php?pr=1");

?>