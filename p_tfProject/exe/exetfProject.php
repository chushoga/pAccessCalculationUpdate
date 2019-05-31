<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';

// insert a temp data into the tfproject table
$sql = "INSERT INTO tfProject (projectName) VALUES ('1')";
$result = mysql_query($sql);
// --------------------------------------------------
// SET VARIABLES
$id = mysql_insert_id(); // gets the last inserted ID
//---------------------------------------------------

//insert the $_POST data from tfProjectInput.php into the tfProject TABLE.
foreach ($_POST as $key => $value){

if ($key != ""){
$sql = "UPDATE tfProject SET 
 			`$key` = '$value'
			WHERE
				id = '$id'
			";
$result = mysql_query($sql);
    }
}    

header("location: ../tfProject.php?pr=2&id=$id&message=success");

?>