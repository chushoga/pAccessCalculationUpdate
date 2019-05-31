<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
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

$query = "UPDATE `makerlistinfo` SET `specialItems` = '$implodedInsert' WHERE `tformNo` = '$tformNoToEdit' && `listName` = '$listName'";

echo $query;

mysql_query($query) or die(mysql_error());

header("location: ../list_specialConditions.php?pr=1&message=success&id=$listName&focusTformNo=$tformNoToEdit");
?>