<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';

/* Open the csv */
if (fopen($_FILES['filename']['tmp_name'], "r") == ''){
    header("location: ../setTermsAndConditions.php?pr=1&message=error&info=ファイル選んでない!");
}

$handle = fopen($_FILES['filename']['tmp_name'], "r"); // set the handle to the csv data

/* Initalize some variables */
$created = date ("Y-m-d H:i:s"); // date created or modified

// -----------------------------------------------------------
// set a table name for truncation BE VERY CAREFUL HERE,
// if you mix up the table name you can cause some big trouble
//------------------------------------------------------------
$tableName = 'sp_plupdate';
// -------------------------------

/* ********************************************************************************** */
// TRUNCATE TABLE CONTENTS FROM THE TEMPERARY TABLE NAMED sp_plupdate
/* ********************************************************************************** */
$deleterecords = mysql_query("TRUNCATE TABLE $tableName");
/* ********************************************************************************** */


while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
	
	// -----------------------------------------------------------
	// input data from csv to the temp table 'sp_plupdate'
	//------------------------------------------------------------
	
	
	// TEST TO REMOVE THE 0 FROM THE CSV AND DO CHECKS BEFORE UPLOADING
    // $data[0] are all "0"s
    //$productId _ $data[1]; // filemaker product id number
	//$tformNo = $data[2]; // tform no
	//$new = $data[3]; // new price
		
	$import = "INSERT INTO $tableName
							(
                            `productId`,
                            `tformNo`,
							`new`) 
							VALUES
							( '$data[0]',
							  '$data[1]',
                              '$data[2]'
							)";
	
    mysql_query($import) or die(mysql_error());
	
	// -----------------------------------------------------------
    // Check the sp_plcurrent table and see if the tformNo already exists.
	// If it does not, insert it into the table so that we can have an inital value
	// to update with the following join query.
    //------------------------------------------------------------
	
    //$result = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` = '$data[1]'"); // UPDTATED ON 2018.9.19 HOWE
    // added an extra $data[i] to compensate for the added product id. // UPDTATED ON 2018.9.19 HOWE
	$result = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `productId` = '$data[0]'"); // UPDTATED ON 2018.9.19 HOWE
    if(mysql_num_rows($result) == 0) {
		$sql = "INSERT INTO `sp_plcurrent`
								(
                                `productId`,
                                `tformNo`,
								`plCurrent`,
                                `sp_disc_rate_id`,
								`created`) 
								VALUES
								('$data[0]',
								'$data[1]',
                                '$data[2]',
                                '0',
								'$created'
								)";
		
		mysql_query($sql) or die(mysql_error());
	}
}

fclose($handle); // close CSV


// Update the current pricelist by comparing sp_plupdate and sp_plcurrent table,
// then adding where the tformNo is the same and not 0.

// UPDTATED ON 2018.9.19 HOWE
/*
$result = mysql_query("UPDATE sp_plcurrent
							INNER JOIN 
								sp_plupdate
							ON 
								sp_plcurrent.tformNo = sp_plupdate.tformNo
							SET 
								sp_plcurrent.plcurrent = sp_plupdate.new,
								sp_plcurrent.created = '$created';
								") or die(mysql_error());
*/
$result = mysql_query("UPDATE sp_plcurrent
							INNER JOIN 
								sp_plupdate
							ON 
								sp_plcurrent.productId = sp_plupdate.productId
							SET 
								sp_plcurrent.plcurrent = sp_plupdate.new,
								sp_plcurrent.created = '$created';
								") or die(mysql_error());

header("location: ../setTermsAndConditions.php?pr=1&message=success");

?>