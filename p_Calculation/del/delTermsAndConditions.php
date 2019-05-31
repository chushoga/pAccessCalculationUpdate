<?php require_once "../../master/dbconnect.php";

$id = $_GET['id'];
echo $id;
//delete rate from the table
$order = sprintf ('DELETE FROM `sp_disc_rate` WHERE id=%d',
         mysql_real_escape_string($id)
                 );
$result = mysql_query($order);  //order executes
if($result){
    header("location: ../termsAndConditions.php?pr=1&message=success");

}else{
    header ("location: ../termsAndConditions.php?pr=1&message=error");

}
?>