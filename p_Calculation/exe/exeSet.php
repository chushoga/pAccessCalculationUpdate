<?php session_start(); date_default_timezone_set('Asia/Tokyo'); require_once '/../../master/dbconnect.php';
$tformNo = $_POST['tformNo'];



$set = '0';
$plCurrent = '0';

/*
 * ////////////////////////////////////////////////////////////////////////////////
 * CHERE IS HERE TO SEE IF HINBAN NUMBER EXISTS OR NOT BEFORE ADDING!!!!!!!!!!
 * ///////////////////////////////////////////////////////////////////////////////
 */
if ($tformNo == ""){
    header("Location: ../insert_set.php?pr=1&tformNo=$tformNo&message=error&info=Tform品番入れてください♪");
} else {    
$checkQuery = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$tformNo'");
if(mysql_num_rows($checkQuery) == true){
    header("Location: ../insert_set.php?pr=1&tformNo=$tformNo&message=error&info=Tform品番もう存在します、違う品番付けて保存してください");
} else {
     
    
    /*
    print_r($_POST);
    echo "<br>";
    print_r($_SESSION);
    echo "<br><hr><br>";
    */
    //QUERIES -------------------------------------------------------------------------------------
    
    //echo "INSERT INTO main (tformNo, set) VALUES (".$tformNo.", ".$set.")";
    //echo "<br><hr><br>";
    
    
    $sql="INSERT INTO `main` (`tformNo`,
    						  `set`)
    							 		VALUES 
    						 ('$tformNo',
    						 '$set')";
    $result = mysql_query($sql);
    
    //echo "INSERT INTO main (tformNo, plCurrent, set) VALUES (".$tformNo.", ".$plCurrent.", ".$set.")";
    //echo "<br><hr><br>";
    
    $sql2="INSERT INTO `plcurrent` (`tformNo`,
    						  `plCurrent`,
    						  `set`)
    								 	 VALUES 
    						 ('$tformNo',
    						 '$plCurrent',
    						 '$set')";
    $result2 = mysql_query($sql2);
    
    
    $i = "";
    foreach ($_SESSION as $key => $value){
        $a = 1;
        while ($a <= $value){
        $a++;
        $i = $key.",".$i;
        }
    }
    
    $change = explode(",", $i);
    $insert = implode($change, ',');
    $str = rtrim($insert,',');
    
     if ($insert != "" ){
     
         
    $sql="UPDATE `main` 
    				SET
    			`set` = '$str'
    				WHERE
    			tformNo = '$tformNo'";
    
    $result = mysql_query($sql);
    
    $sql2="UPDATE `plcurrent` 
    				SET
    			`set` = '$str'
    				WHERE
    			tformNo = '$tformNo'";
    
    $result2 = mysql_query($sql2);
    
    
    //session_start();
    
    session_unset();
    session_destroy();
    header("Location: ../insert_set.php?pr=1&message=success&tformNo=$tformNo");
    exit;
    
    } else {
        
    //session_start();
    session_unset();
    session_destroy();
    header("Location: ../insert_set.php?pr=1&tformNo=$tformNo&message=error");
    exit;
    
    }
  
}
}
?>