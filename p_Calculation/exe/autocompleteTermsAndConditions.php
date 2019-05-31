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
if ($data = $mysqli->query("SELECT * FROM `sp_disc_rate` WHERE `maker` LIKE '%$term%' OR `id` LIKE '%$term%'")) {
	while($row = mysqli_fetch_array($data)) {
		$id = htmlentities(stripslashes($row['id']));
		$maker = htmlentities(stripslashes($row['maker']));
		$year = htmlentities(stripslashes($row['year']));
		$memo = htmlentities(stripslashes($row['memo']));
		
		$netTerm = htmlentities(stripslashes($row['netTerm']));
		$currency = htmlentities(stripslashes($row['currency']));
		$rate = htmlentities(stripslashes($row['rate']));
		$percent = htmlentities(stripslashes($row['percent']));
		$discountPar = htmlentities(stripslashes($row['discountPar']));
		
		$a_json_row["id"] = $id;
		$a_json_row["value"] = $id;
		$a_json_row["label"] = $maker.' '.$year.' '.$memo.' -'.$discountPar.'%/ ￥'.$rate.'/ '.$percent.'%';
		$a_json_row["labelDiscountPar"] = $discountPar;
		$a_json_row["labelRate"] = $rate;
		$a_json_row["labelPercent"] = $percent;
		$a_json_row["labelCurrency"] = $currency;

		array_push($a_json, $a_json_row);
	}
}
// jQuery wants JSON data
echo json_encode($a_json);
flush();
 
$mysqli->close();
?>