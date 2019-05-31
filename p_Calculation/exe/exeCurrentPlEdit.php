<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
$id = $_POST['id'];
$newPrice = $_POST['newPrice'];
$search = $_POST['search'];
$tformNo = $_POST['tformNo'];


// WRITE THE UPDATE FUNCTION HERE......
/*
 * need to modify the form to update
 * NEED:
 * rate id
 * discount id
 * 
 * 
 */
$result = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `id` = '$id'");
while ($row = mysql_fetch_assoc($result)){
    $sp_disc_rate_id = $row['sp_disc_rate_id'];
    $plCurrent = $row['plCurrent'];
}

/*
 * TEST AREA ------------------------
 */

echo "id: ".$id;
echo "<br>";
echo "tformNo: ".$tformNo;
echo "<br>";
echo "oldPrice: ".$plCurrent;
echo "<br>";
echo "newPrice: ".$newPrice;


/*----------------------------------*/
 //main query to copy the current tform price into the history table
    $resultMain = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$tformNo'");
    while ($rowMain = mysql_fetch_assoc($resultMain)){
        $tformPriceNoTax = $rowMain['tformPriceNoTax'];
    }

    $created = date ("Y-m-d H:i:s");
    $modified = date ("Y-m-d H:i:s");
/*
    $import="INSERT INTO `sp_history`
					(`tformNo`, 
					`sp_disc_rate_id`,
					`plCurrent`,
					`tformPriceNoTax`,
					`created`,
					`modified`
					) 
					VALUES
					('$tformNo',
					'$sp_disc_rate_id',
					'$newPrice',
					'$tformPriceNoTax',
					'$created',
					'$modified'
					)";

    mysql_query($import) or die(mysql_error());
    */
//----------------------------------------------------------------------------
// update general history table

$memoInsert = "[ ".$tformNo." ] (MAKER PL) UPDATED in sp_plcurrent";
$action = "UPD";
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
    
//----------------------------------------------------------------------------    



$result = mysql_query("UPDATE `sp_plcurrent`
							SET 
								`plCurrent` = '$newPrice'
                            WHERE `id` = '$id';
") or die(mysql_error());


header('location: ../setTermsAndConditions.php?pr=1&search='.$search.'&message=success&info=メーカー価格アップデートしました！');

?>