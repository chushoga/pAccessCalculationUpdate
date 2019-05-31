<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title;?></title>
<?php
    include_once '../master/config.php';
?>
<script type="text/javascript">
    $(document).ready( function(){
        $('.table_id').dataTable({
            "columnDefs": [{
               "targets": [ 0 ],
               "visible": false,
               "searchable": true
            }],
            "bJQueryUI": true,
            "bPaginate": false,
            "bFilter": false,
            "bInfo": false
        });

        $(function(){

            $(window).on('resize', function() {
              $('#quickFit1').quickfit({ max: 12, min: 6, truncate: true });
              $('#quickFit2').quickfit({ max: 12, min: 6, truncate: true });
              $('#quickFit3').quickfit({ max: 12, min: 6, truncate: true });
            });

            $(window).trigger('resize');

          });

        $('#loading').delay(300).fadeOut(300);

        // =======================================================================================
        // |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
        // =======================================================================================
        // GLOBAL VARS
        // -----------
        var SHOWHIDDEN = false;
        var ID = $("#showAllHiddenBlocks").attr("data-id");
        // -----------
        
        function ToggleBlockDefaults(id){
            console.log(SHOWHIDDEN);
            console.log("showing all block default positions NOW!!");
            $(".blockWrapper").show();
            
            if(SHOWHIDDEN == true){
                $(".hideExpenseBtn").show();
            } else {
                $(".hideExpenseBtn").hide();
            }
            
            $.ajax({
                type: "post",
                url: "exe/processExpense.php",
                data: "action=GetHiddenBlocks&id="+id,
                success: function(data){
                    
                    for(var i = 0; i < data.length; i++){
                        var target = $(".blockWrapper[data-orderNo='"+data[i].orderNo+"']");
                        if(data[i].isHidden == 1){
                            
                            // check if the toggle is on to show the hidden or just gray is out while editing
                            if(SHOWHIDDEN == false){
                                target.hide();
                            } else {
                                target.css({"opacity":"0.5"});
                            }
                        } else {
                            target.css({"opacity":"1"});
                        }
                    }
                },
                error: function(e){
                    console.log(e);
                }
            });
            
        }
        
        function ShowAllHiddenBlocks(){
            console.log("showing all blocks NOW!!");
            
            // set the SHOWHIDDEN flag
            SHOWHIDDEN = !SHOWHIDDEN;
            ToggleBlockDefaults(ID);
            
            // set color of button to show currently editing.
            if(SHOWHIDDEN == true){
                $("#showAllHiddenBlocks").css({
                    "background":"crimson",
                    "color":"#FFFFFF"
                });
            } else {
                $("#showAllHiddenBlocks").css({
                    "background":"#FFFFFF",
                    "color":"#888888"
                });
            }
            
            // set the blocks to show all
            //$(".blockWrapper").show();
        }
        
        function UpdateHiddenBlockFlag(id, orderNo){
            console.log("updating block flag blocks NOW!!" + id + ": " + orderNo);
            
            $.ajax({
                type: "post",
                url: "exe/processExpense.php",
                data: "action=UpdateHiddenBlocks&id="+id+"&orderNo="+orderNo,
                success: function(data){
                    console.log(data);
                    ToggleBlockDefaults(id);
                },
                error: function(e){
                    console.log(e);
                }
            });
        }
        
        // Hide and show the hidden expense blocks
        $("body").on("click", ".hideExpenseBtn", function(){
            
            var recId = $(this).attr("data-id");
            var orderNo = $(this).attr("data-orderNo");
            
            UpdateHiddenBlockFlag(recId, orderNo);
        });
        
        // show all hidden blocks button
        $("#showAllHiddenBlocks").on("click", function(){
           
           ShowAllHiddenBlocks();
            
        });
        
        /*
        $("#showDefaultHiddenBlocks").on("click", function(){
           
            var recId = $(this).attr("data-id");
            
            ToggleBlockDefaults(recId);
        });
        
        */
        // start by showing default hidden states        
        ToggleBlockDefaults(ID);
        // =======================================================================================
        // |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
        // =======================================================================================
        
    });
</script>
    
<style type="text/css">


    .table_id {
        font-size: 10px;
    }

    .table_id td {
        text-align: center;
    }

    @media print {
        #navi,.logo,.editBar,#statusBar,.footer  * {
            display: none !important;
        }
        .sheetWrapper {
            font-size: 12px;
        }
        .sheetTopBox1forwarderBottom {
            font-size: 10px;
        }
        p.breakhere {
            page-break-after: always;
        }
        .orderContents {
            margin-top: 0px;
        }
    }

    .ui-corner-all,.ui-corner-bottom,.ui-corner-right,.ui-corner-br {
        border-radius: 0px;
    }

    .ui-corner-all,.ui-corner-top,.ui-corner-right,.ui-corner-tr {
        border-radius: 0px;
    }

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

    #finishedStatus {
        height: 35px;
        float: right;
        margin-right: 20px;
        height: 100%;
        line-height: 35px;
        font-size: 12px;
        font-weight: bold;
        color: #888;
        outline: 1px solid #CCC;
    }
    #finishedStatus span {
        height: 35px;
        display: block;
        float: left;
        padding-left: 10px;
        padding-right: 10px;
    }
