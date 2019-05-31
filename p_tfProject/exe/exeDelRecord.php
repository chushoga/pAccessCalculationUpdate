<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
// --------------------------------------------------
// SET VARIABLES
$id = $_GET['id'];

 $sql = "DELETE FROM tfProject WHERE id = '$id'";
 $result = mysql_query($sql);
 

header("location: ../tfProject.php?pr=2&message=success");

