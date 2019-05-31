<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $title;?>
    </title>
    <link rel="stylesheet" href="<?php echo $path;?>/css/tfProject/tfProjectInfo.css">
    <?php
	
	include_once '../master/config.php'; 
	
	// VARIABLES
	if (isset($_GET['orderNo'])){
		$orderNo = $_GET['orderNo'];
	} else {
		$orderNo = '';
	}
?>

        <script type="text/javascript">
            $(document).ready(function() {

                // update the input boxes for ignoring Expense
                $("body").on("change", ".ignoreExpenseCheck", function(){
                   
                   var val = $(this).attr("value");

                    if(val == 0){
                      $(this).attr("value", 1);
                    }

                    if(val == 1){
                        $(this).attr("value", 0);
                    }

                });
                

                $(function() {
                    $(document).tooltip();
                });

                var defaultOptions1 = {
                    "sScrollY": 600,
                    "bJQueryUI": true,
                    "bPaginate": false,
                    "bFilter": true,
                    "bInfo": false
                };

                var defaultOptions2 = {
                    "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": true
                    }],
                    "sScrollY": 600,
                    "bJQueryUI": true,
                    "bPaginate": false,
                    "bFilter": true,
                    "bInfo": false,
                    "order": [
                        [1, "asc"]
                    ],
                };

                /* ADD CHECKBOX TO THE TABLE FILTER */
                var allowFilter = ['table_id'] // array to set which tables are allowed to use this.

                $.fn.dataTableExt.afnFiltering.push(function(oSettings, aData, iDataIndex) {
                    var checked = $('#checkbox').is(':checked');

                    if ($.inArray(oSettings.nTable.getAttribute('id'), allowFilter) == -1) {
                        // if not table should be ignored
                        return true;
                    }
                    //console.log(aData[2]);
                    if (checked && aData[2] == "×") {
                        return true;
                    }
                    if (!checked && aData[2] != "") {
                        return true;
                    }

                    return false;
                });

                var oTable1 = $('#table_id').dataTable(defaultOptions1);
                var oTable2 = $('#table_id2').dataTable(defaultOptions2);
                //var oTable3 = $('#table_id3').dataTable(defaultOptions3);

                // ***************************************************
                // add checkbox filter to hid the finished records
                // ***************************************************

                var table1 = $('#table_id');
                var table1Parent = table1.closest('#table_id_wrapper');
                table1Parent.find('.dataTables_filter').prepend(
                    "<input id='checkbox' style='float: right; width: 18px; height: 18px; margin-right: 5px;' type='checkbox'> \
		<span style='float: right; height: 20px; line-height: 20px; font-weight: 700; margin-left: 10px; padding-left: 10px; border-left: 2px solid #FFF;'> 未完成のみ </span>\
		");

                $('#checkbox').on("click", function(e) {
                    oTable1.fnDraw();
                });

                // ***************************************************


                $(window).bind('resize', function() {
                    oTable1.fnAdjustColumnSizing();
                    oTable2.fnAdjustColumnSizing();
                    //oTable3.fnAdjustColumnSizing();
                });

                /*
                // NOT SURE WHAT THIS WAS FOR, DONT NEED IT THOUGH IT SEEMS <-- JUST CAUSED AN ERROR.
                $(function() {
                	e = $.Event('keyup');
                	e.keyCode= 82; // press r key to refresh Cap Sensative
                	$('input').trigger(e);
                });
                */

                $("#datepicker").datepicker({
                    dateFormat: "yy-mm-dd"
                });
                $(".datepicker").datepicker({
                    dateFormat: "yy-mm-dd"
                });


                //inset the currency and discount on click
                $("a#currencyBtn").click(function() {
                    var value = $('#currencyVal');
                    var input = $('.currencyCopy');
                    input.val(value.val());
                });
                $("a#discountBtn").click(function() {
                    var value = $('#discountVal');
                    var input = $('.discountCopy');
                    input.val(value.val());
                });
                $("a#dateBtn").click(function() {
                    var value = $('.dateVal');
                    var input = $('.dateCopy');
                    input.val(value.val());
                });

                $('#loading').delay(300).fadeOut(300);

                $(window).keydown(function(event) {
                    if (event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                });
                
                $(window).keydown(function(event) {
                    if (event.keyCode == 9) {
                        event.preventDefault();
                        return false;
                    }
                });
                
                $(window).keydown(function(event) {
                    if (event.keyCode == 33) {
                        event.preventDefault();
                        return false;
                    }
                });
                
                $(window).keydown(function(event) {
                    if (event.keyCode == 34) {
                        event.preventDefault();
                        return false;
                    }
                });
                
                $(window).keydown(function(event) {
                    if (event.keyCode == 33) {
                        var focused = $(':focus');
                        focused.closest("tr").prev("tr").find('.priceInputBox').focus();
                    }
                });
                
                $(window).keydown(function(event) {
                    if (event.keyCode == 34) {
                        var focused = $(':focus');
                        focused.closest("tr").next("tr").find('.priceInputBox').focus();
                    }
                });


            });

        </script>
        <script>
            // dialogue boxes

            $(function() {
                var dialogRenameOrder;

                dialogRenameOrder = $("#dialogRenameOrder").dialog({
                    autoOpen: false
                });

                $("#renameOrderBtn").click(function() {
                    dialogRenameOrder.dialog("open");
                });
            });

            $(function() {
                var dialogCopyOrder;

                dialogCopyOrder = $("#dialogCopyOrder").dialog({
                    autoOpen: false
                });

                $("#copyOrderBtn").click(function() {
                    dialogCopyOrder.dialog("open");
                });
            });

            $(function() {
                var dialogUploadOrderWithPrice;

                dialogUploadOrderWithPrice = $("#dialogUploadOrderWithPrice").dialog({
                    autoOpen: false
                });

                $("#dialogUploadOrderWithPriceBtn").click(function() {
                    dialogUploadOrderWithPrice.dialog("open");
                });
            });

            $(function() {
                var dialog, form,
                    tips = $(".validateTips"),
                    orderNo = $("#orderNo"),
                    range = $("#range"),
                    date = $("#date"),
                    allFields = $([]).add(orderNo).add(date).add(range);
                var arrPre = $('#phpVarArray').val();
                var arr = arrPre.split(',');

                function updateTips(t) {
                    tips
                        .text(t)
                        .addClass("ui-state-highlight");
                    setTimeout(function() {
                        tips.removeClass("ui-state-highlight", 1500);
                    }, 500);
                }

                /* CHECK THE DATE */
                function checkDate(txtDate) {
                    var currVal = txtDate.val();
                    if (currVal == '') {
                        txtDate.addClass("ui-state-error");
                        updateTips("日付必要！");
                        return false;
                    }

                    //Declare Regex
                    var rxDatePattern = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
                    var dtArray = currVal.match(rxDatePattern); // is format OK?

                    if (dtArray == null) {
                        txtDate.addClass("ui-state-error");
                        updateTips("日付のフォーマット違います！");
                        return false;
                    }

                    //Checks for yyyy/mm/dd format.
                    dtYear = dtArray[1];
                    dtMonth = dtArray[3];
                    dtDay = dtArray[5];

                    if (dtMonth < 1 || dtMonth > 12) {
                        txtDate.addClass("ui-state-error");
                        updateTips("日付のフォーマット違います！");
                        return false;
                    } else if (dtDay < 1 || dtDay > 31) {
                        txtDate.addClass("ui-state-error");
                        updateTips("日付のフォーマット違います！");
                        return false;
                    } else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31) {
                        txtDate.addClass("ui-state-error");
                        updateTips("日付のフォーマット違います！");
                        return false;
                    } else if (dtMonth == 2) {
                        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
                        if (dtDay > 29 || (dtDay == 29 && !isleap)) {
                            txtDate.addClass("ui-state-error");
                            updateTips("日付のフォーマット違います！");
                            return false;
                        }
                    }
                    return true;
                }

                /* CHECK THE LENGTH OF ORDER NO */
                function checkLength(o, n, min, max) {
                    if (o.val().length > max || o.val().length < min) {
                        o.addClass("ui-state-error");
                        updateTips(n + "の文字数は " +
                            min + " ～ " + max + " 必要です。");
                        return false;
                    } else {
                        return true;
                    }
                }

                /* CHECK IF RECORD AMOUNT IS LESS THAN 0 */
                function checkRange(o, n, min, max) {
                    if (o.val() > max || o.val() < min) {
                        o.addClass("ui-state-error");
                        updateTips("Length of " + n + " must be between " +
                            min + " and " + max + ".");
                        return false;
                    } else {
                        return true;
                    }
                }

                /* SEARCH ARRAY AN CHECK IF ORDER NO exists ALREADY! */
                function checkArray(o, ar, n) {
                    if (jQuery.inArray(o.val(), ar) != -1) {
                        o.addClass("ui-state-error");
                        updateTips("オーダーNO. [ " + n + " ] 存在します ");
                        return false;
                    } else {
                        return true;
                    }
                }

                function addOrder() {
                    var valid = true;
                    allFields.removeClass("ui-state-error");
                    updateTips("※ すべて必須項目ですので、必ず入力してください。");

                    valid = valid && checkArray(orderNo, arr, orderNo.val());
                    valid = valid && checkLength(orderNo, "オーダー番号", 4, 32);
                    valid = valid && checkDate(date);
                    valid = valid && checkRange(range, "range", 1, 100);

                    if (valid) {
                        //alert("SEND");
                        $("#newOrderForm").submit(); // submit the form if pass
                        dialog.dialog("close");
                    }
                    //return valid;
                }

                dialog = $("#dialog-form").dialog({
                    autoOpen: false,
                    height: 350,
                    width: 350,
                    modal: true,
                    buttons: {
                        "決定": addOrder,
                        "キャンセル": function() {
                            dialog.dialog("close");
                        }
                    },
                    close: function() {
                        //form[ 0 ].reset();
                    }
                });

                //form = dialog.find( "form" ).on( "submit", function( event ) {
                //event.preventDefault();
                //addOrder();
                //});

                /*
                // if uesugi wants button uncomment this and the html at bottom of page
                $( "#create-form" ).button().on( "click", function() {
                  dialog.dialog( "open" );
                });
                */

                $('#newOrd').click(function() {
                    dialog.dialog("open");
                });

                // ***************************************************
                // scroll to top --------------------------------------
                // ***************************************************
                var checkOrderNo = "<?php echo $orderNo?>";
                if (checkOrderNo == "") {
                    var contactTopPosition = 0;
                } else {
                    var contactTopPosition = $('#table_id').find("[data-id='scrollToMe_<?php echo $orderNo;?>']").position().top;
                }

                $(".dataTables_scrollBody").animate({
                    scrollTop: contactTopPosition - 65

                });


                // ***************************************************
                // LEFT NAVI <tr> Link==------------------------------
                // ***************************************************

                $(".clickable-row").click(function() {
                    window.document.location = $(this).data("href");
                });

                // ***************************************************

                // ***************************************************
                // hight row on text input focus
                // ***************************************************

                var tbl = $("#table_id2 input");

                tbl.on("focusin", function() {

                    $(this).closest("tr").toggleClass("hightlightRow");

                });

                tbl.on("focusout", function() {

                    $(this).closest("tr").toggleClass("hightlightRow");

                });

            });

        </script>
        <style type="text/css">
            
            .ui-datepicker-prev {
                background-color: #FFF;
            }
            
            .ui-datepicker-next {
                background-color: #FFF;
            }
            
            .ui-corner-all,
            .ui-corner-bottom,
            .ui-corner-right,
            .ui-corner-br {
                border-radius: 0px;
            }
            
            .ui-corner-all,
            .ui-corner-top,
            .ui-corner-right,
            .ui-corner-tr {
                border-radius: 0px;
            }
            
            #fragment-1 {
                min-height: 150px;
            }
            
            #fragment-2 {
                min-height: 150px;
            }
            
            #fragment-2 input[type=text] {
                height: 20px;
            }
            
            #fragment-3 {
                min-height: 150px;
            }
            
            #fragment-4 {
                min-height: 150px;
            }
            
            #table_id2 input[type=text] {
                text-align: center;
                width: 100%;
            }
            
            #table_id3 input[type=text] {
                text-align: center;
                width: 100%;
            }
            
            select {
                text-align: center;
                width: 100%;
            }
            
            .oneQuarterBox {
                width: 25%;
                background-color: #FFF;
                float: left;
            }
            
            .oneQuarterBox a {
                text-decoration: none;
                color: #000;
            }
            
            .threeQuarterBox {
                width: 75%;
                background-color: #FFF;
                float: left;
            }
            
            .orderH1 {
                height: 30px;
                line-height: 30px;
            }
            
            .ui-widget-content {
                border: none;
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
            /* DIALOGUE INFO*/
            
            .newOrderDialog label,
            .newOrderDialog input {
                display: block;
                margin-bottom: 4px;
            }
            
            .newOrderDialog input.text {
                margin-bottom: 12px;
                width: 95%;
                padding: .4em;
                border: 1px solid #999;
            }
            
            .newOrderDialog fieldset {
                padding: 0;
                border: 0;
                margin-top: 25px;
            }
            
            .newOrderDialog h1 {
                font-size: 1.2em;
                margin: .6em 0;
            }
            
            .newOrderDialog div#users-contain {
                width: 350px;
                margin: 20px 0;
            }
            
            .newOrderDialog div#users-contain table {
                margin: 1em 0;
                border-collapse: collapse;
                width: 100%;
            }
            
            .newOrderDialog div#users-contain table td,
            div#users-contain table th {
                border: 1px solid #eee;
                padding: .6em 10px;
                text-align: left;
            }
            
            .newOrderDialog .ui-dialog .ui-state-error {
                padding: .3em;
            }
            
            .newOrderDialog .validateTips {
                border: 1px solid transparent;
                padding: 0.3em;
            }
            
            #dialog-form {
                border-left: 1px solid #999;
                border-right: 1px solid #999;
                border-bottom: 1px solid #999;
            }
            
            .newOrderDialog input[type=range] {
                -webkit-appearance: none;
                background-color: #CCC;
                width: 250px;
                height: 26px;
            }
            
            .newOrderDialog input[type="range"]::-webkit-slider-thumb {
                -webkit-appearance: none;
                background-color: #489EFA;
                width: 12px;
                height: 32px;
            }
            
            .newOrderDialog input[type="range"] {
                outline: none;
            }
            
            #dialogRenameOrder {
                border: 1px solid #aaaaaa;
            }
            
            #dialogCopyOrder {
                border: 1px solid #aaaaaa;
            }
            
            #dialogUploadOrderWithPrice {
                border: 1px solid #aaaaaa;
            }
            
            .clickable-row:hover {
                cursor: pointer;
                outline: 2px solid lightskyblue;
            }
            
            .hightlightRow {
                outline: 3px solid orange;
            }

        </style>
