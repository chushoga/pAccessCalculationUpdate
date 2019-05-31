<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';



if(isset($_POST['year'])) {
	$year = $_POST['year'];
}else{
	$year = "-";
}


if($_POST['maker'] != "") {
	$maker = strtoupper($_POST['maker']);
}else{
	$maker = "-";
}
if(isset($_POST['rate'])) {
	$rate = $_POST['rate'];
}else{
	$rate = "-";
}
if(isset($_POST['percent'])) {
	$percent = $_POST['percent'];
}else{
	$percent = "-";
}
if($_POST['memo'] != "") {
	$memo = $_POST['memo'];
}else{
	$memo = "-";
}
if($_POST['netTerm'] != "") {
	$netTerm = $_POST['netTerm'];
}else{
	$netTerm = "-";
}
if($_POST['currency'] != "") {
	$currency = $_POST['currency'];
}else{
	$currency = "-";
}
if($_POST['sp1'] != "") {
	$sp1Par = $_POST['sp1'];
	$sp1 = (100 - $_POST['sp1']) / 100 ;
}else{
	$sp1 = 1;
	$sp1Par = 0;
}
if($_POST['sp2'] != "") {
	$sp2Par = $_POST['sp2'];
	$sp2 = (100 - $_POST['sp2']) / 100 ;
}else{
	$sp2 = 1;
	$sp2Par = 0;
}
if($_POST['sp3'] != "") {
	$sp3Par = $_POST['sp3'];
	$sp3 = (100 - $_POST['sp3']) / 100 ;
}else{
	$sp3 = 1;
	$sp3Par = 0;
}
if($_POST['sp4'] != "") {
	$sp4Par = $_POST['sp4'];
	$sp4 = (100 - $_POST['sp4']) / 100 ;
}else{
	$sp4 = 1;
	$sp4Par = 0;
}
if($_POST['sp5'] != "") {
	$sp5Par = $_POST['sp5'];
	$sp5 = (100 - $_POST['sp5']) / 100 ;
}else{
	$sp5 = 1;
	$sp5Par = 0;
}

if(isset($_POST['colorId'])){
	$colorId = $_POST['colorId'];
} else {
	$colorId = "#FFFFFF";
}


$netPar = $sp1 * $sp2 * $sp3 * $sp4 * $sp5;
$discountPar = (1-$netPar)*100;
$discount = (100 - $discountPar) / 100 ;

$created = date('Y-m-d H:i:s');
$modified = date('Y-m-d H:i:s');

$sql="INSERT INTO `sp_disc_rate`
	(`year`,
	`memo`,
	`maker`,
	`netTerm`,
	`currency`,
	`created`,
	`modified`,
	`rate`,
	`percent`,
	`discount`,
	`discountPar`,
	`sp1`,
	`sp2`,
	`sp3`,
	`sp4`,
	`sp5`,
	`sp1Par`,
	`sp2Par`,
	`sp3Par`,
	`sp4Par`,
	`sp5Par`,
	`colorId`)
		 VALUES 
	 ('$year',
	  '$memo',
	  '$maker',
	  '$netTerm',
	  '$currency',
	  '$created',
	  '$modified',
	  '$rate',
	  '$percent',
	  '$discount',
	  '$discountPar',
	  '$sp1',
	  '$sp2',
	  '$sp3',
	  '$sp4',
	  '$sp5',
	  '$sp1Par',
	  '$sp2Par',
	  '$sp3Par',
	  '$sp4Par',
	  '$sp5Par',
	  '$colorId')";
$result = mysql_query($sql);

header("location: ../termsAndConditions.php?pr=1&message=success"); die();

?>

