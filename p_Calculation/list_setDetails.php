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
	    var thHeight = 65;
	    var toolBarFooter = 0;
	    var minusResult = navi + uiToolbar + thHeight + toolBarFooter;
	    var h = Math.floor($(window).height() - minusResult);
	    return h + 'px';
	};
	defaultOptions.sScrollY = calcDataTableHeight();
	
	var oTable = $('#listTable').dataTable(defaultOptions);
	var oTable = $('#listTable2').dataTable(defaultOptions);

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
.boxLeft {
	width: 75%;
	float: left;
}
.boxRight{
	width: 25%;
	float: left;
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

						<!-- MAIN TABLE HERE -->

						
								<div style='margin-top: 0px;'>

						<div id='saveWrapper'>
										<div style='width: 100%;'> 
												<table style='width: 100%;'>
														<tr>	
																<td style='width: 20%; text-align: left;'><?php echo $listName;?> [ <?php echo $listID;?> ]</td>
																<td style='text-align: right;'><a href='javascript:history.go(-1)'>リストへ戻る <i class="fa fa-list-alt"></i></a></td>
														</tr>
												</table>
										</div>
										<div class='boxLeft'>
										<table id="listTable" style='font-size: 10px;'>
												<thead>
														<tr>
																<th style='min-width: 200px;'>Tform品番</th>
																<th>set内容</th>
																<th>メーカー品番</th>
																<th>PL</th>
																<th>廃番</th>
																<th>セット合計</th>
																<th>シリーズ</th>
																<th>セット</th>
																
														</tr>
												</thead>
												<tbody>

												<?php
												$listInfoQuery = mysql_query("SELECT * FROM `makerlistinfo` WHERE `listName` = '$listName'");
												while ($rowListInfoQuery = mysql_fetch_assoc($listInfoQuery)){
												    $listTformNo = $rowListInfoQuery['tformNo'];
												    $testPrice = $rowListInfoQuery['testPrice'];

												    // main
												    $mainQuery = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$listTformNo'");
												    while ($rowMainQuery = mysql_fetch_assoc($mainQuery)){
												        $img = $rowMainQuery['img'];
												        $maker = $rowMainQuery['maker'];
												        $makerNo = $rowMainQuery['makerNo'];
												        $tformPriceNoTax = $rowMainQuery['tformPriceNoTax'];
												        $series = $rowMainQuery['series'];
												        if (empty($rowMainQuery['set'])){
												            $isSet = '×';
												            $isSetCheck = 0;
												        } else {
												            $isSet = "<span style='color: red;'>セット</span>";
												            $isSetCheck = 1;
												        }
												    }
												    // sp_plcurrent
												    $plCurrentQuery = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` = '$listTformNo'");
												    while ($rowPlCurrent = mysql_fetch_assoc($plCurrentQuery)){
												        $plCurrent = $rowPlCurrent['plCurrent'];

												        $sp_disc_rate_id = $rowPlCurrent['sp_disc_rate_id'];
												        
												     if ($plCurrent == 0){
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
											            
											            if ($currency == 'YEN'){
											               $yenPricePre =  $plCurrent; 
											               $yenPricePre1 = $plCurrent;
											               $yenPricePre2 = $plCurrent;
											            } else {
											               $yenPricePre = $plNet * $rate * (1 + ($percent/100)); 
											               $yenPricePre1 = $plNet * $testRate1 * (1 + ($percent1/100));
											               $yenPricePre2 = $plNet * $testRate2 * (1 + ($percent2/100));
											               
											               
											            }
											            
											            
											            $yenPrice = intval($yenPricePre);
											            $bairitsu =  $tformPriceNoTax/$yenPrice;
											            $test_bairitsu =  $testPrice/$yenPrice;
											           
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
                                		        	
                                		        	while ($historyRow = mysql_fetch_assoc($historyResult)){
                                		        	    $histPL = $historyRow['plCurrent'];
                                		        	    if ($histBai == 0 || $histPL == 0){
                                		        	       $histBai = 0; 
                                		        	    } else {
                                		        	    $histBai = (($plCurrent/$histPL)-1)*100;
                                		        	    }
                                		        	 }
                                		        	 if ($testPrice != 0){
                                		        	     $color = "red";
                                		        	 } else {
                                		        	     $color = "#FFF";
                                		        	 }
												    ?>
														<tr>
																<!-- <td><i class='fa fa-picture-o' style='font-size: 80px; color: #FFF;'></i></td>-->
																
																<td style='text-align: center;'><?php echo $listTformNo;?></td>
																<td style='text-align: center;'><?php 
																if ($isSetCheck == '1'){
																$setContentsQuery = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$listTformNo'");
																while ($setContentsRow = mysql_fetch_assoc($setContentsQuery)){
																    $array1  = str_replace(",", " ", $setContentsRow['set']);
																    $matches1 = explode(" ", $array1);
																    foreach ($matches1 as $value){
																        if ($value != ""){
																     //query value for a pricelist
																     $setContentsPLQuery = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` = '$value'");
																         if (mysql_num_rows($setContentsPLQuery) == 0){
																            echo "<span style='color: red;'>";
																            $setContentsArray[] = $value;
																            $plArray[] = "PL無し";
																         } else {
																             while ($setContentsPLRow = mysql_fetch_assoc($setContentsPLQuery)){
																                 //echo "<span>[ ".$setContentsPLRow['plCurrent']." ] ";
																                 $plArray[] = $setContentsPLRow['plCurrent'];
																              }
																         }
																     echo $value."</span>";
																     $setContentsDetailsQuery = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$value'");
																    while ($setContentsDetailsRow = mysql_fetch_assoc($setContentsDetailsQuery)){
																        $makerNoContents = $setContentsDetailsRow['makerNo'];
																        $makerNoHaiban = $setContentsDetailsRow['memo'];
																     if(strpos($makerNoHaiban, '廃番') == true ){
                                								            $memoHai = "廃番";
                                    								    } else {
                                    								        $memoHai = "";
                                    								    }
																    }
																     //echo " ( ".$makerNoContents." )";
																     $makerNoArray[] = $makerNoContents;
																     $makerNoHaibanArray[] = $memoHai;
																     echo "<br>";
																        } else {
																        }
																    }
																    //echo $setContentsRow['set'];
																}
																} else {
																    
																}
																?></td>
																<td style='text-align: center;'><?php
																//print_r($makerNoArray);
																if (isset($makerNoArray) == true){
																    foreach ($makerNoArray as $value){
																        if ($value != ""){
																            
																            
																            echo $value;
																            echo "<br>";
																        }
																        }
																unset($makerNoArray);
																}
																?></td>
																<td style='text-align: center;'><?php
																$setTotal = 0;
																//print_r($plArray);
																if (isset($plArray) == true){
																    foreach ($plArray as $value){
																        if ($value != ""){
																        if($value == "PL無し"){
																                $colorCheck = "red";
																            } else {
																                $colorCheck = "green";
																            }
																            echo "<span style='color: ".$colorCheck."'>";
																            echo $value;
																            echo "</span><br>";
																            if ($value != "PL無し"){
																             $setTotal += $value;
																            }
																        }
																        }
																unset($plArray);
																}
																?>
																</td>
																<td style='text-align: center;'>
																<?php
																if (isset($makerNoHaibanArray) == true){
																foreach ($makerNoHaibanArray as $value){
																        if ($value != ""){
																        if($value == "廃番"){
																                $colorCheck = "red";
																            } else {
																                $colorCheck = "green";
																            }
																            echo "<span style='color: ".$colorCheck."'>";
																            echo $value;
																            echo "</span><br>";
																        } else {
																            echo "<br>";
																        }
																}
																unset($makerNoHaibanArray);
																}
																?>
																</td>
																<td style='text-align: center;'><?php echo $setTotal;?></td>
																<td style='text-align: center;'><?php echo $series;?></td>
																
																<td style='text-align: center;'><?php echo $isSet;?></td>
																
																
														</tr>
														<?php }?>
												</tbody>
										</table>
										</div>
										<div class='boxRight'>
										<table id="listTable2" style='font-size: 10px;'>
												<thead>
														<tr>	
																<th>No.</th>
																<th>unique品番</th>
																<th>メーカー品番</th>
																<th>価格</th>
														</tr>
												</thead>
												<tbody>
												
												<?php 
										$counter = 1;
										if (isset($setContentsArray) == true){
										$setContentsResult = array_unique($setContentsArray);
										foreach ($setContentsResult as $value){
										    $makerNoIs = "";
										    $resultMakerNo = mysql_query("SELECT `makerNo`, `memo` FROM `main` WHERE `tformNo` = '$value'");
										    while ($rowMakerNo = mysql_fetch_assoc($resultMakerNo)){
										        $makerNoIs = $rowMakerNo['makerNo'];
										        $makerHaiban = $rowMakerNo['memo'];
										    }
										echo "<tr>";
										echo "<td style='width: 40px; text-align:center;'>".$counter."</td>";
										echo "<td style='text-align: center;'>";
										echo $value;
										echo "</td>";
										echo "<td>";
										echo $makerNoIs;
										echo "</td>";
										
										if(strpos($makerHaiban, '廃番') == true ){
    								        
    								        echo "<td>";
									        echo "廃番";
    								        echo "</td>";
        								    } else {
        								        echo "<td>";
										        echo "</td>";
        								    }
									    
										
										echo "</tr>";
										$counter++;
										}
										}
										    
										?>
												</tbody>
												</table>
											</div>
										
								</div>
						</div>
						<!-- SAVE WRAPER END -->

						<!-- PAGE CONTENTS END HERE -->
				</div>
		</div>
		<?php require_once '../master/footer.php';?>
</body>
</html>
