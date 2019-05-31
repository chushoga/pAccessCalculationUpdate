<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
if (fopen($_FILES['filename']['tmp_name'], "r") == ''){
	header("location: ../calculation.php?pr=1&message=error&info=ファイル選んでない!");
}

$handle = fopen($_FILES['filename']['tmp_name'], "r");
$tableName = 'main';
$inserted = 0;
$updated = 0;
$total = $inserted + $updated;
$date = date ("Y-m-d H:i:s");

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	$result = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$data[2]'");
	$sql = mysql_fetch_assoc($result);
	$num = mysql_num_rows($result);

	if ($num){
		/* ADDED productColor, actualQuantity, possibleQuantity 2018-4-4 */

		$import="UPDATE $tableName SET
									`productId` = '$data[1]',
									`tformNo` = '$data[2]',
									`type` = '$data[3]',
									`maker` = '$data[4]',
									`series` = '$data[5]',
									`makerNo` = '$data[6]',
									`orderNo` = '$data[7]',
									`tformPriceNoTax` = '$data[8]',
									`setMatchedProductId` = '$data[9]',
									`setProductId` = '$data[10]',
									`set` = '$data[11]',
                                    `productColor` = '$data[12]',
                                    `actualQuantity` = '$data[13]',
                                    `possibleQuantity` = '$data[14]',
                                    `orderNoId` = '$data[15]',
									`expectedImportDate` = '$data[16]',
									`orderAmount` = '$data[17]',
									`img` = '$data[18]',
									`thumb` = '$data[19]',
									`memo` = '$data[20]',
									`web` = '$data[21]',
									`webVariation` = '$data[22]',
									`cancelMaker` = '$data[23]',
									`cancelTform` = '$data[24]',
									`cancelSelling` = '$data[25]',
									`productSize` = '$data[26]',
									`modified` = '$date'
								WHERE 
									`productId` = '$data[1]'
							";
		mysql_query($import) or die(mysql_error());
		$updated++;
	} else {
		//echo "<span style='color: red;'>INSERTER</span><br>";

		$import="INSERT INTO $tableName (
									`productId`,
									`tformNo`,
									`type`,
									`maker`,
									`series`,
									`makerNo`,
									`orderNo`,
									`tformPriceNoTax`,
									`setMatchedProductId`,
									`setProductId`,
									`set`,
                                    `productColor`,
                                    `actualQuantity`,
                                    `possibleQuantity`,
                                    `orderNoId`,
                                    `expectedImportDate`,
                                    `orderAmount`,
									`img`,
									`thumb`,
									`memo`,
									`web`,
									`webVariation`,
									`cancelMaker`,
									`cancelTform`,
									`cancelSelling`,
									`productSize`,
                                    `created`,
									`modified`)
								VALUES (
									'$data[1]',
									'$data[2]',
									'$data[3]',
									'$data[4]',
									'$data[5]',
									'$data[6]',
									'$data[7]',
									'$data[8]',
									'$data[9]',
									'$data[10]',
									'$data[11]',
									'$data[12]',
									'$data[13]',
									'$data[14]',
									'$data[15]',
									'$data[16]',
									'$data[17]',
									'$data[18]',
									'$data[19]',
									'$data[20]',
                                    '$data[21]',
									'$data[22]',
									'$data[23]',
                                    '$data[24]',
                                    '$data[25]',
                                    '$data[26]',
                                    '$date',
									'$date')
							";

		mysql_query($import) or die(mysql_error());
		$inserted++;
	}
}

//copy to gernal history table-----------------------
	$created = date ("Y-m-d H:i:s");
	$action = "";
	$memoInsert = "[ ".$inserted." ] files inserted into main (FILEMAKER)";
	$memoUpdate = "[ ".$updated." ] files updated in main (FILEMAKER)";
	if ($inserted >= 1){
	$action = "INS";
	$import="INSERT INTO `sp_history_general` (
									`action`, 
									`memo`, 
									`created`) 
								VALUES (
									'$action',
									'$memoInsert',
									'$created')
							";
		mysql_query($import) or die(mysql_error());
	}
	if ($updated >= 1){
	$action = "UPD";
	$import="INSERT INTO `sp_history_general` (
									`action`, 
									`memo`, 
									`created`) 
								VALUES (
									'$action',
									'$memoUpdate',
									'$created')
							";
		mysql_query($import) or die(mysql_error());
	}
	//----------------------------------------------------

	fclose($handle);
	$total = $inserted + $updated;
	header("location: ../calculation.php?pr=1&message=success&info=$total files edited"); die();
?>