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
	$('#loading').delay(300).fadeOut(300);
		} );
</script>
<style type="text/css">

.topBlock{
	width: 600px;
	margin-left: auto;
	margin-right: auto;
	background-color: #CCC;
	margin-top: 225px;
	padding: 10px;
	}
.topBlockHalf{
	width: 90%;
	background-color: #AAA;
	padding: 10px;
	margin-left: auto;
	margin-right: auto;
}
.termsAndConditionsTopTableWrapper {
	width: 100%;
	height: auto;
	background-color: #CCC;
	}
.termsAndConditionsTopTableWrapper table {
	
	border: solid 2px #CCC;
}	
.termsAndConditionsTopTableWrapper th{
	max-width: 75px;
	text-align: right;
	padding-right: 10px;
	}	
.termsAndConditionsTopTableWrapper td{
	text-align: right;
	padding-right: 10px;
	
	}
.termsAndConditionsTopTableWrapper table{
	width: 100%;
	background-color: #FFF;
	margin-left: auto;
	margin-right: auto;
	padding: 10px;
}		
.termsAndConditionsTopTableWrapper input[type=text]{
	width: 100%;
	height: 24px;
}
.termsAndConditionsTopTableWrapper select{
	width: 100%;
	height: 24px;
}
.hitsuyou {
	color: red;
	}
