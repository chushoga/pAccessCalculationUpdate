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
/*DATATABLES START*/
	var defaultOptions = {
			"bJQueryUI": true,
			"bPaginate": false,
			"bInfo": false,
			"sScrollX" : "100%",
			"iDisplayLength": 100,
			"order": [[ 2, "asc" ]]
				};//options
	var calcDataTableHeight = function() {
	    var minusResult = 180;
	    var h = Math.floor($(window).height() - minusResult);
	    return h + 'px';
	};
	defaultOptions.sScrollY = calcDataTableHeight();
	
	var oTable = $('#calcTable').dataTable(defaultOptions);

	 $(window).bind('resize', function () {
		 $('div.dataTables_scrollBody').css('height',calcDataTableHeight());
		oTable.fnAdjustColumnSizing();
	  } );
/*DATATABLES END*/
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
// TOOL TIP
	$(function() { $( document ).tooltip(); });
// LOADING
	$('#loading').delay(300).fadeOut(300);
// CLEAR ALL
    $("#clearButton").click(function() {
    	$('input[id=clearAll]').val('0');
    	
    });

});

//-------------------------------------------
</script>
<style type="text/css">
.currencyRates {
	padding: 5px;
	height: 25px;
}

.currencyRates input[type=text] {
	width: 30px;
	height: 18px;
	text-align: center;
}

.currencyRates div {
	float: left;
	padding: 2px;
	margin-right: 20px;
}

.rateDiscountColor {
	color: #3AC1D6;
}

.simStyle {
	color: #3AC1D6;
}
</style>
</head>
<body>
<?php

// set the list name from the get `id`
if(isset($_GET['id'])){
	$listName = $_GET['id'];
} else {
	$listName = "NUll";
}

//set the file save name and date
$savFileDate = date('Y_m_d');
$saveFileProjectName = $listName;
$saveFileName = $saveFileProjectName."_".$savFileDate;

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

// if a post with hideImage is sent then hide/show the image
if(isset($_POST['hideImage'])){
	$hideInsert = "UPDATE `makerlistcontents`
    									SET 
    									`imageView` = true
    									 WHERE `listName` = '$listName'";
	mysql_query($hideInsert) or die(mysql_error());
}

if(isset($_POST['showImage'])){
	$hideInsert = "UPDATE `makerlistcontents`
    									SET 
    									`imageView` = false
    									 WHERE `listName` = '$listName'";
	mysql_query($hideInsert) or die(mysql_error());
}

// if a post with isInputLocked is sent then hide/show the input location
if(isset($_POST['hideInput'])){
	$hideInsert = "UPDATE `makerlistcontents`
    									SET 
    									`isInputLocked` = true
    									 WHERE `listName` = '$listName'";
	mysql_query($hideInsert) or die(mysql_error());
}

if(isset($_POST['showInput'])){
	$hideInsert = "UPDATE `makerlistcontents`
    									SET 
    									`isInputLocked` = false
    									 WHERE `listName` = '$listName'";
	mysql_query($hideInsert) or die(mysql_error());
}

// if a post with hideFilter/showFilter is sent then hide/show the input location
if(isset($_POST['hideFilter'])){
	$hideInsert = "UPDATE `makerlistcontents`
										SET
										`filterView` = true
										WHERE `listName` = '$listName'";
	mysql_query($hideInsert) or die(mysql_error());
}

if(isset($_POST['showFilter'])){
	$hideInsert = "UPDATE `makerlistcontents`
										SET
										`filterView` = false
										WHERE `listName` = '$listName'";
	mysql_query($hideInsert) or die(mysql_error());
}

// DESCIDE TO UPDATE FILTER OR NOT
if(isset($_POST['updateFilter'])){
	$upfilt = $_POST['newFilter'];
	$hideInsert = "UPDATE `makerlistcontents`
										SET
										`filterItems` = '$upfilt'
										WHERE `listName` = '$listName'";
	mysql_query($hideInsert) or die(mysql_error());
	
}
// ------------------------------------------------------------------------
//GET makerlistcontents query
$makerListInfoResult = mysql_query("SELECT * FROM `makerlistcontents` WHERE `listName` = '$listName'");
while ($makerListInfoRow = mysql_fetch_assoc($makerListInfoResult)){
	// SET RATES AND PERCENTAGES HERE
	$EUR_rate = $makerListInfoRow['eur_rate'];
	$EUR_percent = $makerListInfoRow['eur_percent'];

	$USD_rate = $makerListInfoRow['usd_rate'];
	$USD_percent = $makerListInfoRow['usd_percent'];

	$RMB_rate = $makerListInfoRow['rmb_rate'];
	$RMB_percent = $makerListInfoRow['rmb_percent'];

	$DKR_rate = $makerListInfoRow['dkr_rate'];
	$DKR_percent= $makerListInfoRow['dkr_percent'];

	$SKR_rate = $makerListInfoRow['skr_rate'];
	$SKR_percent = $makerListInfoRow['skr_percent'];

	$SGD_rate = $makerListInfoRow['sgd_rate'];
	$SGD_percent = $makerListInfoRow['sgd_percent'];

	// this is for the simulation so that if there is not currency set it will default to 0
	$NC_rate = 0;
	$NC_percent = 0;

	//CHECK IF ABOVE RATES ARE EMPTY
	if(
	$EUR_rate == 0 && $EUR_percent == 0 &&
	$USD_rate == 0 && $USD_percent == 0 &&
	$RMB_rate == 0 && $RMB_percent == 0 &&
	$DKR_rate == 0 && $DKR_percent == 0 &&
	$SKR_rate == 0 && $SKR_percent == 0 &&
	$SGD_rate == 0 && $SGD_percent == 0
	){
		$isSimulation = false;
	} else {
		$isSimulation = true;
	}

	$YEN_rate = 1;
	$YEN_percent = 0;

	//SET CONDITIONALS
	$imageView = $makerListInfoRow['imageView']; //check the list to see if $imageViews is set to true;
	$isHinbanHidden = $makerListInfoRow['isHinbanHidden'];
	$isInputLocked = $makerListInfoRow['isInputLocked'];
	$isFilterHidden = $makerListInfoRow['filterView'];
	$isFilterItems = $makerListInfoRow['filterItems'];
}

