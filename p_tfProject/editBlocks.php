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

<?php
$counter = 1;
?>
$(document).ready( function() {
	//START OF THE ADD FUNCTION
	//BUTTON CLICK CODE
	$('.calcBtn').click(function () {
	    appendBox();
	});
	$('.cancelBtn').click(function () {
	    removeBox();
	});
		
		} );
</script>
<style type="text/css">
</style>
</head>
<body>
	<div id='wrapper'>
	
    	<?php require_once '../header.php';?>
    	
    	<div class='contents'>
    		<!-- PAGE CONTENTS START HERE -->
    		
						<?php
						//variables
						if(isset($_POST['id'])){
						$id = $_POST['id'];
						}
						if(isset($_GET['id'])){
						    $id = $_GET['id'];
						}

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
								<script>
								//SET COUNTER VARIABLES
								var counterPiece = 0;
								var setCount = <?php echo $count;?> + 1;
								var genkaTotal = 0;
								var salesTotal = 0;
								

								//ADD BOX CODE
								function appendBox() {
								    var a = setCount + counterPiece;
								    
								    var displayBlock = "<div id='addBox" + a + "' style='\
								    width: 40%;\
								    height: 30px; \
								    border: 2px solid #CCC;\
								    background-color: #FFF; \
								    margin-bottom: 10px; \
								    margin-left: 0px;\
								    font-size: 16px;\
								    line-height: 30px;\
								    text-align: center;\
								    padding: 3px;'>\
								 	 ブロック足した!  <span style='color: red'>※ [保存してから計算押して編集が出来ます] \
								 	<input type='hidden' name='itemCount_" + a + "' value='1'>\
								 	</span></div>";
								    counterPiece++;
								    //$(".additionalBoxes").append(a);
								    $(".additionalBoxes").append(displayBlock);

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
					
								
    function submitForm(action)
    {
        document.getElementById('editBlocksSave').action = action;
        document.getElementById('editBlocksSave').submit();
    }
</script>
								<div class='tableWrapper'>
								<?php
						echo "<button class='calcBtn' style='margin-right: 10px; margin-left: 10px; float: left;'>入力ブロック +</button>";
						echo "<button class='cancelBtn' style='float: left;'>入力ブロック -</button>";
						?>
										<form id='editBlocksSave' name='editBlocksSave' action='exe/exeEditProject.php'
												method='POST'
												onSubmit="if(!confirm('これでいいですか?')){return false;}">
												<input type="hidden" name='dbId' value="<?php echo $id;?>">
												<input type="button" value="キャンセル"
														style='float: right; padding: 2px; margin-right: 5px;'
														class='cancelBtn'
														onClick="location.href='tfProject.php?pr=2&id=<?php echo $id;?>'">
														<br><br>
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
																<td class='tg-s6z2' colspan='2'>".$row['projectName']."</td>
																<td class='tg-s6z2' colspan='3'>".$row['place']."</td>
																<td class='tg-s6z2'>".$row['date']."</td>
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

												for ($i = 1; $i <= $count; $i++){
												    $result = mysql_query("SELECT * FROM tfProject WHERE `id` = '$id'");
												    while ($row = mysql_fetch_assoc($result)){
												        // SET THE LOOP VARIABLES
												        $priceListAD = $row['priceList_'.$i]*(1-($row['generalDisc_'.$i]/100))*(1-($row['projectDisc_'.$i]/100));
												        $yenAmount = $row['priceList_'.$i]*(1-($row['generalDisc_'.$i]/100))*(1-($row['projectDisc_'.$i]/100))*$row['rate_'.$i]*(1+($row['percent_'.$i]/100));
												        $genka = $row['itemCount_'.$i]*intval($yenAmount);
												        

												        //$yenMitBai = $row['mitsumori_'.$i]/intval($yenAmount);
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
														<td class='tg-s6z2' colspan='5' rowspan='2' style='border: none;'></td>
												</tr>
												<tr>
														<td class='tg-s6z2' >".$row['archNo_'.$i]."</td>
														<td class='tg-s6z2' colspan='2'>".$row['type_'.$i]."</td>
														<td class='tg-s6z2' colspan='4'>".$row['itemCount_'.$i]."</td>
												</tr>



												<tr>
														<td class='tg-s6z2' rowspan='4'>";
												        if ($row['image_'.$i] == ''){
												            echo "イメージ";
												        } else {
												            echo "<img src='../".$row['image_'.$i]."' style='max-width: 115px; max-height: 137px;'>";
												            echo "<br>";
												            echo "<a href='exe/exeImgDelete.php?id=$id&imgId=image_$i'>イメージ削除</a>";
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
														<td class='tg-s6z2'>".$row['maker_'.$i]."</td>
														<td class='tg-s6z2'>".$row['series_'.$i]."</td>
														<td class='tg-s6z2' colspan='2'>".$row['tformNo_'.$i]."</td>
														<td class='tg-s6z2' colspan='2'>".$row['makerNo_'.$i]."</td>
														<td class='tg-s6z2' colspan='5'>".$row['finish_'.$i]."</td>
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
														<td class='tg-s6z2'>".$row['currency_'.$i]."</td>
														<td class='tg-s6z2'>".$row['priceList_'.$i]."</td>
														<td class='tg-s6z2'>".$row['generalDisc_'.$i]."</td>
														<td class='tg-s6z2'>".$row['projectDisc_'.$i]."</td>
														<td class='tg-s6z2'>".$priceListAD."</td>
														<td class='tg-s6z2'>".$row['rate_'.$i]."</td>
														<td class='tg-s6z2'>".$row['percent_'.$i]."</td>
														<td class='tg-s6z2'>￥".number_format($yenAmount, 0, '.',',')."</td>
														<td class='tg-s6z2'>￥".number_format($genka, 0, '.', ',')."</td>
														<td class='tg-031e' colspan='2'>".$row['memo_'.$i]."</td>
												</tr>
												<tr>
														<td class='tg-031e' colspan='7' rowspan='2'>";
												        if ($count > 1){
												        ?>
												<input type='button'
														onClick="
														if(!confirm('本当このブロック削除で宜しいですか?')){
														return false;
														}else{
														submitForm('exe/exeDelBlock.php?id=<?php echo $id; ?>&block=<?php echo $i;?>') 
														}
														"
														value='ブロック削除' class='delBtn' style='margin-left: 10px;' />
														<?php
												        } else {}
														echo "</td>
														<td class='tg-s6z3'>倍率</td>
														<td class='tg-s6z3'>見積単価</td>
														<td class='tg-s6z3'>販売価格（税別）</td>
														<td class='tg-s6z3'>掛率</td>
														<td class='tg-s6z3'>上代</td>
												</tr>
												<tr>
														<td class='tg-s6z2'>".number_format($yenMitBai, 2, '.','')."<br>
														
														
														</td>
														<td class='tg-s6z2'>￥".number_format($row['mitsumori_'.$i], 0, '.',',')."</td>
														<td class='tg-s6z2'>￥".number_format($salesPrice, 0, '.',',')."</td>
														<td class='tg-s6z2'>".number_format($retailBai, 2, '.','')."</td>
														<td class='tg-s6z2'>".$row['retailPrice_'.$i]."</td>
												</tr>
												</table>
												<br>
												";
														$totalGenka += $genka;
														$totalSales += $row['mitsumori_'.$i]*$row['itemCount_'.$i];
														echo "<script>
                                                		document.getElementById('file_$i').onchange = function() {
                                                		    document.getElementById('form_$i').submit();
                                                		}
                                                </script>";


												    }
												}
												?>

												<!-- END OF LOOP -->
												<div class='additionalBoxes'></div>
												<br> <br>
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
																<td class="tg-s6z4">仕入合計</td>
																<td class="tg-s6z4">販売合計</td>
																<td class="tg-s6z4" colspan="2"
																		style='background-color: Gold;'>粗利</td>
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
																//echo number_format((($totalSales-$totalGenka)/$totalSales)*100, 2, '.',',')."%";


																?>
																</td>
																<td class="tg-s6z2"><?php echo "￥".number_format(intval($totalSales-$totalGenka), 0, '.',',');?>
																</td>
														</tr>
												</table>


										</form>
										<br> <input type='button'
												onClick="
														if(!confirm('本当こ全体のエントリー削除で宜しいですか?')){
														return false;
														}else{
														submitForm('exe/exeDelRecord.php?id=<?php echo $id; ?>') 
														}
														"
												value='全体削除' class='delEntryBtn'
												style='float: right; margin-right: 5px;' /> <br> <br>
    		</div>
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>	
	<?php require_once '../master/footer.php';?>
</body>
</html>

