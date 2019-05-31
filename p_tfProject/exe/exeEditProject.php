<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
// --------------------------------------------------
// SET VARIABLES
$id = $_POST['dbId']; 
//---------------------------------------------------

//insert the $_POST data from tfProjectInput.php into the tfProject TABLE.
foreach ($_POST as $key => $value){

if ($key != "" && $key != "dbId"){
    /*
    echo "KEY: ".$key." VALUE: ".$value;
    echo "<br>";
    */
$sql = "UPDATE `tfproject` SET `$key` = '$value'
			WHERE
				`id` = '$id'
			";
$result = mysql_query($sql);

    }
}    

header("location: ../tfProject.php?pr=2&id=$id&message=success");