// set the color and shape for the show/hide haiban button F76A84 858585
if($isHinbanHidden == false){
	$showHinbanBtn = "<button class='showBtn' name='hide' style='margin-left: 5px;' title='品番非表示' ><span style='color: #858585;'>(廃番)</span></button>";
} else {
	$showHinbanBtn = "<button class='showBtn' name='show' style='margin-left: 5px;' title='品番表示' ><span style='color: #F76A84;'>(廃番)</span></button>";
}
// set the color and shape for the show/hide image button
if($imageView == true){
	$showImageBtn = "<button class='showBtn' name='showImage' style='margin-left: 5px;' title='イメージ非表示' ><span style='color: #858585;'><i class='fa fa-image'></i> イメージ</span></button>";
} else {
	$showImageBtn = "<button class='showBtn' name='hideImage' style='margin-left: 5px;' title='イメージ表示' ><span style='color: #F76A84;'><i class='fa fa-image'></i> イメージ</span></button>";
}
// set the color and shape for the show/hide input button
if($isInputLocked == true){
	$showInputBtn = "<button class='showBtn' name='showInput' style='margin-left: 5px;' title='入力表示' ><span style='color: #F76A84;'><i class='fa fa-lock'></i> 入力</span></button>";
} else {
	$showInputBtn = "<button class='showBtn' name='hideInput' style='margin-left: 5px;' title='入力非表示' ><span style='color: #858585;'><i class='fa fa-unlock-alt'></i> 入力</span></button>";
}
/* 
 * 
 * 1. show-only list toggle
 * 2. import new list button
 * 
 * */

$specialMemo = "1.システムから表示したい商品のみのヨコ書きリストをcsvデータでつくる。
2.csvデータをメモで開きコピー➡Special表示をクリック➡Special List Updateヨコのフィールドにペースト➡Special List Update.
※ 廃番商品でも表示します。";

// 1 show-only toggle
if($isFilterHidden == true){
	$showFilterBtn = "<button class='showBtn' name='showFilter' style='margin-left: 5px;' title='$specialMemo' ><span style='color: #F76A84;'><i class='fa fa-filter'></i> Special表示</span></button>";
} else {
	$showFilterBtn = "<button class='showBtn' name='hideFilter' style='margin-left: 5px;' title='$specialMemo' ><span style='color: #858585;'><i class='fa fa-filter'></i> Special表示</span></button>";
}

// 2 import new list button
if($isFilterHidden == true){
	$showFilterUpdateBtn = "<button class='showBtn' name='updateFilter' style='margin-left: 5px;' title='Special List Update' ><span style='color: #F76A84;'><i class='fa fa-refresh'></i> Special List Update</span></button>
    						<textarea name='newFilter' rows='1'>$isFilterItems</textarea>";
} else {
	$showFilterUpdateBtn = "";
}


