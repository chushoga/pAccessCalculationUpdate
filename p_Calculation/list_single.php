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
	/*DATATABLES START*/
	var defaultOptions = {
			"bJQueryUI": true,
			"bPaginate": false,
			"bInfo": false,
			"sScrollX" : "100%",
			"iDisplayLength": 100
				};//options
	var calcDataTableHeight = function() {
		// navi: 20px + uiToolbar: 38px + thHeight: 25px + toolBarFooter: 40px; = 123px 
	    var navi = 20;
	    var uiToolbar = 38;
	    var thHeight = 116;
	    var toolBarFooter = 105;
	    var minusResult = navi + uiToolbar + thHeight + toolBarFooter;
	    var h = Math.floor($(window).height() - minusResult);
	    return h + 'px';
	};
	defaultOptions.sScrollY = calcDataTableHeight();
	
	var oTable = $('#listTable').dataTable(defaultOptions);

	 $(window).bind('resize', function () {
		 $('div.dataTables_scrollBody').css('height',calcDataTableHeight());
		oTable.fnAdjustColumnSizing();
	  } );
/*DATATABLES END*/

     $('#loading').delay(300).fadeOut(300);
		} );
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
.R1 {
		background-color: #D0F4F5;;
		height: 40px;
}

.R2 {
		background-color: #C1ED9D;;
		height: 40px;
}

.yearChoice {
		background-color: #F5F2D0;;
		height: 40px;
}

