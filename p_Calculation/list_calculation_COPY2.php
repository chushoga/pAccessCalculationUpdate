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
/*DATATABLES START*/
	var defaultOptions = {
			"bJQueryUI": true,
			"bPaginate": false,
			"bInfo": false,
			"sScrollX" : "100%",
			"iDisplayLength": 100,
			"order": [[ 2, "asc" ]]
				};//options
	var calcDataTableHeight = function() {
	    var minusResult = 180;
	    var h = Math.floor($(window).height() - minusResult);
	    return h + 'px';
	};
	defaultOptions.sScrollY = calcDataTableHeight();
	
	var oTable = $('#calcTable').dataTable(defaultOptions);

	 $(window).bind('resize', function () {
		 $('div.dataTables_scrollBody').css('height',calcDataTableHeight());
		oTable.fnAdjustColumnSizing();
	  } );
/*DATATABLES END*/
//START WITH REFRESH
$(function() {
			e = $.Event('keyup');
			e.keyCode= 82; // press r key to refresh Cap Sensative
			$('input').trigger(e);
		});
//PREVENT ENTER KEY FROM TRIGGERING SUBMIT ON FORM
     $('#listSave').bind("keyup keypress", function(e) {
		  var code = e.keyCode || e.which; 
		  if (code  == 13) {               
		    e.preventDefault();
		    return false;
		  }
		});
// TOOL TIP
	$(function() { $( document ).tooltip(); });
// LOADING
	$('#loading').delay(300).fadeOut(300);
// CLEAR ALL
    $("#clearButton").click(function() {
    	$("input[type=text]").val('0');
    });

});

//-------------------------------------------
</script>
<style type="text/css">
.currencyRates {
	padding: 5px;
	height: 25px;
}
.currencyRates input[type=text] {
	width: 30px;
	height: 18px;
	text-align: center;
}
.currencyRates div {
	float: left;
	padding: 2px;
	margin-right: 20px;
}
.rateDiscountColor {
	color: #3AC1D6;
	
}


</style>
</head>
<body>
<?php 
$savFileDate = "fixHistory";
$saveFileProjectName = "January2015";
$saveFileName = $saveFileProjectName."_".$savFileDate;
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
    		

/* ------------------------------------------------------------------------
 * ----------------------------- VARIABLES --------------------------------
 */
// SET LABLE INFO FOR ON HOVER
$lbl_image = "";
$lbl_series = "";
$lbl_tformNo = "";
$lbl_haibanCheck = "(PL = 0) && (廃番 = FALSE) => ☑が必要";
$lbl_makerNo = "";
$lbl_set = "品番はセットかどうか";
$lbl_pl_previous = "前のPL価格";
$lbl_priceRateIncrease = "値上率";
$lbl_currencyName = "通貨";
$lbl_pl_current = "PL価格";
$lbl_discount = "値引率";
$lbl_rate = "レート条件〔 ￥ / % 〕";
$lbl_purchasePrice = "仕入原価";
$lbl_net = "NET価格 = (PL価格*(割引条件/100)) * レート〔￥〕) * (1+(パーセント〔%〕/100)) ";
$lbl_totalCost = "原価価格 = (NET価格 += )";
$lbl_bairitsu = "販売価格/原価価格";
$lbl_salesPrice = "";
$lbl_bairitsu_new= "新倍率 = 販売価格/新販売価格";
$lbl_salesPrice_new = "計算インプット";
$lbl_ = "";
// ************************************************************************
$isSet = false; //set this variable in the loop
$t = 1;
$s = 1;
// set the list name from the get `id`
if(isset($_GET['id'])){
    $listName = $_GET['id'];
} else {
    $listName = "NUll";
}
// SET THE PLACE-----------------------------------------------------------
if(isset($_POST['hide'])){
    $hideInsert = "UPDATE `makerlistcontents` 
    									SET 
    									`isHinbanHidden` = true
    									 WHERE `listName` = '$listName'";
    mysql_query($hideInsert) or die(mysql_error());
}
if(isset($_POST['show'])){
    $hideInsert = "UPDATE `makerlistcontents` 
    									SET 
    									`isHinbanHidden` = false
    									 WHERE `listName` = '$listName'";
    mysql_query($hideInsert) or die(mysql_error());
}
/* ------------------------------------------------------------------------
 */
                           
 /* ------------------------------------------------------------------------
 */

//GET makerlistcontents query
$makerListInfoResult = mysql_query("SELECT * FROM `makerlistcontents` WHERE `listName` = '$listName'");
while ($makerListInfoRow = mysql_fetch_assoc($makerListInfoResult)){
// SET RATES AND PERCENTAGES HERE
    $EUR_rate = $makerListInfoRow['eur_rate'];
    $EUR_percent = $makerListInfoRow['eur_percent'];
    
    $USD_rate = $makerListInfoRow['usd_rate'];
    $USD_percent = $makerListInfoRow['usd_percent'];
    
    $RMB_rate = $makerListInfoRow['rmb_rate'];
    $RMB_percent = $makerListInfoRow['rmb_percent'];
    
    $DKR_rate = $makerListInfoRow['dkr_rate'];
    $DKR_percent= $makerListInfoRow['dkr_percent'];
    
    $SKR_rate = $makerListInfoRow['skr_rate'];
    $SKR_percent = $makerListInfoRow['skr_percent'];
    
    $SGD_rate = $makerListInfoRow['sgd_rate'];
    $SGD_percent = $makerListInfoRow['sgd_percent'];
    
    $YEN_rate = 1;
    $YEN_percent = 0;
    
    $isHinbanHidden = $makerListInfoRow['isHinbanHidden'];
}

