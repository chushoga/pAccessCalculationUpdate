<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';

//print_r($_POST);
if ($_POST['listName'] == ''){
    header("location: ../list_input.php?pr=1&message=error&info=リスト名無かった");
} else {

    $mainMakerName = str_replace(' ', '_', $_POST['makerName']);
    $makerName = strtoupper($mainMakerName);
    $mainListName = str_replace(' ', '_', $_POST['listName']);
    $listName = strtoupper($mainListName)."_LIST";
    $i = 0;
    $listNameCheck = "";
    $listTformNoCheck = "";


    //If the list name is set do the following...
     

     
    foreach($_POST as $key => $value){
        //echo $key."<br>";
        $resultCheck = mysql_query("SELECT * FROM `makerlistinfo` WHERE `tformNo` = '$key'");
        while ($rowCheck = mysql_fetch_assoc($resultCheck)){

            $listNameCheck = $rowCheck['listName'];
            $listTformNoCheck = $rowCheck['tformNo'];
            
        }
        //echo $listNameCheck."---".$listTformNoCheck."<br>";
        //echo "<span style='color: green'>".$listName."---".$key."<br></span>";
        if ($listNameCheck.$listTformNoCheck != $listName.$key){

            if ($key != "listName" AND $key != "makerName"){
                $import="INSERT INTO `makerlistinfo`
					(`tformNo`, 
					`listName`
					) 
					VALUES
					('$key',
					'$listName'
					)";

                mysql_query($import) or die(mysql_error());
                $i++;
            }

        }
    }
    if ($i != 0){
        $created = date ("Y-m-d H:i:s");
        $modified = date ("Y-m-d H:i:s");
                    $ins="INSERT INTO `makerlistcontents`
					(`listName`,
					 `maker`,
					 `created`,
					 `modified`) 
					VALUES
					('$listName',
					 '$makerName',
					'$created',
					'$modified')";

                mysql_query($ins) or die(mysql_error());
    
    //header("location: ../list_single.php?pr=1&message=success&id=$listName");
    $lAdded = $listName." was Added!";
    header("location: ../list_input.php?pr=1&message=success&info=$lAdded");
    } else {
         header("location: ../list_input.php?pr=1&message=error");
    }
}
?>