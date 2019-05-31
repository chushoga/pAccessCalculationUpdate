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
	$( ".datePick" ).datepicker({ dateFormat: "yy.mm.dd"});
	$('#mainForm').bind("keyup keypress", function(e) {
		  var code = e.keyCode || e.which; 
		  if (code  == 13) {               
		    e.preventDefault();
		    return false;
		  }
		});
	$('.hasTooltip').each(function() { // Notice the .each() loop, discussed below
	    $(this).qtip({
	        content: {
	            text: $(this).next('.tooltiptext') // Use the "div" element next to this for the content
	        }
	    });
	});
	$(function() {
	    $(".inputWrapper").mousedown(function() {
	        var button = $(this);
	        button.addClass('clicked');
	        setTimeout(function(){
	            button.removeClass('clicked');
	        },50);
	    });
	});	
		} );
</script>
<style type="text/css">
</style>
</head>
<body>
<?php
//variables
$id = $_GET['id'];
$color = "#CFFFCF";
?>
	<div id='wrapper'>
	
    	<?php require_once '../header.php';?>
    	
    	<div class='contents'>
    		<!-- PAGE CONTENTS START HERE -->

						<?php
						

						// PART TO GET THE AMOUNT OF TIMES TO SHOW DATA BLOCKS------------
						$count = 0;
						$result = mysql_query("SELECT * FROM tfProject WHERE `id` = '$id'");
						while ($row = mysql_fetch_assoc($result)){
						    for ($i = 1; $i <= 20; $i++){
						        if (
						        $row['archNo_'.$i] == '' &&
						        $row['type_'.$i] == '' &&
						        $row['itemCount_'.$i] == '' &&
						        $row['maker_'.$i] == '' &&
						        $row['series_'.$i] == '' &&
						        $row['tformNo_'.$i] == '' &&
						        $row['makerNo_'.$i] == '' &&
						        $row['finish_'.$i] == '' &&
						        $row['currency_'.$i] == '' &&
						        $row['priceList_'.$i] == 0 &&
						        $row['generalDisc_'.$i] == 0 &&
						        $row['projectDisc_'.$i] == 0 &&
						        $row['rate_'.$i] == 0 &&
						        $row['percent_'.$i] == 0 &&
						        $row['memo_'.$i] == '' &&
						        $row['mitsumori_'.$i] == 0 &&
						        $row['retailPrice_'.$i] == 0
						        ){
						            //echo $i."NULL";
						        } else {
						            //echo $i."TRUE";
						            $count++;
						        }
						    }
						}
						// END OF COUNT BLOCK ------------------------------------------

						?>
								<div class='tableWrapper'>
										<form id='calculationSave' action='exe/exeEditProject.php' method='POST'
												onSubmit="if(!confirm('保存しても宜しいですか?')){return false;}">
												 <input
														type="hidden" name='dbId' value="<?php echo $id;?>"> <input
														type="submit" value="保存"
														style='float: right; padding: 2px; margin-right: 5px;'
														class='saveBtn'> <input type="button" value="キャンセル"
														style='float: right; padding: 2px; margin-right: 5px;'
														class='cancelBtn'
														onClick="location.href='tfProject.php?pr=2&id=<?php echo $id;?>'">

												<table class="tg" style="table-layout: fixed; width: 1254px">
														<colgroup>
																<col style="width: 119px">
																<col style="width: 90px">
																<col style="width: 116px">
																<col style="width: 85px">
																<col style="width: 80px">
																<col style="width: 82px">
																<col style="width: 80px">
																<col style="width: 122px">
																<col style="width: 122px">
																<col style="width: 119px">
																<col style="width: 118px">
																<col style="width: 121px">
														</colgroup>
														<?php
														$result = mysql_query("SELECT * FROM tfProject WHERE `id` = '$id'");
														while ($row = mysql_fetch_assoc($result)){

														    echo "<tr>
												    <th class='tg-s6z3'>id</th>
												    <th class='tg-s6z3' colspan='2'> プロジェクト名</th>
												    <th class='tg-s6z3' colspan='3'>現場住所</th>
												    <th class='tg-s6z3'>date</th>
												    <th class='tg-031e' colspan='5' rowspan='2'
																style='border: none;'></th>
																</tr>
																<tr>
																<td class='tg-s6z2'>
																".$row['id']."
																</td>
																
																<td class='tg-s6z2' colspan='2'><input type='text' name='projectName' value='".$row['projectName']."' id='projectName'></td>
																<td class='tg-s6z2' colspan='3'><input type='text' name='place' value='".$row['place']."' id='place'></td>
																<td class='tg-s6z2'><input type='text' name='date' class='datePick' value='".$row['date']."'></td>
																</tr>";
														}
														?>
												</table>

												<br>
												<!-- START OF LOOP -->

												<?php
												// SET THE ADDING TOTAL VARIABLES BEFORE ADDING
												$priceListAD = 0;
												$yenAmount = 0;
												$genka = 0;
												$yenMitBai = 0;
												$salesPrice = 0;
												$retailBai = 0;
												$totalGenka = 0;
												$totalSales = 0;
												

												//----------------------------------------------
												for ($i = 1; $i <= $count; $i++){
												    $result = mysql_query("SELECT * FROM tfProject WHERE `id` = '$id'");
												    while ($row = mysql_fetch_assoc($result)){
												        // SET THE LOOP VARIABLES
												        $priceListAD = $row['priceList_'.$i]*(1-($row['generalDisc_'.$i]/100))*(1-($row['projectDisc_'.$i]/100));
												        $yenAmount = $row['priceList_'.$i]*(1-($row['generalDisc_'.$i]/100))*(1-($row['projectDisc_'.$i]/100))*$row['rate_'.$i]*(1+($row['percent_'.$i]/100));
												        $genka = $row['itemCount_'.$i]*intval($yenAmount);
												        
												        //-----------------------
												        if($row['mitsumori_'.$i] == 0 || $yenAmount == 0){
												            $yenMitBai = 0;
												        }else {
												           $yenMitBai = $row['mitsumori_'.$i]/intval($yenAmount);
												        }
												        //-----------------------
												        $salesPrice = $row['mitsumori_'.$i]*$row['itemCount_'.$i];
												        //-----------------------
												        if($row['mitsumori_'.$i] == 0 || $row['retailPrice_'.$i] == 0){
												            $retailBai = 0;
												        }else {
												            $retailBai = $row['mitsumori_'.$i]/$row['retailPrice_'.$i];
												        }
												        //-----------------------
												        
												        echo "
										        
										<table class='tg' style='table-layout: fixed; width: 1254px'>
												<colgroup>
														<col style='width: 119px'>
														<col style='width: 90px'>
														<col style='width: 116px'>
														<col style='width: 85px'>
														<col style='width: 80px'>
														<col style='width: 82px'>
														<col style='width: 80px'>
														<col style='width: 122px'>
														<col style='width: 122px'>
														<col style='width: 119px'>
														<col style='width: 118px'>
														<col style='width: 121px'>
												</colgroup>


												<tr>
														<td class='tg-s6z3' style='background-color: #EEE; '>図面番号</td>
														<td class='tg-s6z3' colspan='2' style='background-color: #EEE; '>商品</td>
														<td class='tg-s6z3' colspan='4' style='background-color: #EEE; '>数量</td>
														<td class='tg-031e' colspan='5' rowspan='2' style='border: none;'></td>
												</tr>
												<tr>
														<td class='tg-s6z2' ><input type='text' name='archNo_$i' value='".$row['archNo_'.$i]."'></td>
														<td class='tg-s6z2' colspan='2'><input type='text' name='type_$i' value='".$row['type_'.$i]."'></td>
														<td class='tg-s6z2' colspan='4'><input type='text' name='itemCount_$i' value='".$row['itemCount_'.$i]."' class='itemCount_$i'></td>
												</tr>



												<tr>
														<td class='tg-s6z2' rowspan='4'>";
												        if ($row['image_'.$i] == ''){
												            echo "<form id='form_$i' action='exe/exeImgUpload.php' enctype='multipart/form-data' method='POST'>
														
														<input type='hidden' name='id' value='$id'>
														<input type='hidden' name='imgId' value='image_$i'>
														<div class='inputWrapper' style='height: 100px; width: 100px; margin: auto; text-align: center; line-height: 100px;'>イメージ
														<input class='fileInput hidden' type='file' name='file' id='file_$i' > 
														</div>
														</form>";
												        } else {
												            echo "<img src='../".$row['image_'.$i]."' style='max-width: 115px; max-height: 137px;'>";
												        }

												        echo "
														</td>
														<td class='tg-s6z3'>メーカー</td>
														<td class='tg-s6z3'>シリーズ</td>
														<td class='tg-s6z3' colspan='2'>tformNo</td>
														<td class='tg-s6z3' colspan='2'>モデルNO.</td>
														<td class='tg-s6z3' colspan='5'>仕様</td>

												</tr>
												<tr>
														<td class='tg-s6z2'><input type='text' name='maker_$i' value='".$row['maker_'.$i]."'></td>
														<td class='tg-s6z2'><input type='text' name='series_$i' value='".$row['series_'.$i]."'></td>
														<td class='tg-s6z2' colspan='2'><input type='text' name='tformNo_$i' value='".$row['tformNo_'.$i]."'></td>
														<td class='tg-s6z2' colspan='2'><input type='text' name='makerNo_$i' value='".$row['makerNo_'.$i]."'></td>
														<td class='tg-s6z2' colspan='5'><input type='text' name='finish_$i' value='".$row['finish_'.$i]."'></td>
												</tr>
												<tr>
														<td class='tg-s6z3'>通貨</td>
														<td class='tg-s6z3'>PL価格</td>
														<td class='tg-s6z3'>通常値引</td>
														<td class='tg-s6z3'>プロジェクト値引</td>
														<td class='tg-s6z3'>NET Price</td>
														<td class='tg-s6z3'>rate</td>
														<td class='tg-s6z3'>経費</td>
														<td class='tg-s6z3'>仕入原価</td>
														<td class='tg-s6z3'>仕入合計</td>
														<td class='tg-s6z3' colspan='2'>memo</td>

												</tr>
												<tr>
														<td class='tg-s6z2'><input type='text' name='currency_$i' value='".$row['currency_'.$i]."'></td>
														<td class='tg-s6z2'><input type='text' name='priceList_$i' value='".$row['priceList_'.$i]."' class='priceList_$i'></td>
														<td class='tg-s6z2'><input type='text' name='generalDisc_$i' value='".$row['generalDisc_'.$i]."' class='generalDisc_$i'></td>
														<td class='tg-s6z2'><input type='text' name='projectDisc_$i' value='".$row['projectDisc_'.$i]."' class='projectDisc_$i'></td>
														<td class='tg-s6z2' style='background-color: $color;'><input type='text' class='netPrice_$i' value='0' readonly></td>
														<td class='tg-s6z2'><input type='text' name='rate_$i' value='".$row['rate_'.$i]."' class='rate_$i'></td>
														<td class='tg-s6z2'><input type='text' name='percent_$i' value='".$row['percent_'.$i]."' class='percent_$i' ></td>
														<td class='tg-s6z2' style='background-color: $color;'><input type='text' class='yenAmount_$i'value='0' readonly></td>
														<td class='tg-s6z2' style='background-color: $color;'><input type='text' class='yenTotal_$i' value='0' readonly></td>
														<td class='tg-031e' colspan='2'><textarea style='width: 100%; height: 100%;' name='memo_$i'>".$row['memo_'.$i]."</textarea></td>
												</tr>
												<tr>
														<td class='tg-031e' colspan='7' rowspan='2'></td>
														<td class='tg-s6z3'>倍率</td>
														<td class='tg-s6z3'>見積単価</td>
														<td class='tg-s6z3'>販売価格（税別）</td>
														<td class='tg-s6z3'>掛率</td>
														<td class='tg-s6z3'>上代</td>
												</tr>
												<tr>
														<td class='tg-s6z2' style='background-color: $color;'><input type='text' class='baiRitsu_$i' value='0' readonly></td>
														<td class='tg-s6z2'><input type='text' name='mitsumori_$i' value='".$row['mitsumori_'.$i]."' class='mitsumori_$i'></td>
														<td class='tg-s6z2' style='background-color: $color;'><input type='text' class='mitsumoriTotal_$i' value='0' readonly></td>
														<td class='tg-s6z2' style='background-color: $color;'><input type='text' class='kakeRitsu_$i' value='0' readonly></td>
														<td class='tg-s6z2'><input type='text' name='retailPrice_$i' value='".$row['retailPrice_'.$i]."' class='tformPrice_$i'></td>
												</tr>
												</table>
												<br>
												";
												        
												        //-----------------------------------------------------------------------
												        $totalGenka += $genka;
												        $totalSales += $row['mitsumori_'.$i]*$row['itemCount_'.$i];


												        // START SETTING UP THE CALCULATION HERE
												        ?>
												<script type="text/javascript">
                                                
												 jQuery(function($) {
		                                        	 // input variables go here
		                                        	 // top VARS ------------------------------------------------
		                                        	 var itemCount = $(".itemCount_<?php echo "$i";?>"); // itemCount
		                                        	 
		                                        	 var priceList = $(".priceList_<?php echo "$i";?>"); // priceList
		                                        	 var generalDisc = $(".generalDisc_<?php echo "$i";?>"); // generalDisc
		                                        	 var projectDisc = $(".projectDisc_<?php echo "$i";?>"); // projectDisc
		                                        	 
		                                        	 var netPrice = $(".netPrice_<?php echo "$i";?>"); // netPrice
		                                        	 var rate = $(".rate_<?php echo "$i";?>"); // rate
		                                        	 var percent = $(".percent_<?php echo "$i";?>"); // percent
		                                        	 
		                                        	 var yenAmount = $(".yenAmount_<?php echo "$i";?>"); // yenAmount
		                                        	 var yenTotal = $(".yenTotal_<?php echo "$i";?>"); // yenTotal

		                                        	 var baiRitsu = $(".baiRitsu_<?php echo "$i";?>"); // baiRitsu
		                                        	 
		                                        	 var mitsumori = $(".mitsumori_<?php echo "$i";?>"); // mitsumori
		                                        	 var mitsumoriTotal = $(".mitsumoriTotal_<?php echo "$i";?>"); // mitsumoriTotal
		                                        	 var kakeRitsu = $(".kakeRitsu_<?php echo "$i";?>"); // kakeRitsu
		                                        	 var tformPrice = $(".tformPrice_<?php echo "$i";?>"); // tformPrice
		                                        	                                      
		    										$([	
		       											itemCount[0],
		       											priceList[0],
		    											generalDisc[0],
		    											projectDisc[0],
		    											netPrice[0],
		    											rate[0],
		    											percent[0],
		    											yenAmount[0],	
		    											yenTotal[0],	
		    											baiRitsu[0],	
		    											mitsumori[0],	
		    											mitsumoriTotal[0],
		    											kakeRitsu[0],	
		    											tformPrice[0]

														 ]).bind("change keyup keydown paste", function(e){

				                                       	netPriceFunc();
				                                       	yenAmountFunc();
		                                         		yenTotalFunc();
		                                         		bairitsuFunc();
		                                         		mitsumoriTotalFunc();
		                                         		kakeritsuFunc();
		                                     		});

		                                     		//NETPRICE
		                                     		var netPriceFunc = function()
		                                     		{ 
		                                     			var netResult;
		                                         		netResult = parseFloat(priceList.val()) * (1-(parseFloat(projectDisc.val())/100)) * (1-(parseFloat(generalDisc.val())/100));
		                                         		netPrice.val(truncate(netResult,3));
		                                     		}

		                                     		//YEN AMOUNT
		    										var yenAmountFunc = function()
		                                    		{   var Result;
		                                    		Result = parseFloat(netPrice.val()) * parseFloat(rate.val()) * (1+(parseFloat(percent.val())/100));
		                                     		yenAmount.val(truncate(Result, 1));
		                                    		};	

		                                    		//YEN TOTAL
		                                    		var yenTotalFunc = function()
		                                    		{   var Result;
		                                     		Result = parseFloat(itemCount.val()) * parseFloat(yenAmount.val());
		                                     		yenTotal.val(truncate(Result, 1));
		                                    		};

		                                    		//BAIRITSU
		                                    		var bairitsuFunc = function(){
		                                        		var Result;
		                                        		Result = parseFloat(mitsumori.val()) / parseFloat(yenAmount.val());
		                                        		baiRitsu.val(truncate(Result, 3));
		                                    		};

		                                     		//MITSUMORI TOTAL
		                                     		var mitsumoriTotalFunc = function (){
		                                         		var Result
		                                         		Result = parseFloat(itemCount.val()) * parseFloat(mitsumori.val());
		                                         		mitsumoriTotal.val(Result);
		                                     		};

		                                     		//KAKERITSU
		                                     		var kakeritsuFunc = function(){
		                                         		var Result;
		                                         		Result = parseFloat(mitsumori.val()) / parseFloat(tformPrice.val());
		                                         		kakeRitsu.val(truncate(Result, 3));
		                                     		};
		                                     		
		                                     		 e = jQuery.Event("paste")
														e.which = 13 //choose the one you want
														    $(".rate_" + "<?php echo $i;?>").keypress(function(){
														     //alert('keypress triggered');
														     	netPriceFunc();
						                                       	yenAmountFunc();
				                                         		yenTotalFunc();
				                                         		bairitsuFunc();
				                                         		mitsumoriTotalFunc();
				                                         		kakeritsuFunc();
		                                         		}).trigger(e)
		                                        });
												
												
                                                </script>
                                                

                                                <?php

                                                // ADD THE STARTING COUNTERS TO = 0 BEFORE THE LOOP STARTS
                                                // END THE CALCULATION INSIDE THE LOOP
												    }
												}


												?>

												<!-- END OF LOOP -->
												<br>
												<table class="tg" style="table-layout: fixed; width: 1254px">
														<colgroup>
																<col style="width: 119px">
																<col style="width: 90px">
																<col style="width: 116px">
																<col style="width: 85px">
																<col style="width: 80px">
																<col style="width: 82px">
																<col style="width: 80px">
																<col style="width: 122px">
																<col style="width: 122px">
																<col style="width: 119px">
																<col style="width: 118px">
																<col style="width: 121px">
														</colgroup>

														<tr>
																<td class="tg-031e" colspan="8" rowspan="2"
																		style='border: none;'></td>
																<td class="tg-s6z4">仕入合計<span style="color: red; font-size: 14px;"> ※ </span></td>
																<td class="tg-s6z4">販売合計<span style="color: red; font-size: 14px;"> ※ </span></td>
																<td class="tg-s6z4" colspan="2"
																		style='background-color: Gold;'>粗利<span style="color: red; font-size: 14px;"> ※ </span></td>
														</tr>
														<tr>
																<td class="tg-s6z2">￥<?php echo number_format($totalGenka, 0, '.',',');?>

																</td>
																<td class="tg-s6z2">￥<?php echo number_format($totalSales, 0, '.',',');?>
																</td>
																<td class="tg-s6z2"><?php 
																if (($totalSales-$totalGenka) == 0 || $totalSales == 0){
																    echo " - ";
																} else {
																    echo number_format((($totalSales-$totalGenka)/$totalSales)*100, 2, '.',',')."%";
																}
																
																


																?>
																</td>
																<td class="tg-s6z2">￥<?php echo number_format(intval($totalSales-$totalGenka),0,'.',',');?>



																</td>
														</tr>
												</table>
												<br>
												<span style="float: right; color: red; font-weight: bold;">※ 保存してからアップデート</span>
										</form>

										<br> <br>
    		</div>
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>	
	<?php require_once '../master/footer.php';?>
	<script>
	$('.rate_1').trigger(jQuery.Event('keypress', {which: 49}));
	</script>
</body>
</html>


