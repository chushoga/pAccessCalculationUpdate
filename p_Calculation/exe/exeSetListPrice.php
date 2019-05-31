<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
$listId = $_POST['listName']; // list name
$id = $_POST['id']; // id of the submitted tform no in the list
$memo = $_POST['memo']; // the memo for each thing in the list
$inputPrice = $_POST['inputPrice']; // the input price

for ($i = 0; $i < count($inputPrice); $i++){
	$result="UPDATE `makerlistinfo` SET
						`memo` = '$memo[$i]',
    					`testPrice` = '$inputPrice[$i]'
    				WHERE 
    					`id` = '$id[$i]'
    			";
	mysql_query($result) or die(mysql_error());
}
header("location: ../list_calculation.php?pr=1&message=success&id=$listId");

?>