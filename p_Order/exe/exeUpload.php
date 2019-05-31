<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';

//variables -----------------------------------------------------
if (empty($_FILES['filename']['tmp_name'])) {
header('location: order.php?message=error');
    
} else {
       $handle = fopen($_FILES['filename']['tmp_name'], "r");
  
    
//$i=1;
     while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
         $sql = "INSERT INTO `order`
         			 (`tformNo`,
         			 `makerNo`,
         			 `orderNo`,
         			 `date`,
         			 `quantity`)
          		VALUES 
          			('$data[2]',
          			'$data[3]',
          			'$data[4]',
          			'$data[5]',
          			'$data[6]')
          			";
         mysql_query($sql) or die(mysql_error());
        
      }
    
	fclose($handle);
	$id = mysql_insert_id(); // gets the last inserted ID
	$result = mysql_query("SELECT * FROM `order` WHERE `id` = '$id'");
	while ($row = mysql_fetch_assoc($result)){
	    $orderNo = $row['orderNo'];
	}
header("location: ../order.php?pr=4&orderNo=$orderNo&message=success&info=オーダーNO.[$orderNo]アップロード完成！"); die();
}
?>