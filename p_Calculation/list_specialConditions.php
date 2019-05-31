<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title;?></title>
<link rel="stylesheet" href="<?php echo $path;?>/css/tfProject/tfProjectInfo.css">
<?php
include_once '../master/config.php'; ?>
<script type="text/javascript">
$(document).ready( function() {
//START WITH REFRESH
$(function() {
			e = $.Event('keyup');
			e.keyCode= 82; // press r key to refresh Cap Sensative
			$('input').trigger(e);
		});
//PREVENT ENTER KEY FROM TRIGGERING SUBMIT ON FORM
     $('#listSave').bind("keyup keypress", function(e) {
		  var code = e.keyCode || e.which; 
		  if (code  == 13) {               
		    e.preventDefault();
		    return false;
		  }
		});
//DRAG AND DROP		
     var $sourceFields = $("#sourceFields");
     var $destinationFields = $("#destinationFields");
     var $chooser = $("#fieldChooser").fieldChooser(sourceFields, destinationFields);

// TOOL TIP
	$(function() { $( document ).tooltip(); });
// LOADING
	$('#loading').delay(300).fadeOut(300);
// SUBMIT FORM
	$( "#submitChanges" ).click(function() {
		  $( "#mainForm" ).submit();
		});

	if (!document.location.hash){
	    document.location.hash = 'go-here';
	}
	
		} );
</script>
<style type="text/css">
#mainBox {
	background-color: #FFFFFF;
	position: absolute;
	width: 100%;
	top: 50px;
	bottom: 0px;
}

#leftBox {
	outline: 2px solid #CCC;
	position: absolute;
	width: 50%;
	left: 0px;
	top: 0px;
	bottom: 0px;
	top: 0px;
}

#middleBox {
	outline: 2px solid #CCC;
	position: absolute;
	width: 25%;
	left: 50%;
	top: 0px;
	bottom: 0px;
	top: 0px;
	overflow: auto;
	position: absolute;
}

#rightBox {
	outline: 2px solid #CCC;
	position: absolute;
	width: 25%;
	height: 100%;
	right: 0px;
	top: 0px;
	bottom: 0px;
	top: 0px;
	overflow: auto;
}

.innerLeft {
	height: 100%;
	overflow: auto;
}

.innerMiddle {
	height: 100%;
	overflow: auto;
}

.innerRight {
	height: 100%;
	width: 100%;
	overflow: auto;
}

.innerMovable {
	background: #ffffff; /* Old browsers */
	background: -moz-linear-gradient(top, #ffffff 0%, #e5e5e5 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ffffff), color-stop(100%, #e5e5e5) ); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #ffffff 0%, #e5e5e5 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #ffffff 0%, #e5e5e5 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #ffffff 0%, #e5e5e5 100%); /* IE10+ */
	background: linear-gradient(to bottom, #ffffff 0%, #e5e5e5 100%); /* W3C */
	filter: progid :                                                           DXImageTransform.Microsoft.gradient (                                                             startColorstr =                                                           '#ffffff', endColorstr =                                                           '#e5e5e5', GradientType = 
		                                                         0 );
	/* IE6-9 */
	padding: 2px; //
	border: 1px solid #CCC;
}

.midInnerMovable {
	background: rgb(240, 249, 255); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(240, 249, 255, 1) 0%, rgba(226, 244, 255, 1) 47%, rgba(186, 229, 255, 1) 100% ); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(240, 249, 255, 1) ), color-stop(47%, rgba(226, 244, 255, 1) ), color-stop(100%, rgba(186, 229, 255, 1) ) ); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(240, 249, 255, 1) 0%, rgba(226, 244, 255, 1) 47%, rgba(186, 229, 255, 1) 100% ); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(240, 249, 255, 1) 0%, rgba(226, 244, 255, 1) 47%, rgba(186, 229, 255, 1) 100% ); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(240, 249, 255, 1) 0%, rgba(226, 244, 255, 1) 47%, rgba(186, 229, 255, 1) 100% ); /* IE10+ */
	background: linear-gradient(to bottom, rgba(240, 249, 255, 1) 0%, rgba(226, 244, 255, 1) 47%, rgba(186, 229, 255, 1) 100% ); /* W3C */
	filter: progid :                                 DXImageTransform.Microsoft.gradient (                                   startColorstr =                                 '#f0f9ff', endColorstr =                                 '#bae5ff', GradientType =                                 0 ); /* IE6-9 */
	padding: 2px; //
	border: 1px solid #CCC;
	box-shadow: 0px 0px 10px 0px rgba(222, 222, 222, 1.0);
}

