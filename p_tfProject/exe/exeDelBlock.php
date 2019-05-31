<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
// --------------------------------------------------
// SET VARIABLES
$id = $_GET['id'];
$block = $_GET['block'];
//---------------------------------------------------
// PART TO GET THE AMOUNT OF TIMES TO SHOW DATA BLOCKS------------
$counter = 0;
$result = mysql_query("SELECT * FROM tfProject WHERE `id` = '$id'");
while ($row = mysql_fetch_assoc($result)){
    for ($i = 1; $i <= 20; $i++){
        if (
        $row['archNo_'.$i] == '' &&
        $row['type_'.$i] == '' &&
        $row['itemCount_'.$i] == '' &&
        $row['maker_'.$i] == '' &&
        $row['series_'.$i] == '' &&
        $row['tformNo_'.$i] == '' &&
        $row['makerNo_'.$i] == '' &&
        $row['finish_'.$i] == '' &&
        $row['currency_'.$i] == '' &&
        $row['priceList_'.$i] == 0 &&
        $row['generalDisc_'.$i] == 0 &&
        $row['projectDisc_'.$i] == 0 &&
        $row['rate_'.$i] == 0 &&
        $row['percent_'.$i] == 0 &&
        $row['memo_'.$i] == '' &&
        $row['mitsumori_'.$i] == 0 &&
        $row['retailPrice_'.$i] == 0
        ){
            //echo $i."NULL";
        } else {
            //echo $i."TRUE";
            $counter++;
        }
    }
}
// END OF COUNT BLOCK ------------------------------------------

echo $counter;
$blkUpdateCount = $counter - 1;


//SET VARIABLES

echo "<hr>block to be deleted [ -- | ".$block." | -- ]<hr>";
echo "counter: ".$counter." - 1 = $blkUpdateCount";
// OLD DATA
echo "<hr>updated Data<hr>";
$count = 0;
$result = mysql_query("SELECT * FROM tfProject WHERE `id` = '$id'");
while ($row = mysql_fetch_assoc($result)){
    echo $row['id'];
    echo " | ";
    echo $row['projectName'];
    echo " | ";
    echo $row['place'];
    echo " | ";
    echo $row['date'];
    echo "<br>";

    for ($i = $block; $i <= $counter+1; $i++){
        $iChange = $i - 1; // where to put the new data
        if ($i == $block){
            echo "<span style='background-color: red; color: white;'>".$i.". </span>";
        }
        else {
            if($i == 21){
                $sql = "UPDATE tfProject SET
                `archNo_$iChange` = '',
                `type_$iChange` = '',
                `itemCount_$iChange` = '',
                `image_$iChange` = '',
                `maker_$iChange` = '',
                `series_$iChange` = '',
                `tformNo_$iChange` = '',
                `makerNo_$iChange` = '',
                `finish_$iChange` = '',
                `currency_$iChange` = '',
                `priceList_$iChange` = '0',
                `generalDisc_$iChange` = '0',
                `projectDisc_$iChange` = '0',
                `rate_$iChange` = '0',
                `percent_$iChange` = '0',
                `memo_$iChange` = '',
                `mitsumori_$iChange` = '0',
                `retailPrice_$iChange` = '0'
             
             WHERE
             id = '$id'
             ";
                $result = mysql_query($sql);


            } else {

                $value0 = $row['archNo_'.$i];
                $value1 = $row['type_'.$i];
                $value2 = $row['itemCount_'.$i];
                $value3 = $row['image_'.$i];
                $value4 = $row['maker_'.$i];
                $value5 = $row['series_'.$i];
                $value6 = $row['tformNo_'.$i];
                $value7 = $row['makerNo_'.$i];
                $value8 = $row['finish_'.$i];
                $value9 = $row['currency_'.$i];
                $value10 = $row['priceList_'.$i];
                $value11 = $row['generalDisc_'.$i];
                $value12 = $row['projectDisc_'.$i];
                $value13 = $row['rate_'.$i];
                $value14 = $row['percent_'.$i];
                $value15 = $row['memo_'.$i];
                $value16 = $row['mitsumori_'.$i];
                $value17 = $row['retailPrice_'.$i];
                 
                $sql = "UPDATE tfProject SET
                `archNo_$iChange` = '$value0',
                `type_$iChange` = '$value1',
                `itemCount_$iChange` = '$value2',
                `image_$iChange` = '$value3',
                `maker_$iChange` = '$value4',
                `series_$iChange` = '$value5',
                `tformNo_$iChange` = '$value6',
                `makerNo_$iChange` = '$value7',
                `finish_$iChange` = '$value8',
                `currency_$iChange` = '$value9',
                `priceList_$iChange` = '$value10',
                `generalDisc_$iChange` = '$value11',
                `projectDisc_$iChange` = '$value12',
                `rate_$iChange` = '$value13',
                `percent_$iChange` = '$value14',
                `memo_$iChange` = '$value15',
                `mitsumori_$iChange` = '$value16',
                `retailPrice_$iChange` = '$value17'
             
             WHERE
             id = '$id'
             ";
                $result = mysql_query($sql);

            }
        }




        echo "<br>";

    }

}

echo "<hr>OLD<hr>";
$count = 0;
$result = mysql_query("SELECT * FROM tfProject WHERE `id` = '$id'");
while ($row = mysql_fetch_assoc($result)){
    echo $row['id'];
    echo " | ";
    echo $row['projectName'];
    echo " | ";
    echo $row['place'];
    echo " | ";
    echo $row['date'];
    echo "<br>";

    for ($i = 1; $i <= 20; $i++){
        echo $i.". ";

        echo
        $row['archNo_'.$i].
        $row['type_'.$i].
        $row['itemCount_'.$i].
        $row['image_'.$i].
        $row['maker_'.$i].
        $row['series_'.$i].
        $row['tformNo_'.$i].
        $row['makerNo_'.$i].
        $row['finish_'.$i].
        $row['currency_'.$i].
        $row['priceList_'.$i].
        $row['generalDisc_'.$i].
        $row['projectDisc_'.$i].
        $row['rate_'.$i].
        $row['percent_'.$i].
        $row['memo_'.$i].
        $row['mitsumori_'.$i].
        $row['retailPrice_'.$i];
        echo "<br>";

    }
}
header("location: ../tfProject.php?pr=2&id=$id&message=success");
