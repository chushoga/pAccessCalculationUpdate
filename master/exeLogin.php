<?php
session_start();
header('Content-type: application/json');

// ------------------------------------------------
// SET DATABASE AND LOCATION
// ------------------------------------------------

date_default_timezone_set('Asia/Tokyo'); 
require_once 'dbconnect.php';

// ------------------------------------------------
/* DEBUGGER FUNCTION */
// ------------------------------------------------

function debugger($array){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

// check if login is checked and then set to true or false
if(isset($_POST['action'])){
	$login = true;
} else {
	$login = false;
}
//--------------------------------------------------------
// check USER NAME
if(isset($_POST['user'])){
	$user = $_POST['user'];
} else {
	$user = false;
}
//--------------------------------------------------------
// check LOGIN NAME
if(isset($_POST['password'])){
	$password = $_POST['password'];
} else {
	$password = false;
}
//--------------------------------------------------------

//debugger($_POST);

// if everything is set then do the query
if ($login == true && $user != false && $password != false)
{
	$query = "SELECT * FROM users WHERE name = '$user'";
	
	$result = mysql_query($query);
	
	while($row = mysql_fetch_assoc($result))
	{
		// check if the password and username matches the database
		if($user == $row['name'] && $password == $row['password'])
		{
			$_SESSION["loggedIn"] = $row['name']; // set session
			$array = array ("id" => $row['id'], "user" => $row['name'], "accessLevel" => $row['accessLevel']);
		}
	}
	echo json_encode($array);
}


?>