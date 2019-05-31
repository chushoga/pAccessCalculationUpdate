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
	$( "#datepicker" ).datepicker({ dateFormat: "yy.mm.dd" });
		} );
    
// prevent the form from being submitted on enter
$(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
</script>

<style type="text/css">

.ui-datepicker-prev {
		background-color: #FFF;
}

.ui-datepicker-next {
		background-color: #FFF;
}

    #finishedStatus {
        width: 100%;
        height: 30px;
        float: left;
        color: #AAA;
    }
    .finishedStatusBoxText{
        float: left;
        font-weight: bold;
        height: 30px;
        line-height: 30px;
        margin-right: 0px;
        padding-left: 10px;
        padding-right: 5px;
        background-color: #EBEBEB;
    }
    
    .finishedStatusBoxCheck {
        float: left;
        height: 25px;
        padding-top: 5px;
        padding-right: 4px;
        margin-right: 0px;
        background-color: #EBEBEB;
    }
    
    .finishedStatusCheckColored{
        background-color: #99cb3d;
    }

.regular-radio {
	-webkit-appearance: none;
	background-color: #fafafa;
	border: 1px solid #cacece;
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
	padding: 6px;
	/* border-radius: 50px; */
	display: inline-block;
	position: relative;
    margin-top: 2px;
}

.regular-radio:checked:after {
	content: ' ';
	width: 10px;
	height: 10px;
	/* border-radius: 50px; */
	position: absolute;
	top: 1px;
	background: #DEDEDE;
	box-shadow: inset 0px 0px 10px rgba(0,0,0,0.3);
	text-shadow: 0px;
	left: 1px;
	font-size: 12px;
}

.regular-radio:checked {
	background-color: #e9ecee;
	color: #99a1a7;
	border: 1px solid #adb8c0;
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1), inset 0px 0px 10px rgba(0,0,0,0.1);
}

.regular-radio:active, .regular-radio:checked:active {
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
}


