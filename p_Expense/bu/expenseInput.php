
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
	$(function() {
		e = $.Event('keyup');
		e.keyCode= 82; // press r key to refresh Cap Sensative
		$('input').trigger(e);
	});
	$('#ajax-loading2').hide();
	$('#table_id').show();
	
	$( "#datepicker" ).datepicker({ dateFormat: "yy.mm.dd"});
	
		} );
</script>
<style type="text/css">
</style>
</head>
<body>
	<div id='wrapper'>	
    	<?php 
    	//require_once '/../functions/function.php';
    	require_once '../header.php';?>
    	<div class='contents'>
    		<!-- PAGE CONTENTS START HERE -->
    		<form name='inputForm' id='expenseInputForm' method='post' action='exe/exeExpense.php'
										onsubmit="return validateForm()">
										<div class='sheetWrapper'>
										<br>
												<div class='tax'>
														消費税 <input type='text' name='tax' class='taxInput'>%
												</div>
												<div class='sheetTop'>

														<div class='sheetTopBox1Wrapper'>
																<div class='sheetTopBox1Top'>入荷日</div>
																<div class='sheetTopBox1Bottom'>
																		<input type='text' name='date' id='datepicker'>
																</div>
														</div>
														<div class='sheetTopBox1Wrapper'>
																<div class='sheetTopBox1Top'>フォワーダー</div>
																<div class='sheetTopBox1Bottom'>
																		<input type='text' name='forwarder'>
																</div>
														</div>
														<div class='sheetTopBox1Wrapper'>
																<div class='sheetTopBox1Top'>Vessel</div>
																<div class='sheetTopBox1Bottom'>
																		<input type='text' name='vessle'>
																</div>
														</div>
														<div class='sheetTopBox1Wrapper'>
																<div class='sheetTopBox1Top'
																		style='border-right: 1px solid #CCC;'>梱包/コンテナー</div>
																<div class='sheetTopBox1Bottom'
																		style='border-right: 1px solid #CCC;'>
																		<input type='text' name='packing'>
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
																		//$i = 0;
																		for ($i = 1; $i<=10; $i++) {
																		    echo "
																		<tbody>
																				<tr>
																						<td style='border-left: none;'><input type='text'
																								name='orderNo_".$i."'></td>
																						<td><input type='text' name='makerName_".$i."'></td>
																						<td><select name='currency1_".$i."'>
																										<option value=''>選ぶ</option>
																										<option value='EUR'>EUR</option>
																										<option value='US$'>US$</option>
																										<option value='CNY'>CNY</option>
																										<option value='JPY'>JPY</option>
																										<option value='DDK'>DDK</option>
																										<option value='SGD'>SGD</option>

																						</select> 
																							<input style='width: 80px;' type='text' name='currency2_".$i."' class='pl_".$i."' value=''>
																						</td>
																						<td>
																							<input style='width: 50px;' type='text' name='rate_".$i."' class='rt_".$i."' value=''>
																						</td>
																						<td style='font-size: 10px; text-align: right; border-right: none;' >
																							￥<input style='width: 100px; border: 0px;' type='text' class='tot_".$i."' value='0'>
																						</td>
																				</tr>
																		</tbody>
																		";

																		}?>
																		
																</table>
																<br>
												<div class='sheetTopTotal'>
														<p>
																合計 (A) <span class='greenText'>￥<input type='text' class='tot_A'  style='border: none;'></span>
														</p>
														<hr>
														<p>
																経費 (B/A) <span class=''><b><input type='text' class='top_percent_1'  style='border: none;'>%</b> </span>
														</p>
														<hr style='margin-right: 0'>
														<br>
														<p>
															<input type='text' class='top_percent_2' style='border: none;'>% 税込
														</p>
												</div>
																<br>																
														</div>
												</div>


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
																				<td class='aRight'>￥<input type='text'
																						name='bankCharge' class='bank_pr'></td>
																				<td class='aRight'><input type='text' style='text-align: right:'class='bank_rate'
																						name='bankChargeTimes'></td>
																				<td class='aRight'>￥<input type='text'
																						class='tot_bank' name='bankChargeTotal' value='0'>
																				</td>
																		</tr>
																		<tr>
																				<td>運賃</td>
																				<td class='aRight'></td>
																				<td class='aRight'></td>
																				<td class='aRight'>￥<input type='text'
																						name='shippingTotal' class='shipping' value='0'></td>
																		</tr>
																		<tr>
																				<td>運賃 (外貨)</td>
																				<td class='aRight'><input type='text'
																						name='shippingCharge' class='shipping_pr'></td>
																				<td class='aRight'><input type='text' 
																						name='shippingChargeTimes' class='shipping_rate'></td>
																				<td class='aRight'>￥<input type='text'
																						class='tot_shipping' name='shippingChargeTotal' value='0'></td>
																		</tr>
																		<tr>
																				<td>保険料</td>
																				<td></td>
																				<td></td>
																				<td class='aRight'>￥<input type='text'
																						name='insuranceTotal' class='tot_insurance' value='0'></td>
																		</tr>
																		<tr>
																				<td>customs clearance fee</td>
																				<td>(非課税)</td>
																				<td></td>
																				<td class='aRight'>￥<input type='text'
																						name='clearanceTotal' class='tot_customs' value='0'></td>
																		</tr>
																		<?php // ADD LINE HERE ---------?>
																		<tr>
																				<td>検査,その他</td>
																				<td>(非課税)</td>
																				<td></td>
																				<td class='aRight'>￥<input type='text'
																						name='inspectionTotal' class='tot_inspection' value='0'></td>
																		</tr>
																		<?php // ADD LINE HERE DONE---------?>
																		<tr>
																				<td>通関手数料</td>
																				<td>(課税)</td>
																				<td></td>
																				<td class='aRight'>￥<input type='text'
																						name='customsTotal' class='tot_t1' value='0'></td>
																		</tr>
																		<tr>
																				<td>国内運賃</td>
																				<td>(課税)</td>
																				<td></td>
																				<td class='aRight'>￥<input type='text'
																						name='inlandShippingTotal' class='tot_t2' value='0'></td>
																		</tr>
																		<tr>
																				<td>蔵出料,その他</td>
																				<td>(課税)</td>
																				<td></td>
																				<td class='aRight'>￥<input type='text'
																						name='otherTotal' class='tot_t3' value='0'></td>
																		</tr>
																		
																		<tr>
																				<td>関税</td>
																				<td></td>
																				<td></td>
																				<td class='aRight'>￥<input type='text'
																						name='tarrifTotal' class='tot_tarrif' value='0'></td>
																		</tr>
																</tbody>
														</table>

														<br>＜ メモ ＞(改行必要場合 &lt;br&gt;書いてください。)<br>
														<textarea name='memo'></textarea>
														<!-- 
														<div class='sheetBottomTotal'>
																<p>
																		経費合計 (B) <span class='green'>￥0,000,000</span>
																</p>
																<hr>
														</div>
														 -->
														<table class='sheetTable2'>
																<thead>
																		<tr>
																				<th></th>
																				<th></th>
																		</tr>
																</thead>
																<tbody>
																		<tr>
																				<td style='text-align: right;'></td>
																				<td class='aRight'>経費合計 (B) ￥<input type='text'
																						name='' class='tot_B'>
																				</td>
																		</tr>
																		<tr>
																			<td style='border: none;'><br></td>
																			<td style='border: none;'></td>
																		</tr>
																		<tr>
																				<td></td>
																				<td class='aRight'>消費税(課税の8%計算) ￥<input type='text' class='tot_tax' style='border: none;'></td>
																		</tr>
																		<tr >
																				<td style='text-align: right;'></td>
																				<td class='aRight'>輸入消費税 ￥<input type='text'
																						name='consumptionTotal' class='tot_import_consumption' value='0'>
																						
																				</td>
																		</tr>
																		<tr >
																				<td style='text-align: right;'></td>
																				<td class='aRight'>合計輸入消費税(C) ￥<input type='text'
																						style='border: none;' class='tot_C' name=''>
																				</td>
																		</tr>
																		<tr>
            																<td style='border: none;'></td>
            																<td class='aRight' style='border: none;'>(C)/(A)= <input type='text' style='border: none; text-align: right;' class='bottom_percent'>%</td>
																		</tr>
																		
																</tbody>
														</table>
														<br>
												</div>
										</div>
										<br> <br>
								</form>
						</div>
						<script type="text/javascript">

                                jQuery(function($) {
                                	 // input variables go here
                                	 // top VARS ------------------------------------------------
                                	 var taxInput = $(".taxInput"); // tax

                                	 // (A) START
                                	 var pl_1 = $(".pl_1"); // price list
                                	 var pl_2 = $(".pl_2"); // price list
                                	 var pl_3 = $(".pl_3"); // price list
                                	 var pl_4 = $(".pl_4"); // price list
                                	 var pl_5 = $(".pl_5"); // price list
                                	 var pl_6 = $(".pl_6"); // price list
                                	 var pl_7 = $(".pl_7"); // price list
                                	 var pl_8 = $(".pl_8"); // price list
                                	 var pl_9 = $(".pl_9"); // price list
                                	 var pl_10 = $(".pl_10"); // price list
                                	 
                                	var rt_1 = $(".rt_1"); // rate
                                	 var rt_2 = $(".rt_2"); // rate
                                	 var rt_3 = $(".rt_3"); // rate
                                	 var rt_4 = $(".rt_4"); // rate
                                	 var rt_5 = $(".rt_5"); // rate
                                	 var rt_6 = $(".rt_6"); // rate
                                	 var rt_7 = $(".rt_7"); // rate
                                	 var rt_8 = $(".rt_8"); // rate
                                	 var rt_9 = $(".rt_9"); // rate
                                	 var rt_10 = $(".rt_10"); // rate

                                	 var tot_1 = $(".tot_1"); // total of pricelist x rate
                                	 var tot_2 = $(".tot_2"); // total of pricelist x rate
                                	 var tot_3 = $(".tot_3"); // total of pricelist x rate
                                	 var tot_4 = $(".tot_4"); // total of pricelist x rate
                                	 var tot_5 = $(".tot_5"); // total of pricelist x rate
                                	 var tot_6 = $(".tot_6"); // total of pricelist x rate
                                	 var tot_7 = $(".tot_7"); // total of pricelist x rate
                                	 var tot_8 = $(".tot_8"); // total of pricelist x rate
                                	 var tot_9 = $(".tot_9"); // total of pricelist x rate
                                	 var tot_10 = $(".tot_10"); // total of pricelist x rate
                                	// (A) END

                                	var tot_A = $(".tot_A"); //top total 合計 (A) 
                                	var top_percent_1 = $(".top_percent_1"); // top percent 経費 (B/A)
                                	var top_percent_2 = $(".top_percent_2"); // top percent % 税込

                                	// BOTTOM VARS ------------------------------------------------
                                	
                                	// (B) START
                                	var bank_pr = $(".bank_pr"); // 銀行手数料
                                	var bank_rate = $(".bank_rate"); // 銀行手数料
                                	var tot_bank = $(".tot_bank"); // 銀行手数料
                                	
                                	var shipping = $(".shipping"); // shipping 運賃

                                	var shipping_pr = $(".shipping_pr"); //運賃 (外貨)
                                	var shipping_rate = $(".shipping_rate"); //運賃 (外貨)
                                	var tot_shipping = $(".tot_shipping"); //運賃 (外貨)

                                	var tot_insurance = $(".tot_insurance"); // 保険料
                                	var tot_customs = $(".tot_customs"); // customs clearance fee
                                	var tot_inspection = $(".tot_inspection"); // customs clearance fee
                                	
                                	// (TAX) START
                                	var tot_t1 = $(".tot_t1"); // 通関手数料	(課税)
                                	var tot_t2 = $(".tot_t2"); // 国内運賃	(課税)
                                	var tot_t3 = $(".tot_t3"); // 蔵出料,検査,その他	(課税)
                                	// (TAX) END

                                	var tot_tarrif = $(".tot_tarrif"); // tarrif 関税
                                	// (B) END
                                	                                	
                                	var tot_B = $(".tot_B"); // 経費合計 (B)

                                	var tot_tax = $(".tot_tax"); // 消費税(課税の8%計算) ￥ (t1+t2+t3/tax)
                                	var tot_import_consumption = $(".tot_import_consumption"); // 輸入消費税 ￥
                                	var tot_C = $(".tot_C"); // 合計輸入消費税(C) ￥ (tot_tax+tot_tarrif)
                                	var bottom_percent = $(".bottom_percent"); // (C)/(A)= 0%

                                	// FUNCTION BINDING
                                	<?php $i = 1; for ($i = 1; $i<=10; $i++) { ?>
                                	$([pl_<?php echo "$i"; ?>[0], rt_<?php echo "$i"; ?>[0]]).bind("change keyup keydown paste", function(e) {
                                		    var Result<?php echo "$i"; ?>;
                                		    Result<?php echo "$i"; ?> = parseFloat(rt_<?php echo "$i"; ?>.val()) * parseFloat(pl_<?php echo "$i"; ?>.val());
                                		    tot_<?php echo "$i"; ?>.val(truncate(Result<?php echo "$i"; ?>, 1));
                                		    totalA();
                                		});
                            		<?php } ?>

                            		$([bank_pr[0], bank_rate[0]]).bind("change keyup keydown paste", function(e){
                                		var bankResult;
                                		bankResult = parseFloat(bank_pr.val()) * parseFloat(bank_rate.val());
                                		tot_bank.val(bankResult);
                                		totalB();
                            		});
                            		
                            		$([shipping_pr[0], shipping_rate[0]]).bind("change keyup keydown paste", function(e){
                                		var shippingResult;
                                		shippingResult = parseFloat(shipping_pr.val()) * parseFloat(shipping_rate.val());
                                		tot_shipping.val(shippingResult);
                                		totalB();
                            		});
                            		
                            		$([tot_t1[0], tot_t2[0], tot_t3[0], taxInput[0]]).bind("change keyup keydown paste", function(e){
                                		var taxTotalResult;
                                		taxTotalResult = (parseFloat(tot_t1.val()) + parseFloat(tot_t2.val()) + parseFloat(tot_t3.val())) * (taxInput.val()/100);
                                		//tot_tax.val(truncate(taxTotalResult, 1));
                                		tot_tax.val(truncate(taxTotalResult, 1));
                                		totalC();
                                		totalCA();
                            		});
                            		$([tot_bank[0],
                               		 shipping[0], 
                               		 tot_shipping[0], 
                               		 tot_insurance[0], 
                               		 tot_customs[0], 
                               		 tot_inspection[0],
                               		 tot_t1[0], 
                               		 tot_t2[0], 
                               		 tot_t3[0], 
                               		 tot_tarrif[0], 
                               		 tot_import_consumption[0]]
                               		 
                              		 ).bind("change keyup keydown paste", function(e){
                                		totalB();
                                		totalC();
                                		totalCA();
                            		});

                            		var totalA = function()
                            		{   var ResultA;
                            		    ResultA = 
                                		    parseFloat(tot_1.val()) + 
                                		    parseFloat(tot_2.val()) +
                                		    parseFloat(tot_3.val()) +
                                		    parseFloat(tot_4.val()) +
                                		    parseFloat(tot_5.val()) +
                                		    parseFloat(tot_6.val()) +
                                		    parseFloat(tot_7.val()) +
                                		    parseFloat(tot_8.val()) +
                                		    parseFloat(tot_9.val()) +
                                		    parseFloat(tot_10.val());
                            		    tot_A.val(truncate(ResultA, 1));
                            		    totalCA();
                            		    totalBA();
                            		};

                            		var totalB = function()
                            		{  
                            		    ResultB = 
                                		    parseFloat(tot_bank.val()) + 
                                		    parseFloat(tot_shipping.val()) +
                                		    parseFloat(shipping.val()) + 
                                		    parseFloat(tot_insurance.val()) +
                                		    parseFloat(tot_customs.val()) +
                                		    parseFloat(tot_inspection.val()) +
                                		    parseFloat(tot_t1.val()) + 
                                		    parseFloat(tot_t2.val()) + 
                                		    parseFloat(tot_t3.val()) + 
                                		    parseFloat(tot_tarrif.val())  
                                		    ;
                            		    tot_B.val(truncate(ResultB, 1));
                            		    totalCA();
                            		    totalBA();
                            		};

                            		var totalC = function()
                            		{  
                            		    ResultC = 
                                		    parseFloat(tot_tax.val()) +
                                		    parseFloat(tot_import_consumption.val())  
                                		    ;
                            		    tot_C.val(truncate(ResultC, 1));
                            		    totalCA();
                            		};
                            		var totalCA = function()
                            		{  
                            		    ResultCA = 
                                		    (parseFloat(tot_C.val()) /
                                		    parseFloat(tot_A.val()))*100  
                                		    ;
                            		    bottom_percent.val(truncate(ResultCA, 3));
                            		    addPercent();
                            		};
                                var totalBA = function()
                        		{  
                        		    ResultBA = 
                            		    (parseFloat(tot_B.val()) /
                            		    parseFloat(tot_A.val()))*100  
                            		    ;
                        		    top_percent_1.val(truncate(ResultBA, 3));
                        		    addPercent();
                        		    
                        		};
                        		var addPercent = function ()
                        		{
                            		ResultPercentTotal =
                                		parseFloat(top_percent_1.val()) + parseFloat(bottom_percent.val());
                            		top_percent_2.val(truncate(ResultPercentTotal, 3));
                        		}
                            });
                                function format1(n, currency) {
                                    return currency + " " + n.toFixed(0).replace(/./g, function(c, i, a) {
                                        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                                    });
                                }
                                </script>
    		<!-- PAGE CONTENTS END HERE -->
    	
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>
