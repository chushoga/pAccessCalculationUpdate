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
	$('.table_id').dataTable( {
		"columnDefs": [
		               {
		                   "targets": [ 0 ],
		                   "visible": false,
		                   "searchable": true
		               }
		           ],
		"bJQueryUI": true,
		"bPaginate": false,
		"bFilter": false,
		"bInfo": false
	});
	$(function() {
	    $(window).on('resize', function() {	      
	      $('#quickFit1').quickfit({ max: 12, min: 6, truncate: true });
	      $('#quickFit2').quickfit({ max: 12, min: 6, truncate: true });
	      $('#quickFit3').quickfit({ max: 12, min: 6, truncate: true });
	    });
	    $(window).trigger('resize');    
	  });
	$('#loading').delay(300).fadeOut(300);
		} );
</script>
<style type="text/css">
.table_id {
	font-size: 10px;
}

.table_id td {
	text-align: center;
}

@media print {
	#navi,.logo,.editBar,#statusBar,.footer  * {
		display: none !important;
	}
	.sheetWrapper {
		font-size: 12px;
	}
	.sheetTopBox1forwarderBottom {
		font-size: 10px;
	}
	p.breakhere {
		page-break-after: always;
	}
	.orderContents {
		margin-top: 0px;
	}
}

.ui-corner-all,.ui-corner-bottom,.ui-corner-right,.ui-corner-br {
	border-radius: 0px;
}

