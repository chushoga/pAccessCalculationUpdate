<?php 
date_default_timezone_set('Asia/Tokyo'); 
require_once '../../master/dbconnect.php';

// check if can input the information or not
$canUpdate = true;
$conflictingOrderNo = "";
$tmp = array();

// ----------------
// Edit: 2018-10-2
// ----------------

if (empty($_FILES['filename']['tmp_name'])) {
    
    header('location: order.php?message=error');

} else {
    
    $handle = fopen($_FILES['filename']['tmp_name'], "r");

    /* 
        START by checking if there are any order no present already and if so,
        set the canUpdate bool to false and do not update.
    */
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $sql = mysql_query("SELECT * FROM `order` WHERE orderNo = '$data[4]'");
        while($row = mysql_fetch_assoc($sql)){
            
            if($row['orderNo'] == $data[4]){
                
                $canUpdate = false; // do not allow updating
                
                // log the conflicting order numbers
                if(in_array($row['orderNo'], $tmp) == false){
                    $tmp[] = $row['orderNo'];
                    $conflictingOrderNo .= $row['orderNo']." | ";
                }
            }
        }
        
    }
    
    fclose($handle);
    
    $handle = fopen($_FILES['filename']['tmp_name'], "r");

    // if can update then run the insert but even if one is present do not allow any to be updated.
    if($canUpdate){
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            // first check if the orderNo Already exists for all before insterting.
            $sql = "INSERT INTO `order`
                                        (`tformNo`,
                                        `makerNo`,
                                        `orderNo`,
                                        `date`,
                                        `quantity`,
                                        `priceList`)
                                        VALUES
                                        ('$data[2]',
                                        '$data[3]',
                                        '$data[4]',
                                        '$data[5]',
                                        '$data[6]',
                                        '$data[1]')
            ";
            
            // run the query
            mysql_query($sql) or die(mysql_error());

        }
         fclose($handle);
        
        // if everything went ok then return the success message.
        header("location: ../order.php?pr=4&message=success&info=アップロード完成！"); die();

    } else {
        
        // if there are double orders then return this error...
        header("location: ../order.php?pr=4&message=error&info=ORDERS: ".$conflictingOrderNo." are already present. Did not updload"); die();

    }
}

?>
