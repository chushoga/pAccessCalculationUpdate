<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
// Set the discount ID for the current pricelist.
//VARIABLES----
$search = $_GET['search'];
$i = 0;
$created = date ("Y-m-d H:i:s");
$modified = date ("Y-m-d H:i:s");
$plCurrent = 0;
$tformPriceNoTax = 0;
$tformNo = "";

if ($_POST['id'] != ""){
    $id = $_POST['id'];
} else {
    header("location: ../setTermsAndConditionsNew.php?pr=1&message=error&info=割引条件ID選んでください。&search=$search"); die();
}

foreach ($_POST as $key => $value) {

    //update sp_plcurrent
    $sql = "UPDATE sp_plcurrent
						SET 
				`sp_disc_rate_id` = '$id'
						WHERE
				productId = '$key'
				";
    $result = mysql_query($sql);

//main query to copy the current tform price into the history table
    $resultMain = mysql_query("SELECT * FROM `main` WHERE `productId` = '$key'");
    while ($rowMain = mysql_fetch_assoc($resultMain)){
        $tformPriceNoTax = $rowMain['tformPriceNoTax'];
        $tformNo = $rowMain['tformNo'];
    }
    
    $resultplCurrent = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `productId` = '$key'");
    while ($rowplCurrent = mysql_fetch_assoc($resultplCurrent)){
        $plCurrent = $rowplCurrent['plCurrent'];
    }

    // before inserting make sure that the first check(id for the select ALL checkbox on the prevous page) is ignorned
    if ($key != 'id'){
        
    $import = "INSERT INTO `sp_history`
					(`tformNo`,
                    `productId`,
					`sp_disc_rate_id`,
					`plCurrent`,
					`tformPriceNoTax`,
					`created`,
					`modified`
					) 
					VALUES
					('$tformNo',
                    '$key',
					'$id',
					'$plCurrent',
					'$tformPriceNoTax',
					'$created',
					'$modified'
					)";

    mysql_query($import) or die(mysql_error());
$i++;
    }
    
        //----------------------------------------------------------------------------
}

//update general history
$action = "UPD";
$memoInsert = "[ ".$i." ] files UPDATED in sp_disc_rate (DISCOUNT/RATE)";
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

header("location: ../setTermsAndConditionsNew.php?pr=1&message=success&search=$search"); die();

    ?>