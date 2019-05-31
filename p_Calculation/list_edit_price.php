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
	    var uiToolbar = 35;
	    var thHeight = 100;
	    var toolBarFooter = 0;
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

     $('#listSave').bind("keyup keypress", function(e) {
		  var code = e.keyCode || e.which; 
		  if (code  == 13) {               
		    e.preventDefault();
		    return false;
		  }
		});
		$(function() {
			e = $.Event('keyup');
			e.keyCode= 82; // press r key to refresh Cap Sensative
			$('input').trigger(e);
		})

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

.listEditDetails {
		width: 400px;
		margin: auto;
}
.listEditDetails input{
	width: 60px;
}



.listImg {
		background-color: none;
		height: 45px;
		width: 45px;
		overflow: hidden;
		margin: auto;
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
		width: 45px;
		float: right;
		overflow: hidden;
		line-height: 45px;
		text-align: right;
		margin-right: 5px;
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
    $search = "NULL";
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
				$sp_disc_rate_id = 0;
				$selected = "";
				$rate = "";
				$percent = "";


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

						<div id='saveWrapper'>
								<div style='margin-top: 20px;'>
								<input type="button" value="保存せずに終了"
														style='float: right; padding: 2px; margin-right: 5px;'
														class='cancelBtn'
														onClick="location.href='list_single.php?pr=1&id=<?php echo $idPass;?>'">

										
										<div>
												<table>
														<tr>
																<td><?php echo $listName;?></td>
																<td>[ <?php echo $listID;?> ]</td>
														</tr>
												</table>
										</div>
										<form method='post' action='exe/exeSetListPrice.php' id='listSave'>
										<table id="listTable" style='font-size: 10px;'>
												<thead>
														<tr>
																<th style='min-width: 60px;'>イメージ</th>
																<th style='min-width: 100px;'>Tform品番</th>
																<th>メーカー品番</th>
																<th>シリーズ</th>
																<th>PL</th>
																<th>plNET 工事出し</th>
																<th>set</th>
																<th>is廃番</th>
																<th>廃番 <i class='fa fa-check-square-o'></i></th>
																<th style='background-color: #F5F2D0;'>前のPL</th>
																<th style='background-color: #F5F2D0;'>値上率</th>
																<th style='background-color: #F5D0D0;'>原価</th>
																<th style='background-color: #D0F4F5;'>原価<br> ￥<?php echo $testRate1;?><br> +<?php echo $percent1;?>%</th>
																<th style='background-color: #C1ED9D;'>原価<br> ￥<?php echo $testRate2;?><br> +<?php echo $percent2;?>%</th>
																
																<th style='background-color: #F5D0D0;'>倍率</th>
																<th style='background-color: #D0F4F5;'>倍率<br> ￥<?php echo $testRate1;?><br> +<?php echo $percent1;?>%</th>
																<th style='background-color: #C1ED9D;'>倍率<br> ￥<?php echo $testRate2;?><br> +<?php echo $percent2;?>%</th>
																<th>価格(税別)</th>
																
														</tr>
												</thead>
												<tbody>

												<?php
												$t = 1;
                        						$s = 1;
                        						$r = 1;
                        						$u = 1;
                        						$tab = -1;
                        						$checked = "";
												$listInfoQuery = mysql_query("SELECT * FROM `makerlistinfo` WHERE `listName` = '$listName'");
												while ($rowListInfoQuery = mysql_fetch_assoc($listInfoQuery)){
												    $listTformNo = $rowListInfoQuery['tformNo'];
												    $testPrice = $rowListInfoQuery['testPrice'];
												    $listTformNoId = $rowListInfoQuery['id'];
												    $check = $rowListInfoQuery['haiban'];
												    
												    if($check == 1){
												        $checked = "checked";
												    } else {
												        $checked = "";
												    }

												    // main
												    $mainQuery = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$listTformNo'");
												    while ($rowMainQuery = mysql_fetch_assoc($mainQuery)){
												        $isHaiban = $rowMainQuery['memo'];
												        $getHaiban = "";
												        $img = $rowMainQuery['img'];
												        $maker = $rowMainQuery['maker'];
												        $makerNo = $rowMainQuery['makerNo'];
												        $tformPriceNoTax = $rowMainQuery['tformPriceNoTax'];
												        $series = $rowMainQuery['series'];
												     
												        if(strchr($isHaiban, '廃番')==true){
												            $getHaiban = "廃番";
												        } else {
												            $getHaiban = "";
												        }
												        
												        if (empty($rowMainQuery['set'])){
												            $isSet = '×';
												        } else {
												            $isSet = "<span style='color: red;'>セット</span>";
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
											            $yenPricePre = $plNet * $rate * (1 + ($percent/100));
											            $yenPrice = intval($yenPricePre);
											            $bairitsu =  $tformPriceNoTax/$yenPrice;
											            $yenPricePre1 = $plNet * $testRate1 * (1 + ($percent1/100));
											            $yenPricePre2 = $plNet * $testRate2 * (1 + ($percent2/100));
											            $yenPriceTest1 = intval($yenPricePre1);
											            $yenPriceTest2 = intval($yenPricePre2);
											            
											            if ($tformPriceNoTax == 0 || $yenPriceTest1 == 0){
											                $bairitsu1 = 0;
											            } else {
											                $bairitsu1 =  $tformPriceNoTax/$yenPriceTest1;
											            }
												        if ($tformPriceNoTax == 0 || $yenPriceTest2 == 0){
											                $bairitsu2 = 0;
											            } else {
											                $bairitsu2 =  $tformPriceNoTax/$yenPriceTest2;
											            }
												    }
												    
												    

												    ?>
														<tr>
																<!-- <td><i class='fa fa-picture-o' style='font-size: 80px; color: #FFF;'></i></td>-->
																<td><?php 
																echo "<div class='listImg'>";
																if($img != ""){
																    //echo "<img src='http://www.tform.co.jp/$img' style='max-width: 45px; max-height: 45px;'>";
																    $thumRep = str_replace("img/img_phot/photo", "img/img_phot/photo_thum060", $img);
																    echo "<img src ='http://www.tform.co.jp/".$thumRep."' style='max-width: 45px; max-height: 45px;'>";
																} else {
																    echo "<li class='fa fa-picture-o' style='font-size: 40px; color: #CCC;'></li>";
																}
																echo "</div>";
																?>
																</td>
																<td><?php echo $listTformNo;?></td>
																<td><?php echo $makerNo;?></td>
																<td><?php echo $series;?></td>
																<td><?php echo $plCurrent;?></td>
																<td><?php echo number_format($plNet, 2, '.',' ');?></td>
																<td><?php echo $isSet;?></td>
																<?php 
																echo "<td style='color: red;'>".$getHaiban;
																echo "</td>";
																?>
																<td>
																<input type ="hidden" name ='<?php echo "haiban_".$listTformNoId;?>' value='0'>
																<input type='checkbox' name='<?php echo "haiban_".$listTformNoId;?>' value='1' tabindex="<?php echo $tab;?>" <?php echo $checked;?>></td>
																<td>NOT SET</td>
																<td>NOT SET</td>
																<td>￥<?php echo number_format($yenPrice, 0, ' ', ',');?><br>
																<?php echo "<span style='color: #7D7D7D';>￥".$rate."/".$percent."%</span>";?>
																</td>
																<td>￥<?php echo number_format($yenPriceTest1, 0, ' ', ',');?><br>
																<td>￥<?php echo number_format($yenPriceTest2, 0, ' ', ',');?><br>
																
																<td>
																<?php 
																$cost1 = $yenPriceTest1;
																$cost2 = $yenPriceTest2;
																$cost3 = $yenPrice;
																echo "<input type='hidden' class='costA".$s."' value='$cost1'>";// hidden calc variables
						                            			echo "<input type='hidden' class='costB".$r."' value='$cost2'>"; //hidden calc variables
						                            			echo "<input type='hidden' class='costC".$u."' value='$cost3'>"; //hidden calc variables
						                            			
						                            			echo "<input type='text' class='outputValC".$u."' value='' style='max-width: 100px; background-color: transparent; text-align: center; border: 0px; color: green; font-size: 16px;' tabindex=".$tab.">";
						                            			echo number_format($bairitsu, 2, '.', '');
						                            			//$tab++;
						                            			?>
																</td>
																<td>
																<?php echo "<input type='text' class='outputValA".$s."' value='' style='max-width: 100px; background-color: transparent; text-align: center; border: 0px; color: green; font-size: 16px;' tabindex=".$tab.">";?>
																<?php echo number_format($bairitsu1, 2, '.', '');
																//$tab++;
																?>
																</td>
																<td>
																<?php echo "<input type='text' class='outputValB".$r."' value='' style='max-width: 100px; background-color: transparent; text-align: center; border: 0px; color: green; font-size: 16px;' tabindex=".$tab.">";?>
																<?php echo number_format($bairitsu2, 2, '.', '');
																//$tab++;
																?>
																</td>
																<td style='min-width: 100px'>￥<input type='text' name='<?php echo $listTformNoId;?>' value='<?php echo $testPrice;?>' style='width: 70px;' class='inputVal<?php echo $t;?>'><br>
																	<input type='hidden' name='id' value='<?php echo $idPass;?>'>
																	<span style='color: #7D7D7D';'>
																		￥<?php echo number_format($tformPriceNoTax, 0, ' ', ',');?>
																	</span>
																</td>
																<script type="text/javascript">
                                jQuery(function($) {                                	
                                	  var Input = $(".inputVal<?php echo "$t"; ?>"); // main input
                                	  
                                	  var OutputA = $(".outputValA<?php echo "$s"; ?>"); // first result
                                	  var CostA = $(".costA<?php echo "$s"; ?>"); // cost 
                                	  
                                	  var OutputB = $(".outputValB<?php echo "$r"; ?>");
                                	  var CostB = $(".costB<?php echo "$r"; ?>");
                                	  
                                	  var OutputC = $(".outputValC<?php echo "$u"; ?>");
                                	  var CostC = $(".costC<?php echo "$u"; ?>");

                                
                                		$([CostA[0], Input[0]]).bind("change keyup keydown paste", function(e) {
                                		    var ResultA;
                                		    ResultA = parseFloat(Input.val()) / parseFloat(CostA.val());
                                		    OutputA.val(ResultA.toFixed(2));
                                		});  
                                
                                		$([CostB[0], Input[0]]).bind("change keyup keydown paste", function(e) {
                                		    var ResultB;
                                		    ResultB = parseFloat(Input.val()) / parseFloat(CostB.val());
                                		    OutputB.val(ResultB.toFixed(2));
                                		});

                                		$([CostC[0], Input[0]]).bind("change keyup keydown paste", function(e) {
                                		    var ResultC;
                                		    ResultC = parseFloat(Input.val()) / parseFloat(CostC.val());
                                		    OutputC.val(ResultC.toFixed(2));
                                		});
                                });
                                </script>
                                 <?php
                                $t++;
                                $s++;
                                $r++;
                                $u++;
                                ?>
														</tr>
														<?php }?>
												</tbody>
										</table>
										</form>
								</div>
						</div>
						<!-- SAVE WRAPER END -->
						<!-- PAGE CONTENTS END HERE -->
				</div>
		</div>
		<?php require_once '../master/footer.php';?>
</body>
</html>