</head>

<body id='index'>
    <?php

	
// Is orderNo finished

$resultCurrent = mysql_query("SELECT isFinishedHidden FROM order_settings WHERE id = '1'");

while($rowCurrent = mysql_fetch_assoc($resultCurrent)){
	$isAllFinshedQuery = $rowCurrent['isFinishedHidden'];

	if($isAllFinshedQuery == true) {
		$isAllFinshed = true;
	} else {
		$isAllFinshed = false;
	}
}
//---------
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

                <div class='oneQuarterBox' style='background-color: #FFF;'>
                    <table id="table_id">
                        <thead>
                            <tr>
                                <th>オーダーNo.</th>
                                <th>入荷日</th>
                                <th>全体完成</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

						$result = mysql_query("SELECT DISTINCT `orderNo`, `date` FROM `order`");
						while ($row = mysql_fetch_assoc($result)){
							$makerOrderNo = $row['orderNo'];
							/*
							 * LOOP FOR GETTING MAKER NAME FROM EXPENSE TABLE
							 * Loop over the orderNo_1 and makerNo_1 ,2,3 etc and exit loop after match is found.
							 */
							$orderCheck = "";
							$titleMakerAnswer = "";
							$titleMaker1 = "";
							$titleMaker2 = "";
							$titleMaker3 = "";
							$titleMaker4 = "";
							$titleMaker5 = "";
							$titleMaker6 = "";
							$titleMaker7 = "";
							$titleMaker8 = "";
							$titleMaker9 = "";
							$titleMaker10 = "";

							$makerResult = mysql_query("SELECT * FROM `expense` WHERE
							`orderNo_1` = '$makerOrderNo' OR
							`orderNo_2` = '$makerOrderNo' OR
							`orderNo_3` = '$makerOrderNo' OR
							`orderNo_4` = '$makerOrderNo' OR
							`orderNo_5` = '$makerOrderNo' OR
							`orderNo_6` = '$makerOrderNo' OR
							`orderNo_7` = '$makerOrderNo' OR
							`orderNo_8` = '$makerOrderNo' OR
							`orderNo_9` = '$makerOrderNo' OR
							`orderNo_10` = '$makerOrderNo'
							");
							$i = 1;
							while ($makerRow = mysql_fetch_assoc($makerResult)){

								$titleMaker1 = $makerRow['orderNo_1'];
								$titleMaker2 = $makerRow['orderNo_2'];
								$titleMaker3 = $makerRow['orderNo_3'];
								$titleMaker4 = $makerRow['orderNo_4'];
								$titleMaker5 = $makerRow['orderNo_5'];
								$titleMaker6 = $makerRow['orderNo_6'];
								$titleMaker7 = $makerRow['orderNo_7'];
								$titleMaker8 = $makerRow['orderNo_8'];
								$titleMaker9 = $makerRow['orderNo_9'];
								$titleMaker10 = $makerRow['orderNo_10'];

								$finAll = $makerRow['finAll']; // SET ALL FINISHED VARIABLE

								if ($titleMaker1 == $makerOrderNo){
									$titleMakerAnswer = $makerRow['makerName_1'];
									$orderCheck = 1;
								} else if ($titleMaker2 == $makerOrderNo) {
									$titleMakerAnswer = $makerRow['makerName_2'];
									$orderCheck = 2;
								} else if ($titleMaker3 == $makerOrderNo) {
									$titleMakerAnswer = $makerRow['makerName_3'];
									$orderCheck = 3;
								} else if ($titleMaker4 == $makerOrderNo) {
									$titleMakerAnswer = $makerRow['makerName_4'];
									$orderCheck = 4;
								} else if ($titleMaker5 == $makerOrderNo) {
									$titleMakerAnswer = $makerRow['makerName_5'];
									$orderCheck = 5;
								} else if ($titleMaker6 == $makerOrderNo) {
									$titleMakerAnswer = $makerRow['makerName_6'];
									$orderCheck = 6;
								} else if ($titleMaker7 == $makerOrderNo) {
									$titleMakerAnswer = $makerRow['makerName_7'];
									$orderCheck = 7;
								} else if ($titleMaker8 == $makerOrderNo) {
									$titleMakerAnswer = $makerRow['makerName_8'];
									$orderCheck = 8;
								} else if ($titleMaker9 == $makerOrderNo) {
									$titleMakerAnswer = $makerRow['makerName_9'];
									$orderCheck = 9;
								} else if ($titleMaker10 == $makerOrderNo) {
									$titleMakerAnswer = $makerRow['makerName_10'];
									$orderCheck = 10;
								} else {
									$titleMakerAnswer = "オーダーに使っていません...";
								}


							}
							// echo $titleMaker1."-".$makerOrderNo.": ".$titleMakerAnswer."<hr><br>";
							//LOOP DONE
							if ($row['orderNo'] == $orderNo){
								$selectedBg = 'lightskyblue';
								$selectedTxt = '#FFF';
							} else {
								$selectedBg = '';
								$selectedTxt = '';
							}

							/* CHECK IF ALL DONE */
							if ($finAll == 1){
								$finAllIcon = "●";
							} else {
								$finAllIcon = "×";
							}

							echo "
									<tr 
										style='text-align: center;' 
										class='clickable-row' 
										data-href='order.php?pr=4&orderNo=".$row['orderNo']."' 
										data-id='scrollToMe_".$row['orderNo']."'
									>
										<td style='background-color: $selectedBg; color: $selectedTxt;'>
											<a href='order.php?pr=4&orderNo=".$row['orderNo']."' title='$titleMakerAnswer'>
												".$row['orderNo']."
											</a>
										</td>
										<td style='background-color: $selectedBg; color: $selectedTxt;'>
											".$row['date']."
										</td>
										<td style='background-color: $selectedBg; color: $selectedTxt;'>
											$finAllIcon
										</td>
									</tr>
									";

							/*add to ORDER NO ARRAY*/
							$orderNoArray[] = $row['orderNo'];
						}
						?>
                        </tbody>
                    </table>

                </div>

                <div class='threeQuarterBox' style='background-color: #FFF;'>
                    <form action='exe/exeUpdate.php' method='POST' name='updateOrder' id='updateOrder'>
                        <?php
					echo "
						<table id='table_id2' style='text-align: center;'>
						<thead>
                            <tr>
                                <th>HID</th>
                                <th>メーカー品番</th>
                                <th>tform品番</th>
                                <th>入荷日</th>
                                <th>数量</th>
                                <th>通貨</th>
                                <th>PRICE</th>
                                <th>掛率</th>
                                <th>経費合計無</th>
                                <th>削除</th>
                            </tr>
						</thead>
						<tbody>
						";
					
				//button counter for the currency ie: EUR and the DISCOUNT ie: 58.21 to be copied to all bellow
					$buttonCounter = 1;
				//--------------------
				$result = mysql_query("SELECT * FROM `order` WHERE `orderNo` = '$orderNo'");
				while ($row = mysql_fetch_assoc($result)){
                    
					echo "<tr>
					<td>".$row['id']."</td>
					<td><input type='text' name='makerNo_".$row['id']."' value='".$row['makerNo']."' tabindex='-1'></td>
					<td><input type='text' name='tformNo_".$row['id']."' value='".$row['tformNo']."' tabindex='-1'></td>";

					if ($buttonCounter == 1){
						echo "<td style='max-width: 100px; text-align: left;'><input type='text' name='date_".$row['id']."' value='".$row['date']."' style='width: 80px;' class='dateVal' id='datepicker' tabindex='-1'>
						<div style='margin-left: 3px; float: right; padding-left: 3px; padding-right: 3px;'><a href='#' id='dateBtn' tabindex='-1' title='コピー'><i class='fa fa-arrow-down'></i></a></div></td>";
					} else {
						echo "<td style='max-width: 100px;'><input type='text' name='date_".$row['id']."' value='".$row['date']."' class='dateCopy' tabindex='-1'></td>";
					}

					echo "<td style='max-width: 75px;'><input type='text' name='quantity_".$row['id']."' value='".$row['quantity']."' tabindex='-1'></td>";
					
                    /* CHANGE THE INPUT TO A SELECT */
                    // set the selected option according to its database entry. 
                    $selected = ""; // initialize selected string
                    $selectArr = ["", "EUR", "USD", "JPY", "RMB", "DKK", "SGD"]; // CURRENCY OPTIONS
                    
                    if ($buttonCounter == 1){
                    
                        /*
                        echo "<td style='max-width: 75px; text-align: left;'>
                                <input type='text' name='currency_".$row['id']."' value='".$row['currency']."' style='width: 58px;' id='currencyVal' tabindex='-1'>
                                <div style='margin-left: 3px; float: right; padding-left: 3px; padding-right: 3px;'>
                                    <a href='#' id='currencyBtn' tabindex='-1' title='コピー'>
                                        <i class='fa fa-arrow-down'></i>
                                    </a>
                                </div>
                            </td>";
                        */
                        
                        echo "<td style='max-width: 75px; text-align: left;'>";
                        
                        echo "<select name='currency_".$row['id']."' value='".$row['currency']."' style='width: 58px;' id='currencyVal' tabindex='-1'>";
                        
                        foreach($selectArr as $value){
                            if($value == $row['currency']){
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }
                            echo "<option name='".$value."' ".$selected.">".$value."</option>";
                        }
                      
                        echo "</select>";
                            
                        echo "
                            <div style='margin-left: 3px; float: right; padding-left: 3px; padding-right: 3px;'>
                                <a href='#' id='currencyBtn' tabindex='-1' title='コピー'>
                                    <i class='fa fa-arrow-down'></i>
                                </a>
                            </div>
                        </td>";
                        
					} else {

                        /* echo "<td style='max-width: 75px;'>
                                <input type='text' name='currency_".$row['id']."' value='".$row['currency']."' class='currencyCopy' tabindex='-1'>
                            </td>";
                        */
                        echo "<td style='max-width: 75px;'>
                                <select name='currency_".$row['id']."' value='".$row['currency']."' class='currencyCopy' tabindex='-1'>";
                        
                        foreach($selectArr as $value){
                            if($value == $row['currency']){
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }
                            echo "<option name='".$value."' ".$selected.">".$value."</option>";
                        } 
                        
                        echo "
                                </select>
                            </td>";

					}
                    /* ------------------------------------------------------------------------------------------------------------------------------------------------------------------ */
                    
                    
					echo "
					<td  style='max-width: 75px;'><input type='text' class='priceInputBox' name='priceList_".$row['id']."' value='".$row['priceList']."'></td>";
                    
                    // ADDED on 2018-11-17 Howe
                    
                    // check for if the item has a check or not.
                    $appleseed = $row['ignoreExpense'];
                    if($appleseed == true){
                        $ignoreExpense = 1;
                        $checked = "checked";
                    } else {
                        $ignoreExpense = 0;
                        $checked = "";
                    }
                    
                    echo "
                        <td>
                            <input type='hidden' name='ignoreExpense_".$row['id']."' value='0'>
                            <input class='ignoreExpenseCheck' type='checkbox' name='ignoreExpense_".$row['id']."' value='".$ignoreExpense."' ".$checked.">
                        </td>
                    ";
                    // ------------------------

					if ($buttonCounter == 1){
						echo "<td  style='max-width: 75px; text-align: left;'><input type='text' name='discount_".$row['id']."' value='".$row['discount']."' style='width: 58px;' id='discountVal' tabindex='-1'>
						<div style='margin-left: 3px; float: right; padding-left: 3px; padding-right: 3px;'><a href='#' id='discountBtn' tabindex='-1' title='コピー'><i class='fa fa-arrow-down'></i></a></div>
						</td>";
					} else {
						echo "<td  style='max-width: 75px;'><input type='text' name='discount_".$row['id']."' value='".$row['discount']."' class='discountCopy' tabindex='-1'></td>";
					}

					$id = $row['id'];
					echo "<td><a href='exe/delOrderSingle.php?id=$id&orderNo=$orderNo' onClick='return confirm(\"オーダー修正保存しましたか？エントリー削除?\")' tabindex='-1'><div style='width: 100%; background-color: red; color: #FFF;'>
					<i class='fa fa-times'></i>
					</div></a></td>";

					echo "</tr>";
					// add the the buttonCounter so only the first record will show buttons
					$buttonCounter++;
				}
				echo "<input type='text' name='orderNo' value='".$orderNo."' style='display: none;' >";
				echo "
					</tbody>
					</table>
					";

				?>
                    </form>
                </div>

                <div class='clear'></div>


                <div class='fullBox'>
                    <div id="tabs">
                        <ul>
                            <li><a href="#fragment-1"><span>アップロード</span> </a></li>
                            <li><a href="#fragment-2"><span>オーダー商品追加</span> </a></li>
                            <li><a href="#fragment-3"><span>オーダー削除</span> </a></li>
                            <li><a href="#fragment-4"><span>オーダー別経費計算表のメッセージ</span></a>
                        </ul>
                        <div id="fragment-1">
                            <div style='float: left;'>
                                <?php
								/* UPLOAD ▶▶▶WITHOUT◀◀◀ PRICE SET!! */
								/*
								echo "<h1>オーダーアップロード</h1>";
								echo "<form class='formLoad' enctype='multipart/form-data' action='exe/exeUploadWithPrice.php' method='post'>";
								echo "<br>";
								echo "オーダーのCSV選ぶ:<br />";
								echo "<input size='50' type='file' name='filename'><br><br>";
								echo "<button type='submit' name='submit'class='upload'>";
								echo "<i class='fa fa-upload'></i> アプロード ";
								echo "</button>";
								echo "<span class='attention'><br><br> ※ 一回だけ押してください。<br></span>";
								echo "</form>";
								echo "<br><br>";
								*/
							?>
                            </div>

                            <input type="hidden" id="phpVar" value="<?php echo $orderNoVar; ?>">
                            <input type="hidden" id="phpVarArray" value="<?php echo $orderNoArrayImp; ?>">

                            <div style='float: left; margin-left: 20px;'>
                                1. FileMakerからEXCEL(*.xls)<br> 2. Excelで開く<br> 3. sheet名右クリックしてコードを表示するクリック<br> 4. VBAコード貼り付け、[ <span style='color: green; font-weight: 700;'>▶ </span>] ボタン押す<br> 5. 名前付けて保存（*.csv）<br> 6. メモで開いて名前付けて保存（UTF-8, すべてのプログラム）<br> 7. アプロード<br>
                            </div>
                            <div style='float: left; margin-left: 40px;'>
                                EXCEL (VSB) -
                            </div>
                            <div style='float: left; margin-left: 10px; border: dashed 1px #CCC; padding: 5px;'>

                                Sub orderFix()<br> Range("C:C, D:D, F:F, I:I, J:J, M:M, N:N, O:O, P:P").Select<br> Selection.Delete Shift:=xlToLeft<br> Rows(1).Select
                                <br> Selection.Delete Shift:=xlUp<br> Range("A:A").Replace "1", "0"<br> Range("F:F").NumberFormat = "YYYY.MM.DD"<br> Range("A:A,C:C,D:D,E:E,G:G").NumberFormat = "General"<br> Range("B:B").NumberFormat = "0.00"<br> End Sub<br> - UPDATED 2017.2.10
                            </div>

                            <a href='../p_expense/expenseAllFiles.php?pr=3&jump=<?php echo $orderNo;?>'><button class='submit' style='float: right;'><?php echo $orderNo;?>ページへ</button></a>

                            <!-- HIDDEN NEW RECORD FORM -->
                            <div id="dialog-form" title="新規オーダー">
                                <p class="validateTips">※ すべて必須項目ですので、必ず入力してください。</p>
                                <form class="newOrderDialog" id="newOrderForm" action='exe/exeNewRecord.php' method='post'>
                                    <fieldset>
                                        <label for="orderNo">オーダー品番</label>
                                        <input type="text" name="orderNo" id="orderNo" value='' class="text ui-widget-content ui-corner-all">

                                        <label for="date">日付</label>
                                        <input type='text' class='datepicker text ui-widget-content ui-corner-all' name='date' id='date' style='width: 100px;'>
                                        <br>
                                        <label for="points">レコード数</label>
                                        <input type='text' value='1' name='range' id="range" class="text ui-widget-content ui-corner-all" style='width: 50px; float: left; margin-right: 10px;'>
                                        <input type="range" value="1" min="1" max="25" onInput="showValue(this.value)" style='float: right;'>

                                        <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                    </fieldset>
                                </form>
                            </div>


                        </div>
                        <?php
					if ($orderNo != '') {
						echo "<div id='fragment-2'>
								<h1>オーダー商品追加</h1>
								<br>
								<form action='exe/exeAdd.php' method='post'>
										<input type='text' name='orderNo'
												value='$orderNo' style='display: none;'>
										<table style='text-align: center;'>
											<thead>
												<tr>
													<th>メーカー品番</th>
													<th>tform品番</th>
													<th>入荷日</th>
													<th>数量</th>
													<th>通貨</th>
													<th>PRICE</th>
                                                    <th>経費合計無</th>
													<th>DISCOUNT</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td ><input type='text' name='makerNo' style='width: 300px;'></td>
													<td><input type='text' name='tformNo' ></td>
													<td><input type='text' class='datepicker' name='date' style='width: 100px;'>
													</td>
													<td><input type='text' name='quantity' style='width: 50px;'></td>
													<td><input type='text' name='currency' style='width: 100px;'></td>
													<td><input type='text' name='priceList' style='width: 100px;'></td>
                                                    <td><input type='checkbox' name='ignoreExpense' style=''></td>
													<td><input type='text' name='discount' style='width: 100px;'></td>";
													?>
                            <td>
                                <input type='submit' class='upload' value='追加' style='margin: 5px;' onClick="return confirm('オーダー修正保存しましたか？オーダー商品追加しますか？')">
                            </td>
                            <?php
										echo "</tr>
										</tbody>
									</table>
								</form>
							</div>";

							echo "
							<div id='fragment-3'>
							<h1>オーダー削除</h1>";
					?>
                                <button class='delEntryBtn' style='width: 200px; height: 40px; margin-top: 20px;' onClick="if (confirm('オーダー削除してもいいですか？')) location.href='exe/delOrder.php?orderNo=<?php echo $orderNo?>';"> 削除 </button>
                                <?php
						echo "</div>";

						echo "
						<div id='fragment-4'>";
					
						if (isset($_GET['orderNo'])){
							if ($orderNo != '') {
							$display = '';
							} else {
							$display = 'none';
							}
						} else {
							$display = 'none';
						}
					?>
                                    <div style='display: <?php echo $display;?>; width: 75%; margin: auto; padding-top: 10px; padding-bottom: 10px; line-height: 40px; height: 40px;'>

                                        <?php

						// Query for Memo
						$result = mysql_query("SELECT * FROM `order_memo` WHERE `orderNo` = '$orderNo'");
						while ($row = mysql_fetch_assoc($result)){
							$memo = $row['memo'];
						}
						if (isset($memo)){
							$memo = $memo;
						} else {
							$memo = '';
						}
					?>
                                            <form action='exe/exeUpdateMemo.php' method='POST'>
                                                <span style='margin-left: 20px;'><i class="fa fa-comment-o" style='font-size: 16px;'></i> オーダー別経費計算表メモ:</span>
                                                <input type='text' value='<?php echo $memo;?>' name='memo' style='width: 600px;
						font-size: 14px;
						height: 30px;
						margin-left: 10px;
						margin-right: 10px;'>
                                                <input type='hidden' value='<?php echo $orderNo;?>' name='orderNo'>
                                                <button type="submit" class='saveSmallBtn' style='padding-left: 5px; padding-right: 5px; font-size: 12px;'>
						保存 <i class='fa fa-save'></i>
					</button>
                                            </form>

                                    </div>

                                    <?php
				echo "</div>";

				}?>

                    </div>
                    <script>
                        $("#tabs").tabs();

                    </script>

                </div>
                <script type="text/javascript">
                    function showValue(newValue) {
                        document.getElementById("range").value = newValue;
                    }

                </script>

                <!-- RENAME RECORD SCRIPT -->


                <div class='newOrderDialog' id="dialogRenameOrder" title="オーダーNo.変更" style='font-family: monospace; font-size: 13px;'>
                    <form method='post' action='exe/exeRenameOrder.php'>
                        <table id='renameOrderPopup' style='width: 100%; text-align: center;'>
                            <tr>
                                <th style='width: 100px;'>
                                    旧オーダーNo.
                                </th>
                                <td>
                                    <input type='text' name='orderNo' placeholder='' id='renameOrderNo' style='width: 100%;'>
                                </td>
                            </tr>
                            <tr>
                                <th style='width: 100px'>
                                    新オーダーNo.
                                </th>
                                <td>
                                    <input type='text' name='newOrderNo' id='renameNewOrderNo' placeholder='' style='width: 100%'>
                                </td>
                            </tr>
                            <tr>
                                <th colspan='2' style='padding: 10px;'>
                                    <input type='submit' value='変更' style='
										font-family: monospace;
										padding-top: 5px;
										padding-bottom: 5px;
										padding-left: 10px;
										padding-right: 10px;
										display: block;
										margin-left: auto;
										margin-right: auto;
									'>
                                </th>
                            </tr>
                        </table>
                    </form>
                </div>

                <!-- COPY RECORD SCRIPT -->

                <div class='newOrderDialog' id="dialogCopyOrder" title="COPY ORDER" style='font-family: monospace; font-size: 13px;'>
                    <form method='post' action='exe/exeCopyOrder.php'>
                        <table id='copyOrderPopup' style='width: 100%; text-align: center;'>
                            <tr>
                                <th style='width: 100px;'>
                                    旧オーダーNo.
                                </th>
                                <td>
                                    <input type='text' name='orderNo' placeholder='' id='copyOrderNo' style='width: 100%;'>
                                </td>
                            </tr>
                            <tr>
                                <th style='width: 100px'>
                                    新オーダーNo.
                                </th>
                                <td>
                                    <input type='text' name='newOrderNo' id='copyNewOrderNo' placeholder='' style='width: 100%'>
                                </td>
                            </tr>
                            <tr>
                                <th colspan='2' style='padding: 10px;'>
                                    <input type='submit' value='COPY ORDER' style='
										font-family: monospace;
										padding-top: 5px;
										padding-bottom: 5px;
										padding-left: 10px;
										padding-right: 10px;
										display: block;
										margin-left: auto;
										margin-right: auto;
									'>
                                </th>
                            </tr>
                        </table>
                    </form>
                </div>

                <!-- UPLOAD ORDER WITH PRICE RECORD SCRIPT -->
                <div class='newOrderDialog' id="dialogUploadOrderWithPrice" title="Upload With Price" style='font-family: monospace; font-size: 13px;'>
                    <?php
					/* UPLOAD WITH PRICE SET!! */
					echo "<h1>オーダーアップロードﾒｰｶｰ価格付</h1>";
					echo "<form class='formLoad' enctype='multipart/form-data' action='exe/exeUploadWithPrice.php' method='post'>";
					echo "<br>";
					echo "オーダーのCSV選ぶ:<br />";
					echo "<input size='50' type='file' name='filename'><br><br>";
					echo "<button type='submit' name='submit'class='upload'>";
					echo "<i class='fa fa-upload'></i> アプロード ";
					echo "</button>";
					echo "<span class='attention'><br><br> ※ 一回だけ押してください。<br></span>";
					echo "</form>";
					echo "<br><br>";
				?>
                </div>
                <!-- PAGE CONTENTS END HERE -->
            </div>
        </div>
        <?php require_once '../master/footer.php';?>
</body>

</html>
