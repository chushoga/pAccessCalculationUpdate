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
if(isset($_GET['id'])){
    $saveFileName = $_GET['id'];
} else {
$saveFileName = "ERROR";
}
$savFileDate = date("yyyy/mm/dd");
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
	    var minusResult = 150;
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
	$('#loading').delay(300).fadeOut(300);} );
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
}

/* ------------------------------------------------------------------------
 * ------------------------------------------------------------------------
 */
    		?>
   
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
        		 
// WHILE LOOP VARIABLES

/* *****************
 * MAIN LOOP STARTS
 * *****************
 */
$counter = 0;
//------------
//QUERY

//GET makerlistinfo query
$mainListResult = mysql_query("SELECT * FROM `makerlistinfo` WHERE `listName` = '$listName'");
//WHILE LOOP GO ->
while ($mainListRow = mysql_fetch_assoc($mainListResult)){
// SET tformNo and other vars from main
$purchasePriceTotal = 0;
$pref_purchasePriceTotal = 0;
$tformNo = $mainListRow['tformNo'];
$testPrice = $mainListRow['testPrice'];
$haibanInfo = $mainListRow['haiban'];
$listTformNoId = $mainListRow['id'];
$inputPrice = $testPrice;
//MAIN QUERY TO SET DATA FROM MAIN
$mainResult = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$tformNo'");
//query
while($mainRow = mysql_fetch_assoc($mainResult)){
    $series = $mainRow['series'];
    $set = $mainRow['set'];
    $setExplodCln = preg_replace('/\s+/','', $set);
    $setExplode = explode(",", $setExplodCln);
    $img = $mainRow['img'];
    $makerNo = $mainRow['makerNo'];
    $tformPriceNoTax = $mainRow['tformPriceNoTax'];
    
    
   if($testPrice != 0){
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
                while($setplCurrentRow = mysql_fetch_assoc($setplCurrentResult)){
                   $set_plCurrent[] = $setplCurrentRow['plCurrent'];
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
                    $set_currency[] = "";
                    $set_rate[] = 0;
                    $set_percent[] = 0;
                    $set_discountPar[] = 0;
                    $set_net[] = 0;
                    $set_purchasePrice[] = 0;
                    
                }
                }
            }

    } else {
        $setTformNo[] = "";
        $setMakerNo[] = "";
        $set_currency[] = "";
        $set_discount[] = "";
        $set_discountPar[] = "";
        $set_rate[] = "";
        $set_percent[]="";
        $set_net[] = "";
        $set_purchasePrice[] = "";
        
//query for spCurrent for SINGLE
//check if exists first
$plCurrentResult = mysql_query("SELECT * FROM `sp_plCurrent` WHERE `tformNo` = '$tformNo'");
if (mysql_num_rows($plCurrentResult)){
     while($plCurrentRow = mysql_fetch_assoc($plCurrentResult)){
         
         $plCurrent = $plCurrentRow['plCurrent'];
         if($plCurrent == 0){
         $plCurrentShow = "<span style='color: orange; text-align: center;' title='※価格入力必要!!'><i class='fa fa-exclamation-triangle'></i></span>";
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
             $single_currency = "";
             $single_discountPar = "";
             $single_rate = "";
             $single_percent = "";
             $single_net = "";
             $single_purchasePrice = "";
         }
        }
} else {
    $plCurrentShow = "<span style='color: orange; text-align: center;' title='※価格入力必要!!'><i class='fa fa-exclamation-triangle'></i></span>";
    $single_discountPar = "";
    $plCurrent = "";
    $sp_disc_rate_id = "";
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
        				echo "<td title='".$lbl_."'><a href='calculation.php?pr=1&search=".$tformNo."'>".$tformNo."</a></td>";
        			// CHECK NEEDED
        			// IF (PL == 0) && (HAIBAN == FALSE) SHOW CHECK
        				echo "<td title='".$lbl_."'></td>";
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
        				echo "<td title='".$lbl_."'></td>";
        				echo "<td title='".$lbl_."'></td>";
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
        				    echo $single_currency."<br>";
        				}
        				echo "</td>"; //YEN EUR ETC...
        				//------------------------------------------------------------------------
        				//PRICELIST BLOCK
        				echo "<td title='".$lbl_."' style='text-align: right;'>";
        				if ($isSet == true){
        				    if (empty($set_currency) == false){
        				    
        				    foreach ($set_plCurrent as $value => $key){
        				        echo number_format($key,2)."<br>";
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
        				    echo $single_discountPar."%";
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
        				    echo number_format($single_net,2);
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
            				       // echo "<span class='rateDiscountColor'>￥".$set_pref_rate."/".$set_pref_percent."%</span><br>";
            				        } else {
            				        $set_pref_rate = ${$set_currency[$i].'_rate'};
            				        $set_pref_percent = ${$set_currency[$i].'_percent'};
            				        //$set_pref_rateArray[] = $set_pref_rate;
            				        //$set_pref_percentArray[] = $set_pref_percent;
            				        
            				        $set_pref_purchasePrice[] = $set_net[$i] * $set_pref_rate * (1 + ($set_pref_percent/100)); //set SET 仕入原価
            				        
            				        //echo "<span class='rateDiscountColor'>￥".$set_pref_rate."/".$set_pref_percent."%</span><br>";
            				        }
            				        
				        $i++;
            				    }
        				    } else {
        				    }
        				    
        				} else {
        				    echo "￥".$single_rate."/".$single_percent."%<br>";
        				    
        				//DISPLAY THE CORRRECT RATE TO MATCH THE CURRENCY
            				        if ($single_currency == false){
            				        $single_pref_rate = 0;
            				        $single_pref_percent = 0;
            				        $single_pref_purchasePrice = 0;
            				        
            				        //echo "<span class='rateDiscountColor'>￥".$single_pref_rate."/".$single_pref_percent."%</span><br>";
            				        } else {
            				        $single_pref_rate = ${$single_currency.'_rate'};
            				        $single_pref_percent = ${$single_currency.'_percent'};
            				        
            				      
            				        $single_pref_purchasePrice = $single_net * $single_pref_rate * (1 + ($single_pref_percent/100)); //set SINGLE 仕入原価
            				       // echo "<span style='color: blue;'>".$single_pref_purchasePrice."</span></br>";
            				        
            				        //echo "<span class='rateDiscountColor'>￥".$single_pref_rate."/".$single_pref_percent."%</span><br>";
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
            				        
            				      //  echo "<span class='rateDiscountColor'>￥".number_format(truncate($set_pref_purchasePrice[$i],0),0,'',',')."</span><br>";
				        $i++;
            				    }
        				    } else {
        				        
        				    }
        				} else {
        				    echo "￥".number_format(truncate($single_purchasePrice,0), 0, '',',')."<br>";
        				    $purchasePriceTotal += truncate($single_purchasePrice,0);
        				    $pref_purchasePriceTotal = truncate($single_pref_purchasePrice,0);
        				   // echo "<span class='rateDiscountColor'>￥".number_format(truncate($single_pref_purchasePrice,0), 0, '',',')."</span><br>";
        				}
        				echo "</td>";
        				//------------------------------------------------------------------------
        				//SET PURCHASE PRICE TOTAL including sets 原価合計
        				echo "<td title='".$lbl_."' style='text-align: right;'>"; 
        				    echo "￥".number_format($purchasePriceTotal,0,'',',');
        				    //echo "<br><span class='rateDiscountColor'>￥".number_format($pref_purchasePriceTotal,0,'',',')."</span><br>";
        				echo "</td>";
        				//------------------------------------------------------------------------
        				// SET BAIRITSU
        				echo "<td title='".$lbl_."' style='text-align: right;'>";
        				    if ($tformPriceNoTax == 0 || $purchasePriceTotal == 0 || ($pref_purchasePriceTotal == 0 && $isSet == true)){
        					     echo "0.00 ";
        				    } else {
        				        echo number_format(($tformPriceNoTax/$purchasePriceTotal),2);
        				      //  echo "<br><span class='rateDiscountColor'>".number_format(($tformPriceNoTax/$pref_purchasePriceTotal),2)."</span><br>";
        				    }
        				echo "</td>";
        				//------------------------------------------------------------------------
        				// SET TFORMPRICE
        				echo "<td title='".$lbl_."' style='text-align: right;'>￥".number_format($tformPriceNoTax, 0, '',',')."</td>";
        				//------------------------------------------------------------------------
        				// SET NEW bairitsu
        				//<input type='text' class='outputValA".$s."' value='' style='background-color: transparent; max-width: 50px; border: none; text-align: right;' tabindex='-1'>
        				//<br>
        				//<input type='text' class='outputValB".$s."' value='' style='background-color: transparent; max-width: 50px; border: none; text-align: right;' class='rateDiscountColor'  tabindex='-1'>
        				//<br>
                        
        				
        				echo "<td title='".$lbl_."' style='text-align: right;'>
        				
        				<span class='outputValA".$s."'></span>
        				</td>";
        				//------------------------------------------------------------------------
        				// SET INPUTBOX
                           
                        $inputPrice2 = "<span style='".$isTestPrice."'>￥".number_format($testPrice,0,'',',')."</span>";
                            
        				echo "<td title='".$lbl_."' style='min-width: 80px;'>
        				".$inputPrice2."<input type='hidden' name='".$listTformNoId."' value='".$inputPrice."' style='width: 60px; text-align: right; ".$isTestPrice." ' class='inputVal".$t."'><br>";
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

        var OutputC = $(".outputValC<?php echo "$s"; ?>"); // second result
       
		$([CostA[0], Input[0]]).bind("change keyup keydown paste", function(e) {
		    var ResultA;
		    ResultA = parseFloat(Input.val()) / parseFloat(CostA.val());
		    //OutputA.val(ResultA.toFixed(2));
		    OutputA.text(ResultA.toFixed(2));
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

$counter++;
}
/* *****************
 * MAIN LOOP FINSHED
 * *****************
 */
        		echo "</tbody>";
    		?>
    		</table>
    		</form>
    		</div><!-- SAVE WRAPPER END -->
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
    	<?php //echo $counter;?>
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>