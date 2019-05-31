<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title;?></title>
<link rel="stylesheet"
		href="<?php echo $path;?>/css/tfProject/tfProjectInfo.css">
<?php
include_once '../master/config.php'; ?>
<script type="text/javascript">
$(document).ready( function() {
	 $('#loading').delay(300).fadeOut(300);

	 var $sourceFields = $("#sourceFields");
     var $destinationFields = $("#destinationFields");
     var $chooser = $("#fieldChooser").fieldChooser(sourceFields, destinationFields);

     $('#listSave').bind("keyup keypress", function(e) {
		  var code = e.keyCode || e.which; 
		  if (code  == 13) {               
		    e.preventDefault();
		    return false;
		  }
		});


});
</script>
<style type="text/css">
#loading {
		position: fixed;
		z-index: 9000;
		width: 100%;
		height: 100%;
		background-color: #FFF;
}

.loadingGifMain {
		background-color: #FFF;
		width: 150px;
		height: 10px;
		position: absolute;
		left: 50%;
		top: 50%;
		margin-left: -75px;
		margin-top: -10px;
		text-align: center;
}

div#fieldChooser {
		width: 100%;
		height: 100%;
		background-color: #FFF;
		position: fixed;
		bottom: 0px;
		top: 65px;
}

div#sourceFields {
		background-color: #B3B3B3;
}

div#destinationFields {
		background-color: #E8E8E8;
}

.fc-field {
		width: calc(100% -4px);
		height: 45px;
		margin-bottom: 0px;
		padding: 2px;
		background-color: #FFF;
		box-shadow: 0px 0px 10px 0px rgba(222, 222, 222, 1.0);
}

.fc-field:hover {
		outline: #cacaca solid 1px;
}

.fc-field {
		cursor: move;
}

.fc-selected {
		background-color: #D6F1FF;
}

.fc-selected:hover {
		background-color: #EBF8FF;
}

.fc-field-list {
		width: 50%;
		height: 850px;
		margin: 0px;
		padding: 0px;
		overflow: auto;
		background-color: green;
}

.fc-source-fields {
		float: left;
}

.fc-destination-fields {
		float: right;
}

.listImg {
		background-color: none;
		height: 45px;
		width: 45px;
		float: left;
		overflow: hidden;
}

.listTfNo {
		background-color: none;
		height: 40px;
		width: 150px;
		float: left;
		overflow: hidden;
		padding-left: 10px;
		padding-top: 5px;
}

.listSeries {
		background-color: none;
		height: 40px;
		width: 150px;
		float: left;
		overflow: hidden;
		padding-left: 10px;
		padding-top: 5px;
}

.listSpecial {
		background-color: none;
		height: 45px;
		width: 150px;
		float: left;
		overflow: hidden;
		line-height: 45px;
		padding-left: 10px;
}

.listMemo {
		background-color: none;
		height: 45px;
		width: 120px;
		float: right;
		overflow: hidden;
		line-height: 45px;
		text-align: right;
		margin-right: 5px;
}

.preSearch {
		width: 400px;
		height: 100px;
		background-color: #FFF;
		outline: solid 1px #CCC;
		z-index: 2;
		position: fixed;
		top: 400px;
		left: calc(50% -   200px);
}
.searchFilter {
	height: 40px;
	background-color: #FFF;
	line-height: 40px;
}
.searchFilter td{
	outline: 2px solid #CCC;
	padding-left: 4px;
	padding-right: 4px;
}

