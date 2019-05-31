<?php  date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
//////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
if(isset($_POST['tformNo'])){
    $tformNo = $_POST['tformNo'];
} else {
    header("location: ../insert_single.php?pr=1&message=error");
}
//if error drop this page and go back to insert_single page...
//////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

if(isset($_POST['makerNo'])){
    $makerNo = $_POST['makerNo'];
} else {
    $makerNo = "";
}
if(isset($_POST['productType'])){
    $type = $_POST['productType'];
} else {
    $type = "";
}

if(isset($_POST['maker'])){
    $maker = $_POST['maker'];
} else {
    $maker = "";
}

if(isset($_POST['series'])){
    $series = $_POST['series'];
} else {
    $series = "";
}

if(isset($_POST['memo'])){
    $memo = $_POST['memo'];
} else {
    $memo = "";
}
if(isset($_POST['pl'])){
    $pl = $_POST['pl'];
} else {
    $pl = "";
}
if(isset($_POST['rate_disc_id'])){
    $rate_disc_id = $_POST['rate_disc_id'];
} else {
    $rate_disc_id = "";
}
if(isset($_POST['tformPriceNoTax'])){
    $tformPriceNoTax = $_POST['tformPriceNoTax'];
} else {
    $tformPriceNoTax = "";
}

$result = "INSERT INTO `main` (
								`tformNo`,
								`makerNo`,
								`type`,
								`maker`,
								`series`,
								`memo`,
								`tformPriceNoTax`
								)
									 VALUE
								 (
								 '$tformNo',
								 '$makerNo',
								 '$type',
								 '$maker',
								 '$series',
								 '$memo',
								 '$tformPriceNoTax'
								 )"; 

$result2 = "INSERT INTO `sp_plcurrent` (
								`tformNo`,
								`plCurrent`,
								`sp_disc_rate_id`
								)
									 VALUE
								 (
								 '$tformNo',
								 '$pl',
								 '$rate_disc_id'
								 )";

/*
 * CHECK IF TFORM NO EXISTS
 */

$resultCheck = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$tformNo'");
if(mysql_num_rows($resultCheck)){
    header("location: ../insert_single.php?pr=1&message=error&info=品番もう存在しています");
} else {
    
        header("location: ../insert_single.php?pr=1&message");
    
    mysql_query($result) or die(mysql_error());
    mysql_query($result2) or die(mysql_error());
    header("location: ../calculation.php?pr=1&search=$tformNo&message=success");
    
}
//EXIT IF EXISTS!!!!
///////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\
//SET UP SELECT QUERY FOR INSERT INTO MAIN




?>