if($isHinbanHidden == false){

    $showHinbanBtn = "<button class='showBtn' name='hide' style='margin-left: 5px;' title='品番非表示' ><span style='color: BLACK;'><i class='fa fa-eye-slash'></i></span> 廃番</button>";
} else {
    $showHinbanBtn = "<button class='showBtn' name='show' style='margin-left: 5px;' title='品番表示' ><span style='color: RED;'><i class='fa fa-eye'></i></span> 廃番</button>";
}

    		?>
    		<div class='currencyRates'>
    		<form method='post' action='exe/exeSetListDetails.php' id='detailsSave' style='float: left;'>
            		<div>EUR: <input type='text' name='eur_rate' value='<?php echo $EUR_rate;?>' class='rateDiscountColor'> <input type='text' name='eur_percent' value='<?php echo $EUR_percent;?>'  class='rateDiscountColor'>%</div> 
            		<div>USD: <input type='text' name='usd_rate' value='<?php echo $USD_rate;?>' class='rateDiscountColor'> <input type='text' name='usd_percent' value='<?php echo $USD_percent;?>'  class='rateDiscountColor'>%</div>
            		<div>RMB: <input type='text' name='rmb_rate' value='<?php echo $RMB_rate;?>' class='rateDiscountColor'> <input type='text' name='rmb_percent' value='<?php echo $RMB_percent;?>' class='rateDiscountColor'>%</div>
            		<div>DKR: <input type='text' name='dkr_rate' value='<?php echo $DKR_rate;?>' class='rateDiscountColor'> <input type='text' name='dkr_percent' value='<?php echo $DKR_percent;?>' class='rateDiscountColor'>%</div>
            		<div>SKR: <input type='text' name='skr_rate' value='<?php echo $SKR_rate;?>' class='rateDiscountColor'> <input type='text' name='skr_percent' value='<?php echo $SKR_percent;?>' class='rateDiscountColor'>%</div>
            		<div>SGD: <input type='text' name='sgd_rate' value='<?php echo $SGD_rate;?>' class='rateDiscountColor'> <input type='text' name='sgd_percent' value='<?php echo $SGD_percent;?>' class='rateDiscountColor'>%</div>
            		<input type="hidden" name='listName' value='<?php echo $listName;?>'>
            		<button type='submit' class='update' title='為替決定'>決定  <i class='fa fa-arrow-right'></i></button>
            		<!-- <input type='button' value ='保存せずに終了' style='float: right; padding: 2px; margin-right: 5px;' class='delEntryBtn' onClick="location.href='list_calculation_view.php?pr=1&id=<?php echo $listName;?>'"> -->
			</form>
			<button type='button' id='clearButton' style='float: left; margin-left: 5px;' class='cancelBtn' title='押してから保存もしくは決定'> すべてクリア </button>
    			<a href='list_calculation_printView.php?pr=1&id=<?php echo $listName;?>'><img alt="excel export" src="../img/excelExport.png" title='エクセルエクスポート' style='float: right; height: 32px;'></a>	
    		<form action="" method='POST'>
    		    <?php echo $showHinbanBtn;?>
    		</form>
    		</div>
     		<?php
    		if($EUR_rate == 0){
                $EUR_rate = 1;
                 $EUR_percent = 1;
            }
            if($USD_rate == 0){
                $USD_rate = 1;
                 $USD_percent = 1;
            }
            if($RMB_rate == 0){
                $RMB_rate = 1;
                 $RMB_percent = 1;
            }
            if($DKR_rate == 0){
                $UDKR_rate = 1;
                 $DKR_percent = 1;
            }
            if($SKR_rate == 0){
                $SKR_rate = 1;
                 $SKR_percent = 1;
            }
            if($SGD_rate == 0){
                $SGD_rate = 1;
                 $SGD_percent = 1;
            }
    		?>
<div id='saveWrapper'>
    		<form method='post' action='exe/exeSetListPrice.php' id='listSave'>
    		<table id="calcTable">
    		<?php
        		echo "<thead>";
        			echo "<tr>";
        				echo "<th><label title='".$lbl_image."'>イメージ</label></th>";
        				echo "<th><label title='".$lbl_series."'>シリーズ</label></th>";
        				echo "<th><label title='".$lbl_tformNo."'>Tform品番</label></th>";
        				echo "<th><label title='".$lbl_haibanCheck."'><i class='fa fa-check-square-o'></i></label></th>";
        				echo "<th><label title='".$lbl_makerNo."'>メーカー品番</label></th>";
        				echo "<th><label title='".$lbl_set."'>セット</label></th>";
        				echo "<th><label title='".$lbl_pl_previous."'>前のPL</label></th>";
        				echo "<th><label title='".$lbl_priceRateIncrease."'>値上率</label></th>";
        				echo "<th><label title='".$lbl_currencyName."'>通貨</label></th>";
        				echo "<th><label title='".$lbl_pl_current."'>PL</label></th>";
        				echo "<th><label title='".$lbl_discount."'>値引率</label></th>";
        				echo "<th><label title='".$lbl_net."'>NET</label></th>";
        				echo "<th><label title='".$lbl_rate."'>為替/経費</label></th>";
        				echo "<th><label title='".$lbl_purchasePrice."'>仕入原価</label></th>";
        				echo "<th><label title='".$lbl_totalCost."'>原価合計</label></th>";
        				echo "<th><label title='".$lbl_bairitsu."'>倍率</label></th>";
        				echo "<th><label title='".$lbl_salesPrice."'>販売価格</label></th>";
        				echo "<th><label title='".$lbl_bairitsu_new."'>NEW倍率</label></th>";
        				echo "<th><label title='".$lbl_salesPrice_new."'>NEW販売価格</label></th>";
        			echo "</tr>";
        		echo "</thead>";
        		echo "<tbody>";

