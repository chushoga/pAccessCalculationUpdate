<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';

/* VARIABLES */
$orderNo = $_POST['orderNo'];
$date = $_POST['date'];
$recordCount = $_POST['range'];

$checkOrderNo = false;

	$result = mysql_query("SELECT * FROM `order` WHERE `orderNo` = '$orderNo'");
	while ($row = mysql_fetch_assoc($result)){
	    
        $ordNo = $row['orderNo'];
        
        if($ordNo == $orderNo){
            $checkOrderNo = true;
        }
	}

/* CHECK IF ORDER EXISTS AND IF NOT THEN INSERT INTO order TABLE */
if($checkOrderNo){
    // send to the order page because there is a copy of the order no
    header("location: ../order.php?pr=4&message=error&info=オーダーNO.[$orderNo]作成出来ませんでした！"); die();
} else {
   for($i = 0; $i < $recordCount; $i++){
       $sql = "INSERT INTO `order`
         			 (`orderNo`,
         			 `date`)
          		VALUES 
          			('$orderNo',
          			'$date')
          			";
       mysql_query($sql) or die(mysql_error());
   }
    header("location: ../order.php?pr=4&orderNo=$orderNo&message=success&info=オーダーNO.[$orderNo]作成完成！"); die();
}
?>