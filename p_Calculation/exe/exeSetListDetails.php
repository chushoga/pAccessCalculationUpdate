<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';


$listName = $_POST['listName'];
//$rate1 = $_POST['rate1'];
//$rate2 = $_POST['rate2'];
//$percent1 = $_POST['percent1'];
//$percent2 = $_POST['percent2'];
$EUR_rate = $_POST['eur_rate'];
$EUR_percent = $_POST['eur_percent'];

$USD_rate = $_POST['usd_rate'];
$USD_percent = $_POST['usd_percent'];

$RMB_rate = $_POST['rmb_rate'];
$RMB_percent = $_POST['rmb_percent'];

$DKR_rate = $_POST['dkr_rate'];
$DKR_percent= $_POST['dkr_percent'];

$SKR_rate = $_POST['skr_rate'];
$SKR_percent = $_POST['skr_percent'];

$SGD_rate = $_POST['sgd_rate'];
$SGD_percent = $_POST['sgd_percent'];




   // print_r($_POST);

    $ins="UPDATE `makerlistcontents` 
                    	SET
					 `eur_rate` = '$EUR_rate',
					 `eur_percent` = '$EUR_percent',
					 `usd_rate` = '$USD_rate',
					 `usd_percent` = '$USD_percent',
					 `rmb_rate` = '$RMB_rate',
					 `rmb_percent` = '$RMB_percent',
					 `dkr_rate` = '$DKR_rate',
					 `dkr_percent` = '$DKR_percent',
					 `skr_rate` = '$SKR_rate',
					 `skr_percent` = '$SKR_percent',
					 `sgd_rate` = '$SGD_rate',
					 `sgd_percent` = '$SGD_percent'
					 	 WHERE 
					  `listName` = '$listName'
					";

                mysql_query($ins) or die(mysql_error());

   header("location: ../list_calculation.php?pr=1&message=success&id=$listName");

?>