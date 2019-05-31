<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';

$orderNo = $_POST['orderNo'];

foreach ($_POST as $value => $key){
    
    $phrase = $value;

    // get the Id   
    $clnName = array("date_", "priceList_", "discount_", "makerNo_", "tformNo_", "quantity_", "currency_", "ignoreExpense_");
    
    $clnRep = '';
    $clnId = str_replace($clnName, $clnRep, $value);
    
    // get the Name
    $clnName1 = array("_$clnId");
    $clnRep1 = '';
    $clnId1 = str_replace($clnName1, $clnRep1, $value);
    
    
    $result = mysql_query("UPDATE `order`
                        SET 
                            `$clnId1` = '$key'
                        WHERE orderNo = '$orderNo' && id = '$clnId';
                        ") or die(mysql_error());
    
}

header("location: ../order.php?pr=4&orderNo=".$orderNo."&message=success"); die();

?>