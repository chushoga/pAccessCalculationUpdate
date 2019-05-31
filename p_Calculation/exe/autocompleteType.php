<?php
$server = 'localhost';
$user = 'admin';
$password = 'pass';
$database = 'tanka';


$mysqli = new MySQLi($server,$user,$password,$database);
/* Connect to database and set charset to UTF-8 */
if($mysqli->connect_error) {
  echo 'Database connection failed...' . 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
  exit;
} else {
    
  $mysqli->set_charset('utf8');
}

/* retrieve the search term that autocomplete sends */
$term = trim(strip_tags($_GET['term'])); 
$a_json = array();
$a_json_row = array();
if ($data = $mysqli->query("SELECT DISTINCT `type`, `id` FROM `main` WHERE `type` LIKE '%$term%' GROUP BY `type`")) {
	while($row = mysqli_fetch_array($data)) {
		$id = htmlentities(stripslashes($row['id']));
		//$maker = htmlentities(stripslashes($row['maker']));
		//$year = htmlentities(stripslashes($row['year']));
		//$memo = htmlentities(stripslashes($row['memo']));
		
		//$netTerm = htmlentities(stripslashes($row['netTerm']));
		//$currency = htmlentities(stripslashes($row['currency']));
		//$rate = htmlentities(stripslashes($row['rate']));
		//$percent = htmlentities(stripslashes($row['percent']));
		$type = htmlentities(stripslashes($row['type']));
		
		$a_json_row["id"] = $id;
		$a_json_row["value"] = $type;
		$a_json_row["label"] = $type;
		$a_json_row["labelproductType"] = $type;

		array_push($a_json, $a_json_row);
	}
}
// jQuery wants JSON data
echo json_encode($a_json);
flush();
 
$mysqli->close();
?>