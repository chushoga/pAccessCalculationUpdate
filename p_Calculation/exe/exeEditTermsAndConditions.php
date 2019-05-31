<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';

	$id = $_POST['id'];

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
	
	$modified = date('Y-m-d H:i:s');



$sql="UPDATE `sp_disc_rate` SET
								`year` = '$year',
								`memo` = '$memo',
								`maker` = '$maker',
								`netTerm` = '$netTerm',
								`currency` = '$currency',
								`modified` = '$modified',
								`rate` = '$rate',
								`percent` = '$percent',
								`discount` = '$discount',
								`discountPar` = '$discountPar',
								`sp1` = '$sp1',
								`sp2` = '$sp2',
								`sp3` = '$sp3',
								`sp4` = '$sp4',
								`sp5` = '$sp5',
								`sp1Par` = '$sp1Par',
								`sp2Par` = '$sp2Par',
								`sp3Par` = '$sp3Par',
								`sp4Par` = '$sp4Par',
								`sp5Par` = '$sp5Par',
								`colorId` = '$colorId'
									WHERE
							 	`id` = '$id'
							 	";
$result = mysql_query($sql);


if($result){
    header("location: ../editTermsAndConditions.php?pr=1&id=$id&message=success"); die();
} else {
    header("location: ../editTermsAndConditions.php?pr=1&id=$id&message=error"); die();
}


?>