</style>
</head>
<body>
	<div id='wrapper'>	
		
    	<?php 
    	require_once '../header.php';
    	
		/////////////////////////////// SET VARIABLES ///////////////////////////////
		/////////////////////////////////////////////////////////////////////////////


		//	$date = $_POST['date'];
		//	$forwarder = $_POST['forwarder'];
		//	$vessle = $_POST['vessle'];
		//	$packing = $_POST['packing'];
		// set the number of differnt variables
		// loop 10 times
		//SET LOOP TIMES
		$l=10;
		//

		$topAmountSub = 0;
		$topRateSub = 0;

		$divide = 0;

		$topMakerTotal = $topAmountSub + $topRateSub;


		$id = $_GET['id'];
		$i = 0;
		$orderNo_[$i] = " ";
		//-----------------------------------------------------------------------------
		$resultSetter = mysql_query("SELECT * FROM expense WHERE `id` = '$id' ") or die(mysql_error());
		while ($rowSetter = mysql_fetch_assoc($resultSetter)){
		    for ($i = 1; $i<=$l; $i++) {

		       // if ($orderNo_[$i] == ' ' ){
		            $orderNo_[$i] = 0;
		            $makerName_[$i] = 0;
		            $currency1_[$i] = 0;
		            $currency2_[$i] = 0;
		            $rate_[$i] = 0;
		       // } else {
		            $orderNo_[$i] = $rowSetter['orderNo_'.$i];
		            $makerName_[$i] = $rowSetter['makerName_'.$i];
		            $currency1_[$i] = $rowSetter['currency1_'.$i];
		            $currency2_[$i] = $rowSetter['currency2_'.$i];
		            $rate_[$i] = $rowSetter['rate_'.$i];
		       // }

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
            $finUser_01 = $rowVar['finUser_01']; // user 1 finished
            $finUser_02 = $rowVar['finUser_02']; // user 2 finished
            $finAll = $rowVar['finAll']; // all finished
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
		    $customsTotal = $rowVar['customsTotal'];
		    $inspectionTotal = $rowVar['inspectionTotal'];
		    $inlandShippingTotal = $rowVar['inlandShippingTotal'];
		    $otherTotal = $rowVar['otherTotal'];
		    $consumptionTaxTotal = ($customsTotal+$inlandShippingTotal+$otherTotal)*$jpRate;
		    $tarrifTotal = $rowVar['tarrifTotal'];
		    $memo = $rowVar['memo'];
		    $consumptionTotal = $rowVar['consumptionTotal'];
		    $taxTotal = $rowVar['taxTotal'];


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
		
		//-----------------------------------------------------------------------------

        /* SET THE FINISHED CHECKED*/
        if($finUser_01 == 1){
            $finUser_01Checked = 'checked';
            $finished_01Col = 'background-color: #C3EBB9; color: #242424;';
            $finished_01ColTxt = ' ● ';
        } else {
            $finUser_01Checked = '';
            $finished_01Col = '';
            $finished_01ColTxt = ' × ';
        }
        // ----------------------------
        if($finUser_02 == 1){
            $finUser_02Checked = 'checked';
            $finished_02Col = 'background-color: #C3EBB9; color: #242424;';
            $finished_02ColTxt = ' ● ';
        } else {
            $finUser_02Checked = '';
            $finished_02Col = '';
            $finished_02ColTxt = ' × ';
        }
        // ----------------------------
        if($finAll == 1){
            $finAllChecked = 'checked';
            $finishedAll_Col = 'background-color: #C3EBB9; color: #242424';
            $finishedAll_ColTxt = ' ● ';
        } else {
            $finAllChecked = '';
            $finishedAll_Col = '';
            $finishedAll_ColTxt = ' × ';
        }
		?>
    	<div class='contents'>
    		<!-- PAGE CONTENTS START HERE -->
    		
            
            
            <form name='editExpense' id='editExpense' action="exe/exeExpenseUpdate.php?id=<?php echo $id; ?>"
                    method='post'>
            <!-- EDIT BAR START -->
                <div class="editBar">
            <?php 
            echo "
            <div id='finishedStatus'>
                    
                        <div class='finishedStatusBoxText' style='$finished_01Col'>
                            河合
                        </div>
                        <div class='finishedStatusBoxCheck' style='$finished_01Col'>
                            <input type='hidden' name='finUser_01' value='0'>
                            <input type='checkbox' class='regular-radio' name='finUser_01' value='1' ".$finUser_01Checked.">
                       </div>
                   
                   
                        <div class='finishedStatusBoxText' style='$finished_02Col'>
                           上杉
                        </div>
                        <div class='finishedStatusBoxCheck' style='$finished_02Col'>
                            <input type='hidden' name='finUser_02' value='0'>
                            <input type='checkbox' class='regular-radio' name='finUser_02' value='1' ".$finUser_02Checked."> 
                        </div>
                  
                   
                    
                        <div class='finishedStatusBoxText' style='$finishedAll_Col'>
                            全体完成
                        </div>
                        <div class='finishedStatusBoxCheck' style='$finishedAll_Col'>
                            <input type='hidden' name='finAll' value='0'>
                            <input type='checkbox' class='regular-radio' name='finAll' value='1' ".$finAllChecked."> 
                      
                   </div>";
                    
            ?>
                    <button class='cancelBtn'
                            style='width: auto; padding: 2px; float: right; margin-right: 5px; margin-top: 4px;'
                            onClick="location.href='expense.php?pr=3&id=<?php echo $id;?>'">キャンセル</button>
                </div>
                <!-- EDIT BAR FINISHED -->
                
                <div class='clear'></div>
                
                    <div class='sheetWrapper'>
                            <div class='tax'>
                                    消費税 <input type='text' name='jpRate'
                                            value='<?php echo $jpRate;?>'>%
                            </div>
                            <div class='sheetTop'>
                                    <div class='sheetTopBox1Wrapper'>
                                            <div class='sheetTopBox1Top'>入荷日</div>
                                            <div class='sheetTopBox1Bottom'>
                                                    <input type='text' value='<?php echo $date;?>'
                                                            name='date' id='datepicker'>
                                            </div>
                                    </div>
                                    <div class='sheetTopBox1Wrapper'>
                                            <div class='sheetTopBox1Top'>フォワーダー</div>
                                            <div class='sheetTopBox1Bottom'>
                                                    <input type='text' value='<?php echo $forwarder;?>'
                                                            name='forwarder'>
                                            </div>
                                    </div>
                                    <div class='sheetTopBox1Wrapper'>
                                            <div class='sheetTopBox1Top'>Vessel</div>
                                            <div class='sheetTopBox1Bottom'>
                                                    <input type='text' value='<?php echo $vessle;?>'
                                                            name='vessle'>
                                            </div>
                                    </div>
                                    <div class='sheetTopBox1Wrapper'>
                                            <div class='sheetTopBox1Top'
                                                    style='border-right: 1px solid #CCC;'>梱包/コンテナー</div>
                                            <div class='sheetTopBox1Bottom'
                                                    style='border-right: 1px solid #CCC;'>
                                                    <input type='text' value='<?php echo $packing;?>'
                                                            name='packing'>
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

                                                            </tr>
                                                    </thead>
                                                    <?php
                                                    $result = mysql_query("SELECT * FROM expense WHERE `id` = '$id' ") or die(mysql_error());
                                                    while ($row = mysql_fetch_assoc($result)){
                                                        for ($i = 1; $i<=10; $i++) {

                                                            echo "
                                                    <tbody>
                                                            <tr>
                                                                    <td style='border-left: none;'>
                                                                    <input type='text' name='orderNo_".$i."' value='";
                                                            echo $row['orderNo_'.$i];
                                                            echo "'></td>
                                                                    <td><input type='text' name='makerName_".$i."' value='";
                                                            echo $row['makerName_'.$i];
                                                            echo "'></td>";

                                                            $selected1 = "";
                                                            $selected2 = "";
                                                            $selected3 = "";
                                                            $selected4 = "";
                                                            $selected5 = "";
                                                            $selected6 = "";
                                                            switch ($row['currency1_'.$i]) {
                                                                case "EUR":
                                                                    $selected1 = "selected";
                                                                    break;
                                                                case "US$":
                                                                    $selected2 = "selected";
                                                                    break;
                                                                case "CNY":
                                                                    $selected3 = "selected";
                                                                    break;
                                                                case "JPY":
                                                                    $selected4 = "selected";
                                                                    break;
                                                                case "DKK":
                                                                    $selected5 = "selected";
                                                                    break;
                                                                case "SGD":
                                                                    $selected6 = "selected";
                                                                    break;
                                                                default:
                                                                    $selected1 = "";
                                                                    $selected2 = "";
                                                                    $selected3 = "";
                                                                    $selected4 = "";
                                                                    $selected5 = "";
                                                                    $selected6 = "";
                                                                    break;
                                                            }

                                                            echo "<td><select name='currency1_".$i."'>
                                                                                    <option value='' >選ぶ</option>
                                                                                    <option value='EUR' "; echo $selected1; echo ">EUR</option>
                                                                                    <option value='US$' "; echo $selected2; echo ">US$</option>
                                                                                    <option value='CNY' "; echo $selected3; echo ">CNY</option>
                                                                                    <option value='JPY' "; echo $selected4; echo ">JPY</option>
                                                                                    <option value='DKK' "; echo $selected5; echo ">DKK</option>
                                                                                    <option value='SGD' "; echo $selected6; echo ">SGD</option>

                                                                    </select> <input style='width: 80px;' type='text'
                                                                            name='currency2_".$i."' value='";
                                                            echo $row['currency2_'.$i];
                                                            echo "'></td>
                                                                    <td><input style='width: 50px;' type='text'
                                                                            name='rate_".$i."' value='";
                                                            echo $row['rate_'.$i];
                                                            echo "'></td>

                                                            </tr>
                                                    </tbody>
                                                    ";

                                                        }
                                                    }
                                                    ?>

                                            </table>
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
                                                            <td class='aRight'>￥ <input type='text'
                                                                    value='<?php echo $bankCharge;?>'
                                                                    name='bankCharge'>
                                                            </td>
                                                            <td class='aRight'><?php // echo $bankChargeTimes;?><input
                                                                    type='text' value='<?php echo $bankChargeTimes;?>'
                                                                    name='bankChargeTimes'></td>

                                                            <td class='aRight'>￥<?php //echo number_format($bankChargeTotal, 0, '.', ',');?>
                                                                    <input type='text'
                                                                    value='<?php echo $bankChargeTotal;?>'
                                                                    name='bankChargeTotal'>
                                                            </td>
                                                    </tr>
                                                    <tr>
                                                            <td>運賃</td>
                                                            <td class='aRight'></td>
                                                            <td class='aRight'></td>
                                                            <td class='aRight'>￥ <input type='text'
                                                                    value='<?php echo $shippingTotal;?>'
                                                                    name='shippingTotal'>
                                                            </td>
                                                    </tr>
                                                    <tr>
                                                            <td>運賃 (外貨)</td>
                                                            <td class='aRight'> <input type='text'
                                                                    value='<?php echo $shippingCharge;?>'
                                                                    name='shippingCharge'>
                                                            </td>
                                                            <td class='aRight'><input type='text'
                                                                    value='<?php echo $shippingChargeTimes;?>'
                                                                    name='shippingChargeTimes'>
                                                            </td>
                                                            <td class='aRight'>￥ <input type='text'
                                                                    value='<?php echo $shippingChargeTotal;?>'
                                                                    name='shippingChargeTotal'>
                                                            </td>
                                                    </tr>
                                                    <tr>
                                                            <td>保険料</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class='aRight'>￥ <input type='text'
                                                                    value='<?php echo $insuranceTotal;?>'
                                                                    name='insuranceTotal'>
                                                            </td>
                                                    </tr>
                                                    <tr>
                                                            <td>customs clearance fee</td>
                                                            <td>(非課税)</td>
                                                            <td></td>
                                                            <td class='aRight'>￥ <input type='text'
                                                                    value='<?php echo $clearanceTotal;?>'
                                                                    name='clearanceTotal'>
                                                            </td>
                                                    </tr>
                                                    <?php // INSPECTION BLOCK HERE....?>
                                                    <tr>
                                                            <td>検査,その他</td>
                                                            <td>(非課税)</td>
                                                            <td></td>
                                                            <td class='aRight'>￥ <input type='text'
                                                                    value='<?php echo $inspectionTotal;?>'
                                                                    name='inspectionTotal'>
                                                            </td>
                                                    </tr>

                                                    <?php // INSPECTION BLOCK HERE....?>
                                                    <tr>
                                                            <td>通関手数料</td>
                                                            <td>(課税)</td>
                                                            <td></td>
                                                            <td class='aRight'>￥ <input type='text'
                                                                    value='<?php echo $customsTotal;?>'
                                                                    name='customsTotal'>
                                                            </td>
                                                    </tr>

                                                    <tr>
                                                            <td>国内運賃</td>
                                                            <td>(課税)</td>
                                                            <td></td>
                                                            <td class='aRight'>￥ <input type='text'
                                                                    value='<?php echo $inlandShippingTotal;?>'
                                                                    name='inlandShippingTotal'>
                                                            </td>
                                                    </tr>
                                                    <tr>
                                                            <td>蔵出料,検査,その他</td>
                                                            <td>(課税)</td>
                                                            <td></td>
                                                            <td class='aRight'>￥ <input type='text'
                                                                    value='<?php echo $otherTotal;?>'
                                                                    name='otherTotal'>
                                                            </td>
                                                    </tr>

                                                    <tr>
                                                            <td>関税</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class='aRight'>￥ <input type='text'
                                                                    value='<?php echo $tarrifTotal;?>'
                                                                    name='tarrifTotal'>
                                                            </td>
                                                    </tr>
                                            </tbody>
                                    </table>

                                    <br>＜ メモ ＞(改行必要場合 &lt;br&gt;書いてください。)<br>
                                    <textarea name='memo'>
                                    <?php echo htmlspecialchars($memo);?>
                            </textarea>

                                    <div class='sheetBottomTotal'>
                                            <p>
                                                    経費合計 (B) <span class='greenText'>￥<?php echo number_format($bottomTotal, 0, '.', ',');?>
                                                    </span>
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
                                            <!-- <tbody>
                                                <tr>
                                                    <td>消費税 (<?php //echo $jpRate*100; echo "%";?>)</td>
                                                    <td class='aRight'>￥<?php //echo number_format($consumptionTaxTotal, 0, '.', ',');?>
                                                    </td>
                                                    </tr>																
                                            </tbody> -->

                                            <tbody>
                                                    <tr>
                                                            <td>消費税<span style='color: red'>※修正しない時 0 は自動計算になります。</span></td>
                                                            <td class='aRight'>￥ <input type='text'
                                                                    value='<?php echo $taxTotal;?>'
                                                                    name='taxTotal'>
                                                            </td>
                                                    </tr>
                                                    <tr>
                                                            <td>輸入消費税</td>
                                                            <td class='aRight'>￥ <input type='text'
                                                                    value='<?php echo $consumptionTotal;?>'
                                                                    name='consumptionTotal'>
                                                            </td>
                                                    </tr>

                                            </tbody>

                                    </table>
                            </div>
                    </div>
            </form>
            <form method="post" action="exe/delExpense.php">
                <?php echo "<input type='hidden' name='id' value='".$id."'>"; ?>
                <div class="editBar">
                            <button class='delEntryBtn'
                                style='width: 40px; float: right; margin-right: 5px;'
                                onclick="return(YNconfirm()); ">削除</button>
                </div>
                <div class='clear'></div>
            <br>
            </form>
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>
	
	<?php require_once '../master/footer.php';?>
</body>
</html>