</style>
</head>
<body>
		<div id='wrapper'>

		<?php require_once '../header.php';?>
		<?php //variables
		if (!empty($_GET['search'])){
		    $search = $_GET['search'];
		} else {
		    $search = "NULL";
		   
		    echo "<div class='preSearch' >";
		    echo "
        	<form method='GET' action='list_input.php' id='searchForm' style='text-align: center; line-height: 100px;'>
    		品番検索:
            <input type='text' name='search' class='searchBar'>
            <input type='hidden' name='pr' value='$pr'>
            <input type='hidden' name='record' value='0'> "; ?>
				<button onClick="document.getElementById('searchForm').submit()"
						id='searchBtn'>
						<i class="fa fa-search"></i>
				</button>
				<?php echo "</form>";
				echo "</div>";
		}
		?>
				<div id='loading'>
				<?php
				$counter = 0;
				$counterTemp = 0;
				$resultCounter = mysql_query("SELECT * FROM `main` WHERE `tformNo` LIKE '%$search%'") or die(mysql_error());
				while ($rowCounter = mysql_fetch_assoc($resultCounter)){
				    $counter++;
				}

				?>
						<span class='loadingGifMain'><img
								src='<?php echo $path;?>/img/142.gif'><br>LOADING <?php echo $counter;?>
								Files ...</span>
				</div>
				<div class='contents'>
						<!-- PAGE CONTENTS START HERE -->
						<?php 
						//set searchFilter Variables
						
						if (isset($_POST['haiban'])== true){
						    $searchHaiban = $_POST['haiban'];
						} else {
						    $searchHaiban = ""; 
						}
						if (isset($_POST['set'])== true){
						    $searchSet = $_POST['set'];
						} else {
						    $searchSet = "";
						}
						if (isset($_POST['isOk'])== true){
						    $searchNoPl = $_POST['isOk'];
						} else {
						    $searchNoPl = "0";
						}
						if (isset($_POST['isWeb'])== true){
						    $searchWeb = $_POST['isWeb'];
						} else {
						    $searchWeb = "";
						}
						//print_r($_POST);
						?>
						
						 <div class='searchFilter'>
						 	<table>
    						 	<tr>
    						 	<form action='' method="post">
    						 		<td style='background-color: #FAD4E2;'><input type='checkbox' name='haiban' value='1' <?php echo ($searchHaiban=='1')?'checked':'' ?>>廃番表示</td>
    						 		<td style='background-color: #E8FCFC;'><input type="radio" name='set' value='1' <?php echo ($searchSet=='1')?'checked':'' ?>>セットのみ<input type="radio" name='set' value='2' <?php echo ($searchSet=='2')?'checked':'' ?>>セット以外 </td>
    						 		<td style='background-color: #FBF5FF;'><input type="radio" name='isOk' value='1' <?php echo ($searchNoPl=='1')?'checked':'' ?>>入力不足<input type="radio" name='isOk' value='2' <?php echo ($searchNoPl=='2')?'checked':'' ?>>設定完了</td>
    						 		<td style='background-color: #F7F7CB;'><input type='checkbox' name='isWeb' value='1' <?php echo ($searchWeb=='1')?'checked':'' ?>>WEB紹介</td>
        						 		
        						 	<td><input type='submit' value='フィルター決定' class='update'></td>
    						 	</form>
    						 	<form action='' method="post">
    						 		<td><input type='submit' value='フィルターの設定クリア' class='delBtn'></td>
    						 	</form>
    						 	</tr>
						 	</table>
						 </div><!-- searchFilter end -->
		    
						<div id="fieldChooser" tabIndex="1">
								<div id="sourceFields">
								<?php
								if ($searchHaiban == 1){
								    $setHaibanQuery = "";
								} else {
								$setHaibanQuery = "AND (`cancelMaker` != '1' AND `cancelTform` !=1 AND `cancelSelling` !=1)";
								}
								if ($searchSet == 1){
								    $setSetQuery = "AND `set` != ''";
								} else if ($searchSet == 2) {
								    $setSetQuery = "AND `set` = ''";
								} else {
								    $setSetQuery = "";  
								}
								
								if ($searchWeb == 1){
								    $setWeb = " AND `web` = '1'";
								} else {
								    $setWeb = "";
								}
								
								$setQuery = $setHaibanQuery." ".$setSetQuery." ";
								
								// $setCheckInner = 0; // reset checker
								 $innerSetChecker = 0;// reset checker
								$result = mysql_query("SELECT * FROM `main` WHERE `tformNo` LIKE '%$search%' $setQuery $setWeb ORDER BY `tformNo`") or die(mysql_error());
								while ($row = mysql_fetch_assoc($result)){
								    $img = $row['img'];
								    $tformNo = $row['tformNo'];
								    $makerNo = $row['makerNo'];
								    $maker = $row['maker'];
								    $series = $row['series'];
								    $mainId = $row['id'];
								    $rate = 0;
								    $percent = 0;
								    $discount = 0;
								    $setHaiban = $row['memo'];
								    $set = $row['set'];
								    $web = $row['web'];

/* CHECK FOR HAIBAN AND SET HAIBAN COLOR */
if (isHaibanNew($tformNo) == true){
	$memo = "<span style='color: red;'> (廃番)</span>";
} else {
	$memo = "";
}
								   $setCheckInner = 0;
								   $plNotExists  = 0;
								    //check if contents of set are not in the sp_plcurrent
								        $array1  = str_replace(",", " ", $set);
									    $matches1 = explode(" ", $array1);
									    foreach ($matches1 as $value){
									        if ($value != ""){
									
							        $resultSetCheck = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$value'") or die(mysql_error());
								    while ($rowSetCheck = mysql_fetch_assoc($resultSetCheck)){
								        
								        // check SPCURRENT if exisits or not
								    $resultSetCurrent = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` = '$value' ") or die(mysql_error());
								    if (mysql_num_rows($resultSetCurrent) == true){
								        $setCheckInner = 2;
								        $innerSetChecker = 2;
								    } else {
								        $setCheckInner = 1;
								        $innerSetChecker = 1;
								    }
								    //echo $value." - ".$innerSetChecker."<br>";
								    }
									        }
								        }
								   
								    //results for sp_plcurent
								    $resultCurrent = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` = '$tformNo' ") or die(mysql_error());
								    if (mysql_num_rows($resultCurrent) == true){
								        $plNotExists = 2; 
								    } else {
								        $plNotExists = 1;
								    }
								    //end of results for sp_plcurrent
								    	
								    // filter check
								    // main variable to see if something is not set inthe hinban or the parts of the hinban(set items with not pl)
								    $mainPlCounter = 0;
								    if ($plNotExists == 1 || $setCheckInner == 1){
								        $mainPlCounter = 1;
								    } else {
								        
								    }
								    
								    if (($mainPlCounter == 1 && $searchNoPl == 1)) {
								    
								        include 'list_input_blocks.php';
								     
								    } else if (($mainPlCounter != 1 && $searchNoPl == 2)) {
								    
								       include 'list_input_blocks.php';
								    
								    } else if($searchNoPl == 0){
								        include 'list_input_blocks.php';
								        
								    } else {
								        // include 'list_input_blocks.php';
								    }
								    //filterCheck END
								}
								?>
								
								</div>
								<form method="post" action='exe/exeSetList.php' id='listSave'>
										<div class='save'>
												メーカー名<span style='margin-left: 10px;'><input type='text'
														name='makerName' id='makerName'
														style='width: 200px; height: 14px;'> </span>
														
												リストタイトル<span style='margin-left: 10px;'>
											<input type='text'
														name='listName' id='listName'
														style='width: 200px; height: 14px;'> _LIST
											</span>
										</div>
										<div id="destinationFields"></div>

								</form>

						</div>
						<!-- PAGE CONTENTS END HERE -->
				</div>
		</div>
		<?php require_once '../master/footer.php';?>

</body>
</html>