</style>
</head>
<body>
<?php
//variables
// make sure $page always = something
$memoOrder = "";
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
if (isset($_GET['id'])){
	$recordId = $_GET['id'];
	$setQuery = "SELECT * FROM `expense` WHERE `id` = '$recordId'";
} else {
	for($j=1;$j<21;$j++){
		$searchArray[] = " OR `orderNo_$j` LIKE '%$search%' ";
		$searchArrayDate[] = " OR `date_$j` LIKE '%$search%' ";
	}
	$searchArrayImp = implode(' ', $searchArray);
	$searchArrayDateImp = implode(' ', $searchArrayDate);
	$setQuery = "SELECT * FROM `expense` WHERE `id` LIKE '%$search%' OR `forwarder` LIKE '%$search%' OR `date` LIKE '%$search%' $searchArrayImp $searchArrayDateImp";
}
//get total amount of results.
$iAmount = 0;
$resultAmount = mysql_query("$setQuery");
$searchEmptyCheck = mysql_num_rows($resultAmount);
while ($rowAmount = mysql_fetch_assoc($resultAmount)){

	$iAmount++;
}
// ---------------------------
$iRecord = $record +1;

//SET FILENAME SAVE HERE
$result = mysql_query("$setQuery ORDER BY ID ASC LIMIT $record, 1");
$idPass = 0; // initialize the record Id

while ($row = mysql_fetch_assoc($result)){
	$idPass = $row['id']; //set the recordId
	$id = $row['id'];
	if ($row['date'] == ""){
		$saveFileDate = 1;
	} else {
		$savFileDate = $row['date'];
	}
	if ($row['id'] == ""){
		$saveFileProjectName = "tformProject";
	} else {
		$saveFileProjectName = $row['id'];
	}
	$saveFileName = $saveFileProjectName."_".$savFileDate;
}

