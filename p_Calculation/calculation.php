<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title;?></title>
<?php
include_once '../master/config.php'; ?>
<script type="text/javascript">
$(document).ready( function() {

	var defaultOptions = {
			"sScrollY": false,
			"bJQueryUI": true,
			"bPaginate": false,
			"bFilter": false,
			"bInfo": false
				};//options
				var defaultOptions2 = {
						"sScrollY": 80,
						"bJQueryUI": true,
						"bPaginate": false,
						"bFilter": false,
						"bInfo": false,
						"aaSorting": [[0,'desc']]
							};//options
							var defaultOptions3 = {
									"sScrollY": 141,
									"bJQueryUI": true,
									"bPaginate": false,
									"bFilter": false,
									"bInfo": false
										};//options
		var oTable = $('#setTable').dataTable(defaultOptions);
		var oTable = $('#historyTable').dataTable(defaultOptions2);
		var oTable = $('#historyTableShort').dataTable(defaultOptions2);
		var oTable = $('#partsTable').dataTable(defaultOptions3);

		 $(window).bind('resize', function () {
				oTable.fnAdjustColumnSizing();

		  } );

		$(function() {
			e = $.Event('keyup');
			e.keyCode= 82; // press r key to refresh Cap Sensative
			$('input').trigger(e);
		});
		$( "#datepicker" ).datepicker({ dateFormat: "yy.mm.dd"});

		$( "#tabs" ).tabs({
			activate: function (event, ui) {
				 var $activeTab = $('#tabs').tabs('option', 'active');
				 if ($activeTab == 1) {
				 // HERE YOU CAN ADD CODE TO RUN WHEN THE SECOND TAB HAS BEEN CLICKED
					//window.alert("test");
					oTable.fnAdjustColumnSizing();
					$(table).dataTable().fnAdjustColumnSizing();
				 }
				 }

 	});
		 $('#loading').delay(300).fadeOut(300);

		// TOOL TIP
			$(function() { $( document ).tooltip(); });
		} );
</script>
<style type="text/css">
th {
	font-size: 10px;
}

.ui-tabs .ui-tabs-panel {
	padding: 0px;
}

.toptd {
	width: 135px;
	height: 18px;
	outline: 1px solid #CCC;
	overflow: hidden;
	padding-right: 4px;
}

.topth {
	color: green;
	min-width: 90px;
}

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

	@media print {
		#navi, #statusBar, #historyTable_wrapper{
			display: none !important;
		}
		#saveWrapper {
			position: absolute;
			top: -50px;
		}
	}
</style>
</head>
<body>
<?php
//variables
// make sure $page always = something
if (isset($_GET['record'])){
	$record = $_GET['record'];
	$previous = $record - 1; // minus from the current record
	$next = $record + 1; // add to the current record
	if ($record < 0){
		$record = 0;
		$previous = $record; // minus from the current record
		$next = $record; // add to the current record
	}

} else {
	$record = 0;
	$previous = $record - 1; // minus from the current record
	$next = $record + 1; // add to the current record
}
// make sure $search always = something
if (isset($_GET['search'])){
	$search = $_GET['search'];
} else {
	$search = "";
}

if (isset($_GET['id']) == true){
	$recordId = $_GET['id'];
	$setQuery = "SELECT * FROM `main` WHERE `id` = '$recordId'";
} else {
	//$setQuery = "SELECT * FROM `sp_disc_rate` WHERE `id` LIKE '%$search%' OR `maker` LIKE '%$search%' OR `date` LIKE '%$search%'";
	$setQuery = "SELECT * FROM `main` WHERE `tformNo` LIKE '%$search%' || `maker` LIKE '%$search%' || `makerNo` LIKE '%$search%' && `tformNo` != ''";
}

if(isset($_GET['list'])){
	$list = $_GET['list'];
	$listNavi = "&list=".$list;
	$setQuery = "SELECT main.* FROM main, makerlistinfo WHERE main.tformNo = makerlistinfo.tformNo AND makerlistinfo.listName = '$list'";
	$date = "";
} else {
	$listNavi = "";
}

//get total amount of results.
$iAmount = 0;
$resultAmount = mysql_query("$setQuery");
$searchEmptyCheck2 = mysql_num_rows($resultAmount);
while ($rowAmount = mysql_fetch_assoc($resultAmount)){
	$iAmount++;
}
// ---------------------------
$iRecord = $record +1;

