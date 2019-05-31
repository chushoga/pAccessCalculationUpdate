<?php require_once "../../master/dbconnect.php";
//variables
$tformNo = "";
$keep = 0;
$destroy = 0;
//---------

$result = mysql_query("SELECT * FROM `sp_history` WHERE `tformNo` LIKE '%$tformNo%'");
while ($row = mysql_fetch_assoc($result)){
    echo "ID:".$row['id']." / RATEID: ".$row['sp_disc_rate_id']." / tfNo: ".$row['tformNo']." / plCurrent: ".$row['plCurrent']." / tfPrice: ".$row['tformPriceNoTax']." / date: ".$row['modified']."<br><hr><br>";
    $idArray[] = $row['id'];
}

echo "<br><br><hr><hr><br><br>";

$result = mysql_query("SELECT DISTINCT `id`,
									  `sp_disc_rate_id`,
									  `plCurrent`,
									  `tformPriceNoTax`,
									  `tformNo`
								  FROM `sp_history` WHERE `tformNo` LIKE '%$tformNo%' 
									  	GROUP BY 
									  `sp_disc_rate_id`,
									  `tformNo`");

while ($row = mysql_fetch_assoc($result)){
    
    echo "ID:".$row['id']." / RATEID: ".$row['sp_disc_rate_id']." / tfNo: ".$row['tformNo']." / plCurrent: ".$row['plCurrent']." / tfPrice: ".$row['tformPriceNoTax']." / date: <br><hr><br>";
    
    $idArray2[] = $row['id'];
}

echo "<br><br><hr><hr><br><br>";

foreach ($idArray as $key){
    if(in_array($key, $idArray2)){
        echo "<span style='color: green;'>".$key."</span><br>";
        $keep++;
    } else {
        echo "<span style='color: red;'>".$key."</span><br>";
        $destroy++;
            $query = "DELETE FROM `sp_history` WHERE `id` = '$key'";
            //$result = mysql_query($query);
            if($result){
                echo "DELETED: ".$key."<br>";
            } else {
                echo "ERROR!";
            }
    }
}
//----
echo "<br><br><hr><hr><br><br>";
//----

foreach ($idArray2 as $key){
    echo $key."<br>";
}
echo "<br><hr><br>";
foreach ($idArray as $key){
    echo $key."<br>";
}


echo "KEEP: ".$keep." DESTROY: ".$destroy;


?>