//----------------------------------
?>
	
	<div id='wrapper'>
		<div id='loading'>
			<span class='loadingGifMain'> <img src='<?php echo $path;?>/img/142.gif'><br> LOADING ... </span>
		</div>
		<?php require_once '../header.php'; ?>
		<div class='contents'>
			<!-- PAGE CONTENTS START HERE -->

			<!-- 
			**********
			STATUS BAR
			**********
			 -->
            <?php
            // set the finished checkbox Views
			//initalize
			$finUser_01 = "";
			$finUser_02 ="";
			$finAll = "";
            $finishedCheckboxResults = mysql_query("SELECT * FROM expense WHERE `id` = '$id' ") or die(mysql_error());
			while ($finishedCheckboxRow = mysql_fetch_assoc($finishedCheckboxResults)){
                $finUser_01 = $finishedCheckboxRow['finUser_01']; // user 1 finished
                $finUser_02 = $finishedCheckboxRow['finUser_02']; // user 2 finished
                $finAll = $finishedCheckboxRow['finAll']; // all finished
            }

            /* SET THE FINISHED CHECKED*/
            if($finUser_01 == 1){
                $user_01_isFinished = ' ● ';
            } else {
                $user_01_isFinished = ' × ';
            }
            // ----------------------------
            if($finUser_02 == 1){
                $user_02_isFinished = ' ● ';
            } else {
                $user_02_isFinished = ' × ';
            }
            // ----------------------------
            if($finAll == 1){
                $all_isFinished = ' ● ';
            } else {
                $all_isFinished = ' × ';
            }
			
			
            ?>
            
			<div id='statusBar'>
			<?php if ($record <= 0){?>
				<button class='recordCycleBtnDisabled' style='cursor: default;'>◀</button>
				<?php }
				else{ ?>
				<button class='recordCycleBtn' onClick="location.href='expense.php?pr=3&record=<?php echo $previous;?>&search=<?php echo $search;?>'">◀</button>
				<?php }
				if($iRecord == $iAmount || $searchEmptyCheck  == 0){
					?>
				<button class='recordCycleBtnDisabled' style='cursor: default;'>▶</button>
				<?php }
				else { ?>
				<button class='recordCycleBtn' onClick="location.href='expense.php?pr=3&record=<?php echo $next;?>&search=<?php echo $search;?>'">▶</button>
				<?php }	?>
				<?php echo $iRecord." of ".$iAmount;
				echo " (search: ".$search.")";
				
                echo "<span id='finishedStatus'>
                       <span class=''> 河合 ".$user_01_isFinished."</span>
                       <span class=''> 上杉 ".$user_02_isFinished."</span>
                       <span class=''> 全体完成 ".$all_isFinished."</span>
                    </span>";
                
           
                
                // show all hidden elements
                echo "<button id='showAllHiddenBlocks' style='
                    color: #888;
                    height: 35px;
                    line-height: 35px;
                    padding-left: 10px;
                    padding-right: 10px;
                    float: right;
                    background: none;
                    border: none;
                    outline: 1px solid #CCC;
                    ' data-id='".$idPass."'>
                        ブロック表示管理
                    </button>";
                
                echo "<br>";
                ?>
                
			</div>
			
			<!-- 
			**************
			STATUS BAR END
			**************
			 -->

			<?php

			//CHECK HERE IF NO FILES FOUND THEN DONT SHOW....
			if ($searchEmptyCheck != 0){
				?>
			<div class='orderContents'>
			<?php
			/////////////////////////////////////////////////////////////////////////////
			/////////////////////////////// SET VARIABLES ///////////////////////////////
			/////////////////////////////////////////////////////////////////////////////

			//---------------------------------------------------------------------------
			// GET SINGLE DATA FROM EXPENSE ONLY NEED TO ACCESS ONCE NO NEED FOR A LOOP
			//---------------------------------------------------------------------------

			$singleResults = mysql_query("SELECT * FROM expense WHERE `id` = '$id' ") or die(mysql_error());
			while ($singleRow = mysql_fetch_assoc($singleResults)){
				$jpRate = $singleRow['jpRate']; // tax
					
				$date = date ('Y.m.d', strtotime($singleRow['date'])); // order date
				$forwarder = $singleRow['forwarder']; // the forwarder
				$vessle = $singleRow['vessle']; // the ship/vessle
				$packing = $singleRow['packing']; // the packing/container type

				//get the bank charge Total
				//if the total is blank then a calculation is needed to find the total.
				if ($singleRow['bankChargeTotal'] == ''){
					$bankCharge = $singleRow['bankCharge'];
					$bankChargeTimes = $singleRow['bankChargeTimes'];
					$bankChargeTotal = $bankCharge * $bankChargeTimes;
				} else {
					//a total price was already input so NO calculation is needed
					$bankCharge = $singleRow['bankCharge'];
					$bankChargeTimes = $singleRow['bankChargeTimes'];
					$bankChargeTotal = $singleRow['bankChargeTotal'];
				}

				// get the shipping total
				if ($singleRow['shippingChargeTotal'] == ''){
					$shippingCharge = $singleRow['shippingCharge'];
					$shippingChargeTimes = $singleRow['shippingChargeTimes'];
					$shippingChargeTotal = $shippingCharge * $shippingChargeTimes;
				} else {
					$shippingCharge = $singleRow['shippingCharge'];
					$shippingChargeTimes = $singleRow['shippingChargeTimes'];
					$shippingChargeTotal = $singleRow['shippingChargeTotal'];
				}
				$shippingTotal = $singleRow['shippingTotal'];
				$insuranceTotal = $singleRow['insuranceTotal'];
				$clearanceTotal = $singleRow['clearanceTotal'];
				$inspectionTotal = $singleRow['inspectionTotal'];
				$customsTotal = $singleRow['customsTotal'];
				$inlandShippingTotal = $singleRow['inlandShippingTotal'];
				$otherTotal = $singleRow['otherTotal'];
				$taxTotal = $singleRow['taxTotal'];
				$consumptionTaxTotal = "";

				if($taxTotal == 0){
					$consumptionTaxTotal = ($customsTotal+$inlandShippingTotal+$otherTotal)*$jpRate;
				} else {
					$consumptionTaxTotal = $taxTotal;
				}

				$tarrifTotal = $singleRow['tarrifTotal'];
				$memo = $singleRow['memo'];
				//$preConsumptionTotal = $singleRow['consumptionTotal'] - $consumptionTaxTotal;
				//$consumptionTotal = $singleRow['consumptionTotal'];
				$preConsumptionTotal = $singleRow['consumptionTotal'];
				$consumptionTotal = $singleRow['consumptionTotal'] + intval($consumptionTaxTotal);
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

			// set the number of differnt variables
			// loop 20 times
			//SET LOOP TIMES

			$l=20;

			//-----------------------------------------------------------------------------

			//*************************************************
			//             _          _                      //
			//  _ __  __ _(_)_ _     /_\  _ _ _ _ __ _ _  _  //
			// | '  \/ _` | | ' \   / _ \| '_| '_/ _` | || | //
			// |_|_|_\__,_|_|_||_| /_/ \_\_| |_| \__,_|\_, | //
			//                                         |__/  //
			//                                               //
			//*************************************************
			
			$pageBreakCount = 0;	//counts the amount of order numbers to use for print preview. After 10 orders it breaks page into 2 for printing.
			$resultSetter = mysql_query("SELECT * FROM expense WHERE `id` = '$id' ") or die(mysql_error());
			while ($rowSetter = mysql_fetch_assoc($resultSetter)){
				for ($i = 1; $i<=$l; $i++) {
					if ($rowSetter['orderNo_'.$i] == ' ' ){
						$orderNo_[$i] = 0;
						$makerName_[$i] = 0;
						$currency1_[$i] = 0;
						$currency2_[$i] = 0;
						$rate_[$i] = 0;
					} else {
						$orderNo_[$i] = $rowSetter['orderNo_'.$i];
						$makerName_[$i] = $rowSetter['makerName_'.$i];
						$currency1_[$i] = $rowSetter['currency1_'.$i];
						$currency2_[$i] = $rowSetter['currency2_'.$i];
						$rate_[$i] = $rowSetter['rate_'.$i];
					}

					$orderNo = "orderNo_$i";
					$makerName = "makerName_$i";
					$currency1 = "currency1_$i";
					$currency2 = "currency2_$i";
					$rate = "rate_$i";

					//fill array here
					if ($rowSetter['orderNo_'.$i] !== ''){
						$pageBreakCount++; // add up page break count
						$mainArray[] = array(
						$rowSetter['orderNo_'.$i],
						$rowSetter['makerName_'.$i],
						$rowSetter['currency1_'.$i],
						$rowSetter['currency2_'.$i],
						$rowSetter['rate_'.$i],
						$rowSetter['date_'.$i]
						);
					}
				}
			}

			//VARIABLES FOR BLOCK CHECK **

			$isSameMaker = false;// check if the previous maker was the same or not. Used for checking if block is finished or not.
			$isBlock = false; // a check to see if we can break a block up
			$isFinalBlock = false; //a check to see if there are not more blocks
			$previousMakerName = "";// sets the previous makers name to check if the block should be done;

			$makerTotalBeforeBreak = 0;// maker total before break
			$plTotalBeforeBreak = 0;// priceList total before break
			$rateCheckBeforeBreak = null;// rate check array for before break

			$topBlocksTotal = 0;//total price


			// _________________________________________________________________
			//	 _____ _____ _____ _____ _____    _____ _____ _____ _____ _____
			//	|   __|  |  |   __|   __|_   _|  |   __|_   _|  _  | __  |_   _|
			//	|__   |     |   __|   __| | |    |__   | | | |     |    -| | |
			//	|_____|__|__|_____|_____| |_|    |_____| |_| |__|__|__|__| |_|
			// _________________________________________________________________

			?>
				<div class="fullBox">

					<div class='clear'></div>
					<div id='saveWrapper'>
						<div class='sheetWrapper'>
							<div class='tax'>
								消費税
								<?php echo $jpRate*100;?>
								%
							</div>
							<!-- -------------------------------------------
							 _____            _____ _____ _____ _____ _____ 
							|_   _|___ ___   |   __|_   _|  _  | __  |_   _|
							  | | | . | . |  |__   | | | |     |    -| | |  
							  |_| |___|  _|  |_____| |_| |__|__|__|__| |_|  
							          |_|                                   
							 ----------------------------------------------->
							<div class='sheetTop'>
								<div class='sheetTopBox1dateWrapper'>
									<div class='sheetTopBox1dateTop'>入荷日</div>
									<div class='sheetTopBox1dateBottom'>
									<?php echo $date;?>
									</div>
								</div>
								<div class='sheetTopBox1forwarderWrapper'>
									<div class='sheetTopBox1forwarderTop'>フォワーダー</div>
									<div class='sheetTopBox1forwarderBottom' id='quickFit1'>
									<?php echo $forwarder;?>
									</div>
								</div>
								<div class='sheetTopBox1VesPackWrapper'>
									<div class='sheetTopBox1VesPackTop'>Vessel</div>
									<div class='sheetTopBox1VesPackBottom' id='quickFit2'>
									<?php echo $vessle;?>
									</div>
								</div>
								<div class='sheetTopBox1VesPackWrapper'>
									<div class='sheetTopBox1VesPackTop' style='border-right: 1px solid #CCC;'>梱包/コンテナー</div>
									<div class='sheetTopBox1VesPackBottom' style='border-right: 1px solid #CCC;' id='quickFit3'>
									<?php echo $packing;?>
									</div>
								</div>
								<div class='clear'></div>

								<div class='sheetTopBox2'>
									<br>
									<p>＜ メーカー別商品代金 ＞</p>

									<br>
									<?php

									echo "<table class='sheetTable1'>";
									echo "<tr>";
									echo "<th>オーダーNo.</th>";
									echo "<th>メーカー名</th>";
									echo "<th>送金日</th>";
									echo "<th>外貨代金</th>";
									echo "<th>為替レート</th>";
									echo "<th style='border-right: none;'>商品代金（￥）</th>";
									echo "</tr>";
									// **************************
									// START OF MAIN LOOP FOR TOP
				
									$pageBreakCounterCheck = false; // sets the page break switch
									$pageBreakMoreThanCheck = false;
									
									for ($i = 0; $i < count($mainArray); $i++){
										// CHECK IF SAME MAKER NAME
										// cycle through each order in the list
										if($i == 18){
											$pageBreakCounterCheck = true;
										} else {
											$pageBreakCounterCheck = false;
										}

										$arrayOrderNo = $mainArray[$i][0];
										$arrayMakerName = $mainArray[$i][1];
										$arrayCurrency1 = $mainArray[$i][2];
										$arrayCurrency2 = $mainArray[$i][3];
										$arrayRate = $mainArray[$i][4];
										$arrayDate = $mainArray[$i][5];

										$arrayTotalcalc = $arrayCurrency2 * $arrayRate;
										$arrayTotal = truncate($arrayTotalcalc, 0);
										$topBlocksTotal += $arrayTotal; //total all the totals for the final green total

										// BREAK BLOCK HERE, SKIPS FIRST RECORD
										//check first if we need a break. If it is not the first record then ignor
										if($i != 0){
											//check for the prevous maker name
											if($mainArray[$i-1][1] !== $mainArray[$i][1]){
												echo "<tr><td colspan='6' style='height: 10px;'></td></tr>";
												
												//add pagebreak for printing if more than 8 records long.
												if($pageBreakCounterCheck == true ){
													echo "<tr class='tablePageBreak'><td colspan='6' style='border: none;'><p class='breakhere'></p></td></tr>";
													$pageBreakMoreThanCheck = true;
												}

												$makerTotalBeforeBreak = 0; //reset to 0 if it is not the same as previous
												$plTotalBeforeBreak = 0; // reset to 0 if it is not the same
												unset($rateCheckBeforeBreak);
											}
										}
										// BREAK BLOCK DONE

										$makerTotalBeforeBreak += $arrayTotal; // add up totals for each in the mini-block. THIS position is important for adding to the array.
										$plTotalBeforeBreak += $arrayCurrency2;
										$rateCheckBeforeBreak[] = $arrayRate;


										//****///////////////////////////****///////////////////////////****///////////////////////////****
										// START OF THE NORMAL OUTPUT, nothing special here. PRINT every TIME
										//****///////////////////////////****///////////////////////////****///////////////////////////****
										$dateSoukin = ""; // initalize
										if($arrayDate == null || $arrayDate == "0000-00-00"){
											$dateSoukin = "";
										} else {
											$dateSoukin = date ('Y.m.d', strtotime($arrayDate)); // order date
										}
										
										echo "<tr>";
										echo "<td style='border-left: none;'>".$arrayOrderNo."</td>";
										echo "<td>".$arrayMakerName."</td>";
										echo "<td style='font-size: 8px;'>".$dateSoukin."</td>";
										echo "<td>".$arrayCurrency1." ".number_format($arrayCurrency2, 2, '.',',')."</td>";
										echo "<td>".$arrayRate."</td>";
										echo "<td style='text-align: right; border-right: none;'>￥".number_format($arrayTotal, 0, '',',')."</td>";
										echo "</tr>";

										//****///////////////////////////****///////////////////////////****///////////////////////////****
										// PRINT THIS ONLY if the previous maker name is the same. Skips the first record because there
										// is nothing previous to check.
										//****///////////////////////////****///////////////////////////****///////////////////////////****
										//check if its a set, and if it is then add the prices together

										//check and set if the prevous rate is the same or not, if it is then use it, else do the calculation

										//SET THE START INDEX
										if (isset($mainArray[$i-1][1])){
											$prevIndex = $mainArray[$i-1][1];
										} else {
											$prevIndex = "START";;
										}
											
										//SET THE END INDEX
										if (isset($mainArray[$i+1][1])){
											$nextIndex = $mainArray[$i+1][1];
										} else {
											$nextIndex = "END";;
										}
										
										
										//if this is the first in the line and there is nothing or different maker name after then use that rate
										//check for the prevous maker name
										if($prevIndex == $mainArray[$i][1] && $nextIndex != $mainArray[$i][1]){
											if (count(array_unique($rateCheckBeforeBreak)) == 1) {
												//THE SAME RATES
												$averageRate = $arrayRate;
												
											} else {
												$averageRate = truncate(($makerTotalBeforeBreak / $plTotalBeforeBreak),2);
											}
											echo "<tr>";
											echo "<td style='border-left: none;'></td>";
											echo "<td style='font-weight: 700;'>".$arrayMakerName."  Total/AV</td>";
											echo "<td></td>";
											echo "<td style='font-weight: 700;'>".number_format($plTotalBeforeBreak, 2, '.',',')."</td>";
											echo "<td style='font-weight: 700;'>".number_format($averageRate, 2, '.',',')."</td>";
											echo "<td style='color: green; font-weight: 700; text-align: right; border-right: none;'>￥".number_format($makerTotalBeforeBreak, 0, '',',')."</td>";
											echo "</tr>";
											
										} else {
											$averageRate = $arrayRate; //will be overridden at the next if
										}

										$allArray[][] = array($mainArray[$i][0], $arrayMakerName, round($averageRate,2)); // fill the array that will calculate the bottom tables
									
										
										
									} // END OF TOP LOOP
																		
									echo "</table>";
									

									//SET A,B,C, B/A, C/A
									$A = $topBlocksTotal; //top green total (A)
									$B = intval($bottomTotal);
									$C = $consumptionTotal;

									//check for 0s
									if($A == 0 || $B == 0){
										$BA = 0;
									} else {
										$BA = ($B/$A)*100;
									}
                
// ADDED ON 2018-11-15
                
                                    if($A == 0 && $B >= 1){
                                        $BA = $B/100;
                                    }
                
                                    if($A >= 1 && $B == 0){
                                        $BA = $A/100;
                                    }
                                    
// -------------------

                
									if($A == 0 || $C == 0){
										$CA = 0;
									} else {
										$CA = (($C)/$A)*100;
									}

				
									//TOTAL GOES HERE FOR TOP BLOCK
									echo "<br>";
									echo "<div class='sheetTopTotal'>";
									echo "<p>";
									echo "合計 (A) <span class='greenText'>￥ ".number_format($topBlocksTotal, 0, '',',')."</span>";
									echo "</p><hr>";
									echo "<p>経費 (B/A) <span style='font-weight: 700;'>";
									echo "".number_format($BA, 2, '.',',')."% </span></p>";
									echo "<hr style='margin-right: 0'><br><p>".number_format($BA + $CA, 2, '.',',')."% 税込</p>";
									echo "</div>";
									?>

								</div>
								<!-- sheetTopBox2 END -->

							</div>
							<!-- sheetTop END -->
			<?php
				
				$pageBreakStyleBorder = '';
				
				if($pageBreakCount >= 8 && $pageBreakMoreThanCheck == false){
					echo "<p class='breakhere'></p>";
					$pageBreakStyleBorder = 'border-top: 1px solid #CCC;';
				} else {
					$pageBreakStyleBorder = '';
				}
			?>
							<!----------------------------------------------------------
							 _       _   _                _____ _____ _____ _____ _____ 
							| |_ ___| |_| |_ ___ _____   |   __|_   _|  _  | __  |_   _|
							| . | . |  _|  _| . |     |  |__   | | | |     |    -| | |  
							|___|___|_| |_| |___|_|_|_|  |_____| |_| |__|__|__|__| |_|  
							------------------------------------------------------------>

							<div class='sheetBottom' style='<?php echo $pageBreakStyleBorder; ?>'>
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
											<td class='aRight'>￥<?php echo number_format($bankCharge, 0, '.', ',');?>
											</td>
											<td class='aRight'><?php echo $bankChargeTimes;?>
											</td>
											<td class='aRight'>￥<?php echo number_format(intval($bankChargeTotal), 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td>運賃</td>
											<td class='aRight'></td>
											<td class='aRight'></td>
											<td class='aRight'>￥<?php echo number_format($shippingTotal, 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td>運賃 (外貨)</td>
											<td class='aRight'><?php echo number_format($shippingCharge, 2, '.', ',');?>
											</td>
											<td class='aRight'><?php echo $shippingChargeTimes;?>
											</td>
											<td class='aRight'>￥<?php echo number_format(intval($shippingChargeTotal), 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td>保険料</td>
											<td></td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($insuranceTotal, 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td>customs clearance fee</td>
											<td>(非課税)</td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($clearanceTotal, 0, '.', ',');?>
											</td>
										</tr>
										<?php // ADD LINE HERE ---------?>
										<tr>
											<td>検査,その他</td>
											<td>(非課税)</td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($inspectionTotal, 0, '.', ',');?>
											</td>
										</tr>
										<?php // ADD LINE HERE DONE---------?>
										<tr>
											<td>通関手数料</td>
											<td>(課税)</td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($customsTotal, 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td>国内運賃</td>
											<td>(課税)</td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($inlandShippingTotal, 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td>蔵出料,検査,その他</td>
											<td>(課税)</td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($otherTotal, 0, '.', ',');?>
											</td>
										</tr>

										<tr>
											<td>関税</td>
											<td></td>
											<td></td>
											<td class='aRight'>￥<?php echo number_format($tarrifTotal, 0, '.', ',');?>
											</td>
										</tr>
									</tbody>
								</table>

								<br>＜ メモ ＞<br>
								<?php echo $memo;?>
								<div class='sheetBottomTotal'>
									<p>
										経費合計 (B) <span class='greenText'>￥<?php echo number_format($B, 0, '.', ',');?> </span>
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
									<tbody>
										<tr>
											<td></td>
											<td class='aRight'>消費税 (<?php echo $jpRate*100; echo "%";?>) ￥<?php echo number_format(intval($consumptionTaxTotal), 0, '.', ',');?>
											</td>
										</tr>
										<tr>
											<td></td>
											<td class='aRight'>輸入消費税 ￥<?php echo number_format($preConsumptionTotal, 0, '.', ',');?>
											</td>
										
										
										<tr>
											<td></td>
											<td class='aRight'><span style='text-align: left;'>合計輸入消費税(C) </span><span class='greenText'>￥<?php echo number_format($C, 0, '.', ',');?> </span></td>
										</tr>
										<tr>
											<td style='border: none;'></td>
											<td class='aRight' style='border: none;'>(C)/(A)=<?php
											echo number_format($CA, 2, '.',',')
											?>%</td>
										</tr>

									</tbody>
								</table>

							</div>

						</div>
						<!-- sheetWrapper END -->
					</div>
					<!-- saveWrapper END -->
				</div>
				<!-- fullBox END -->

				<p class="breakhere">
					<br>
				</p>

				<div class="fullBox">
					<br>
					<div class='sheetWrapper'>

					<?php
					
					$price = '';
					$BotTot = 0;

					// PUT THE ORDER NUMS INTO AN ARRAY
					$result = mysql_query("SELECT * FROM expense WHERE `id` = '$id'") or die(mysql_error());
					while ($row = mysql_fetch_assoc($result)){
						
						
						unset($temp);

						for($a = 1; $a <= $l; $a++){
							$temp[] = $row['orderNo_'.$a];
							$makerTemp[$row['orderNo_'.$a]] = $row['makerName_'.$a];
						}

						$orderArray = array_unique($temp);
						
						foreach ($orderArray as $value => $key){

							if ($key != ''){

								// ---------------------------------
								// PRINT TITLE
								/*******************************************************************************
								* Work STARTS HERE TO MATCH UP THE CORRECT RATE WITH THE CORRECT ORDER NUMBER *
								*******************************************************************************
								*/
								//LETS CLEAN THE $allArray so we only have one of each order No.
								//
								//echo "<br><hr><br>"; // FOR DEGUGGING CAN DELETE

								for ($ii = 0; $ii < count($allArray); $ii++){
									foreach ($allArray[$ii] as $key1 => $value2){
//if($value2[0] == $key || $makerTemp[$key] == $makerTemp[$value2[0]]){ // OLD IF STATEMENT HERE. SHOULD WORK WITHOUT THE $value2[0] == $key
										if($makerTemp[$key] == $makerTemp[$value2[0]]){
											$bottomRateValue = $value2[2];
/*
echo "if (".$value2[0]." == ".$key." || ".$makerTemp[$key]." == ".$makerTemp[$value2[0]]." )<br><br>";
echo "exit Loop. value [".$bottomRateValue."] <br><hr><br>";
*/
											$subtotRateDiv1 = $bottomRateValue;//to set the bottom rate
											$subMakerName = $makerTemp[$value2[0]];
											$bottomMakerOrderNo = $value2[0];
											$bottomMakerName = $value2[1];

										}
									}
								}
								/*********************************************************************************
								 * Work FINISHES HERE TO MATCH UP THE CORRECT RATE WITH THE CORRECT ORDER NUMBER *
								 *********************************************************************************
								 */
                                // DEFAULT VALUE FOR $PRICE
                    
                                // **************************************************************************
                                // **************************************************************************
                                // TEST HERE TO GET ID
                                // **************************************************************************
                                
                                echo "<div class='blockWrapper' style='position: relative;' data-id='".$id."' data-orderNo='".$key."'>";
                                echo "<button 
                                        class='hideExpenseBtn' 
                                        data-orderNo='".$key."' 
                                        data-id='".$id."' 
                                        style='
                                            padding: 1px;
                                            position: absolute;
                                            left: -100px;
                                            top: 0px;
                                            min-width: 80px;
                                            min-height: 20px;
                                        '>
                                        表示/非表示 <span class='fa fa-chevron-right'></span>
                                    </button>";
                                // **************************************************************************
                                // **************************************************************************                
								echo "<a href='../p_Order/order.php?pr=4&orderNo=".$key."'>オーダーNo. ".$key."</a>";
								echo " [ レート: ".$subtotRateDiv1." ]";
								echo " [ ".$subMakerName." ]";

								$result = mysql_query("SELECT * FROM `order_memo` WHERE `orderNo` = '$key'");
								$memoOrder = "";
								while ($row = mysql_fetch_assoc($result)){
									$memoOrder = $row['memo'];
								}
								$result = mysql_query("SELECT `date` FROM `order` WHERE `orderNo` = '$key' LIMIT 1");
								while ($row = mysql_fetch_assoc($result)){
									echo "<span style='float: right; clear: both;'>入荷日: ".$row['date']."</span>";
									echo "<br>";
									echo $memoOrder;
								}
								// ----------------------------------------------------------------------------------------
								// GET CURRENCY TYPE
								$resultCurr = mysql_query("SELECT DISTINCT `currency` FROM `order` WHERE `orderNo` = '$key'");
								while ($rowCurr = mysql_fetch_assoc($resultCurr)){
									$price = $rowCurr['currency'];
								}

									
								// ----------------------------------------------------------------------------------------
								echo "
								<table class='table_id'>
								<thead>
								<tr>
									<th>HID</th>
									<th>メーカー品番</th>
									<th style='max-width: 90px;'>tform品番</th>
									<th style='min-width: 50px;'>数量</th>
									<th>(".$price.")PRICE</th>
									<th style='min-width: 50px;'>掛率</th>
									<th>NET</th>
									<th style='min-width: 70px;'>仕入単価</th>
									<th style='min-width: 70px;'>最終単価</th>
								</tr>
								</thead>
								<tbody>
								";
								
								$midBlockTot = 0; // set midBlock total
								
								$result = mysql_query("SELECT * FROM `order` WHERE `orderNo` = '$key'");
								while ($row = mysql_fetch_assoc($result)){

									$net = ($row['discount'] / 100) * $row['priceList'];

									$netTrunc = truncate($net, 2);
									$tan1 = intval($netTrunc * $subtotRateDiv1);
                                    $tan2 = intval($tan1 *(1+($BA/100)));
// ADDED ON 2018-11-15
                                    
                                    if($tan1 == 0){
                                        //$tan1 = 1;
                                        $tan2 = ($BA*100)/$row['quantity'];
                                    }
                                    
// -------------------
                                                    
// ADDED ON 2018-11-17
                
                                    // check if this record is ignoring the extra expesnse in its calculation
                                    if($row['ignoreExpense'] == 1){
                                        $tan2 = 0;
                                    }
                
// -------------------
                                    
									
									//echo $subtotRateDiv1."<br>";
									echo "<tr>
								<td>".$row['id']."</td>	
								<td>".$row['makerNo']."</td>
								<td>".$row['tformNo']."</td>
								<td>".$row['quantity']."</td>";
									//-----------------------------------------
									// QUERY TO RUN GET THE PRICELIST, DISCOUNT
									//-----------------------------------------

									echo "
								<td>".number_format($row['priceList'],2, '.', ',')."</td>
								<td>".$row['discount']."</td>
								<td>".number_format(sprintf('%01.2f', $netTrunc),2, '.',',')."</td>
								
								<td>￥".number_format($tan1, 0, '.',',')."</td>
								<td>￥".number_format($tan2, 0, '.',',')."</td>";
									
									$finalUnitPrice = intval($tan2);
									$tformNo = $row['tformNo'];
									$makerNo = $row['makerNo'];
									$idFinalUnitPrice = $row['id'];

									// QUERY HERE TO UPDATE THE order table with the finalUnitPrice
									$sql = mysql_query("UPDATE `order`
						        			SET 
						        				`finalUnitPrice` = '$finalUnitPrice' 
					        				WHERE 
					        					`orderNo` = '$key' &&
				        						`tformNo` = '$tformNo' &&
				        						`makerNo` = '$makerNo' &&
												`id` = '$idFinalUnitPrice'
				        					");
									// QUERY END HERE
									echo "</tr>";
									//---------------------------------------
									//FOR THE CHECK ON THE BOTTOM
									$BotTotTemp = $row['quantity']*intval($tan2);
									$BotTot += $BotTotTemp;
									//---------------------------------------
									
									$midBlockTot += $BotTotTemp; // set midBlock total

								}
									
								echo "
								</tbody>
								</table>
								";
								echo "<br>";
								echo "<span style='float: right; color: red;'>[オーダー別合計(数量 * 最終単価 += 合計): ￥".number_format($midBlockTot, 0, '.',',')." ]</span><br><hr><br><br>";
							     echo "</div>";
                            }
						}
					}
					// ADD UP AND SEE IF THERE IS DIFFERENCE IN THE TOTAL
					// $BotTotTemp = $row['quantity']*$tan2;
					//$BotTot =+ $BotTotTemp
					//$z - $BotTot
					//---------------------------------------------------
					if(($A+$B) - $BotTot < 0){
						$col = "red";
					}else{
						$col = "green";
					}

					echo "<div style='width: 100%; height: 30px; line-height: 30px; text-align: right;'>";
					echo "合計 (A+B) ￥".number_format(($A+$B),0, '.',',')." - 最終単価合計  ￥".number_format($BotTot,0,'.',',')." = ";
					echo "<span style='color: $col'>￥".number_format(($A+$B) - $BotTot, 0, '.',',')."</span>";
					echo "(";
					
					// Check for division by 0 before showing the percentage.
					if((($A + $B)-$BotTot) == 0){
						echo number_format(0, 2, '.',',');
					} else {
						echo number_format(((($A+$B) - $BotTot)/($A+$B))*100, 2, '.',',');
					}
					
					echo "%)";
					echo "</div>";

					?>
					</div>
				</div>
			</div>
			<?php
			// END OF SEARCH CHECK WRAPPER
			} ?>
			
			<!-- PAGE CONTENTS END HERE -->
		</div>
	</div>
	<?php require_once '../master/footer.php';?>
	
</body>

</html>