.noneMovable {
	background-color: #FFF;
	color: #2e2e2e;
	padding: 2px;
	outline: 1px solid #CCC;
	overflow: hidden;
	width: 100%;
	padding: 2px;
}

div#fieldChooser {
	background-color: #FFF;
	width: 100%;
	margin: auto;
}

div#sourceFields {
	background-color: #B3B3B3;
}

div#destinationFields {
	height: 100%;
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
	background-color: red;
}

.fc-field {
	cursor: move;
}

.fc-selected {
	background-color: #D6F1FF;
	color: red;
}

.fc-selected:hover {
	background-color: #EBF8FF;
}
</style>
</head>
<body>
	<div id='wrapper'>
		<div id='loading'>
			<span class='loadingGifMain'> <img src='<?php echo $path;?>/img/142.gif'><br> LOADING ... </span>
		</div>
		<?php require_once '../header.php';?>
		<div class='contents'>
			<!-- PAGE CONTENTS START HERE -->
		<?php

		//set Variables
		$listName = $_GET['id'];
		$pr = $_GET['pr'];

		// if click the hide hinban button toggle the isHidden
		if(isset($_POST['hide'])){
			$hideInsert = "UPDATE `makerlistcontents`
		    									SET 
		    									`isHinbanHidden` = true
		    									 WHERE `listName` = '$listName'";
			mysql_query($hideInsert) or die(mysql_error());
		}
		if(isset($_POST['show'])){
			$hideInsert = "UPDATE `makerlistcontents`
		    									SET 
		    									`isHinbanHidden` = false
		    									 WHERE `listName` = '$listName'";
			mysql_query($hideInsert) or die(mysql_error());
		}


		//INITIALIZE VARIABLES
		$specialItems = "";
		$makerListInfoResult = mysql_query("SELECT * FROM `makerlistcontents` WHERE `listName` = '$listName'");
		while ($makerListInfoRow = mysql_fetch_assoc($makerListInfoResult)){
			$specialItems  = $makerListInfoRow['specialItems'];
			$setArray = explode(',', preg_replace('/\s+/', '', $specialItems));
			$isHinbanHidden = $makerListInfoRow['isHinbanHidden']; //廃番 TOGGLE
		}

		// set the color and shape for the show/hide haiban button F76A84 858585
		if($isHinbanHidden == false){
			$showHinbanBtn = "<button class='showBtn' name='hide' style='margin-left: 5px;' title='品番非表示' ><span style='color: #858585;'>(廃番)</span></button>";
		} else {
			$showHinbanBtn = "<button class='showBtn' name='show' style='margin-left: 5px;' title='品番表示' ><span style='color: #F76A84;'>(廃番)</span></button>";
		}


		$listLoopQuery = "SELECT `id`, `tformNo`, `specialItems` FROM `makerlistinfo` WHERE `listName` = '$listName' ORDER BY `tformNo`";
		$listLoopResult = mysql_query($listLoopQuery);
		while($listLoopRow = mysql_fetch_assoc($listLoopResult)){

			/* ------------------------------------------------------------------------
			 * ----------------------------- VARIABLES --------------------------------
			 * ------------------------------------------------------------------------
			 */


			// listLoopQuery variables
			// initialize
			$hasContents = false;
			//setVars

			//set hasContents to true if not empty
			if($listLoopRow['specialItems'] != null){
				$hasContents = true;
			}

			$tfNo = $listLoopRow['tformNo'];
			$tformNo = $listLoopRow['tformNo'];
			$makerlistinfoId = $listLoopRow['id'];

			// mainLoopQuery variables
			$mainLoopQuery = "SELECT `type`,`series`,`makerNo`, `set`, `memo` FROM `main` WHERE `tformNo` = '$tfNo'";
			$mainLoopResult = mysql_query($mainLoopQuery);
			while($mainLoopRow = mysql_fetch_assoc($mainLoopResult)){
				// initialize
				$isHaiban = false;
				$haibanIcon = "";

				// setVars
				$type= $mainLoopRow['type']; //type of product
				$series= $mainLoopRow['series'];
				$makerNo = $mainLoopRow['makerNo'];
				$setString = $mainLoopRow['set'];
				$memo = $mainLoopRow['memo'];
			}
			// /*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*
			// INTERNAL ARRAY HERE

			//break up the main SET contents so we can get the makerNo from the set contenets
			if($setString == "" || preg_match('#[0-9]#', $setString) == false){
				$setStringArray = array($tformNo);
			} else {
				$setStringArray = explode(',', preg_replace('/\s+/', '', $setString)); 	//removes all whitespace
			}

			//GET THE OTHER INFO PER $setStringArray
			foreach($setStringArray as $key){
				$innerArrayQuery = mysql_query("SELECT `makerNo`,`type` FROM `main` WHERE `tformNo` = '$key'");
				while($innerArrayRow = mysql_fetch_assoc($innerArrayQuery)){
					$innerMakerNoinner = $innerArrayRow['makerNo'];
					$innerTypeinner = $innerArrayRow['type'];
				}
				$innerMakerNo[] = $innerMakerNoinner;
				$innerType[] = $innerTypeinner;
			}


/* CHECK FOR HAIBAN AND SET HAIBAN COLOR */
if (isHaibanNew($tfNo) == true){
	$isHaiban = true;
	$haibanIcon = " (<span style='color:red;'>廃番</span>)"; // set a haiban icon if it is haiban
}


			// /*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*

			//FEED THE 2D ARRAY HERE ///////////////////////////////////////////////////////////

			$arrayA = array($tformNo, $makerNo, $type, $series, $hasContents, $setStringArray, $innerMakerNo,$innerType, $haibanIcon, $isHaiban);
			$listContentsArray[] = $arrayA;

			//CLEAR ARRAYS
			unset($setStringArray);
			unset($innerMakerNo);
			unset($innerType);

			//FEED THE 2D ARRAY HERE ///////////////////////////////////////////////////////////
			//-------------------
		}

		//SET UP THE MIDDLE BOX VARIABLES
		//set the middle focus

		if(isset($_GET['focusTformNo'])){
			$focusTformNo = $_GET['focusTformNo'];
		} else {
			$focusTformNo = $listContentsArray[0][0];
		}

		$middleBoxQuery = mysql_query("SELECT * FROM `makerlistinfo` WHERE `listName` = '$listName' AND `tformNo` = '$focusTformNo'");

		while($middleBoxRow = mysql_fetch_assoc($middleBoxQuery)){
			$specialItemsMiddle = $middleBoxRow['specialItems'];
		}

		//cut up the special items
		$setArrayMiddle = explode(',', preg_replace('/\s+/', '', $specialItemsMiddle));

		//FINISHED SETTTING UP MIDDLE BOX VARIABLES

		echo"<div style='background-color: #888888; color: #FFFFFF; width: 100%; height: 200px;'>";
		echo "<h3 style='float: left; margin-top: 5px; margin-left: 10px;'>".$focusTformNo." (".$listName.")</h3>";
		?>
			<!-- SET THE BACK BUTTON -->
			<button style='float: left; margin-left: 20px; margin-top: 3px;' class='submit' onClick="location.href='list_calculation.php?pr=1&id=<?php echo $listName;?>'">
				<i class="fa fa-arrow-left"></i> 戻る
			</button>

			<?php
			echo "<button id='submitChanges' class='submit' style='float: left; margin-left: 20px; margin-top: 3px;'>決定</button>";

			//廃番 TOGGLE
			echo "<form action='' method='POST' style='float: left; margin-top: 3px;'>";
			echo $showHinbanBtn;
			echo "</form>";

			echo "</div>";
			//MAIN BOX
			echo "<div id='mainBox'>";
			//**********************************************
			//
			//					 LEFT BOX
			//
			//**********************************************
			echo "<div id='leftBox'>";
			echo "<div class='innerLeft'>";
			echo "<form>";

			//BODY STARTS HERE

			for($i = 0; $i < count($listContentsArray); $i++){

				//FIRST if haiban hidden is toggeled on the list skip this block
				if($isHinbanHidden == false || $listContentsArray[$i][9] == false){

					//set the focused color
					if($focusTformNo == $listContentsArray[$i][0]){
						$focusedColor = "color: white; background-color: #F05668;";
						$goHere = "id='go-here'";
					} else {
						$focusedColor = "";
						$goHere = "";
					}

					echo "<form action='' method='GET'>";
					echo "<button class='noneMovable' style='".$focusedColor."' ".$goHere.">";
					echo "<input type='hidden' name='id' value='".$listName."'>";
					echo "<input type='hidden' name='focusTformNo' value='".$listContentsArray[$i][0]."'>";
					echo "<input type='hidden' name='pr' value='".$pr."'>";
					echo "<table style='width: 100%; text-align: center;'><tr><td style='width: 120px;'>";
					echo $listContentsArray[$i][0];
					echo $listContentsArray[$i][8];
					echo "</td><td style='width: 120px;'>";
					echo $listContentsArray[$i][3];
					echo "</td><td style='width: 120px;'>";
					foreach ($listContentsArray[$i][5] as $key){
						echo $key."<br>";
					}
					echo "</td><td style='width: 200px;'>";
					foreach ($listContentsArray[$i][6] as $key){
						echo $key."<br>";
					}
					echo "</td><td style='width: 200px;'>";
					foreach ($listContentsArray[$i][7] as $key){
						echo $key."<br>";
					}
					//echo "</td><td>";
					//echo $listContentsArray[$i][2];
					echo "<td  style='width: 30px;'>";
					//IF HAVE CONTENTS SHOW IMG
					if ( $listContentsArray[$i][4] == true){
						echo "<img title= '内容あります' src='../img/bullet_ball_glass_green.png'>";
					}
					echo "</td></tr></table>";
					//echo $listContentsArray[$i][3];
					echo "</button>";
					echo "</form>";
				}
			}

			//BODY ENDS HERE
			echo "</form>";
			echo "</div>";//end of internal div
			echo "</div>";//end of leftBox
			//**********************************************
			//
			//					MIDDLE BOX
			//
			//**********************************************
			//MIDDLE BOX QUERY


			echo "<form id='mainForm' method='POST' action='exe/exeListSpecialTreament.php'>";
			echo "<div id='middleBox'>";
			echo "<div class='innerMiddle'>";
			echo "<input type='hidden' name='listName' value='".$listName."'>"; //SET The list name
			echo "<input type='hidden' name='insertTformNo' value='".$focusTformNo."'>"; // set the tformNo to get the special treatment

			echo "<div id='destinationFields'>";



			//BODY STARTS HERE
			//if the setArrayMiddle is empty then dont show the blocks below
			if($specialItemsMiddle != null){
				foreach ($setArrayMiddle as $key => $value){
					$middleInternalQuery = mysql_query("SELECT `makerNo`,`type` FROM `main` WHERE `tformNo` = '$value'");
					//get additional information for each $key(tformNo)
					while($middleInternalRow = mysql_fetch_assoc($middleInternalQuery)){
						$middleInternalMakerNo = $middleInternalRow['makerNo'];
						$middleInternalType = $middleInternalRow['type'];
					}
					echo "<div class='innerMovable'>";
					echo "<table style='width: 100%; height: 100%;'><tr><td style='width: calc(100%/3);'>".$value."</td><td style='width: calc(100%/3);'>".$middleInternalMakerNo."</td><td style='width: calc(100%/3);'>".$middleInternalType."</td></tr></table>";
					echo "<input type='hidden' name='tformNo[]' value='".$value."'>";//IS MOVED TO THE MIDDLE FORM FOR SUBMIT
					echo "</div>";
				}
			}
			//BODY ENDS HERE

			echo "</div>";


			echo "</div>";//end of inner
			echo "</div>";//end of rightBox
			echo "</form>";


			//**********************************************
			//
			//					 RIGHT BOX
			//
			//**********************************************

			echo "<div id='rightBox'>";
			echo "<div class='innerRight'>";
			echo "<form>";

			//BODY STARTS HERE
			//GET makerlistcontents query
			echo "<div id='fieldChooser'>";
			echo "<div id='sourceFields'>";
			
			$errors = array_filter($setArray); //filters out null, 0, '' or false from array
			if (!empty($errors)){
				
				foreach($setArray as $key => $value){
					
					
					$rightInternalQuery = mysql_query("SELECT `makerNo`,`type` FROM `main` WHERE `tformNo` = '$value'");
					
					//$rightInternalMakerNo = "ERROR MAKER NO";
					//$rightInternalType = "ERROR TYPE";
					
					
					//get additional information for each $key(tformNo)
					while($rightInternalRow = mysql_fetch_assoc($rightInternalQuery)){
						$rightInternalMakerNo = $rightInternalRow['makerNo'];
						$rightInternalType = $rightInternalRow['type'];
					}
	
					echo "<div class='midInnerMovable'>";
					//echo $key." | ";
					//echo $value;
					echo "<table style='width: 100%; height: 100%;'><tr><td style='width: calc(100%/3);'>".$value."</td><td style='width: calc(100%/3);'>".$rightInternalMakerNo."</td><td style='width: calc(100%/3);'>".$rightInternalType."</td></tr></table>";
					echo "<input type='hidden' name='tformNo[]' value='".$value."'>";//IS MOVED TO THE right FORM FOR SUBMIT
					echo "</div>";
				}
			}
			//BODY ENDS HERE
			echo "</div>";
			echo "</div>";
			echo "</form>";
			echo "</div>";//end of inner
			echo "</div>";//end of rightBox
			echo "<div class='clear'></div>";//clear all
			echo "</div>";//end of mainBox		?>
			<!-- PAGE CONTENTS END HERE -->
		</div>
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>