/* *****************
 * MAIN LOOP STARTS
 * *****************
 */
$record = 0;
$counter = 0;
$totalRecords = 0;
//------------
//QUERY

//GET makerlistinfo query
$mainListResult = mysql_query("SELECT * FROM `makerlistinfo` WHERE `listName` = '$listName' ORDER BY `tformNo`");
//WHILE LOOP GO ->
while ($mainListRow = mysql_fetch_assoc($mainListResult)){
    $totalRecords++;
    $purchasePriceTotal = 0;
    $pref_purchasePriceTotal = 0;        		 
/* *******************************
 * HIDE HINBAN
 * CHECK LIST HAS HIDDEN VARIABLE
 * *******************************
 */
   $hbtformNo = $mainListRow['tformNo'];
// If true run the code else SKIP
if($isHinbanHidden == true AND isHaiban($hbtformNo) == true){
    //TRUE IF hide hinban switch is clicked and if it is indeed haiban
     $runCode = true;
} else {
    //IF FALSE run the code
    $runCode = false;
}    

//CHECK HERE TO RUN THE CODE OR NOT
if($runCode == false){


    // SET tformNo and other vars from main
   
    $tformNo = $mainListRow['tformNo'];
    $testPrice = $mainListRow['testPrice'];
    $haibanInfo = $mainListRow['haiban'];
    $listTformNoId = $mainListRow['id'];
    
    //MAIN QUERY TO SET DATA FROM MAIN
    $mainResult = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$tformNo' ORDER BY `tformNo`");
    //query
    while($mainRow = mysql_fetch_assoc($mainResult)){
        $series = $mainRow['series'];
        $set = $mainRow['set'];
        $setExplodCln = preg_replace('/\s+/','', $set);
        $setExplode = explode(",", $setExplodCln);
        $img = $mainRow['img'];
        $makerNo = $mainRow['makerNo'];
        $tformPriceNoTax = $mainRow['tformPriceNoTax'];
        /*
        if($testPrice != 0){
            $inputPrice = $testPrice;
        } else {
            $inputPrice = $tformPriceNoTax;
        } */
        $inputPrice = $testPrice;
       
       if($testPrice != $tformPriceNoTax AND $testPrice != 0){
            $isTestPrice = "color: #F06767;";
        } else {
            $isTestPrice = "";
        }
        
        //SET IF IT IS SET OR NOT WITH BOOLEAN VALUE
        if ($set == ""){
            $isSet = false;
        } else {
            $isSet = true;
        }
        // ------------------------------
        
        //GET SET DETAILS
        //query
        //check if set
        if ($isSet == true){
            foreach($setExplode as $value => $key){
                $setTformNo[] = $key;
                
            }
    // MAIN QUERY to set the 'SET'items
            foreach ($setExplode as $value1 => $key1){
                $setDetailsResult = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$key1'");
                while($setDetailsRow = mysql_fetch_assoc($setDetailsResult)){
                   $setMakerNo[] = $setDetailsRow['makerNo'];
                }
            }
    // PLCURRENT QUERY for SET
            foreach ($setExplode as $value1 => $key1){
                //SP_PLCURRENT
                    $setplCurrentResult = mysql_query("SELECT * FROM `sp_plCurrent` WHERE `tformNo` = '$key1'");
                    if(mysql_num_rows($setplCurrentResult)){
                    while($setplCurrentRow = mysql_fetch_assoc($setplCurrentResult)){
                        
                            $set_plCurrent[] = $setplCurrentRow['plCurrent'];
                        
                       //$set_plCurrent[] = $setplCurrentRow['plCurrent'];
                       $setplCurrent = $setplCurrentRow['plCurrent'];
                       $setsp_disc_rate_id = $setplCurrentRow['sp_disc_rate_id'];
                    //SP_DISC_RATE QUERY for SET
                     $set_sp_disc_rateResult = mysql_query("SELECT * FROM `sp_disc_rate` WHERE `id` = '$setsp_disc_rate_id'");
                    if(mysql_num_rows($set_sp_disc_rateResult)){
                        while($set_sp_disc_rateRow = mysql_fetch_assoc($set_sp_disc_rateResult)){
                          $set_currency[] =  $set_sp_disc_rateRow['currency'];
                          if ($set_sp_disc_rateRow['currency'] == 'YEN'){
                     // set the rate to 1 and percent to 0 if YEN
                              $set_rate[] = 1;
                              $setrate = 1;
                              $set_percent[] = 0;
                              $setpercent = 0;
                          } else {
                              $set_rate[] = $set_sp_disc_rateRow['rate'];
                              $setrate = $set_sp_disc_rateRow['rate'];
                              $set_percent[] = $set_sp_disc_rateRow['percent'];
                              $setpercent = $set_sp_disc_rateRow['percent'];
                             
                          }
                          
                          $set_discount[] = $set_sp_disc_rateRow['discount'];
                          $setdiscount = $set_sp_disc_rateRow['discount'];
                          $set_discountPar[] = $set_sp_disc_rateRow['discountPar'];
                          $set_net[]= ($setplCurrent * $setdiscount);
                          $setnet = ($setplCurrent * $setdiscount);
                          $set_purchasePrice[]= $setnet * $setrate * (1+($setpercent)/100); 
                          
                        }
                    } else {
                        $set_currency[] = 0;
                        $set_rate[] = 0;
                        $set_percent[] = 0;
                        $set_discountPar[] = 0;
                        $set_net[] = 0;
                        $set_purchasePrice[] = 0;
                        $set_plCurrent[] = 0;
                    }
                    }
                    //---
                    } else {
                            $set_plCurrent[] = 0;
                            $set_currency[] = 0;
                            $set_rate[] = 0;
                            $set_percent[] = 0;
                            $set_discountPar[] = 0;
                            $set_net[] = 0;
                            $set_purchasePrice[] = 0;
                        }
                    //---
                }
    
        } else {
            $setTformNo[] = "";
            $setMakerNo[] = "";
            $set_discount[] = "";
            $set_discountPar[] = "";
            $set_rate[] = "";
            $set_percent[]="";
            $set_net[] = "";
            $set_purchasePrice[] = "";
            $set_plCurrent[] = 0;
            
    //query for spCurrent for SINGLE
    //check if exists first
    $plCurrentResult = mysql_query("SELECT * FROM `sp_plCurrent` WHERE `tformNo` = '$tformNo'");
    if (mysql_num_rows($plCurrentResult)){
         while($plCurrentRow = mysql_fetch_assoc($plCurrentResult)){
             
             $plCurrent = $plCurrentRow['plCurrent'];
             if($plCurrent == 0){
             $plCurrentShow = "<span style='color: green; text-align: center;' title='※価格入力必要 (PL = 0)!!'><i class='fa fa-exclamation-triangle'></i></span>";
             } else {
                $plCurrentShow = number_format($plCurrentRow['plCurrent'],2); 
             }
             $sp_disc_rate_id = $plCurrentRow['sp_disc_rate_id'];
             if ($sp_disc_rate_id != 0 || $sp_disc_rate_id != ""){
                 //query for the sp_disc_rate
                 $single_sp_disc_rateResult = mysql_query("SELECT * FROM `sp_disc_rate` WHERE `id` = '$sp_disc_rate_id'");
                 while($single_sp_disc_rateRow = mysql_fetch_assoc($single_sp_disc_rateResult)){
                     $single_currency = $single_sp_disc_rateRow['currency'];
                     $single_discountPar = $single_sp_disc_rateRow['discountPar'];
                     $single_discount = $single_sp_disc_rateRow['discount'];
                     $single_rate = $single_sp_disc_rateRow['rate'];
                     $single_percent = $single_sp_disc_rateRow['percent'];
                     //net calculation for single
                     $single_net = $plCurrent * $single_discount;
                     $single_purchasePrice = $single_net * $single_rate * (1 + ($single_percent/100));
                     //-----------------
                 }
             } else {
                 $sp_disc_rate_id = 0;
                 $single_currency = "";
                 $single_discountPar = "";
                 $single_discount = "";
                 $single_rate = 0;
                 $single_percent = 0;
                 $single_net = 0;
                 $single_purchasePrice = 0;
             }
            }
    } else {
        $plCurrentShow = "<span style='color: orange; text-align: center;' title='※価格入力必要 !!'><i class='fa fa-exclamation-triangle'></i></span>";
        $single_discountPar = "";
        $single_discount = "";
        $plCurrent = "";
        $sp_disc_rate_id = 0;
        $single_currency = "";
        $single_rate = 0;
        $single_percent = 0;
        $single_net = 0;
        $single_purchasePrice = 0;
    }
        }
    }
    
    
    // MAIN QUERY END
            			echo "<tr>";
            			// IMG CODE
            			    echo "<td title='".$lbl_."'>";
                        if($img != ""){
    					    $thumRep = str_replace("img/img_phot/photo", "img/img_phot/photo_thum060", $img);
    					    echo "<img src ='http://www.tform.co.jp/".$thumRep."' style='max-width: 45px; max-height: 45px;'>";
    					} else {
    					    echo "<li class='fa fa-picture-o' style='font-size: 40px; color: #CCC;'></li>";
    					}
            			    echo "</td>";
                        // SERIES
            				echo "<td title='".$lbl_."'>$series</td>";
        				// TFORMNO, SET OR SINGLE
        				    
            				echo "<td title='".$lbl_."'><a href='calculation.php?pr=1&record=".$record."&search=".$tformNo."&list=$listName' tabindex='-1'>".$tformNo."</a></td>";
            			    $record++; //add to the record
// CHECK NEEDED -----------------------------------------------------
            			// IF (PL == 0) && (HAIBAN == FALSE) SHOW CHECK
            				echo "<td title='".$lbl_."'>";
            				 if ($isSet == false){
            				   $haibanResult = mysql_query("SELECT `memo` FROM `main` WHERE `tformNo` = '$tformNo'");
        				        while($haibanRow = mysql_fetch_assoc($haibanResult)){
        				            if(mb_strpos($haibanRow['memo'], "廃番") == true || mb_strpos($haibanRow['memo'], "メーカー") == true){
        				                
        				                echo "-";
        				            } else {
            				            if ($plCurrent == 0){
            				                    //echo $tformNo."<br>";
            				                    //echo "( ".$plCurrent." )<br>";
            				                    $checkedResult = mysql_query("SELECT * FROM `makerlistinfo` WHERE `tformNo` = '$tformNo' AND `listName` = '$listName'");    
            				                    while($checkedRow = mysql_fetch_assoc($checkedResult)){
            				                        $checkedIf = $checkedRow['checked'];
            				                        if ($checkedIf == 1){
            				                            $checkedOn = "checked";
            				                        } else {
            				                            $checkedOn = "";
            				                        }
            				                       // echo $checkedIf."<<- <br>";
            				                    }
            				                    echo "<input type='hidden' name='".$tformNo."' value='0'>";
                				                echo "<input type='checkbox' name='".$tformNo."' value='1' $checkedOn>";
            				                } else {
            				                    echo "-";
            				                }
        				            }
        				        }
            				     /*
            				     if (($plCurrentShow <= 0) && ()){
            				         echo $tformNo."<br>";
            				         echo "<input type='checkbox' name='checkNeeded'>";
            				     } else {
            				         
            				     }
            				    */
            				 } else {
            				     
            				 }
            				echo "</td>";
// ------------------------------------------------------------------
        				// MAKERNO
        				// SET LOOP START HERE
            				echo "<td title='".$lbl_."' style='max-width: 100px; overflow: hidden; white-space: nowrap'>"; 
            				//makerNo
                        if ($isSet == true){
        				  foreach ($setMakerNo as $value2 => $key2){
        				      echo $key2."<br>";
        				    }
        				} else {
        				 echo $makerNo;
        				}
            				echo "</td>";
            				//tformSetNo
            				echo "<td title='".$lbl_."' style='min-width: 120px;'>";
                         if ($isSet == true){
        				    foreach ($setTformNo as $value3 => $key3){
        				        echo $key3;
        				        // query this to see if haiban
        				        $haibanResult = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$key3'");
        				        while($haibanRow = mysql_fetch_assoc($haibanResult)){
        				            $pos = mb_strpos($haibanRow['memo'], "廃番");
        				            if($pos !== false || mb_strpos($haibanRow['memo'], "メーカー") == true){
        				                echo "<span style='color: red'>(廃番)</span>";
        				               //  echo "<br>".$haibanRow["memo"]." = ".mb_detect_encoding($haibanRow["memo"]);
        				            } else {
        				                echo "";
        				            }
        				        }
        				        echo "<br>";
        				    }
        				} else {
        				    //QUERY to find if single item is haiban
        				        $haibanResult = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$tformNo'");
        				        while($haibanRow = mysql_fetch_assoc($haibanResult)){
        				            if(mb_strpos($haibanRow['memo'], "廃番") == true || mb_strpos($haibanRow['memo'], "メーカー") == true){
        				                echo "<span style='color: red'>(廃番)</span>";
        				               //  echo "<br>".$haibanRow["memo"]." = ".mb_detect_encoding($haibanRow["memo"]);
        				            } else {
        				                echo "x";
        				               // echo "<br>".$haibanRow["memo"]." = ".mb_detect_encoding($haibanRow["memo"]);
        				            }
        				        }
        				        echo "<br>"; 
        				}
            				echo "</td>";
            				//------------------------------------------------------------------------
            				//Previous price BLOCK
            				$plHistoryBaiAdd1 = array();
            				if ($isSet == false){
            				    echo "<td title='".$lbl_pl_previous."'>";
                				    //query the pl_history to get the top 2 history prices. 
                				    //pl_history = 2nd record if availible
                				    //pl_historyBai = pl_history/plCurrent * 100(to get the percent) 
                                $plHistoryResult1 = mysql_query("SELECT * FROM `sp_history` WHERE `tformNo` = '$tformNo' ORDER BY `created` DESC LIMIT 2 ");
                				
                                while($plHistoryRow1 = mysql_fetch_assoc($plHistoryResult1)){
                				  $plHistoryBaiAdd1[] = $plHistoryRow1['plCurrent'];
                				  //echo $plHistoryRow1['plCurrent']."<br>";
                				}
                				if(mysql_num_rows($plHistoryResult1) == false){
                				     $plHistoryBaiAdd1[] = 0;
                				     echo "履歴なし";
                				 } else {
                				     if($plHistoryBaiAdd1[0] == 0){
                				     echo "履歴なし";
                				     } else if( count($plHistoryBaiAdd1) >= 2){
                				    echo number_format($plHistoryBaiAdd1[1],2, '.',',');
                				     } else {
                				         echo "履歴なし";
                				     }
                				 }
                				
                				echo "</td>";
                				echo "<td title='".$lbl_priceRateIncrease."'>";
                               
                				// calcualtion
                				// [ ((V2 - V1) / |V1|) * 100 ] From 10 apples to 20 apples is a 100% increase in apples.
                				
                                if( count($plHistoryBaiAdd1) >= 2){
                    				if(($plHistoryBaiAdd1[0] != 0 AND $plHistoryBaiAdd1[1] != 0)){
                        				$plHistoryBaiOut = ((($plHistoryBaiAdd1[0] - $plHistoryBaiAdd1[1]) / $plHistoryBaiAdd1[1]) *100);
                        				if($plHistoryBaiOut < 0){
                        				    $colorThan = "color: red";
                        				} else if($plHistoryBaiOut == 0) {
                        				    $colorThan = "";
                        				} else {
                        				    $colorThan = "color: green;";
                        				}
                        				echo "<span style='".$colorThan."'>".number_format($plHistoryBaiOut, 2, '.','')."%</span><br>";
                    				} else {
                    				    echo "履歴なし";
                    				}
                                } else {
                                    echo "履歴なし";
                                }
                				
                				echo "</td>";
            				} else {
            				    echo "<td>";
            				    //------------------------------------------------------------------------
            				    //前のPL BLOCK
            				    foreach ($setTformNo as $value3 => $key3){
    // START OF SET LOOP
                                    $plHistoryResult1 = mysql_query("SELECT * FROM `sp_history` WHERE `tformNo` = '$key3' ORDER BY `created` DESC LIMIT 2 ");
                                    
                				    while($plHistoryRow1 = mysql_fetch_assoc($plHistoryResult1)){
                    				  $plHistoryBaiAdd1[] = $plHistoryRow1['plCurrent'];
                    				  //echo $plHistoryRow1['plCurrent']."<br>";
                    				}
                				     if(mysql_num_rows($plHistoryResult1) == false){
                    				     $plHistoryBaiAdd1[] = 0;
                    				     
                    				} 
                    				
                    				if( count($plHistoryBaiAdd1) >= 2){
                    				    
                    				    echo number_format($plHistoryBaiAdd1[1],2, '.',',')."<br>";
                    				    
                    				 } else {
                                        echo "履歴なし<br>";
                    				 }
                                    unset($plHistoryBaiAdd1);//reset array
            				    }
            				    echo "</td>";
            				    // -------------------------------------------------------------
            				    //値上率 BLOCK
            				    echo "<td>";
            				     foreach ($setTformNo as $value3 => $key3){
            				         
            				      $plHistoryResult1 = mysql_query("SELECT * FROM `sp_history` WHERE `tformNo` = '$key3' ORDER BY `created` DESC LIMIT 2 ");
                                    
                				    while($plHistoryRow1 = mysql_fetch_assoc($plHistoryResult1)){
                    				  $plHistoryBaiAdd1[] = $plHistoryRow1['plCurrent'];
                    				  //echo $plHistoryRow1['plCurrent']."<br>";
                    				}
                				     if(mysql_num_rows($plHistoryResult1) == false){
                    				     $plHistoryBaiAdd1[] = 0;
                    				} 
                    				
            				        
            				     if( count($plHistoryBaiAdd1) >= 2){
                    				if(($plHistoryBaiAdd1[0] != 0 AND $plHistoryBaiAdd1[1] != 0)){
                        				$plHistoryBaiOut = ((($plHistoryBaiAdd1[0] - $plHistoryBaiAdd1[1]) / $plHistoryBaiAdd1[1]) *100);
                        				if($plHistoryBaiOut < 0){
                        				    $colorThan = "color: red";
                        				} else if($plHistoryBaiOut == 0) {
                        				    $colorThan = "";
                        				} else {
                        				    $colorThan = "color: green;";
                        				}
                        				echo "<span style='".$colorThan."'>".number_format($plHistoryBaiOut, 2, '.','')."%</span><br>";
                    				} else{
                    				   echo "履歴なし<br>";
                    				}
                                } else {
                                    echo "履歴なし<br>";
                                }
            				         
                                unset($plHistoryBaiAdd1);//reset array
            				     }
            				    echo "</td>";
            				}
            				// /\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\
            				unset($plHistoryBaiAdd1);//reset array \/
            				// /\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\
            				//------------------------------------------------------------------------
            				//Currency BLOCK
            				echo "<td title='".$lbl_."'>";
            				if ($isSet == true){
        				        if (empty($set_currency) == false){
        				         
            				    foreach ($set_currency as $value){
            				        echo $value."<br>";
            				    }
            				}
            				} else {
            				    if ($sp_disc_rate_id != 0){
            				        echo $single_currency."<br>";
            				    } else {
            				        echo "<br>";
            				    }
            				    //echo $single_currency." - ".$sp_disc_rate_id."<br>";
            				}
            				echo "</td>"; //YEN EUR ETC...
            				//------------------------------------------------------------------------
            				//PRICELIST BLOCK
            				echo "<td title='".$lbl_."' style='text-align: right;'>";
            				if ($isSet == true){
            				    if (empty($set_currency) == false){
                				    foreach ($set_plCurrent as $value => $key){
                				        if($key == 0){
                				            echo "".$plCurrentShow."<br>";
                				        } else {
                				            echo number_format($key,2)."<br>";
                				        }
                				    }
            				    }
            				} else {
            				    
            				    echo $plCurrentShow;
            				}
            				echo "</td>";
            				//------------------------------------------------------------------------
            				//DISCOUNT BLOCK
            				echo "<td title='".$lbl_."'>";
            				if ($isSet == true){
            				    if (empty($set_discountPar) == false){
            				    
            				    foreach ($set_discountPar as $value => $key){
            				        echo $key."%<br>";
            				    }
            				    } else {
            				        echo "";
            				    }
            				} else {
            				 if ($sp_disc_rate_id != 0){
            				        echo $single_discountPar."<br>";
            				    } else {
            				        echo "<br>";
            				    }
            				    //echo $single_discountPar."%";
            				}
            				echo "</td>";
            				//------------------------------------------------------------------------
            				//NET BLOCK
            				echo "<td title='".$lbl_."' style='text-align: right;'>"; 
                            if ($isSet == true){
            				    if (empty($set_net) == false){
            				        foreach ($set_net as $value => $key){
                				        echo number_format($key, 2)."<br>";
                				    }
            				    } else {
            				        echo "";
            				    }
            				} else {
            				if ($sp_disc_rate_id != 0){
            				        echo number_format($single_net,2)."<br>";
            				    } else {
            				        echo "<br>";
            				    }
            				    //echo number_format($single_net,2);
            				}
            				
            				
            				echo "</td>";
            				
            				//------------------------------------------------------------------------
            				//SET RATE AND PERCENT BLOCK 
            				echo "<td title='".$lbl_."'>"; 
            				$i = 0;
            				if ($isSet == true){
            				    if (empty($set_rate) == false){
                				    foreach ($set_rate as $value => $key){
                				        echo "￥".$key."/".$set_percent[$i]."%<br>";
                				        
    				        //DISPLAY THE CORRRECT RATE TO MATCH THE CURRENCY
                				        if (empty($set_currency[$i])){
                				        $set_pref_rate = 0;
                				        $set_pref_percent = 0;
                				        $set_pref_purchasePrice[] = 0;
                				        //$set_pref_rateArray[] = $set_pref_rate;
                				        //$set_pref_percentArray[] = $set_pref_percent;
                				        echo "<span class='rateDiscountColor'>￥".$set_pref_rate."/".$set_pref_percent."%</span><br>";
                				        } else {
                				        $set_pref_rate = ${$set_currency[$i].'_rate'};
                				        $set_pref_percent = ${$set_currency[$i].'_percent'};
                				        //$set_pref_rateArray[] = $set_pref_rate;
                				        //$set_pref_percentArray[] = $set_pref_percent;
                				        
                				        $set_pref_purchasePrice[] = $set_net[$i] * $set_pref_rate * (1 + ($set_pref_percent/100)); //set SET 仕入原価
                				        
                				        echo "<span class='rateDiscountColor'>￥".$set_pref_rate."/".$set_pref_percent."%</span><br>";
                				        }
    				        $i++;
                				    }
            				    } else {
            				    }
            				    
            				} else {
            				    if ($sp_disc_rate_id != 0){
            				    echo "￥".$single_rate."/".$single_percent."%<br>";
            				    } else {
            				        echo " - ";
            				    }
            				//DISPLAY THE CORRRECT RATE TO MATCH THE CURRENCY
            				    if ($sp_disc_rate_id != 0){
                				        if ($single_currency == false){
                				        $single_pref_rate = 0;
                				        $single_pref_percent = 0;
                				        $single_pref_purchasePrice = 0;
                				        
                				        echo "<span class='rateDiscountColor'>￥".$single_pref_rate."/".$single_pref_percent."%</span><br>";
                				        } else {
                				        $single_pref_rate = ${$single_currency.'_rate'};
                				        $single_pref_percent = ${$single_currency.'_percent'};
                				        
                				      
                				        $single_pref_purchasePrice = $single_net * $single_pref_rate * (1 + ($single_pref_percent/100)); //set SINGLE 仕入原価
                				       // echo "<span style='color: blue;'>".$single_pref_purchasePrice."</span></br>";
                				        if ($sp_disc_rate_id != 0){
                    				    echo "<span class='rateDiscountColor'>￥".$single_pref_rate."/".$single_pref_percent."%</span><br>";
                    				    } else {
                    				        echo "ffff<br>";
                    				    }
                				        //echo "<span class='rateDiscountColor'>￥".$single_pref_rate."/".$single_pref_percent."%</span><br>";
                				        }
            				    } else {
            				      $single_pref_purchasePrice = " - ";
            				    }
            				    
            				}
            				echo "</td>";
            				//------------------------------------------------------------------------
            				//SET purchase price 仕入原価
            				echo "<td title='".$lbl_."' style='text-align: right;'>";
            				$i = 0;
            				if ($isSet == true){
            				    if (empty($set_purchasePrice) == false){
                				    foreach ($set_purchasePrice as $value => $key){
                				        echo "￥".number_format(truncate($key,0),0,'',',')."<br>";
                				        $purchasePriceTotal += truncate($key,0);
                				        $pref_purchasePriceTotal += truncate($set_pref_purchasePrice[$i],0);
                				        
                				        echo "<span class='rateDiscountColor'>￥".number_format(truncate($set_pref_purchasePrice[$i],0),0,'',',')."</span><br>";
    				        $i++;
                				    }
            				    } else {
            				        
            				    }
            				} else {
            				      if ($sp_disc_rate_id != 0){
            				    echo "￥".number_format(truncate($single_purchasePrice,0), 0, '',',')."<br>";
            				      } else {
            				          echo " - ";
            				      }
            				    $purchasePriceTotal += truncate($single_purchasePrice,0);
            				    $pref_purchasePriceTotal = truncate($single_pref_purchasePrice,0);
            				     if ($sp_disc_rate_id != 0){
            				    echo "<span class='rateDiscountColor'>￥".number_format(truncate($single_pref_purchasePrice,0), 0, '',',')."</span><br>";
            				     } else {
            				         echo "<br>";
            				     }
            				}
            				echo "</td>";
            				//------------------------------------------------------------------------
            				//SET PURCHASE PRICE TOTAL including sets 原価合計
            				echo "<td title='".$lbl_."' style='text-align: right;'>"; 
            				
            				//if ($sp_disc_rate_id != 0){
            				    echo "￥".number_format($purchasePriceTotal,0,'',',');
            				    echo "<br><span class='rateDiscountColor'>￥".number_format((float)$pref_purchasePriceTotal, 0,'',',')."</span><br>";
            				    //echo "<br><span class='rateDiscountColor'>￥".$pref_purchasePriceTotal."</span><br>";
            				/* } else {
            				     echo " - ";
            				 }*/
            				echo "</td>";
            				//------------------------------------------------------------------------
            				// SET BAIRITSU
            				echo "<td title='".$lbl_."' style='text-align: right;'>";
            				    if ($tformPriceNoTax == 0 || $purchasePriceTotal == 0 || $pref_purchasePriceTotal == 0){
            					    echo " - ";
            				    } else {
            				       //  if ($sp_disc_rate_id != 0){
                				        echo number_format(($tformPriceNoTax/$purchasePriceTotal),2);
                				        if(($tformPriceNoTax/$pref_purchasePriceTotal)>= 100){
                				            echo "<br><span class='rateDiscountColor'>0.00</span><br>";
                				        } else {
                				        echo "<br><span class='rateDiscountColor'>".number_format(($tformPriceNoTax/$pref_purchasePriceTotal),2)."</span><br>";
                				        }
            				    /*   } else {
            				             echo " - ";
            				         } */
            				    }
            				echo "</td>";
            				//------------------------------------------------------------------------
            				// SET TFORMPRICE
            				echo "<td title='".$lbl_."' style='text-align: right;'>￥".number_format($tformPriceNoTax, 0, '',',')."</td>";
            				//------------------------------------------------------------------------
            				// SET NEW bairitsu
            				echo "<td title='".$lbl_."' style='text-align: right;'><input type='text' class='outputValA".$s."' value='' style='background-color: transparent; max-width: 50px; border: none; text-align: right;' tabindex='-1'><br><input type='text' class='outputValB".$s."' value='' style='background-color: transparent; max-width: 50px; border: none; text-align: right;' class='rateDiscountColor'  tabindex='-1'>
            				</td>";
            				//------------------------------------------------------------------------
            				// SET INPUTBOX
            				echo "<td title='".$lbl_."' style='min-width: 80px;'>
            				￥<input type='text' name='".$listTformNoId."' value='".$inputPrice."' style='width: 60px; text-align: right; ".$isTestPrice." ' class='inputVal".$t."'>
            				<br>";    
    						echo "<input type='hidden' name='id' value='$listName'>";
    						echo "<input type='hidden' class='costA".$s."' value='$purchasePriceTotal'>";// hidden calc variables
    						echo "<input type='hidden' class='costB".$s."' value='$pref_purchasePriceTotal'>";// hidden calc variables
            				echo "</td>";
            				//------------------------------------------------------------------------
            			echo "</tr>";
            			
    
    // SET JAVASCRIPT HERE
    ?>
    <script type="text/javascript">
        jQuery(function($) {                                	
        	var Input = $(".inputVal<?php echo "$t"; ?>"); // main input
        	
            var OutputA = $(".outputValA<?php echo "$s"; ?>"); // first result
            var CostA = $(".costA<?php echo "$s"; ?>"); // cost 
    
            var OutputB = $(".outputValB<?php echo "$s"; ?>"); // second result
            var CostB = $(".costB<?php echo "$s"; ?>"); // cost 
           
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
        });
        </script>
         <?php
    //javascript counter vars
        $t++;
        $s++;
        			
    //clear Variables
    unset($setTformNo);
    unset($setMakerNo);
    unset($set_plCurrent);
    unset($set_currency);
    unset($set_discount);
    unset($set_discountPar);
    unset($set_rate);
    unset($set_percent);
    unset($set_net);
    unset($set_purchasePrice);
    unset($set_pref_purchasePrice);
    $plCurrentShow = "0";
    
    $counter++;
}
/* ********************
 * RUN CODE CHECK DONE
 * ********************
 */
}
/* *****************
 * MAIN LOOP FINSHED
 * *****************
 */

        		echo "</tbody>";
        		//echo $totalRecords;
    		?>
    		</table>
    		</form>
    		</div>
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
    	<?php //echo $counter;?>
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>