//SET FILENAME SAVE HERE
$result = mysql_query("$setQuery ORDER BY tformNo ASC LIMIT $record, 1 ");
$idPass = 0; // initialize the record Id

while ($row = mysql_fetch_assoc($result)){
	$idPass = $row['id']; //set the recordId
	$id = $row['id'];


	if ($row['maker'] == ""){
		$saveFileDate = 1;
	} else {
		$savFileDate = $row['maker'];
	}
	if ($row['id'] == ""){
		$saveFileProjectName = "calculation";
	} else {
		$saveFileProjectName = $row['id'];
	}
	$saveFileName = $saveFileProjectName."_".$savFileDate;

}
//----------------------------------
?>
	<div id='wrapper'>
		<div id='loading'>
			<span class='loadingGifMain'> <img src='<?php echo $path;?>/img/142.gif'><br> LOADING ... </span>
		</div>
		<?php require_once '../header.php'; ?>
		<div class='contents'>
			<!-- PAGE CONTENTS START HERE -->
			<div id='statusBar'>
			<?php if ($record <= 0){?>
				<button class='recordCycleBtnDisabled' style='cursor: default;'>◀</button>

				<?php }
				else{ ?>
				<button class='recordCycleBtn' onClick="location.href='calculation.php?pr=1<?php echo $listNavi;?>&record=<?php echo $previous;?>&search=<?php echo $search;?>'">◀</button>

				<?php }
				if($iRecord == $iAmount || $searchEmptyCheck2  == 0){
					?>
				<button class='recordCycleBtnDisabled' style='cursor: default;'>▶</button>

				<?php }
				else { ?>
				<button class='recordCycleBtn' onClick="location.href='calculation.php?pr=1<?php echo $listNavi;?>&record=<?php echo $next;?>&search=<?php echo $search;?>'">▶</button>


				<?php }	?>
				<?php echo $iRecord." of ".$iAmount;
				echo " (search: ".$search.")";
				if(isset($_GET['list'])){
					echo "<a href ='list_calculation.php?pr=1&id=".$list."'><button style='margin-left: 10px;' class='upload'><i class='fa fa-reply' style='color: red;'></i> 一覧へ戻る </button></a>";
				}
				echo "<br>";
				?>
			</div>
			<?php //CHECK HERE IF NO FILES FOUND THEN DONT SHOW....
			if ($searchEmptyCheck2 != 0){
				?>
				<?php
				//Variables

				//MAIN VARIABLES
				$resultMain = mysql_query("SELECT * FROM `main` WHERE `id` = '$id'");
				while ($rowMain = mysql_fetch_assoc($resultMain)){
					$tformNo = $rowMain['tformNo'];
					$type = $rowMain['type'];
					$maker = $rowMain['maker'];
					$makerNo = $rowMain['makerNo'];
					$series = $rowMain['series'];
					$modelMemo = $rowMain['memo'];
					$img = $rowMain['thumb'];
					$tformPriceNoTax = $rowMain['tformPriceNoTax'];
					$topTformPriceNoTax = $rowMain['tformPriceNoTax'];
					$date = $rowMain['modified'];
					$web = $rowMain['web'];
					$cancelMaker = $rowMain['cancelMaker'];
					$cancelTform = $rowMain['cancelTform'];
					$cancelSelling = $rowMain['cancelSelling'];


				}

				//RATE_DISCOUNT VARIABLES

				//PLCURRENT VARIABLES

				$modified = $date;
				$PL = "";
				$currency = "";
				$discount = "";
				$net = 0;
				$rate = 0;
				$percent = 0;
				$yenPrice = 0;
				$bairitsu = 0;
				$sp_disc_rate_id = "n/a";

				$spResult = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` = '$tformNo'");
				while ($spRow = mysql_fetch_assoc($spResult)){

					$sp_disc_rate_id = $spRow['sp_disc_rate_id'];
					$PL = $spRow['plCurrent'];
					$spResultInner = mysql_query("SELECT * FROM `sp_disc_rate` WHERE `id` = '$sp_disc_rate_id'");
					while ($spRowInner = mysql_fetch_assoc($spResultInner)){
						$currency = $spRowInner['currency'];
						$discount = $spRowInner['discountPar'];
						$net = $spRowInner['discount'] * $PL;
						$rate = $spRowInner['rate'];
						$percent = $spRowInner['percent'];
						$yenPrice = $net * $rate * (1 + ($percent/100));
						if($tformPriceNoTax == 0 AND $yenPrice == 0){
							$bairitsu =  $tformPriceNoTax/$yenPrice;
						} else {
							$bairitsu =  0;
						}
					}
				}

				?>



			<div id='saveWrapper'>
				<div id='calcTopBlock'>
					<div id='calcMainInfo' style=''>

						<span style='margin-left: 10px; '>
							WEB紹介:
						<?php
									if ($web == 1){
										$checked = "checked";
									} else {
										$checked = "";
									}
									?>
									<input style='margin-top: 3px;' type ="checkbox" <?php echo $checked;?>>
						</span>

						<span style='margin-left: 10px;'>
							メーカー廃番:
						<?php
									if ($cancelMaker == 1){
										$checked = "checked";
									} else {
										$checked = "";
									}
									?>
									<input style='margin-top: 3px;' type ="checkbox" <?php echo $checked;?>>
						</span>

						<span style='margin-left: 10px;'>
							Tform廃番:
						<?php
									if ($cancelTform == 1){
										$checked = "checked";
									} else {
										$checked = "";
									}
									?>
									<input style='margin-top: 3px;' type ="checkbox" <?php echo $checked;?>>
						</span>

						<span style='margin-left: 10px;'>
							販売終了:
						<?php
									if ($cancelSelling == 1){
										$checked = "checked";
									} else {
										$checked = "";
									}
									?>
									<input style='margin-top: 3px;' type ="checkbox" <?php echo $checked;?>>
						</span>


						<table border="0">
							<tr>
								<td>更新日:</td>
								<td>
									<div class='toptd'>
									<?php echo $modified;?>
									</div>
								</td>
								<td>PL:</td>
								<td>
									<div class='toptd'>
									<?php echo $PL;?>
									</div>
								</td>
								<td rowspan='8' style='max-width: 200px;'>
									<div style='width: 200px; height: 200px; background-color: #CCC; text-align: center; position: relative;'>
									<?php
									if ($img == '0' || $img == ''){
										echo "<li class='fa fa-picture-o' style='font-size: 80px; color: #FFF; line-height: 200px;'></li>";
									} else {
										$thumRep = str_replace("img/img_phot/photo", "img/img_phot/photo_thum120", $img);
										echo "<img src ='".$filemakerImageLocation.$img."' style='max-width: 200px; max-height: 200px;'>";
									}
									/* CHECK FOR HAIBAN AND SET HAIBAN COLOR */
									if (isHaibanNew($tformNo) == true){
										echo "
										<div style='
										width: 60px;
										height: 35px;
										position: absolute;
										top: 0px;
										right: 0px;
										font-weight: bold;
										z-index: 5;
										color: crimson;
										font-size: 30px;
										line-height: 35px;
										opacity: 0.75;
										'>
										廃番
										</div>
										";
									}
									?>


									</div>
								</td>
							</tr>
							<tr>
								<td>品番:</td>
								<td>
									<div class='toptd'>
									<?php echo $tformNo;?>
									</div>
								</td>
								<td>通貨:</td>
								<td>
									<div class='toptd'>
									<?php echo $currency;?>
									</div>
								</td>
							</tr>
							<tr>
								<td>メーカー品番:</td>
								<td>
									<div class='toptd' title="<?php echo $makerNo;?>">
									<?php echo $makerNo;?>
									</div>
								</td>
								<td>%割引:</td>
								<td>
									<div class='toptd'>
									<?php echo $discount;?>
									</div>
								</td>
							</tr>
							<tr>
								<td>タイプ:</td>
								<td>
									<div class='toptd' title="<?php echo $type;?>">
									<?php echo $type;?>
									</div>
								</td>
								<td>NET(PL):</td>
								<td>
									<div class='toptd'>
									<?php echo number_format($net, 2, '.','');?>
									</div>
								</td>
							</tr>
							<tr>
								<td>メーカー:</td>
								<td>
									<div class='toptd'>
									<?php echo $maker;?>
									</div>
								</td>

								<td>レート:</td>
								<td>
									<div class='toptd'>
									<?php echo $rate;?>
									</div>
								</td>
							</tr>
							<tr>
								<td>シリーズ:</td>
								<td>
									<div class='toptd' title="<?php echo $series;?>">
									<?php echo $series;?>
									</div>
								</td>


								<td>%:</td>
								<td>
									<div class='toptd'>
									<?php echo $percent;?>
									</div>
								</td>

							</tr>

							<tr>
								<td class='topth'>伝票詳細表記:</td>
								<td style='color: red;'>
									<div class='toptd' title="<?php echo $modelMemo;?>">
									<?php echo $modelMemo;?>
									</div>
								</td>

								<td>原価: </td>
								<td>
									<div class='toptd'>
									<?php echo "￥".number_format(truncate($yenPrice, 0), 0, '.',',');?>
									</div>
								</td>

							</tr>
							<tr>
								<td>割引条件ID:</td>
								<td>
								<div class='toptd'>
									<?php echo $sp_disc_rate_id;?>
								</div>
								</td>

								<td>TF価格:</td>
								<td>
									<div class='toptd'>
										<?php echo "￥".number_format($tformPriceNoTax, 0, '.',',');?>
									</div>
								</td>

							</tr>
						</table>
					</div>

					<div id='calcPartOfBlock'>
						入っているセット:
						<?php echo $tformNo;?>

						<table id="partsTable">

							<thead>
								<tr>
									<th style='min-width: 100px;'>TFORM品番</th>
									<th style='max-width: 75px;'>メーカー品番</th>
									<th style='max-width: 75px;'>メーカー</th>
									<th style='max-width: 75px;'>タイプ</th>
								</tr>
							</thead>
							<tbody>
							<?php


							$inSetResult = mysql_query("SELECT * FROM `main` WHERE `set` LIKE '%$tformNo%'");
							while ($inSetRow = mysql_fetch_assoc($inSetResult)){
								$inSetId = $inSetRow['id'];
								$inSetTformNo = $inSetRow['tformNo'];
								$inSetMakerNo = $inSetRow['makerNo'];
								$inSetMaker = $inSetRow['maker'];
								$inSetType = $inSetRow['type'];
								?>
								<tr>
									<td style='text-align: center;'><a href='calculation.php?pr=1&id=<?php echo $inSetId;?>'><?php echo $inSetTformNo; ?> </a></td>
									<td style='max-width: 75px; overflow: hidden; text-align: center;'><?php echo $inSetMakerNo;?></td>
									<td style='text-align: center;'><?php echo $inSetMaker;?></td>
									<td style='text-align: center;'><?php echo $inSetType;?></td>
								</tr>
								<?php 	}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div class='clear'></div>

				<div id='calcSetBlock'>
					< セット部品 >
					<table id="setTable">
						<thead>
							<tr>
								<th>イメージ</th>
								<th>TFORM品番</th>
								<th>メーカー品番</th>
								<th>メーカー</th>
								<th>タイプ</th>
								<th>PL</th>
								<th>%割引</th>
								<th>NET</th>
								<th>原価（円）</th>
							</tr>
						</thead>
						<tbody>
						<?php

						$setTot = 0; // total counter
						$resultSetter = mysql_query("SELECT * FROM `main` WHERE tformNo = '$tformNo' ORDER BY tformNo") or die(mysql_error());
						while ($rowSetter = mysql_fetch_assoc($resultSetter)){
							// IF SET DO THIS ------------------------------------------------------------>

							$array = str_replace(",", " ", $rowSetter['set']);
							$matches = explode(" ", $array);

							/*
							 * CHECK here for any extra items that must be added. (need to check lists)
							 * If contains specialItems then set hasSpecialItems = true and then add to the currentent set list
							 */

							//initialize isSpecial
							$isSpecial = array();

							//initialize matchesArray
							$matchesArray = "";

							//query the makerlist info table to check for special items
							$specialItemsResult = mysql_query("SELECT `tformNo`, `specialItems` FROM `makerlistinfo` WHERE `tformNo` = '$tformNo'");

							//first before anything check if there is actually an item in any list by checking if it is null.
							if (mysql_num_rows($specialItemsResult)){
								while ($specialItemsRow = mysql_fetch_assoc($specialItemsResult)){
									//matchesArray
									$matchesArray = str_replace(",", " ", $specialItemsRow['specialItems']);
									$matchesSpecial = explode(" ", $matchesArray);

									//if single and has a special item, push into the array before the extras!
									if(empty($rowSetter['set'])){
										array_push($matches, $tformNo);
									}

									//push the extra specaial items onto the back of the array
									foreach($matchesSpecial as $var){
										$isSpecial[] = $var;
										array_push($matches, $var);
									}
								}
							}
							// --------------------------------------------------------------

							foreach ($matches as $value){
								if ($value == ''){

								} else {

									// if not in plcurrent query main
									if ($value != '0'){
										$resultInner = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$value'") or die(mysql_error());
									} else {
										$resultInner = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$tformNo'") or die(mysql_error());
									}

									while ($rowInner = mysql_fetch_assoc($resultInner)){

										//PLCURRENT VARIABLES

										$tformPriceNoTax = $rowInner['tformPriceNoTax'];
										$setPL = 0;
										$setCurrency = "";
										$setDiscount = 0;
										$setNet = 0;
										$setRate = 0;
										$setPercent = 0;
										$setYenPrice = 0;
										$NAC = 0;
										//$setBairitsu = 0;
										$sp_disc_rate_id = "n/a";


										$spResult = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` = '$value'");
										while ($spRow = mysql_fetch_assoc($spResult)){

											$sp_disc_rate_id = $spRow['sp_disc_rate_id'];
											$setPL = $spRow['plCurrent'];
											$spResultInner = mysql_query("SELECT * FROM `sp_disc_rate` WHERE `id` = '$sp_disc_rate_id'");
											while ($spRowInner = mysql_fetch_assoc($spResultInner)){
												$setCurrency = $spRowInner['currency'];
												$setDiscount = $spRowInner['discountPar'];
												$setNet = $spRowInner['discount'] * $setPL;
												$setRate = $spRowInner['rate'];
												$setPercent = $spRowInner['percent'];
												if ($setCurrency == "YEN"){
													$setYenPrice = $setPL;
												} else {
													$NAC = $setNet * $setRate * (1 + ($setPercent/100));

													$setYenPrice = truncate($NAC, 0);
												}
											}
										}

										//check if item is special and if so add green ball!
										if(in_array($value, $isSpecial)){
											$specialMarker = "<img title= '特別アイテム' src='../img/bullet_ball_glass_green.png' style='float: right;'>";
										} else {
											$specialMarker = "";
										}

										echo "<tr>";
										echo "<td>";
										echo "<div style='position: relative;'>";
										if ($rowInner['thumb'] == '0' || $rowInner['thumb'] == ''){
											echo "<li class='fa fa-picture-o' style='font-size: 30px; color: #9F9F9F; line-height: 50px;'></li>";
										} else {
											$thumRep = str_replace("img/img_phot/photo", "img/img_phot/photo_thum120", $rowInner['thumb']);
											//$thumbFull = "http://183.177.132.197/db_img/".$thumRep;
											echo "<img src ='".$filemakerImageLocation.$thumRep."' style='width: 50px; height: 50px;'>";
										}
                                  
										/* CHECK FOR HAIBAN AND SET HAIBAN COLOR */
										if (isHaibanNew($rowInner['tformNo']) == true){

										echo "<span style='color: red; position: absolute; top: 0; right: 0; display: block;'> (廃番)</span>";
										}
										echo "</div>";
										echo "</td>";
										echo "<td><a href='calculation.php?pr=1&id=".$rowInner['id']."'>".$rowInner['tformNo']."</a>".$specialMarker;

										echo "</td>";

										// HAIBAN CHECK DONE
										if ($value != '0'){
											$resultType = mysql_query("SELECT * FROM `main` WHERE tformNo = '$value' ORDER BY tformNo") or die(mysql_error());
										} else {
											$resultType = mysql_query("SELECT * FROM `main` WHERE tformNo = '$tformNo' ORDER BY tformNo") or die(mysql_error());
										}
										while ($rowType = mysql_fetch_assoc($resultType)){
											echo "<td >".$rowType['makerNo']."</td>";
											echo "<td >".$rowType['maker']."</td>";
											echo "<td>".$rowType['type']."</td>";
											echo "<td>".$setPL."(".$setCurrency.")</td>";
											echo "<td>".$setDiscount."</td>";
											echo "<td>".number_format($setNet,2,'.','')."</td>";
											echo "<td>￥".number_format($setYenPrice, 0, '',',')."<br>￥".$setRate." / ".$setPercent."%</td>";
											$setTot += truncate($setYenPrice,0);
										}
										echo "</tr>";
									}
								}
							}
						}
						?>
						</tbody>
						<?php
						//set the set bairitsu if set
						if ($topTformPriceNoTax == 0 || $setTot == 0){
							$setBai = "0";
						} else {
							$setBai = number_format($topTformPriceNoTax/$setTot,2);
						}
						?>

					</table>
				<br>
				<span style='float: right;'>原価合計[￥ <?php echo number_format($setTot,0,'',',');?> ] 倍率[ <?php echo $setBai;?> ]</span>
				<br>
				</div>
				<br>
				<br>

				<div id='calcHistBlock'>
				<br>
				<hr>
				<br>
				< 履歴 >
				<?php
				/*
				 * TAB VIEW
				 */
				?>
					<div class='fullBox'>
						<table id="historyTable">
							<thead>
								<tr>
									<th>変更日</th>
									<th>Tform品番</th>
									<th>年</th>
									<th>DR_ID</th>
									<th>PL</th>
									<th>割引条件</th>
									<th>PLNET</th>
									<th>レート</th>
									<th>%</th>
									<th>原価</th>
									<th>Tform価格</th>
									<th>倍率</th>

									<th>履歴削除</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$bairitsuPrev = 0;
							$historyResult = mysql_query("SELECT * FROM `sp_history` WHERE `tformNo` = '$tformNo'");

							while ($historyRow = mysql_fetch_assoc($historyResult)){

								$sp_disc_rate_id = $historyRow['sp_disc_rate_id'];
								// $plCurrent = $historyRow['plCurrent'];
								if ($historyRow['plCurrent'] == 0){
									$plCurrent = 1 ;
								} else {
									$plCurrent = $historyRow['plCurrent'];
								}
								// initalize variables
								$year = 0;
								$discountPar = 0;
								$rate= 0;
								$percent = 0;
								$plusMinus = 0;


								$plNet = 0; // ******
								$yenCost = 0; // ******
								$bairitsu = 0; // ******
								//set variables
								$termsResult = mysql_query("SELECT * FROM `sp_disc_rate` WHERE `id` = '$sp_disc_rate_id'");
								if(mysql_num_rows($termsResult) == false){
									$memo = "メモなし";
								}
								while ($termsRow = mysql_fetch_assoc($termsResult)){

									$year = $termsRow['year'];
									$memo = $termsRow['memo'];

									//prefent division by 0;
									$discountPar = $termsRow['discountPar'];
									$rate = $termsRow['rate'];
									$percent = $termsRow['percent'];

									if($discountPar == 0){
										$discountPar = 1;
									}
									if($rate == 0){
										$rate = 1;
									}
									if($percent == 0){
										$percent = 1;
									}

									$tformPriceNoTax = $historyRow['tformPriceNoTax'];

									$plNet = $termsRow['discount'] * $plCurrent;
									$yenCost = $plNet * $rate * (1 + ($percent/100));

									$bairitsu =  $tformPriceNoTax/$yenCost;
									$plusMinus = $bairitsu - $bairitsuPrev;

									$bairitsuPrev = $bairitsu;


								}
								// end setvariables

								//check if there is memo available


								echo "<tr>";
								echo "<td>".$historyRow['created']."</td>";
								echo "<td>".$historyRow['tformNo']."</td>";
								echo "<td><span title='".$memo."'>".$year."</span></td>";
								echo "<td>".$sp_disc_rate_id."</td>";
								echo "<td>".$historyRow['plCurrent']."</td>";
								echo "<td>".$discountPar."%</td>";
								echo "<td>".number_format($plNet,2,'.','')."</td>";
								echo "<td>".$rate."</td>";
								echo "<td>".$percent."</td>";
								echo "<td>￥".number_format($yenCost,0,'',',')."</td>";
								echo "<td>￥".number_format($tformPriceNoTax,0,'',',')."</td>";
								echo "<td>".number_format($bairitsu,2,'.','')."</td>";

								echo "<td> ";
								?>
								<a href='del/delHistory.php?pr=1&search=<?php echo $search;?>&record=<?php echo $record;?>&historyid=<?php echo $historyRow['id'].$listNavi;?>' onclick="return confirm('履歴削除しますか?')"> <i class='fa fa-times' style='color: red;'></i> </a>
								<?php
								echo "</td>";
								echo "</tr>";

							}
							?>

							</tbody>
						</table>

					</div>


					<?php
					// END OF SEARCH CHECK WRAPPER
			} ?>
					<!-- PAGE CONTENTS END HERE -->
				</div>
			</div>
			<!-- SaveWraper End -->
		</div>
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>
