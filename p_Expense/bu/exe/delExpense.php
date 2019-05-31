<?php require_once "../../master/dbconnect.php";

$id = $_POST['id'];

//delete discount from the table
$order = sprintf ('DELETE FROM expense WHERE id=%d',
         mysql_real_escape_string($id)
                 );
$result = mysql_query($order);  //order executes
if($result){
    header("location: ../expense.php?pr=3&message=success");

}else{
    header ("location: ../expense.php?pr=3&message=error");
}
?>