?>
	<div id='wrapper'>
		<div id='loading'>
			<span class='loadingGifMain'> <img src='<?php echo $path;?>/img/142.gif'><br> LOADING ... </span>
		</div>
		<?php require_once '../header.php';?>
		<div class='contents'>
			<!-- PAGE CONTENTS START HERE -->
			<div class='currencyRates' style='background-color: #888888; color: #FFF;'>
			<?php
			echo "<div class='titleBtn' style='float: left;'><span style='font-weight: 700; color: #888888'> < ".$listName." > </span></div>";
			?>
				<form method='post' action='exe/exeSetListDetails.php' id='detailsSave' style='float: left;'>
					<div>
						EUR: <input type='text' name='eur_rate' value='<?php echo $EUR_rate;?>' class='rateDiscountColor'> <input type='text' name='eur_percent' value='<?php echo $EUR_percent;?>' class='rateDiscountColor'>%
					</div>
					<div>
						USD: <input type='text' name='usd_rate' value='<?php echo $USD_rate;?>' class='rateDiscountColor'> <input type='text' name='usd_percent' value='<?php echo $USD_percent;?>' class='rateDiscountColor'>%
					</div>
					<div>
						RMB: <input type='text' name='rmb_rate' value='<?php echo $RMB_rate;?>' class='rateDiscountColor'> <input type='text' name='rmb_percent' value='<?php echo $RMB_percent;?>' class='rateDiscountColor'>%
					</div>
					<div>
						DKR: <input type='text' name='dkr_rate' value='<?php echo $DKR_rate;?>' class='rateDiscountColor'> <input type='text' name='dkr_percent' value='<?php echo $DKR_percent;?>' class='rateDiscountColor'>%
					</div>
					<div>
						SKR: <input type='text' name='skr_rate' value='<?php echo $SKR_rate;?>' class='rateDiscountColor'> <input type='text' name='skr_percent' value='<?php echo $SKR_percent;?>' class='rateDiscountColor'>%
					</div>
					<div>
						SGD: <input type='text' name='sgd_rate' value='<?php echo $SGD_rate;?>' class='rateDiscountColor'> <input type='text' name='sgd_percent' value='<?php echo $SGD_percent;?>' class='rateDiscountColor'>%
					</div>
					<input type="hidden" name='listName' value='<?php echo $listName;?>'>
					<button type='submit' class='update' title='為替決定'>
						決定 <i class='fa fa-arrow-right'></i>
					</button>
				</form>

				<form action="" method='POST' style='float: left;'>
				<?php echo $showHinbanBtn;?>
				</form>

				<form action="" method='POST' style='float: left;'>
				<?php echo $showImageBtn;?>
				</form>

				<form action="" method='POST' style='float: left;'>
				<?php echo $showInputBtn;?>
				</form>
				
				<form action="" method='POST' style='float: left;'>
				<?php echo $showFilterBtn;?>
				</form>
				
				<form action="" method='POST' style='float: left;'>
				<?php echo $showFilterUpdateBtn; ?>
				</form>

				<!-- <a href='list_calculation_printView.php?pr=1&id=<?php echo $listName;?>'><img alt="excel export" src="../img/excelExport.png" title='エクセルエクスポート' style='float: right; height: 32px;'> </a> -->
				<button type='button' id='clearButton' style='float: right; margin-left: 5px;' class='cancelBtn' title='押してから保存'>NEW販売価格すべてクリア</button>
				<div class='clear'></div>

			</div>
			<div></div>
			<div id='saveWrapper'>
				<form method='post' action='exe/exeSetListPrice.php' id='listSave'>
					<table id="calcTable">
					<?php
					echo "<thead>";
					echo "<tr>";
					echo "<th><label>イメージ</label></th>";
					echo "<th><label>シリーズ</label></th>";
					echo "<th style='min-width: 100px;'><label>Tform品番</label></th>";
					echo "<th><label title='Tform No 廃番'>廃番</label></th>";
					echo "<th><label><i class='fa fa-check-square-o'></i>メモ</label></th>";
					echo "<th><label title='(PL = 0) && (廃番 = FALSE) => ☑が必要'><i class='fa fa-exclamation-circle'></i></label></th>";
					echo "<th><label>メーカー品番</label></th>";
					echo "<th><label>セット</label></th>";
					echo "<th><label title='セット部品廃番'>廃番</label></th>";
					echo "<th><label>前のPL</label></th>";
					echo "<th><label>値上率</label></th>";
					echo "<th><label>通貨</label></th>";
					echo "<th><label>PL</label></th>";
					echo "<th><label>値引率</label></th>";
					echo "<th><label title='NET価格 = (PL価格*(割引条件/100)) * レート〔￥〕) * (1+(パーセント〔%〕/100))'>NET</label></th>";
					echo "<th><label title='レート条件〔 ￥ / % 〕'>為替/経費</label></th>";
					echo "<th><label>仕入原価</label></th>";
					echo "<th><label title='原価価格 = (NET価格 += )'>原価合計</label></th>";
					echo "<th><label title='販売価格/原価価格'>倍率</label></th>";
					echo "<th><label>販売価格</label></th>";
					echo "<th><label title='新倍率 = 販売価格/新販売価格'>NEW倍率</label></th>";
					echo "<th><label>NEW販売価格</label></th>";
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";

					/* *****************
					 * MAIN LOOP STARTS
					 * *****************
					 */
					$count = 0; //CAN DELETE USED FOR DEBUGGING
					$t = 1;	//for the javascript
					$s = 1;	//for the javascript
					$record = -1; //counts the record so when go to calculation.php the record is on the correct place in the list
					$listLoopQuery = "SELECT `id`, `tformNo`,`testPrice`,`memo`, `specialItems` FROM `makerlistinfo` WHERE `listName` = '$listName' ORDER BY `tformNo`";
					$listLoopResult = mysql_query($listLoopQuery);
					while($listLoopRow = mysql_fetch_assoc($listLoopResult)){

						/* ------------------------------------------------------------------------
						 * ----------------------------- VARIABLES --------------------------------
						 * ------------------------------------------------------------------------
						 */
						// listLoopQuery variables
						// initialize
						$tformNo = "";
						$testPrice = "";
						$listMemo = "";
						$makerlistinfoId = "";
						$specialItems = "";
						//setVars
						$tformNo = $listLoopRow['tformNo'];
						$testPrice = $listLoopRow['testPrice'];
						$listMemo = $listLoopRow['memo'];
						$makerlistinfoId = $listLoopRow['id'];
						$specialItems = $listLoopRow['specialItems']; // later down splice this into the $setString
						$inputPrice = $testPrice; // set the price for the dynamic calculation input area
						$record++; //add to the record

						// mainLoopQuery variables
						$mainLoopQuery = "SELECT `type`,`series`,`tformPriceNoTax`,`set`,`thumb`,`memo`, `web` FROM `main` WHERE `tformNo` = '$tformNo'";
						$mainLoopResult = mysql_query($mainLoopQuery);
						while($mainLoopRow = mysql_fetch_assoc($mainLoopResult)){
							// initialize
							$type = "";
							$series = "";
							$tformPriceNoTax = "";
							$setString = "";
							$imgURL = "";
							$mainMemo = "";
							$web = "";
							// setVars
							$type = $mainLoopRow['type']; //type of product
							$series = $mainLoopRow['series'];
							$tformPriceNoTax = $mainLoopRow['tformPriceNoTax'];
							$setString = $mainLoopRow['set'];
							$imgURL = $mainLoopRow['thumb'];
							$mainMemo = $mainLoopRow['memo'];
							$web = $mainLoopRow['web']; //WEB 表示
						}
						// set the tform haiban if it is haiban
						//check if main tformNo is Haiban or not.(includes single and set)

						$istformNoHaiban = false;

						
/* CHECK FOR HAIBAN */
if (isHaibanNew($tformNo) == true){
	$istformNoHaiban = true;
}
// -----------------------------------------------------------------------------

						//take $setString and convert it to array
						// if the set is empty include the origional tformNo as the set contents so we can loop through the inner array without having to split between set and single products
						// sometimes the $setString would contain just ( , ) and this would skip the test of = "" so added preg_match and only went to else if there were numbers containted in the string.
						if($setString == "" || preg_match('#[0-9]#', $setString) == false){
							$setArray = array($tformNo);
						} else {
							$setArray = explode(',', preg_replace('/\s+/', '', $setString)); 	//removes all whitespace
						}
						
						//Add together setString and specialItems
						//SPECIAL ITEMS EXPLOSION!!!
						if($specialItems == "" || preg_match('#[0-9]#', $specialItems) == false){
							$specialItemsArray = array();
							$setModifiedArray = $setArray;
						} else {
							$specialItemsArray = explode(',', preg_replace('/\s+/', '', $specialItems)); 	//removes all whitespace

							$setModifiedArray = array_merge($setArray,$specialItemsArray);
							
						}
						
						
						//print_r($setModifiedArray);

						/* ---------------------------------------------------------------------
						 *	 ____ ____ ____ ____ ____ ____ ____ ____ ____ ____
						 *	||I |||N |||I |||T |||I |||A |||L |||I |||Z |||E ||
						 *	||__|||__|||__|||__|||__|||__|||__|||__|||__|||__||
						 *	|/__\|/__\|/__\|/__\|/__\|/__\|/__\|/__\|/__\|/__\|
						 * ---------------------------------------------------------------------
						 */
						unset($internalArray); //clear internal array before inital loop so we can SMASH the bugs
						unset($internalSimArray); // FOR SIM clear internal array before inital loop so we can SMASH the bugs
						$net = 0;
						$calcNAC = 0;
						$calcSimNAC = 0;
						$NAC = 0;
						$simNAC = 0;
						$totalNet = 0;
						$totalSimNet = 0;
						$bairitsu = 0;

						//check if all contents are haiban and if they are not set to false inside the inner loop
						$isAllHaiban = true;


						//loop to run for each item in the set to set the innerArray --  $key = tformNo
						foreach ($setModifiedArray as $key){
							//unset($VARIABLE);

							unset($historyPlArray);
							unset($historyIdArray);
							$count ++; // DONT NEED THIS COUNT DELETE AFTER USED FOR DEBUGGING

							// CHECKS
							$inPl = true;
							$isHaiban = false;
							$isZero = false;
							$isYen = false;
							$hasHistory = true;

							// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
							//INNER LOOP `main` QUERY
							$mainInnerQuery = "SELECT `tformNo`, `makerNo`, `memo` FROM `main` WHERE `tformNo` = '$key'";
							$mainInnerResult = mysql_query($mainInnerQuery);
							if(mysql_num_rows($mainInnerResult) == false){
								echo "(".$tformNo.") NOT IN SYSTEM[".$key."]".$count;
							}
							while($mainInnerRow = mysql_fetch_assoc($mainInnerResult)){
								// initialize
								$makerNo = "";
								$memo = "";
								// setVars
								$tformNoHaibanSearch = $mainInnerRow['tformNo'];
								$makerNo = $mainInnerRow['makerNo'];
								$memo = $mainInnerRow['memo'];

/* CHECK FOR HAIBAN */
if (isHaibanNew($tformNoHaibanSearch) == true){
	$isHaiban = true;
}

							}
							// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
							//INNER LOOP `sp_plCurrent` QUERY
							$sp_plCurrentInnerQuery = "SELECT `plCurrent`, `sp_disc_rate_id` FROM `sp_plcurrent` WHERE `tformNo` = '$key'";
							$sp_plCurrentInnerResult = mysql_query($sp_plCurrentInnerQuery);
							//check for if price exists or not in the list
							if(mysql_num_rows($sp_plCurrentInnerResult) == false){
								$sp_plCurrent = " - ";
								$sp_disc_rate_id = 0;
								$inPl = false;
							} else {
								while($sp_plCurrentInnerRow = mysql_fetch_assoc($sp_plCurrentInnerResult)){
									// initialize
									$sp_plCurrent = 0;
									$sp_disc_rate_id = 0;
									// setVars
									$sp_plCurrent = $sp_plCurrentInnerRow['plCurrent'];
									$sp_disc_rate_id = $sp_plCurrentInnerRow['sp_disc_rate_id'];
									//check if PL = 0;
									if($sp_plCurrent == 0){
										//echo $key."IS ZERO";
										$isZero = true;
									}
								}
							}
							// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
							//INNER LOOP `sp_history` QUERY
							$sp_historyInnerQuery = "SELECT `plCurrent`, `sp_disc_rate_id` FROM `sp_history` WHERE `tformNo` = '$key' ORDER BY `created` DESC LIMIT 2";
							$sp_historyInnerResult = mysql_query($sp_historyInnerQuery);
							if(mysql_num_rows($sp_historyInnerResult) == false){
								$historyPl = "履歴なし";
								$historyBai = "履歴なし";
								$history_sp_disc_rate_id = 0;
							} else {
								while ($sp_historyInnerRow = mysql_fetch_assoc($sp_historyInnerResult)){
									// initialize
									$historyPl = 0;
									$historyBai = 0;
									$history_sp_disc_rate_id = 0;
									// setVars
									$historyPl = $sp_historyInnerRow['plCurrent'];
									$history_sp_disc_rate_id = $sp_historyInnerRow['sp_disc_rate_id'];

									//check if the current used rate is the same as the history. If it is skip the pl and do the next.
									//FEED the prices and id into an array
									$historyPlArray[] = $historyPl;
									$historyIdArray[] = $history_sp_disc_rate_id;
								}

								if( count($historyPlArray) >= 2){

									//search array and return index if true;
									$historyKey = array_search($sp_disc_rate_id, $historyIdArray);

									// choose the opposite of the same sp_rate_id and set the index to the opposite so we can use it in our calculations below
									if($historyKey == 0){
										$historyIndex = 1;
									} else {
										$historyIndex = 0;
									}

									//calculation goes here
									// [ ((V2 - V1) / |V1|) * 100 ] From 10 apples to 20 apples is a 100% increase in apples.
									$historyPl = number_format($historyPlArray[$historyIndex],2,'.',',');
									$historyPlCalc = $historyPlArray[$historyIndex];

									//check for division by 0
									if(($sp_plCurrent - $historyPlCalc) == 0 || $historyPlCalc == 0 || $sp_plCurrent == 0){
										$historyBaiCalc = 0;
									} else {
										$historyBaiCalc = (($sp_plCurrent - $historyPlCalc) / $historyPlCalc) * 100;
									}
									$historyBai = number_format($historyBaiCalc,2,'.',',');

								} else {
									$hasHistory = false;
									$historyPl = "履歴なし";
									$historyBai = "履歴なし";
								}
							}
							// <><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><>
							//INNER LOOP `sp_disc_rate` QUERY
							$sp_dis_rate_InnerQuery = "SELECT `year`, `memo`, `maker`, `netTerm`,`currency`,`rate`,`percent`,`discount`,`discountPar` FROM `sp_disc_rate` WHERE `id` = '$sp_disc_rate_id'";
							$sp_dis_rate_InnerResult = mysql_query($sp_dis_rate_InnerQuery);
							//check for if price exists or not in the list
							if($inPl == false){
								$spdrYear = "";
								$spdrMemo = "";
								$spdrMaker = "";
								$spdrNetTerm = "";
								$spdrCurrency = "NC";
								$spdrRate = 0;
								$spdrPercent = 0;
								$spdrDiscount = 0;
								$spdrDiscountPar = 0;
							} else {

								while($sp_dis_rate_InnerRow = mysql_fetch_assoc($sp_dis_rate_InnerResult)){
									// initialize
									$spdrYear = "";
									$spdrMemo = "";
									$spdrMaker = "";
									$spdrNetTerm = "";
									$spdrCurrency = "-";
									$spdrRate = 0;
									$spdrPercent = 0;
									$spdrDiscount = 0;
									$spdrDiscountPar = 0;
									// setVars
									$spdrYear = $sp_dis_rate_InnerRow['year'];
									$spdrMemo = $sp_dis_rate_InnerRow['memo'];
									$spdrMaker = $sp_dis_rate_InnerRow['maker'];
									$spdrNetTerm = $sp_dis_rate_InnerRow['netTerm'];
									$spdrCurrency = $sp_dis_rate_InnerRow['currency'];
									$spdrRate = $sp_dis_rate_InnerRow['rate'];
									$spdrPercent = $sp_dis_rate_InnerRow['percent'];
									$spdrDiscount = $sp_dis_rate_InnerRow['discount'];
									$spdrDiscountPar = $sp_dis_rate_InnerRow['discountPar'];

									//check if currency is YEN
									if($spdrCurrency == "YEN"){
										//echo $key." is YEN!!!";
										$isYen = true;
									}
								}
							}

							// +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+-
							//CALCULATIONS HERE

							//CALCULATIONS FOR THE SIMULATION
							$simulationRate = ${$spdrCurrency.'_rate'};
							$simulationPercent = ${$spdrCurrency.'_percent'};
							//---------------------------------------------

							//if all tformNo (set or single) = false then set isAllHinban to false
							if ($isHaiban == false){
								$isAllHaiban = false;
							}
							//echo "habain: [".$isHaiban."] allhaiban: [".$isAllHaiban."]<br>";

							//if isHaiban = true then set haibanIcon text
							if ($isHaiban == true){
								$haibanIcon = "<span style='color: red; font-size: 9;'> (廃番)</span>";
							} else {
								$haibanIcon = " - ";
							}

							//NEEDS A MEMO INSERT
							if($sp_plCurrent == 0 && $isHaiban == false){
								$needsCheckIcon = "<span style='color: orange; font-size: 9;'> <label title='PL = 0 AND 廃番 NOT SET'><i class='fa fa-exclamation-circle'></i></label></span>";
							} else {
								$needsCheckIcon = "";
							}

							// do not do the discount calculation for the net if the discount is 0 or it will set the price to 0
							if ($spdrDiscount == 0){
								$net = $sp_plCurrent;
							} else {
								$net = $sp_plCurrent * $spdrDiscount;
							}
							//if $isYen = true then $calcNAC = $net; if we do not do this then yen will be 0; Yen is special because there is not currency exchange involved
							if ($isYen == true){
								$calcNAC = $net;
							} else {
								$calcNAC = $net * $spdrRate * (1 + ($spdrPercent/100)); //$single_net * $single_rate * (1 + ($single_percent/100));
								$calcSimNAC = $net * $simulationRate * (1 + ($simulationPercent/100)); // FOR SIM $single_net * $single_rate * (1 + ($single_percent/100));
							}

							$NAC = number_format(truncate($calcNAC, 0), 0, '',','); //net after calculation. take the net and add the percentage rate to get the yen amount
							$simNAC = number_format(truncate($calcSimNAC, 0), 0, '',','); // FOR SIM net after calculation. take the net and add the percentage rate to get the yen amount

							//ADD UP TOTALS
							$totalNet += truncate($calcNAC, 0); // add up all the net after calculations -- $calcNAC
							$totalSimNet += truncate($calcSimNAC, 0); // FOR SIM add up all the net after calculations -- $calcNAC


							// IMG CODE
							// DISSABLE image if $imageView is set to false;
							if($imageView == true){
								if($imgURL != ""){
									$thumRep = str_replace("img/img_phot/photo", "img/img_phot/photo_thum060", $imgURL);
									$img = "<img src ='".$filemakerImageLocation.$imgURL."' style='max-width: 45px; max-height: 45px;'>";
								} else {
									$img = "<li class='fa fa-picture-o' style='font-size: 40px; color: #CCC;'></li>";
								}
							} else {
								$img = "";
							}

							//if set Item is added via the special items mark with true
							if(in_array($key, $specialItemsArray)){
								$isSpecial = 1;
							} else {
								$isSpecial = 0;
							}


							// +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+- +-+-+-+-+-+-
							// [0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1]
							//FILL ARRAY HERE

							$arrayA = array($key, $makerNo , $historyPl, $historyBai, $spdrCurrency, $sp_plCurrent, $spdrDiscountPar, $net, $spdrRate, $spdrPercent, $NAC, $isYen, $haibanIcon, $needsCheckIcon, $isSpecial); //take values and feed them into the array
							$internalArray[] = $arrayA; //feed internal array

							$arrayB = array($simulationRate, $simulationPercent, $simNAC); //take the sim rate/currency and do the caluclations and feed it into an array
							$internalSimArray[] = $arrayB; //feed internal array

							// [0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1][0][1]

						} // internal loop end

						// [-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*]
						//Calculations that occur after the internal loop

						//set the array length
						$arrayLength = count($internalArray); // set array length

						if($arrayLength <= 1){
							$break = ""; // set a line break
						} else {
							$break = "<br>";
						}

						//set the bairitsu in case of division by 0
						if($tformPriceNoTax == 0 || $totalNet == 0) {
							$bairitsu = 0;
						} else {
							$bairitsu = $tformPriceNoTax / $totalNet;
						}

						//SET TO RUN BLOCK OR NOT
						if($isHinbanHidden == true){ //check if the list has a hidden haiban or not

							if ($isAllHaiban == true || $istformNoHaiban == true) { // if ALL of set or single tformNo are haiban then do not display
								$displayBlock = false;
							} else {
								$displayBlock = true;
							}

						} else {
							$displayBlock = true;
						}
						
						//check if the special filter is on and only shows the contents if tformNo matches the contents of the special list.
						if($isFilterHidden == true){
							$explodedFilter = explode(',', $isFilterItems);
							
							if(in_array($tformNo, $explodedFilter)){
								$displayBlock = true;
							} else {
								$displayBlock = false;
							}
						} 


						// [-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*][-][*]

						// echo "<br><br>".$tformNo." - ".$count." )<br><hr>"; // CAN DELETE USED FOR DEBUGGING

						// ************************************************************************
						/*
						* BEFROE START CHECK IF ...
						*/
						// haiban view toggled
						if($displayBlock == true){

							// ************************************************************************
							/* START OF BLOCK */
							echo "<tr>";
							// [IMAGE] BLOCK ===================================
							echo "<td>";
							echo $img;
							echo "</td>";
							// [SERIES] BLOCK ===================================
							echo "<td>";
							echo $series;
							echo "</td>";
							// [TFORM NO] BLOCK ===================================
							echo "<td>";
							echo "<a href='calculation.php?pr=1&record=".$record."&search=".$tformNo."&list=$listName' tabindex='-1'>".$tformNo."</a>"; // here record is for the place in the list on calculation.php
							echo "</td>";
							// [main tformNo 廃番] BLOCK ==============================

/* CHECK FOR HAIBAN */
if (isHaibanNew($tformNo) == true){
	$isHaibanMaintformNo = "(廃番)";
} else {
	$isHaibanMaintformNo = "";
}
							echo "<td>";
							echo $isHaibanMaintformNo;
							echo "</td>";
							// [CHECK MEMO] BLOCK ===================================
							echo "<td>";
							if($isInputLocked == true){
								echo "<span style='text-align: center;'>".$listMemo."</span>";
							} else {
								echo "<input style='width: 80px; background: #FFCFAC; border: none;' type='text' name='memo[]' value='".$listMemo."' tabindex='-1'>";
							}
							echo "</td>";
							// [CHECK ] BLOCK ===================================
							echo "<td>";

							//CHECK FOR IF NEEDS ATTENTIONS
							if($arrayLength <= 1){
								for($j = 0; $j < $arrayLength; $j++){
									//--------------------------
									echo $internalArray[$j][13];
									//--------------------------
								}
							}
							echo "</td>";

							// [MAKERNO] BLOCK ===================================
							echo "<td style='max-width: 100px;'>";
							for($j = 0; $j < $arrayLength; $j++){
								//--------------------------
								echo $internalArray[$j][1].$break;
								//--------------------------
							}
							echo "</td>";
							// [SET] BLOCK ===================================
							echo "<td style='min-width: 130px;'>";

							//if set echo x
							if($arrayLength <= 1){
								echo "x";
							} else {
								for($j = 0; $j < $arrayLength; $j++){
									//--------------------------
									//check if is special item
									if($internalArray[$j][14] == true){
										//$specialIcon = "<img title= '特別アイテム' src='../img/bullet_ball_glass_green.png' style='float: right;'>";
										$specialIcon = "";
										$specialText = "color: #858585";
									} else {
										$specialIcon = "";
										$specialText = "";
									}

									echo "<span style='".$specialText."'>".$internalArray[$j][0]."</span>".$specialIcon.$break;
									//--------------------------
								}
							}
							echo "</td>";
							// [haiban (廃番)] BLOCK ===================================
							echo "<td>";
							for($j = 0; $j < $arrayLength; $j++){
								//--------------------------
								echo $internalArray[$j][12].$break;
								//--------------------------
							}
							echo "</td>";
							// [HISTORY PL] BLOCK ===================================
							echo "<td>";
							for($j = 0; $j < $arrayLength; $j++){
								//--------------------------
								echo $internalArray[$j][2].$break;
								//--------------------------
							}
							echo "</td>";
							// [HISTORY BAI] BLOCK ===================================
							echo "<td>";
							for($j = 0; $j < $arrayLength; $j++){
								//--------------------------
								echo $internalArray[$j][3].$break;
								//--------------------------
							}
							echo "</td>";
							// [CURRENCY] BLOCK ===================================
							echo "<td>";
							for($j = 0; $j < $arrayLength; $j++){
								//--------------------------
								echo $internalArray[$j][4].$break;
								//--------------------------
							}
							echo "</td>";
							// [PL] BLOCK ===================================
							echo "<td style='text-align: right;'>";
							for($j = 0; $j < $arrayLength; $j++){
								//--------------------------
								echo number_format(floatval($internalArray[$j][5]),2, '.',',').$break;
								//--------------------------
							}
							echo "</td>";
							// [DISCOUNT] BLOCK ===================================
							echo "<td>";
							for($j = 0; $j < $arrayLength; $j++){
								//--------------------------
								echo $internalArray[$j][6]."%".$break;
								//--------------------------
							}
							echo "</td>";
							// [NET] BLOCK ===================================
							echo "<td style='text-align: right;'>";
							for($j = 0; $j < $arrayLength; $j++){
								//--------------------------
								echo number_format(floatval($internalArray[$j][7]), 2, '.',',').$break;
								//--------------------------
							}
							echo "</td>";
							// [￥ / %] BLOCK ===================================
							echo "<td>";
							for($j = 0; $j < $arrayLength; $j++){
								//--------------------------
								echo "￥".$internalArray[$j][8]." / ";
								echo $internalArray[$j][9]."%".$break;
								//SIMILATION DISPLAY
								if($isSimulation == true){
									echo "<br><span class='simStyle'>";
									echo "￥".$internalSimArray[$j][0]." / ";
									echo $internalSimArray[$j][1]."%".$break;
									echo "</span>";
								}
								//--------------------------
							}
							echo "</td>";
							// [NET AFTER CONVERSION] BLOCK ===================================
							echo "<td style='text-align: right;'>";
							for($j = 0; $j < $arrayLength; $j++){
								//--------------------------
								echo "￥".$internalArray[$j][10].$break;
								//SIMULATION DISPLAY
								if($isSimulation == true){
									echo "<br><span class='simStyle'>";
									echo "￥".$internalSimArray[$j][2].$break;
									echo "</span>";
								}
								//--------------------------
							}
							echo "</td>";
							// [TOTAL NET] BLOCK =================================== // TOTAL of all of the NAC
							echo "<td style='text-align: right;'>";
							echo "￥".number_format($totalNet,0, '',',');
							//SIMULATION DISPLAY
							if($isSimulation == true){
								echo "<span class='simStyle'>";
								echo "<br>￥".number_format($totalSimNet,0, '',',');
								echo "</span>";
							}
							echo "</td>";
							// [BAIRITSU] BLOCK =================================== // tformPriceNoTax / TOTAL NET (販売価格/原価価格)
							echo "<td style='text-align: right;'>";
							echo number_format($bairitsu, 2, '.','');
							echo "</td>";
							// [TFORM PRICE NO TAX] BLOCK ===================================
							echo "<td style='text-align: right;'>";
							echo "￥".number_format($tformPriceNoTax,0,'',',');
							echo "</td>";
							// [NEW BAI] BLOCK ===================================
							echo "<td style='text-align: right;'>";
							//echo "<input type='text' class='outputValA".$s."' value='' style='background-color: transparent; max-width: 50px; border: none; text-align: right;' tabindex='-1'><br>";
							echo "<span class='outputValA".$s."'></span>";
							//SIMULATION DISPLAY
							if($isSimulation == true){
								//echo "<input type='text' class='outputValB".$s."' value='' style='background-color: transparent; max-width: 50px; border: none; text-align: right; color: #3AC1D6;' tabindex='-1'>";
								echo "<br><span style='color: #3AC1D6;' class='outputValB".$s."'></span>";
							}
							//--------------------
							echo "</td>";
							// [NEW TFORM PRICE] BLOCK ===================================
							echo "<td>";
							if($isInputLocked == true){
								echo "<span style='text-align: right;'>￥".$inputPrice."</span>";
								echo "<input type='hidden' name='inputPrice[]' value='".$inputPrice."'class='inputVal".$t."'>";
							} else {
								echo "￥<input type='text' name='inputPrice[]' value='".$inputPrice."' style='width: 60px; text-align: right;' class='inputVal".$t."' id='clearAll'>";
							}
							echo "<input type='hidden' name='id[]' value='".$makerlistinfoId."'>"; // for the ids
							echo "<input type='hidden' name='listName' value='$listName'>"; // hidden list name for form
							echo "<input type='hidden' class='costA".$s."' value='$totalNet'>";// hidden calc variables
							echo "<input type='hidden' class='costB".$s."' value='$totalSimNet'>";// hidden calc variables
							echo "</td>";
							// ============================================
							echo "</tr>";
						}// END OF CHECK IF...
						/* END OF BLOCK */
						/*
						 *********************************************************
						 *   _                                _             _
						 *  (_) __ ___   ____ _ ___  ___ _ __(_) ___  _ __ | |_
						 *  | |/ _` \ \ / / _` / __|/ __| '__| |/ _ \| '_ \| __|
						 *  | | (_| |\ V / (_| \__ \ (__| |  | | (_) | |_) | |_
						 * _/ |\__,_| \_/ \__,_|___/\___|_|  |_|\___/| .__/ \__|
						 *|__/                                       |_|
						 **********************************************************
						 */
						?>
						<script type="text/javascript">
				        jQuery(function($) {                                	
				        	var Input = $(".inputVal<?php echo "$t"; ?>"); // main input
				        	
				            var OutputA = $(".outputValA<?php echo "$s"; ?>"); // first result
				            var CostA = $(".costA<?php echo "$s"; ?>"); // cost 
				    
				            var OutputB = $(".outputValB<?php echo "$s"; ?>"); // second result
				            var CostB = $(".costB<?php echo "$s"; ?>"); // cost 
				           
				    		$([CostA[0], Input[0]]).bind("change keyup keydown paste", function(e) {
				    		    var ResultA;
				    		    ResultA = parseFloat(Input.val()) / parseFloat(CostA.val());
				    		    OutputA.text(ResultA.toFixed(2));
				    		});  
				    		
				    		$([CostB[0], Input[0]]).bind("change keyup keydown paste", function(e) {
				    		    var ResultB;
				    		    ResultB = parseFloat(Input.val()) / parseFloat(CostB.val());
				    		    OutputB.text(ResultB.toFixed(2));
				    		});  
				        });
				        </script>
				        <?php
				        //javascript counter vars
				        $t++;
				        $s++;
				        // ********************************************************
					}
					
					echo "</tbody>";
					?>
					</table>
				</form>
			</div>
			<!-- PAGE CONTENTS END HERE -->
		</div>
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>