</style>
</head>
<body>
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
    	//get info from the id
    	//set defualt values
    	$maker = "";
    	$year = "";
    	$memo = "";
    	$rate = "";
    	$percent = "";
    	$netTerm = "";
    	$currency = "";
    	$sp1Par = "";
    	$sp2Par = "";
    	$sp3Par = "";
    	$sp4Par = "";
    	$sp5Par = "";
    	$id = $_GET['id'];
    	
		$result = mysql_query("SELECT * FROM `sp_disc_rate` WHERE `id` = '$id'");
		while ($row = mysql_fetch_assoc($result)){
        //set vars
        $maker = $row['maker'];
		$colorId = $row['colorId'];
    	$year = $row['year'];
    	$memo = $row['memo'];
    	$rate = $row['rate'];
    	$percent = $row['percent'];
    	$netTerm = $row['netTerm'];
    	$currency = $row['currency'];
    	$sp1Par = $row['sp1Par'];
    	$sp2Par = $row['sp2Par'];
    	$sp3Par = $row['sp3Par'];
    	$sp4Par = $row['sp4Par'];
    	$sp5Par = $row['sp5Par'];
		}
    	?>
    			<div class='topBlock'>
    			<h2 style='background-color: #FFFFFF; margin: 5px; padding: 3px;'><?php echo $maker." ".$year." [ ".$memo." ]";?></h2>
    		<form name='inputForm' id='termsAndConditionsInputForm' method='post' action='exe/exeEditTermsAndConditions.php'
										onsubmit="return validateTermsAndConditionsForm()">
    			<div class='topBlockHalf'>
        			<div class="termsAndConditionsTopTableWrapper">
                		<table>
                    			<tr><th><span class='hitsuyou'>※</span>メーカー</th><td><input type='text' name='maker' value='<?php echo $maker;?>' style='width: 50%;float: left;'>色: <input type='color' name='colorId' value='<?php echo $colorId; ?>'></td>
                    			<tr><th><span class='hitsuyou'>※</span>年(例：1970)</th><td><input type='text' name='year' maxlength="4" size="4" value='<?php echo $year;?>'></td></tr>
                    			<tr><th><span class='hitsuyou'>※</span>メモ(N45,PL2014...)</th><td><input type='text' name='memo' value='<?php echo $memo;?>'></td></tr>
                    			<tr><th><span class='hitsuyou'>※</span>レート(￥)</th><td><input type='text' name='rate' value='<?php echo $rate;?>'></td></tr>
                    			<tr><th><span class='hitsuyou'>※</span>経費(%)</th><td><input type='text' name='percent' value='<?php echo $percent;?>'></td></tr>
                    			<tr><th><span class='hitsuyou'>※</span>NET言語</th><td>
                    			<select name="netTerm">
                    			<?php 
                    			// set the selected option
                    			if ($netTerm == "EXW"){
                    			    $EXW = " value='EXW' selected=selected";
                    			} else {
                    			    $EXW = " value='EXW' ";
                    			}
            			        if ($netTerm == "FOB"){
                    			    $FOB = " value='FOB' selected=selected";
                    			} else {
                    			    $FOB = " value='FOB' ";
                    			}
                    			if ($netTerm == "FCA"){
                    			    $FCA = " value='FCA' selected=selected";
                    			} else {
                    			    $FCA = " value='FCA' ";
                    			}
                    			if ($netTerm == "DDU"){
                    			    $DDU = " value='DDU' selected=selected";
                    			} else {
                    			    $DDU = " value='DDU' ";
                    			}
    								echo "<option value=''>選ぶ</option>";
    								echo "<option ".$EXW." >EXW</option>";
    								echo "<option ".$FOB." >FOB</option>";
    								echo "<option ".$FCA." >FCA</option>";
    								echo "<option ".$DDU." >DDU</option>";
    								?>
    							</select>
                    			</td></tr>
                    	</table>
            		</div>
    			</div>
    			<div class='topBlockHalf'>
        			<div class="termsAndConditionsTopTableWrapper">
            			<table>
            					<tr><th><span class='hitsuyou'>※</span>通貨</th><td>
                						<select name="currency">
                        					<?php 
                                			// set the selected option
                                			if ($currency == "EUR"){
                                			    $EUR = " value='EUR' selected=selected";
                                			} else {
                                			    $EUR = " value='EUR' ";
                                			}
                        			        if ($currency == "USD"){
                                			    $USD = " value='USD' selected=selected";
                                			} else {
                                			    $USD = " value='USD' ";
                                			}
                                			if ($currency == "YEN"){
                                			    $YEN = " value='YEN' selected=selected";
                                			} else {
                                			    $YEN = " value='YEN' ";
                                			}
                                			if ($currency == "RMB"){
                                			    $RMB = " value='RMB' selected=selected";
                                			} else {
                                			    $RMB = " value='RMB' ";
                                			}
                								echo "<option value=''>選ぶ</option>";
                								echo "<option ".$EUR." >€ EUR</option>";
                								echo "<option ".$USD." >$ USD</option>";
                								echo "<option ".$YEN." >￥ YEN</option>";
                								echo "<option ".$RMB." >元 RMB</option>";
        								    ?>
        									
    									</select>
            					</td></tr>
                    			<tr><th><span class='hitsuyou'>※</span>割引条件1(%)</th><td><input type='text' name='sp1' value='<?php echo $sp1Par;?>'></td></tr>
                    			<tr><th>割引条件2(%)</th><td><input type='text' name='sp2' value='<?php echo $sp2Par;?>'></td></tr>
                    			<tr><th>割引条件3(%)</th><td><input type='text' name='sp3' value='<?php echo $sp3Par;?>'></td> </tr>
                    			<tr><th>割引条件4(%)</th><td><input type='text' name='sp4' value='<?php echo $sp4Par;?>'></td></tr>
                    			<tr><th>割引条件5(%)</th><td><input type='text' name='sp5' value='<?php echo $sp5Par;?>'></td></tr>
                    			
                    			<tr>
                        			<th colspan="2" style='text-align: center;'>
                            			<input type='submit' value='アップデート' class='submit'>
                            			<input type='hidden' name='id' value='<?php echo $id;?>'>
                        			</th>
                    			</tr>
                		</table>
            		</div>
    			</div>
    		</form>
    		<button class='cancelBtn' style='margin: 10px;' onclick="window.location.href='termsAndConditions.php?pr=1'"> ＜ 戻る</button>
    		</div>
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>