.ui-corner-all,.ui-corner-top,.ui-corner-right,.ui-corner-tr {
	border-radius: 0px;
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
</style>
</head>
<body>
<?php
//variables
// make sure $page always = something
$memoOrder = "";
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
if (isset($_GET['id'])){
	$recordId = $_GET['id'];
	$setQuery = "SELECT * FROM `expense` WHERE `id` = '$recordId'";
} else {
	for($j=1;$j<11;$j++){
		$searchArray[] = " OR `orderNo_$j` LIKE '%$search%' ";
	}
	$searchArrayImp = implode(' ', $searchArray);
	$setQuery = "SELECT * FROM `expense` WHERE `id` LIKE '%$search%' OR `forwarder` LIKE '%$search%' OR `date` LIKE '%$search%' $searchArrayImp";
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
$result = mysql_query("$setQuery ORDER BY ID ASC LIMIT $record, 1");
$idPass = 0; // initialize the record Id

while ($row = mysql_fetch_assoc($result)){
	$idPass = $row['id']; //set the recordId
	$id = $row['id'];
	if ($row['date'] == ""){
		$saveFileDate = 1;
	} else {
		$savFileDate = $row['date'];
	}
	if ($row['id'] == ""){
		$saveFileProjectName = "tformProject";
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
				<button class='recordCycleBtn' onClick="location.href='expense.php?pr=3&record=<?php echo $previous;?>&search=<?php echo $search;?>'">◀</button>

				<?php }
				if($iRecord == $iAmount || $searchEmptyCheck2  == 0){

					?>
				<button class='recordCycleBtnDisabled' style='cursor: default;'>▶</button>

				<?php }
				else { ?>
				<button class='recordCycleBtn' onClick="location.href='expense.php?pr=3&record=<?php echo $next;?>&search=<?php echo $search;?>'">▶</button>


				<?php }	?>
				<?php echo $iRecord." of ".$iAmount;
				echo " (search: ".$search.")<br>";
				?>
			</div>
			<?php //CHECK HERE IF NO FILES FOUND THEN DONT SHOW....
			if ($searchEmptyCheck2 != 0){

				?>
			<div class='orderContents'>
			<?php
			/////////////////////////////////////////////////////////////////////////////
			/////////////////////////////// SET VARIABLES ///////////////////////////////
			/////////////////////////////////////////////////////////////////////////////

			// set the number of differnt variables
			// loop 10 times
			//SET LOOP TIMES
			$l=10;
			//

			$topAmountSub = 0;
			$topRateSub = 0;

			$divide = 0;

			$topMakerTotal = $topAmountSub + $topRateSub;
			// ------------------------------------

			//$id = $_GET['id'];


			//-----------------------------------------------------------------------------
			$resultSetter = mysql_query("SELECT * FROM expense WHERE `id` = '$id' ") or die(mysql_error());
			while ($rowSetter = mysql_fetch_assoc($resultSetter)){
				for ($i = 1; $i<=$l; $i++) {
					//echo $orderNo_[$i];
					if ($rowSetter['orderNo_'.$i] == ' ' ){
						$orderNo_[$i] = 0;
						$makerName_[$i] = 0;
						$currency1_[$i] = 0;
						$currency2_[$i] = 0;
						$rate_[$i] = 0;
					} else {
						$orderNo_[$i] = $rowSetter['orderNo_'.$i];
						$makerName_[$i] = $rowSetter['makerName_'.$i];
						$currency1_[$i] = $rowSetter['currency1_'.$i];
						$currency2_[$i] = $rowSetter['currency2_'.$i];
						$rate_[$i] = $rowSetter['rate_'.$i];
					}

					$orderNo = "orderNo_$i";
					$makerName = "makerName_$i";
					$currency1 = "currency1_$i";
					$currency2 = "currency2_$i";
					$rate = "rate_$i";

					//----------------------------------------------------------------------------
					if ($rate_[$i] != '' ){
						// top sub total -------------
						$topSubTotal_[$i] = $currency2_[$i] * $rate_[$i];
					} else {
						// top sub total -------------
						$topSubTotal_[$i] = $currency2_[$i];
					}

					$topAmountSub += $currency2_[$i];
					$topRateSub += $rate_[$i];
					// set amount of times to divide to get the rateSubtotal
					if( $rate_[$i] != '') {
						$divide++;
					}
					//-----------------------------------------------------

				}
			}
			//---------------------------------------------------------------------------
			// SAVED CODE

			$resultVar = mysql_query("SELECT * FROM expense WHERE `id` = '$id' ") or die(mysql_error());
			while ($rowVar = mysql_fetch_assoc($resultVar)){
					
				$jpRate = $rowVar['jpRate'];
					
				$date = date ('Y.m.d', strtotime($rowVar['date']));
				$forwarder = $rowVar['forwarder'];
				$vessle = $rowVar['vessle'];
				$packing = $rowVar['packing'];

				if ($rowVar['bankChargeTotal'] == ''){
					$bankCharge = $rowVar['bankCharge'];
					$bankChargeTimes = $rowVar['bankChargeTimes'];
					$bankChargeTotal = $bankCharge * $bankChargeTimes;
				} else {
					$bankCharge = $rowVar['bankCharge'];
					$bankChargeTimes = $rowVar['bankChargeTimes'];
					$bankChargeTotal = $rowVar['bankChargeTotal'];
				}
				if ($rowVar['shippingChargeTotal'] == ''){
					$shippingCharge = $rowVar['shippingCharge'];
					$shippingChargeTimes = $rowVar['shippingChargeTimes'];
					$shippingChargeTotal = $shippingCharge * $shippingChargeTimes;
				} else {
					$shippingCharge = $rowVar['shippingCharge'];
					$shippingChargeTimes = $rowVar['shippingChargeTimes'];
					$shippingChargeTotal = $rowVar['shippingChargeTotal'];
				}
				$shippingTotal = $rowVar['shippingTotal'];
				$insuranceTotal = $rowVar['insuranceTotal'];
				$clearanceTotal = $rowVar['clearanceTotal'];
				$inspectionTotal = $rowVar['inspectionTotal'];
				$customsTotal = $rowVar['customsTotal'];
				$inlandShippingTotal = $rowVar['inlandShippingTotal'];
				$otherTotal = $rowVar['otherTotal'];
				$taxTotal = $rowVar['taxTotal'];
				$consumptionTaxTotal = "";

				if($taxTotal == 0){
					$consumptionTaxTotal = ($customsTotal+$inlandShippingTotal+$otherTotal)*$jpRate;
				} else {
					$consumptionTaxTotal = $taxTotal;
				}


				$tarrifTotal = $rowVar['tarrifTotal'];
				$memo = $rowVar['memo'];
				//$preConsumptionTotal = $rowVar['consumptionTotal'] - $consumptionTaxTotal;
				//$consumptionTotal = $rowVar['consumptionTotal'];
				$preConsumptionTotal = $rowVar['consumptionTotal'];
				$consumptionTotal = $rowVar['consumptionTotal'] + intval($consumptionTaxTotal);

			}
			//bottom total -----------
			$bottomTotal =
			$bankChargeTotal +
			$shippingTotal +
			$shippingChargeTotal +
			$insuranceTotal +
			$clearanceTotal +
			$customsTotal +
			$inspectionTotal +
			$inlandShippingTotal +
			$otherTotal +
			$tarrifTotal;
			// -------------------------
			//$C = (($consumptionTotal)/$z)*100;
			//---------------------------------


			?>


				<!-- DATA START -->
				<div class="fullBox">

					<div class='clear'></div>
					<div id='saveWrapper'>
						<div class='sheetWrapper'>
							<div class='tax'>
								消費税
								<?php echo $jpRate*100;?>
								%
							</div>
							<div class='sheetTop'>
								<div class='sheetTopBox1dateWrapper'>
									<div class='sheetTopBox1dateTop'>入荷日</div>
									<div class='sheetTopBox1dateBottom'>
									<?php echo $date;?>
									</div>
								</div>
								<div class='sheetTopBox1forwarderWrapper'>
									<div class='sheetTopBox1forwarderTop'>フォワーダー</div>
									<div class='sheetTopBox1forwarderBottom' id='quickFit1'>
									<?php echo $forwarder;?>
									</div>
								</div>
								<div class='sheetTopBox1VesPackWrapper'>
									<div class='sheetTopBox1VesPackTop'>Vessel</div>
									<div class='sheetTopBox1VesPackBottom' id='quickFit2'>
									<?php echo $vessle;?>
									</div>
								</div>
								<div class='sheetTopBox1VesPackWrapper'>
									<div class='sheetTopBox1VesPackTop' style='border-right: 1px solid #CCC;''>梱包/コンテナー</div>
									<div class='sheetTopBox1VesPackBottom' style='border-right: 1px solid #CCC;' id='quickFit3'>
									<?php echo $packing;?>
									</div>
								</div>
								<div class='clear'></div>
								<div class='sheetTopBox2'>
									<br>
									<p>＜ メーカー別商品代金 ＞</p>

									<br>
									<table class='sheetTable1'>
										<thead>
											<tr>
												<th>オーダーNo.</th>
												<th>メーカー名</th>
												<th>外貨代金</th>
												<th>為替レート</th>
												<th style='border-right: none;'>商品代金（￥）</th>
											</tr>
										</thead>
										<?php
										$maker = "1";
										$makerCheck = "1";
										$subtot = 0;
										$subMaker = "";
										$subtotRate = 0;
										$subtotRateCounter = 0;
										$d = 0;
										$alltot = 0;
										$z = 0;
										$k = 0;
										$q = 0;
										$count = 0;
										$subDivideArray[] = "";

										for ($i = 1; $i<=$l; $i++) {


											$orderNo = "orderNo_$i";
											$result = mysql_query("SELECT * FROM expense WHERE `id` = '$id' ") or die(mysql_error());
											while ($row = mysql_fetch_assoc($result)){
													

												if ($orderNo_[$i] != ''){
													$topSubTotalTest = $row['currency2_'.$i] * $row['rate_'.$i];
													$makerCheck = $row['makerName_'.$i];


													if ($maker != $makerCheck && $maker != '1'){
														if ($q == 1){
															// IF BLOCK +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

															echo "<tr><td colspan='5' style='height: 10px;'></td></tr>";
															// ---------------------------------------------------------------------------------------------
															$subtot = 0;
															$subMaker = "";
															$subtotRate = 0;
															$subtotRateCounter = 0;
															$d = 0;
															$z += $subtotAll;
															$k = 0;
															$q = 0;

															echo "
        																		<tbody>
        																				<tr>
        																						<td style='border-left: none;'>".$row['orderNo_'.$i]."</td>
        																						<td>".$row['makerName_'.$i]."</td>
        																						<td>".$row['currency1_'.$i]." ".number_format($row['currency2_'.$i], 2, '.',',')."</td>
        																						<td >".$row['rate_'.$i]."</td>
        																						<td style='font-size: 10px; text-align: right; border-right: none;'>￥
        																						".number_format(intval($topSubTotalTest), 0, '.', ',')."</td>
        																						
        																				</tr>
        																		</tbody>
        																		";
															

															$d++;
															$q++;
															$k += intval($topSubTotalTest);
															// IF BLOCK +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


														}else{
															// IF BLOCK +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

															echo "<tbody>
                                                                                <tr>
                                                                                <td style='border-left: none;'></td>
                                                                                <td><b>".$subMaker." Total/AV </b></td>
                                                                                <td><b>";
															//FIRST CHECK HERE TO SEE IF ALL THE rates are the same:
															
															$subtotRateDiv = truncate(($subtotAll / $subtot), 2); //IF STATEMENT HERE ********
															
															//print_r($subDivideArray);
															$makerSingleArray[$subMaker] = $subtotRateDiv;
															$makerToArray[] = "";
															echo number_format($subtot, 2, '.',',');
															echo "</b></td><td><b>";
															echo $subtotRateDiv;


															// HERE IS SUBTOTAL
															echo "</b></td><td style='color: green; font-weight: bold; text-align: right; border-right: none;'>￥";
															echo number_format($subtotAll, 0, '.',',');
                                                                                "</td>
                                                                                </tr>
																				</tbody>";
															echo "<tr><td colspan='5' style='height: 10px;'></td></tr>";

															//TOTAL HERE TO ADD TO COUNTER ARRAY
															/*
															* ADD TO All ARRAY
															*/
															$orderNoTempArrayImplode = implode(",", $orderNoTempArray);

															$totArray [] = array("orderNo" => $orderNoTempArrayImplode, "maker" => $row['makerName_'.$i], "rate" => $subtotRateDiv);
															unset($orderNoTempArray);
															//----------------------------

															// ---------------------------------------------------------------------------------------------
															$subtot = 0;
															$subMaker = "";
															$subtotRate = 0;
															$subtotRateCounter = 0;
															$d = 0;
															$z += $subtotAll;
															$k = 0;
															$q = 0;
															echo "
        																		<tbody>
        																				<tr>
        																						<td style='border-left: none;'>".$row['orderNo_'.$i]."</td>
        																						<td>".$row['makerName_'.$i]."</td>
        																						<td>".$row['currency1_'.$i]." ".number_format($row['currency2_'.$i], 2, '.',',')."</td>
        																						<td >".$row['rate_'.$i]."</td>
        																						<td style='font-size: 10px; text-align: right; border-right: none;'>￥
        																						
        																						".number_format(intval($topSubTotalTest), 0, '.', ',')."</td>
        																						
        																				</tr>
        																		</tbody>
        																		";
															
															$d++;
															$q++;
															$k += intval($topSubTotalTest);
															// IF BLOCK +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


														}

													} else {
														// HERE IS THE PROBLEM
														echo "
        																		<tbody>
        																				<tr>
        																						<td style='border-left: none;'>".$row['orderNo_'.$i]."</td>
        																						<td>".$row['makerName_'.$i]."</td>
        																						<td>".$row['currency1_'.$i]." ".number_format($row['currency2_'.$i], 2, '.',',')."</td>
        																						<td >".$row['rate_'.$i]."</td>
        																						<td style='font-size: 10px; text-align: right; border-right: none;'>￥
        																						
        																						".number_format(intval($topSubTotalTest), 0, '.', ',')."</td>
        																				</tr>
        																		</tbody>
        																		";
														// PROBLEM END
														
														$d++;
														$q++;
														$k += intval($topSubTotalTest);
														
													}
													// CHECK IF MAKER IS THE SAME AND ECHO OUT THE SUBTOTAL ROW IF THEY ARE NOT


													//--------------------------------------------------------------------------


												}
												
												$maker = $row['makerName_'.$i];
												$subtot += $row['currency2_'.$i];
												if ($maker != ''){
													$subMaker = $row['makerName_'.$i];
												}

												$subtotRate += $row['rate_'.$i];
												$subtotRateCounter++;

													


												if ($k == 0){

													$subtotAll = 0;
													$subtotRateDiv = 0;

												} else {
													$subtotAll = $k;

													/*
													 * PUT IF HERE TO CONTROL IF THERE THERE IS $subtotRateDiv!!!!!!
													 */
													$subtotRateCheckArray [] = "";
													$orderNumberFixed = "";


													// echo "[ ".$row['orderNo_'.$i]." ]";
													if(in_array($row['orderNo_'.$i], $subDivideArray)){
													
															
														$subtotRateDiv = truncate(($subtotAll / $subtot), 2); // PLACE IFF STAMEENT HERE*******************
														
													
														
														$subtotRateCheckArray [] = $orderNumberFixed;
														//echo $orderNumberFixed."<= A";
													} else {
														//echo $row['orderNo_'.$i]."<= B";
														$orderNumberFixed = $row['orderNo_'.$i];

														$subtotRateDiv = $row['rate_'.$i]; //ADD TO ARRAY CHECK HERE *******************
														
														
														
														
														/*
														 * ADD TO All ARRAY
														 * if maker name is not the same then add to single array!!
														 */
															
														$allArray [] = array("orderNo" => $row['orderNo_'.$i], "maker" => $maker, "rate" => $row['rate_'.$i]);
															
													}
													
												}
												

												//check to clear orderNoTempArray
												// echo "<br>";

													
													
												if (isset($makerNoTempArray) && in_array($maker, $makerNoTempArray)){
													// echo "MAKER ALREADY SET";
													$makerMoreThanOneArray[] = $maker;
												} else {
													//$makerSingleArrray [] = $maker;
												}
												$makerNoTempArray[] = $maker;
													
												$orderNoTempArray[] = $row['orderNo_'.$i];
												//end check
													
												//echo $row['rate_'.$i];
												//echo " - ".$subtotRateCounter;
												// echo "--";
												//echo $subtotRateDiv."| ".$orderNumberFixed."<br><hr><br>";

												if(!in_array($orderNumberFixed, $subtotRateCheckArray)){
													//    echo "[ ".$orderNumberFixed." IN ARRAY BOTTOM]";
													$subtotRateDiv = $row['rate_'.$i]; //ADD TO ARRAY CHECK HERE *******************
													
													
													
												}
												//echo "<".$subtotRateDiv."><br><hr><br>";
												
												$subDivideArray [$orderNumberFixed] =  $subtotRateDiv;
												//echo $row['orderNo_'.$i]." - ";
												// echo $subtotRateDiv."<br><hr><br>";
												//-----------------------------------

													


											}
										}
										//echo $subMaker."-----<";

										if($q != 1){
											echo "<tbody>
                                                                        <tr>
                                                                        <td style='border-left: none;'></td>
                                                                        <td><b>$subMaker Total/AV</b></td>
                                                                        <td><b>";
											// print_r($subDivideArray);
											$makerSingleArray[$subMaker] = $subtotRateDiv;



											echo number_format($subtot, 2, '.',',');
											echo "</b></td><td><b>";
											echo $subtotRateDiv;
											
											

											//add to totals
											//$totalsArray[] = array("total" => $subtotRateDiv, "maker" => $maker);
											//

											echo "</b></td><td style='color: green; font-weight: bold; text-align: right; border-right: none;'>￥";
											echo number_format($subtotAll, 0, '.',',');

                                                                        "</td>
                                                                        </tr>
    																	</tbody>";
											//TOTAL HERE TO ADD TO COUNTER ARRAY
											/*
											* ADD TO All ARRAY
											*/

											$orderNoTempArrayImplode = implode(",", $orderNoTempArray);

											$totArray [] = array("orderNo" => $orderNoTempArrayImplode, "maker" => $maker, "rate" => $subtotRateDiv);
											unset($orderNoTempArray);
											
											//----------------------------

										} else {

										}


										// adds the subtotals

										$z += $subtotAll;
										//-------------------
										if ($k == 0){
											$C = 0;
										} else {
											$C = (($consumptionTotal)/$z)*100;
										}
										//---------------------------------

										?>

									</table>
									<br>
									<div class='sheetTopTotal'>
										<p>
											合計 (A) <span class='greenText'>￥<?php echo number_format($z, 0, '.',',');?> </span>
										</p>
										<hr>
										<p>
											経費 (B/A) <span style='font-weight: 700;'><?php 
											if ($k == 0){
												$BA = 0;
											} else {
												$BA = ($bottomTotal/$z)*100;
											}
											echo number_format($BA, 2, '.',',');
											?>% </span>
										</p>
										<hr style='margin-right: 0'>
										<br>
										<p>
										<?php echo number_format($BA + $C, 2, '.',',');?>
											% 税込
										</p>
									</div>
								</div>
							</div>
							<?php
							/*
							 echo "<h3>Total ARRAY</h3>";

							 foreach ($totArray as $keyTot){
							 echo $keyTot['orderNo'];
							 echo " : ";
							 echo $keyTot['maker'];
							 echo " : ";
							 echo $keyTot['rate'];
							 echo "<br>";

							 }
							 */

							/*
							 * TEST START
							 */
							/*
							 echo "<br><hr>****<hr><br>";
							 //print_r($AllArray);
							 echo "<h3>All ARRAY</h3>";
							 foreach ($allArray as $keyAll){
							 	
							 echo $keyAll['orderNo'];
							 echo " : ";
							 echo $keyAll['maker'];
							 echo " : ";
							 echo $keyAll['rate'];
							 echo "<br>";

							 }
							 */
							//	echo "<br><hr>****<hr><br>";
							/*
							* TEST END
							*/
							//print_r($totalsArray);
							/**
							echo "<br><hr><br>";
							echo "makerSingleArr";
							print_r($makerSingleArray);
							echo "<br><hr><br>";
							*/
							?>

							<div class='sheetBottom'>
								<br>
								<p>＜ 経費 ＞</p>
								<br>
								<table class='sheetTable2'>
									<thead>
										<tr>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>銀行手数料</td>
											<td class='aRight'>￥<?php echo number_format($bankCharge, 0, '.', ',');?>
											</td>
											<td class='aRight'><?php echo $bankChargeTimes;?>
											</td>
											<td class='aRight'>￥<?php echo number_format(intval($bankChargeTotal), 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td>運賃</td>
											<td class='aRight'></td>
											<td class='aRight'></td>
											<td class='aRight'>￥<?php echo number_format($shippingTotal, 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td>運賃 (外貨)</td>
											<td class='aRight'><?php echo number_format($shippingCharge, 2, '.', ',');?>
											</td>
											<td class='aRight'><?php echo $shippingChargeTimes;?>
											</td>
											<td class='aRight'>￥<?php echo number_format(intval($shippingChargeTotal), 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td>保険料</td>
											<td></td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($insuranceTotal, 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td>customs clearance fee</td>
											<td>(非課税)</td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($clearanceTotal, 0, '.', ',');?>
											</td>
										</tr>
										<?php // ADD LINE HERE ---------?>
										<tr>
											<td>検査,その他</td>
											<td>(非課税)</td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($inspectionTotal, 0, '.', ',');?>
											</td>
										</tr>
										<?php // ADD LINE HERE DONE---------?>
										<tr>
											<td>通関手数料</td>
											<td>(課税)</td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($customsTotal, 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td>国内運賃</td>
											<td>(課税)</td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($inlandShippingTotal, 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td>蔵出料,検査,その他</td>
											<td>(課税)</td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($otherTotal, 0, '.', ',');?>
											</td>
										</tr>

										<tr>
											<td>関税</td>
											<td></td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($tarrifTotal, 0, '.', ',');?>
											</td>
										</tr>
									</tbody>
								</table>

								<br>＜ メモ ＞<br>
								<?php echo $memo;?>
								<div class='sheetBottomTotal'>
									<p>
										経費合計 (B) <span class='greenText'>￥<?php echo number_format($bottomTotal, 0, '.', ',');?> </span>
									</p>
									<hr>
								</div>
								<table class='sheetTable2'>
									<thead>
										<tr>
											<th></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td></td>
											<td class='aRight'>消費税 (<?php echo $jpRate*100; echo "%";?>) ￥<?php echo number_format(intval($consumptionTaxTotal), 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td></td>
											<td class='aRight'>輸入消費税 ￥<?php echo number_format($preConsumptionTotal, 0, '.', ',');?>
											</td>
										
										
										<tr>
											<td></td>
											<td class='aRight'><span style='text-align: left;'>合計輸入消費税(C) </span><span class='greenText'>￥<?php echo number_format($consumptionTotal, 0, '.', ',');?> </span></td>
										</tr>
										<tr>
											<td style='border: none;'></td>
											<td class='aRight' style='border: none;'>(C)/(A)=<?php 
											if ($k == 0){
												$C = 0;
											} else {
												$C = (($consumptionTotal)/$z)*100;
											}
											echo number_format($C, 2, '.',',')
											?>%</td>
										</tr>

									</tbody>
								</table>

							</div>
							<!-- sheetBottom END -->
						</div>
						<!-- sheetWrapper END -->
					</div>
					<!-- saveWrapper END -->
				</div>
				<!-- fullBox END -->

				<p class="breakhere">
					<br>
				</p>



				<div class="fullBox">
					<br>
					<div class='sheetWrapper'>

					<?php
					//print_r($subDivideArray);
					//echo "<br><br>";
					// DEFAULT VALUE FOR $PRICE
					$price = '';
					$BotTot = 0;

					// PUT THE ORDER NUMS INTO AN ARRAY
					$result = mysql_query("SELECT * FROM expense WHERE `id` = '$id'") or die(mysql_error());
					while ($row = mysql_fetch_assoc($result)){
						unset($temp);

						for($a = 1; $a <= $l; $a++){
							$temp[] = $row['orderNo_'.$a];
							//$makerTemp[] = array("orderNo" => $row['orderNo_'.$a], "makerName" =>$row['makerName_'.$a]);
							$makerTemp[$row['orderNo_'.$a]] = $row['makerName_'.$a];
						}
						// print_r($makerTemp);
						$orderArray = array_unique($temp);
						foreach ($orderArray as $value => $key){

							if ($key != ''){
								//echo $key." ";

								// ---------------------------------
								// PRINT TITLE
								/*******************************************************************************
								* Work STARTS HERE TO MATCH UP THE CORRECT RATE WITH THE CORRECT ORDER NUMBER *
								*******************************************************************************
								*/
								/*
								 echo "Maker Single Array: ";
								 print_r($makerSingleArray);
								 echo "<hr><br> All Orders Array: ";
								 print_r($allArray);
								 echo "<hr><br>";
								 */

								foreach ($allArray as $value1){
									// echo $key." <--key<br>";
									//echo $value1['maker']." | orderNo: ".$value1['orderNo']." = ".$key." | ".$value1['rate']."<br>";

									if ($value1['orderNo'] == $key){
										// echo $value1['maker']." | orderNo: ".$value1['orderNo']." = ".$key." | ".$value1['rate']."<br>";
										// add the search options and matching options here
										// set the current Maker

										//

										// echo $value1['maker'];
										multi_array_search($value1['maker'], $allArray)? $found = true : $found = false;
										//echo $found."<br>";
										if ($found == true){

											if (isset($makerSingleArray)){
												// echo "is set";
													
												foreach ($makerSingleArray as $value2 => $key2){

													// echo "(".$value2.") ".$key2." | ".$value1['maker']."<br>";
													if ($value1['maker'] == $value2){
														$subtotRateDiv1 = $key2;
													} else {
														$subtotRateDiv1 = $value1['rate'];
													}
												}

											} else {
												$subtotRateDiv1 = $value1['rate'];
											}

										} else {

											// |||||||||||||||||||||||||||||||||||||||||||||||||

											$subtotRateDiv1 = $value1['rate']; // if the value = the key then use this rate... (this is the default for selecting rate)
										}
									} else {
										//backup test else
										//$subtotRateDiv1 = $value1['rate'];
									}
								}

								/*********************************************************************************
								 * Work FINISHES HERE TO MATCH UP THE CORRECT RATE WITH THE CORRECT ORDER NUMBER *
								 *********************************************************************************
								 */
								$result = mysql_query("SELECT * FROM `order_memo` WHERE `orderNo` = '$key'");
								$memoOrder = "";
								while ($row = mysql_fetch_assoc($result)){
									$memoOrder = $row['memo'];
								}
								$result = mysql_query("SELECT `date`, `orderNo` FROM `order` WHERE `orderNo` = '$key' LIMIT 1");
								while ($row = mysql_fetch_assoc($result)){
									echo "<a href='../p_Order/order.php?pr=4&orderNo=".$row['orderNo']."'>オーダーNo. ".$row['orderNo']."</a>";
									echo " [ レート: ".$subtotRateDiv1." ]";

									//echo " | ".$subtotRateDiv1; // shows the rate used by the order: if there is a double maker it takes the total rate and if single it takes single rate.
									echo "<span style='float: right; clear: both;'>入荷日: ".$row['date']."</span>";
									echo "<br>";
									echo $memoOrder;
								}
								// ----------------------------------------------------------------------------------------
								// GET CURRENCY TYPE
								$resultCurr = mysql_query("SELECT DISTINCT `currency` FROM `order` WHERE `orderNo` = '$key'");
								while ($rowCurr = mysql_fetch_assoc($resultCurr)){
									$price = $rowCurr['currency'];
								}
								// GET KAWASE RATE
								/*
								$resultCurr = mysql_query("SELECT * FROM `expense` WHERE `orderNo` = '$key'");
								while ($rowCurr = mysql_fetch_assoc($resultCurr)){
								$price = $rowCurr['currency'];
								}
								*/
									
								// ----------------------------------------------------------------------------------------
								echo "
								<table class='table_id'>
								<thead>
								<tr>
									<th>HID</th>
									<th>メーカー品番</th>
									<th style='max-width: 90px;'>tform品番</th>
									<th style='min-width: 50px;'>数量</th>
									<th>(".$price.")PRICE</th>
									<th style='min-width: 50px;'>掛率</th>
									<th>NET</th>
									<th style='min-width: 70px;'>仕入単価</th>
									<th style='min-width: 70px;'>最終単価</th>
								</tr>
								</thead>
								<tbody>
								";
								$result = mysql_query("SELECT * FROM `order` WHERE `orderNo` = '$key'");
								while ($row = mysql_fetch_assoc($result)){

									$net = ($row['discount'] / 100)*$row['priceList'];
									//$tester = 1212133;
									// echo $net."[ ".truncate2($net,2)." ] ".truncate($net, 2). "|| ".$tester."[ ".truncate2($tester,2)." ] ".truncate($tester, 2)."<br>";


									$netTrunc = truncate($net, 2);
									$tan1 = intval($netTrunc * $subtotRateDiv1);
									$tan2 = intval($tan1 *(1+($BA/100)));
									//echo $subtotRateDiv1."<br>";
									echo "<tr>
								<td>".$row['id']."</td>	
								<td>".$row['makerNo']."</td>
								<td>".$row['tformNo']."</td>
								<td>".$row['quantity']."</td>";
									//-----------------------------------------
									// QUERY TO RUN GET THE PRICELIST, DISCOUNT
									//-----------------------------------------
									/*
									$sql = mysql_query("SELECT * FROM `order` WHERE `orderNo` = '$orderNoArray'");
									while ($get = mysql_fetch_assoc($sql)){
									$get[''];
									}
									*/
									echo "
								<td>".number_format($row['priceList'],2, '.', ',')."</td>
								<td>".$row['discount']."</td>
								<td>".number_format(sprintf('%01.2f', $netTrunc),2, '.',',')."</td>
								
								<td>￥".number_format($tan1, 0, '.',',')."</td>
								<td>￥".number_format($tan2, 0, '.',',')."</td>
								";
									$finalUnitPrice = intval($tan2);
									$tformNo = $row['tformNo'];
									$makerNo = $row['makerNo'];

									// QUERY HERE TO UPDATE THE order table with the finalUnitPrice
									$sql = mysql_query("UPDATE `order`
						        			SET 
						        				`finalUnitPrice` = '$finalUnitPrice' 
					        				WHERE 
					        					`orderNo` = '$key' 
				        					&& `tformNo` = '$tformNo'
				        					&& `makerNo` = '$makerNo'
				        					");
									// QUERY END HERE
									echo "</tr>";
									//---------------------------------------
									//FOR THE CHECK ON THE BOTTOM
									$BotTotTemp = $row['quantity']*intval($tan2);
									$BotTot += $BotTotTemp;
									//---------------------------------------
								}
									
								echo "
								</tbody>
								</table>
								";
								echo "<br>";

							}
						}
					}
					// ADD UP AND SEE IF THERE IS DIFFERENCE IN THE TOTAL
					// $BotTotTemp = $row['quantity']*$tan2;
					//$BotTot =+ $BotTotTemp
					//$z - $BotTot
					//---------------------------------------------------
					if(($z+$bottomTotal) - $BotTot < 0){
						$col = "red";
					}else{
						$col = "green";
					}

					echo "<div style='width: 100%; height: 30px; line-height: 30px; text-align: right;'>";
					echo "合計 (A+B) ￥".number_format(($z+$bottomTotal),0, '.',',')." - 最終単価合計  ￥".number_format($BotTot,0,'.',',')." = ";
					echo "<span style='color: $col'>￥".number_format(($z+$bottomTotal) - $BotTot, 0, '.',',')."</span>";
					echo "(";
					echo number_format(((($z+$bottomTotal) - $BotTot)/($z+$bottomTotal))*100, 2, '.',',');
					echo "%)";
					echo "</div>";

					?>
					</div>
				</div>
			</div>
			<?php
			// END OF SEARCH CHECK WRAPPER
			} ?>
			<!-- PAGE CONTENTS END HERE -->
		</div>
	</div>
	<?php require_once '../master/footer.php';?>
</body>

</html>