.listEditDetails {
		width: 400px;
		margin: auto;
}
.listEditDetails input{
	width: 60px;
}
.noChange label:hover{
	cursor: hand;
	cursor: pointer;
	text-decoration: none;
}
.noChange a:hover{	
	text-decoration: none;
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
    $setQuery = "SELECT * FROM `makerlistcontents` WHERE `listName` = '$recordId'";
} else {
    //$setQuery = "SELECT * FROM `sp_disc_rate` WHERE `id` LIKE '%$search%' OR `maker` LIKE '%$search%' OR `date` LIKE '%$search%'";
    $setQuery = "SELECT * FROM `makerlistcontents` WHERE `listName` LIKE '%$search%'";
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
$id = 0; // initialize the id;
while ($row = mysql_fetch_assoc($result)){
    $idPass = $row['listName']; //set the recordId
    $id = $row['id'];

    $savFileDate = date ("Y-m-d H:i:s");
    $saveFileProjectName = "価格設定リスト";

    $saveFileName = $saveFileProjectName."_".$savFileDate;

}

//----------------------------------
?>
		<div id='wrapper'>
		<div id='loading'>
    		<span class='loadingGifMain'>
    			<img src='<?php echo $path;?>/img/142.gif'><br>
    			LOADING ...
    		</span>
		</div>
		<?php require_once '../header.php';?>
				<div class='contents'>
						<!-- PAGE CONTENTS START HERE -->
				<?php
				// initalize variables
				$listID = 0; // initialize
				$listName = ""; // initialize
				$plCurrent = 0;
				$plNet = 0;
				$yenPrice = 0;
				$yenPriceTest1 = 0;
				$yenPriceTest2 = 0;
				$bairitsu =  0;
				$bairitsu1 =  0;
				$bairitsu2 =  0;
				$test_bairitsu =  0;
				$test_bairitsu1 =  0;
				$test_bairitsu2 =  0;
				$sp_disc_rate_id = 0;
				$selected = "";
				$rate = "";
				$percent = "";
				$histBai = 0;
				$histYenPrice = "";
				$histRate = "";
				$histPercent = "";
				$histDiscount = "";

				$sp_plcurrentQuery = "";
				$sp_discRateQuery = "";


				//run query
				// get the list data
				$listContentsQuery = mysql_query("SELECT * FROM `makerlistcontents` WHERE `id` = '$id'");
				while ($rowListContentsQuery = mysql_fetch_assoc($listContentsQuery)){
				    $makerName = $rowListContentsQuery['maker'];
				    $listName = $rowListContentsQuery['listName'];
				    $listID = $rowListContentsQuery['id'];
				    $testRate1 = $rowListContentsQuery['testRate1'];
				    $percent1 = $rowListContentsQuery['percent1'];
				    $testRate2 = $rowListContentsQuery['testRate2'];
				    $percent2 = $rowListContentsQuery['percent2'];
				    $testRate3 = $rowListContentsQuery['testRate3'];
				    $percent3 = $rowListContentsQuery['percent3'];
				    $memo = $rowListContentsQuery['memo'];
				    $historyYear = $rowListContentsQuery['historyYear'];

				}
				
				?>

						<div id='statusBar'>
						<?php if ($record <= 0){?>
								<button class='recordCycleBtnDisabled' style='cursor: default;'>◀
								</button>

								<?php }
								else{ ?>
								<button class='recordCycleBtn'
										onClick="location.href='list_single.php?pr=1&record=<?php echo $previous;?>&search=<?php echo $search;?>'">◀
								</button>

								<?php }
								if($iRecord == $iAmount || $searchEmptyCheck2  == 0){

								    ?>
								<button class='recordCycleBtnDisabled' style='cursor: default;'>▶
								</button>

								<?php }
								else { ?>
								<button class='recordCycleBtn'
										onClick="location.href='list_single.php?pr=1&record=<?php echo $next;?>&search=<?php echo $search;?>'">▶
								</button>


								<?php }	?>
								<?php echo $iRecord." of ".$iAmount;
								echo " (search: ".$search.")<br>";
								
								?>
						</div>


						<!-- MAIN TABLE HERE -->

						
								<div style='margin-top: 60px;'>

										<div>
												<form method='post' action='exe/exeSetListDetails.php'
														id='detailsSave'>
														<table class='listEditDetails'>
																<tr class='R1'>
																		<td>レート１</td>
																		<td><input type='text' name='rate1'
																				value='<?php echo $testRate1;?>'></td>
																		<td>パーセント1</td>
																		<td><input type='text' name='percent1'
																				value='<?php echo $percent1;?>'></td>
																</tr>
																<tr class='R2'>
																		<td>レート2</td>
																		<td><input type='text' name='rate2'
																				value='<?php echo $testRate2;?>'></td>
																		<td>パーセント2</td>
																		<td><input type='text' name='percent2'
																				value='<?php echo $percent2;?>'></td>
																</tr>
														</table>
														<input type="hidden" name='listName'
																value='<?php echo $listName;?>'>
												</form>
												

										</div>
						<div id='saveWrapper'>
										<div style='width: 100%;'>
												<table style='width: 100%; border-spacing: 0px;'>
														<tr>	
															
															<td style='width: 20%; text-align: left;'><?php echo $listName;?> [ <?php echo $listID;?> ] </td>
															
															<td style='text-align: right;' class='noChange'>
    															<a href='list_setDetails.php?pr=1&id=<?php echo $idPass;?>'>
        															<label style='
    																			background-color: #757575; 
    																			color: white; 
    																			padding-left: 6px; 
    																			padding-right: 6px; 
    																			padding-top: 1px; 
    																			height: 100%;
																			'>
        																<i class="fa fa-list"></i> セット内容情報 
        															</label>
    															</a>
															</td>
																
														</tr>
												</table>
										</div>
										<table id="listTable" style='font-size: 10px;'>
												<thead>
														<tr>
																<th style='min-width: 60px;'>イメージ</th>
																<th>シリーズ</th>
																<th style='min-width: 100px;'>Tform品番</th>
																<th style='width: 20px;'>is廃番</th>
																<th style='width: 20px;'>廃番<i class='fa fa-check-square-o'></i> </th>
																<th>メーカー品番</th>
																<th>set</th>
																<th style='background-color: #F5F2D0;'>前のPL</th>
																<th style='background-color: #F5F2D0;'>値上率</th>
																<th>PL</th>
																<th>plNET 工事出し</th>
																<th>NET合計</th>
																
																
																<th style='background-color: #F5D0D0;'>原価</th>
																<th style='background-color: #D0F4F5;'>原価<br> ￥<?php echo $testRate1;?><br> +<?php echo $percent1;?>%</th>
																<th style='background-color: #C1ED9D;'>原価<br> ￥<?php echo $testRate2;?><br> +<?php echo $percent2;?>%</th>
																<th style='background-color: #F5D0D0;'>倍率</th>
																<th style='background-color: #D0F4F5;'>倍率<br> ￥<?php echo $testRate1;?><br> +<?php echo $percent1;?>%</th>
																<th style='background-color: #C1ED9D;'>倍率<br> ￥<?php echo $testRate2;?><br> +<?php echo $percent2;?>%</th>
																<th>価格(税別)</th>
																<th>備考</th>
														</tr>
												</thead>
												<tbody>

												<?php
												// First query to get the maker list info
												
												$listInfoQuery = mysql_query("SELECT * FROM `makerlistinfo` WHERE `listName` = '$listName'");
												$check = "";
												while ($rowListInfoQuery = mysql_fetch_assoc($listInfoQuery)){
												    $listTformNo = $rowListInfoQuery['tformNo'];
												    $testPrice = $rowListInfoQuery['testPrice'];
												    // main
												    $setHinbanArray[] = "";
												    $i = 0;
												    $setExplode ="";
												    $check = $rowListInfoQuery['haiban'];
												    if($check == 1){
												        $checked = "<span style='color: green; font-size: 14px;'><i class='fa fa-check-square-o'></i></span> ";
												    } else {
												        $checked = "<span style='color: red; font-size: 14px;'><i class='fa fa-square-o'></i></span> ";
												    }
												    
												    $mainQuery = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$listTformNo'");
												    while ($rowMainQuery = mysql_fetch_assoc($mainQuery)){
												        $isHaiban = $rowMainQuery['memo'];
												        $getHaiban = "";
												        $mainId = $rowMainQuery['id'];
												        $img = $rowMainQuery['img'];
												        $maker = $rowMainQuery['maker'];
												        $makerNo = $rowMainQuery['makerNo'];
												        $tformPriceNoTax = $rowMainQuery['tformPriceNoTax'];
												        $series = $rowMainQuery['series'];
												        $set = $rowMainQuery['set'];
												        
												        if(strchr($isHaiban, '廃番')==true){
												            $getHaiban = "廃番";
												        } else {
												            $getHaiban = "";
												        }
												        if (empty($rowMainQuery['set'])){
												            $isSet = '×';
												            $setExplode = "";
												            
												        } else {
												            $setExplode = preg_split('/[\ \n\,]+/', $rowMainQuery['set']);
												            
												            $isSet = "<span style='color: red;'>セット</span>";
												            
												        }
												    }
												    $plCurrentQuery = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` = '$listTformNo'");
												 if (mysql_num_rows($plCurrentQuery)){
												  while ($rowPlCurrent = mysql_fetch_assoc($plCurrentQuery)){
												       
												        $plCurrent = $rowPlCurrent['plCurrent'];

												        $sp_disc_rate_id = $rowPlCurrent['sp_disc_rate_id'];
												        
												     if ($plCurrent == 0 OR $plCurrent == ''){
												            $plNet = 0;
												            $yenPrice = 0;
												            $yenPriceTest1 = 0;
												            $yenPriceTest2 = 0;
												            $bairitsu =  0;
												            $bairitsu1 =  0;
												            $bairitsu2 =  0;
												            $test_bairitsu =  0;
												            $test_bairitsu1 =  0;
												            $test_bairitsu2 =  0;
												        }
												    }
												        } else {
												            $plCurrent = 0;
												            $plNet = 0;
												            $yenPrice = 0;
												            $yenPriceTest1 = 0;
												            $yenPriceTest2 = 0;
												            $bairitsu =  0;
												            $bairitsu1 =  0;
												            $bairitsu2 =  0;
												            $test_bairitsu =  0;
												            $test_bairitsu1 =  0;
												            $test_bairitsu2 =  0;
												        }
												   
												    

												    // sp_disc_rate
												    $sp_disc_rateQuery = mysql_query("SELECT * FROM `sp_disc_rate` WHERE `id` = '$sp_disc_rate_id'");
												    while ($rowSp_disc_rate = mysql_fetch_assoc($sp_disc_rateQuery)){
												        $year = $rowSp_disc_rate['year'];
												        $netTerm = $rowSp_disc_rate['netTerm'];
												        $currency = $rowSp_disc_rate['currency'];
												        $created = $rowSp_disc_rate['created'];
												        $modified = $rowSp_disc_rate['modified'];
												        $rate = $rowSp_disc_rate['rate'];
												        $percent = $rowSp_disc_rate['percent'];
												        $discount = $rowSp_disc_rate['discount'];
												        $discountPar = $rowSp_disc_rate['discountPar'];

												        // calculated variables
												       
											            $plNet = $plCurrent * $discount;
											            $yenPricePre = $plNet * $rate * (1 + ($percent/100));
											            
											            if ($currency == "YEN"){
											                $yenPrice = $plCurrent;
											                $yenPricePre1 = $plCurrent;
											                $yenPricePre2 = $plCurrent;
											            } else {
    											            $yenPrice = intval($yenPricePre);
    											            $yenPricePre1 = $plNet * $testRate1 * (1 + ($percent1/100));
    											            $yenPricePre2 = $plNet * $testRate2 * (1 + ($percent2/100));
											            
											            }
											            if($yenPrice == 0){
    											            $bairitsu =  0;
    											            $test_bairitsu =  0;
											            }else {
    											            $bairitsu =  $tformPriceNoTax/$yenPrice;
    											            $test_bairitsu =  $testPrice/$yenPrice;
											            }
											            $yenPriceTest1 = intval($yenPricePre1);
											            $yenPriceTest2 = intval($yenPricePre2);
											            
											            if ($tformPriceNoTax == 0 || $yenPriceTest1 == 0){
											                $bairitsu1 = 0;
											                $test_bairitsu1 = 0;
											            } else {
											                $bairitsu1 =  $tformPriceNoTax/$yenPriceTest1;
											                $test_bairitsu1 =  $testPrice/$yenPriceTest1;
											            }
												        if ($tformPriceNoTax == 0 || $yenPriceTest2 == 0){
											                $bairitsu2 = 0;
											                $test_bairitsu2 = 0;
											            } else {
											                $bairitsu2 =  $tformPriceNoTax/$yenPriceTest2;
											                $test_bairitsu2 =  $testPrice/$yenPriceTest2;
											            }
												    }
												    
												   /*
												    * SET HISTORY DETAILS
												    */
												    
                                		        	$historyResult = mysql_query("SELECT * FROM `sp_history` WHERE `tformNo` = '$listTformNo' ORDER BY `id` DESC LIMIT 1, 1");
												    $histPL = 0;
                                		        	
                                		        	while ($historyRow = mysql_fetch_assoc($historyResult)){
                                		        	    $histPL = $historyRow['plCurrent'];
                                		        	    $histPlDiscRateId = $historyRow['sp_disc_rate_id'];
                                		        	    $histResult = mysql_query("SELECT * FROM `sp_disc_rate` WHERE `id` = '$histPlDiscRateId'");
                                		        	    while ($histRow = mysql_fetch_assoc($histResult)){
                                		        	     $histRate = $histRow['rate'];
                                		        	     $histPercent = $histRow['percent'];
                                		        	     $histDiscount = $histRow['discount'];
                                		        	    }
                                		        	     $histPlNet = $histPL * $histDiscount;
                                		        	     $histYenPrice = $histPlNet * $histRate * (1 + ($histPercent/100));
                                		        	    if ($histPL == 0){
                                		        	       $histBai = 0; 
                                		        	    } else {
                                		        	    $histBai = $tformPriceNoTax/$histYenPrice;
                                		        	    //$histBai = 1;
                                		        	    }
                                		        	 }
                                		        	 if ($testPrice != 0){
                                		        	     $color = "red";
                                		        	 } else {
                                		        	     $color = "#FFF";
                                		        	 }
												    
                                		        	 /*
                                		        	  * IF SET DO THIS CODE ELSE DO SET CODE
                                		        	  */
                                		        	  if($set != ""){
                                		        	
													         	echo "<tr>";
																
																echo "<td>"; 
												   
																echo "<div class='listImg'>";
																if($img != ""){
																    //echo "<img src='http://www.tform.co.jp/$img' style='max-width: 45px; max-height: 45px;'>";
																    $thumRep = str_replace("img/img_phot/photo", "img/img_phot/photo_thum060", $img);
																    echo "<img src ='http://www.tform.co.jp/".$thumRep."' style='max-width: 45px; max-height: 45px;'>";
																} else {
																    echo "<li class='fa fa-picture-o' style='font-size: 40px; color: #CCC;'></li>";
																}
																echo "</div>";
																echo "</td>";
																echo "<td>".$series."</td>";
																echo "<td>".$listTformNo."</td>";
																// IS HAIBAN //
																echo "<td style='color: red;'>".$getHaiban;
																echo "</td>";
																if ($plCurrent == 0 && $getHaiban != "廃番"){
																echo "<td style='color: orange;'>"; 
																echo $checked;
																echo "</td>";
																} else {
																 echo "<td></td>";
																}
																echo "</td>";
																
																// **********************************************************
																echo "<td style='width: 90px; max-width: 90px; overflow: hidden;'>"; 
																$setXP0 = preg_replace('/\s+/', '',$set);
																$setXP = explode(",", $setXP0);
																foreach ($setXP as $key => $value){
																    $setXPQuery = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$value'");
																    while($setXPResult = mysql_fetch_assoc($setXPQuery)){
																       echo $setXPResult['makerNo']."<br>";
																    }
																}
																
																echo "</td>";
																//----------------------------------------------------------
																//**********************************************************
																// ** HAIBAN BLOCK **
																// ************* INDEPENDENT CAN MOVE **********************
																// HAIBAN BLOCK //
																
																echo "<td>";
										                        if($setExplode != false){
									    					        foreach ($setExplode as $k => $val){
									    					            //query to check if haiban
									    					           
												                
												                $resultInnerCheck = mysql_query("SELECT `memo` FROM `main` WHERE `tformNo` = '$val'");
								    					        while($rowInnerCheck = mysql_fetch_assoc($resultInnerCheck)){
												                    if(strchr($rowInnerCheck['memo'], '廃番')==true){
												                        echo "<span style='color: orange;'>";
												                        echo $val;
												                        echo " 廃番";
												                        echo "</span>";
												                    } else {
												                        echo $val;
												                    }
											                    echo "<br>";
												                }
									    					        }
																}
																echo "</td>";
																
															//HISTORY DETAILS
															echo "<td>".$histPL."</td>";
															echo "<td>".number_format($histBai,2, '.','')."%</td>";
															//------------------------------------------------------------
																
															//---------------------------------
																
																
																// SET PL CURRENT PER SET ITEM
																echo "<td>";
																$setPlNet = 0;
																$setPlCurrentTot = 0;
																$setPlNetTot = 0;
																foreach ($setXP as $key => $value){
																    
																    $setXPQuery = mysql_query("SELECT * FROM `sp_plCurrent` WHERE `tformNo` = '$value'");
																    if(mysql_num_rows($setXPQuery)>0){
																      
																    while($setXPResult = mysql_fetch_assoc($setXPQuery)){
																      
																       echo $setXPResult['plCurrent']."<br>";
																       $setPlCurrentTot0 = $setXPResult['plCurrent'];
																       $setPlCurrentTot += $setXPResult['plCurrent'];
																       $setId = $setXPResult['sp_disc_rate_id'];
																    }
																    if ($setId != 0){
    																    $setDiscQuery = mysql_query("SELECT * FROM `sp_disc_rate` WHERE `id` = '$setId'");
    																    while($setDiscResult = mysql_fetch_assoc($setDiscQuery)){
    																        $setDiscount = $setDiscResult['discount'];
    																        $setDiscountAmount[]=$setPlCurrentTot0*$setDiscount;
    																    }
																    } else {
																        $setDiscountAmount[]=0;
																    }
																    
																         
																       } else {
																       $setPlCurrentTot0 = 0;
																       $setPlCurrentTot += 0;
																       $setDiscountAmount[]=0;
																           echo "0<br>";
																       }
																}
																
																//$setPlNet[] = $setPlCurrentTot * $setDiscount;
																
																
																echo "<td>";
																foreach ($setDiscountAmount as $k1){
																echo truncate($k1, 2)."<br>";
																
																$setPlNetTot += truncate($k1, 2);
																}
																unset($setDiscountAmount);
																echo "</td>";
																
																//---------------------
																//echo $plCurrent;
																//echo "<td>";
																//echo $setPlNetTot;
																//echo "</td>";
																
																//total NET PRICE including set!
																echo "<td>";
																//echo $setPlCurrentTot;
																echo $setPlNetTot;
																echo "</td>";
																//------------------------------
																
																
																
																// ----------------------------------------------------------
																
																
																//------------------------------------------------------------
																
																
																echo "<td>￥".number_format($yenPrice, 0, ' ', ',')."<br>";
																echo "<span style='color: #7D7D7D';>￥".$rate."/".$percent."%</span>";
																echo "</td>";
																echo "<td>￥".number_format($yenPriceTest1, 0, ' ', ',')."<br>";
																echo "<td>￥".number_format($yenPriceTest2, 0, ' ', ',')."<br>";
																echo "<td><span style='color: ".$color."';>".number_format($test_bairitsu, 2, '.', '')."</span>";
																echo "<br><span style='color: #7D7D7D';>".number_format($bairitsu, 2, '.', '');
																echo "</span></td>";
																echo "<td><span style='color: ".$color."';>".number_format($test_bairitsu1, 2, '.', '')."</span>";
																echo "<br><span style='color: #7D7D7D';>".number_format($bairitsu1, 2, '.', '');
																echo "</span></td>";
																echo "<td><span style='color: ".$color."';>".number_format($test_bairitsu2, 2, '.', '')."</span>";
																echo "<br><span style='color: #7D7D7D';>".number_format($bairitsu2, 2, '.', '');
																echo "</span></td>";
																echo "<td><span style='color: ".$color."';>￥".number_format($testPrice, 0, ' ', ',')."</span><br>";
																echo "		<span style='color: #7D7D7D';>￥".number_format($tformPriceNoTax, 0, ' ', ',');
																echo "</span></td>";
																echo "<td>".$memo."</td>";
																echo "</tr>";
                                		        	  } else {
													 /*
                                		        	  * IF SINGLE DO THIS CODE
                                		        	  */
                                		        	      
                                		        	      
																
												         	echo "<tr>";
															
															echo "<td>"; 
															echo "<div class='listImg'>";
															if($img != ""){
															    //echo "<img src='http://www.tform.co.jp/$img' style='max-width: 45px; max-height: 45px;'>";
															    $thumRep = str_replace("img/img_phot/photo", "img/img_phot/photo_thum060", $img);
															    echo "<img src ='http://www.tform.co.jp/".$thumRep."' style='max-width: 45px; max-height: 45px;'>";
															} else {
															    echo "<li class='fa fa-picture-o' style='font-size: 40px; color: #CCC;'></li>";
															}
															echo "</div>";
															echo "</td>";
															echo "<td>".$series."</td>";
															echo "<td>".$listTformNo."</td>";
                                		        	  echo "<td style='color: red;'>".$getHaiban;
															echo "</td>";
															
															if ($plCurrent == 0 && $getHaiban != "廃番"){
															echo "<td style='color: orange;'>"; 
															echo $checked;
															echo "</td>";
															} else {
															 echo "<td></td>";
															}
															
															
															echo "<td style='width: 90px; max-width: 90px; overflow: hidden;'>".$makerNo."</td>";
															echo "<td>";
															echo "x";
															echo "</td>";
															//HISTORY DETAILS
																echo "<td>".$histPL."</td>";
																echo "<td>".number_format($histBai,2, '.','')."%</td>";
																//------------------------------------------------------------
															echo "<td>".$plCurrent."</td>";
															echo "<td>".number_format($plNet, 2, '.',' ')."</td>";
															
															//total NET PRICE including set!
																echo "<td>";
																echo number_format($plNet, 2, '.',' ');
																echo "</td>";
																//------------------------------
															
															//echo "</td>";
															
															echo "<td>￥".number_format($yenPrice, 0, ' ', ',')."<br>";
															echo "<span style='color: #7D7D7D';>￥".$rate."/".$percent."%</span>";
															echo "</td>";
															echo "<td>￥".number_format($yenPriceTest1, 0, ' ', ',')."<br>";
															echo "<td>￥".number_format($yenPriceTest2, 0, ' ', ',')."<br>";
															echo "<td><span style='color: ".$color."';>".number_format($test_bairitsu, 2, '.', '')."</span>";
															echo "<br><span style='color: #7D7D7D';>".number_format($bairitsu, 2, '.', '');
															echo "</span></td>";
															echo "<td><span style='color: ".$color."';>".number_format($test_bairitsu1, 2, '.', '')."</span>";
															echo "<br><span style='color: #7D7D7D';>".number_format($bairitsu1, 2, '.', '');
															echo "</span></td>";
															echo "<td><span style='color: ".$color."';>".number_format($test_bairitsu2, 2, '.', '')."</span>";
															echo "<br><span style='color: #7D7D7D';>".number_format($bairitsu2, 2, '.', '');
															echo "</span></td>";
															echo "<td><span style='color: ".$color."';>￥".number_format($testPrice, 0, ' ', ',')."</span><br>";
															echo "		<span style='color: #7D7D7D';>￥".number_format($tformPriceNoTax, 0, ' ', ',');
															echo "</span></td>";
															echo "<td>".$memo."</td>";
															echo "</tr>";
                                		        	  }
												}?>
												</tbody>
										</table>
								</div>
						</div>
						<!-- SAVE WRAPER END -->

						<!-- PAGE CONTENTS END HERE -->
				</div>
		</div>
		<?php require_once '../master/footer.php';?>
</body>
</html>
