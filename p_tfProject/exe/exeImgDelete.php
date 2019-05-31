<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
//variables
$id = $_GET['id'];
$imgId = $_GET['imgId'];
$sqlID = "UPDATE tfProject
					SET 
				$imgId = ''
					WHERE
				id = '$id'";
$resID = mysql_query($sqlID);
header("location: ../editBlocks.php?pr=2&id=$id&message=success&info=イメージ削除完成!!!!");

?>