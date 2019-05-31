<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';


//variables
$id = $_GET['id'];
//---------

foreach ($_POST as $key => $value){
    if ($key != ""){
 $sql = "UPDATE expense SET 
 			`$key` = '$value'
			WHERE
				id = '$id'
			";
$result = mysql_query($sql);

           // echo "- ".$key." | ".$value." - ".$id."<br>";
    }
    }

header("location: ../expense.php?pr=3&id=$id&message=success");

?>