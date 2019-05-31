<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title;?></title>
<link rel="stylesheet" href="<?php echo $path;?>/css/tfProject/tfProjectInfo.css">
<style>


.tableWrapper input[type=text] {
		width: 100%;
		height: 100%;
		border: none;
		text-align: center;
		background-color: transparent;
}

</style>
<?php
include_once '../master/config.php';
 
if(isset($_GET['amount'])){
    if ($_GET['amount'] > 20){
        $count = 20;
    } else {
        $count = $_GET['amount'];
    }
} else {
    $count = 0;
}
$color = "#CFFFCF";

?>

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
	//BUTTON CLICK CODE
	$('.calcBtn').click(function () {
	    appendBox();
	});
	$('.cancelBtn').click(function () {
	    removeBox();
	});
	//SET COUNTER VARIABLES
	var counterPiece = 0;
	var setCount = <?php echo $count;?> + 1;
	var genkaTotal = 0;
	var salesTotal = 0;
	var color = "<?php echo $color;?>";

	//ADD BOX CODE
	function appendBox() {
	    var a = setCount + counterPiece;
	    

	    var text3 = "<div id='addBox" + a + "' style='width: 100%; height: auto; background-color: #FFF;'> \
					<table class='tg' style='table-layout: fixed; width: 1254px'> \
						<colgroup> \
								<col style='width: 119px'> \
								<col style='width: 90px'> \
								<col style='width: 116px'> \
								<col style='width: 85px'> \
								<col style='width: 80px'> \
								<col style='width: 82px'> \
								<col style='width: 80px'> \
								<col style='width: 122px'> \
								<col style='width: 122px'> \
								<col style='width: 119px'> \
								<col style='width: 118px'> \
								<col style='width: 121px'> \
						</colgroup> \
						<tr> \
								<td class='tg-s6z2' style='background-color: #EEE; '>図面番号</td>  \
								<td class='tg-s6z2' colspan='2' style='background-color: #EEE; '>商品</td>  \
								<td class='tg-s6z2' colspan='4' style='background-color: #EEE; '>数量</td>  \
								<td class='tg-031e' colspan='5' rowspan='2' style='border: none;'></td> \
						</tr> \
						<tr> \
								<td class='tg-s6z2' ><input type='text' name='archNo_" + a + "' value=''></td> \
								<td class='tg-s6z2' colspan='2'><input type='text' name='type_" + a + "' value=''></td> \
								<td class='tg-s6z2' colspan='4'><input type='text' name='itemCount_" + a + "' value='1' class='itemCount_" + a + "'></td> \
						</tr> \
						<tr> \
						<td class='tg-s6z2' rowspan='4'>イメージ<br><span style='color: RED; font-size: 9px;'>[保存してからイメージ入力]</span></td> \
								<td class='tg-s6z2'>メーカー</td> \
								<td class='tg-s6z2'>シリーズ</td> \
								<td class='tg-s6z2' colspan='2'>tformNo</td> \
								<td class='tg-s6z2' colspan='2'>モデルNO.</td> \
								<td class='tg-s6z2' colspan='5'>仕様</td> \
						</tr> \
						<tr> \
								<td class='tg-s6z2'><input type='text' name='maker_" + a + "' value=''></td> \
								<td class='tg-s6z2'><input type='text' name='series_" + a + "' value=''></td> \
								<td class='tg-s6z2' colspan='2'><input type='text' name='tformNo_" + a + "' value=''></td> \
								<td class='tg-s6z2' colspan='2'><input type='text' name='makerNo_" + a + "' value=''></td> \
								<td class='tg-s6z2' colspan='5'><input type='text' name='finish_" + a + "' value=''></td> \
						</tr> \
						<tr> \
								<td class='tg-s6z2'>通貨</td> \
								<td class='tg-s6z2'>PL価格</td> \
								<td class='tg-s6z2'>通常値引</td> \
								<td class='tg-s6z2'>プロジェクト値引</td> \
								<td class='tg-s6z2'>NET Price</td> \
								<td class='tg-s6z2'>rate</td> \
								<td class='tg-s6z2'>経費</td> \
								<td class='tg-s6z2'>仕入原価</td> \
								<td class='tg-s6z2'>仕入合計</td> \
								<td class='tg-s6z2' colspan='2'>memo</td> \
						</tr> \
						<tr> \
								<td class='tg-s6z2'><input type='text' name='currency_" + a + "' value=''></td> \
								<td class='tg-s6z2'><input type='text' name='priceList_" + a + "' value='0' class='priceList_" + a + "'></td> \
								<td class='tg-s6z2'><input type='text' name='generalDisc_" + a + "' value='0' class='generalDisc_" + a + "'></td> \
								<td class='tg-s6z2'><input type='text' name='projectDisc_" + a + "' value='0' class='projectDisc_" + a + "'></td> \
								<td class='tg-s6z2' style='background-color: " + color + "'><input type='text' class='netPrice_" + a + "' value='0' readonly></td> \
								<td class='tg-s6z2'><input type='text' name='rate_" + a + "' value='0' class='rate_" + a + "'></td> \
								<td class='tg-s6z2'><input type='text' name='percent_" + a + "' value='0' class='percent_" + a + "' ></td> \
								<td class='tg-s6z2' style='background-color: " + color + "'><input type='text' class='yenAmount_" + a + "'value='0' readonly></td> \
								<td class='tg-s6z2' style='background-color: " + color + "'><input type='text' class='yenTotal_" + a + "' value='0' readonly></td> \
								<td class='tg-031e' colspan='2'><textarea style='width: 100%; height: 100%;' name='memo_" + a + "'></textarea></td> \
						</tr> \
						<tr> \
								<td class='tg-s6z2' colspan='7' rowspan='2'></td> \
								<td class='tg-s6z2'>倍率</td> \
								<td class='tg-s6z2'>見積単価</td> \
								<td class='tg-s6z2'>販売価格（税別）</td> \
								<td class='tg-s6z2'>掛率</td> \
								<td class='tg-s6z2'>上代</td> \
						</tr> \
						<tr> \
								<td class='tg-s6z2' style='background-color: " + color + "'><input type='text' class='baiRitsu_" + a + "' value='0' readonly></td> \
								<td class='tg-s6z2'><input type='text' name='mitsumori_" + a + "' value='0' class='mitsumori_" + a + "'></td> \
								<td class='tg-s6z2' style='background-color: " + color + "'><input type='text' class='mitsumoriTotal_" + a + "' value='0' readonly></td> \
								<td class='tg-s6z2' style='background-color: " + color + "'><input type='text' class='kakeRitsu_" + a + "' value='0' readonly></td> \
								<td class='tg-s6z2'><input type='text' name='retailPrice_" + a + "' value='0' class='tformPrice_" + a + "'></td> \
						</tr> \
						</table> \
						<br> \
	<script> \
	jQuery(function($){\
	    var itemCount = $('.itemCount_" + a + "');\
	    var priceList = $('.priceList_" + a + "');\
	    var generalDisc = $('.generalDisc_" + a + "');\
	    var projectDisc = $('.projectDisc_" + a + "');\
	    var netPrice = $('.netPrice_" + a + "');\
	    var rate = $('.rate_" + a + "');\
	    var percent = $('.percent_" + a + "');\
	    var yenAmount = $('.yenAmount_" + a + "');\
	    var yenTotal = $('.yenTotal_" + a + "');\
	    var baiRitsu = $('.baiRitsu_" + a + "');\
	    var mitsumori = $('.mitsumori_" + a + "');\
	    var mitsumoriTotal = $('.mitsumoriTotal_" + a + "');\
	    var kakeRitsu = $('.kakeRitsu_" + a + "');\
	    var tformPrice = $('.tformPrice_" + a + "');\
	$([itemCount[0], priceList[0], generalDisc[0], projectDisc[0], netPrice[0], rate[0], percent[0], yenAmount[0], yenTotal[0], baiRitsu[0], mitsumori[0], mitsumoriTotal[0], kakeRitsu[0], tformPrice[0]]).bind('change keyup keydown paste', function(e){ \
		netPriceFunc(); \
		yenAmountFunc(); \
		yenTotalFunc(); \
		bairitsuFunc(); \
		mitsumoriTotalFunc(); \
		kakeritsuFunc(); \
	}); \
	var testFunc = function() {  \
	Result = parseFloat(priceList.val()) * 2; \
	netPrice.val(Result); \
	}; \
	var netPriceFunc = function() \
	{  \
	netResult = parseFloat(priceList.val()) * (1-(parseFloat(projectDisc.val())/100)) * (1-(parseFloat(generalDisc.val())/100)); \
	netPrice.val(truncate(netResult, 3)); \
	}; \
	var yenAmountFunc = function(){\
	Result = parseFloat(netPrice.val()) * parseFloat(rate.val()) * (1+(parseFloat(percent.val())/100)); \
	yenAmount.val(truncate(Result, 3)); \
	};	 \
	var yenTotalFunc = function(){\
	Result = parseFloat(itemCount.val()) * parseFloat(yenAmount.val()); \
	yenTotal.val(truncate(Result, 3)); \
	}; \
	var bairitsuFunc = function(){ \
	Result = parseFloat(mitsumori.val()) / parseFloat(yenAmount.val()); \
	baiRitsu.val (truncate(Result, 3)); \
	}; \
	var mitsumoriTotalFunc = function (){ \
	Result = parseFloat(itemCount.val()) * parseFloat(mitsumori.val()); \
	mitsumoriTotal.val(truncate(Result, 3)); \
	}; \
	var kakeritsuFunc = function(){ \
	Result = parseFloat(mitsumori.val()) / parseFloat(tformPrice.val()); \
	kakeRitsu.val(truncate(Result, 3)); \
	}; \
	}); <\/script> \
	</div>";
	if (a < 21) {
	    counterPiece++;
	    //$(".additionalBoxes").append(a);
	    
	    $(".additionalBoxes").append(text3);
	    } else {}

	}

	function removeBox() {
	    var a = setCount + counterPiece - 1;
	    var boxId = "#addBox" + a;
	    //$(".additionalBoxes").append(boxId);
	    $(boxId).remove();
	    if (counterPiece < 1) {} else {
	        counterPiece--;
	    }
	}
		} );
</script>

</head>
<body>

	<div id='wrapper'>
    	<?php require_once '../header.php';?>
    	<div class='contents'>
    		<!-- PAGE CONTENTS START HERE -->
    		
					<?php
						echo "<div class='amountBox' style='padding: 10px; background-color: #FFF; height: 30px;'>";        				
						echo "<button class='calcBtn' style='margin-right: 10px; margin-left: 10px;'>入力ブロック +</button>";
						echo "<button class='cancelBtn'>入力ブロック -</button>";
						echo " <br><span style='color: red; font-size: 12px;'>※ 注意点:20段までに</span>";
        				echo "</div>";
						
						
						?>

								<div class='tableWrapper'>
										<form id='mainForm' action='exe/exetfProject.php' method='POST'
												onclick="FormValidation()"
												onsubmit="return confirm('これでいいですか?')">
												<!-- MAKE A JAVASCRIPT INSERT BUTTON THAT IF CLICK YOU CAN ADD A NEW BLOCK FOR INSERT INTO THE TABLE -->


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
																<th class="tg-s6z2" style='border: <?php echo $border;?>;'>id</th>
																<th class="tg-s6z2" colspan="2">プロジェクト名</th>
																<th class="tg-s6z2" colspan="3">現場住所</th>
																<th class="tg-s6z2">date</th>
																<th class="tg-031e" colspan="5" rowspan="2"
																		style='border: none;'></th>
														</tr>
														<tr>
																<td class="tg-s6z2">
																		<!--<input type='text' name='id' value=''> -->
																</td>
																<td class="tg-s6z2" colspan="2"><input type='text'
																		name='projectName' value='' id='projectName'></td>
																<td class="tg-s6z2" colspan="3"><input type='text'
																		name='place' value='' id='place'></td>
																<td class="tg-s6z2"><input type='text' name='date'
																		class='datePick'></td>
														</tr>

												</table>

												<br>
												
												<div class='additionalBoxes'></div>
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
																<td class="tg-s6z2">仕入合計</td>
																<td class="tg-s6z2">販売合計</td>
																<td class="tg-s6z2" colspan="2"
																		style='background-color: Gold;'>粗利</td>
														</tr>
														<tr>
																<td class="tg-s6z2"><span style='color: RED; font-size: 10px;'>保存してから計算します</span></td>
																<td class="tg-s6z2"><span style='color: RED; font-size: 14px;'>-</span></td>
																<td class="tg-s6z2"><span style='color: RED; font-size: 14px;'>-</span></td>
																<td class="tg-s6z2"><span style='color: RED; font-size: 14px;'>-</span></td>
														</tr>
												</table>
												<input type="submit" value="保存" class='update'>
										</form>

										<br> <br>

										<!-- DATA FINISHED -->
								</div>
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>
    <?php require_once '../master/footer.php';?>
</body>
</html>

