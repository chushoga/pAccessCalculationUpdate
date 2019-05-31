<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        取引条件設定
    </title>
    <link rel="stylesheet" href="<?php echo $path;?>/css/tfProject/tfProjectInfo.css">
    <?php include_once '../master/config.php'; ?>
    <script type="text/javascript">
        
        $(document).ready(function() {
            /*DATATABLES START*/
            var defaultOptions = {
                "bJQueryUI": true,
                "bPaginate": false,
                "bInfo": false,
                "sPaginationType": "full_numbers",
                "sScrollX": "100%",
                "iDisplayLength": 100,
                "aaSorting": [
                    [0, 'desc']
                ],
            }; 
            
            //options
            var defaultOptions2 = {
                "bJQueryUI": true,
                "bPaginate": false,
                "bInfo": false,
                "sPaginationType": "full_numbers",
                "sScrollX": "100%",
                "iDisplayLength": 100,
                "aaSorting": [
                    [1, 'asc']
                ]
            };
            
            //options
            var calcDataTableHeight = function() {
                var h = 530;
                return h + 'px';
            };
            defaultOptions.sScrollY = calcDataTableHeight();

            var calcDataTableHeight2 = function() {
                // navi: 20px + uiToolbar: 38px + thHeight: 25px + toolBarFooter: 40px; = 123px 
                var minusResult = 768
                var h = Math.floor($(window).height() - minusResult);
                return h + 'px';
            };
            defaultOptions2.sScrollY = calcDataTableHeight2();

            var oTable1 = $('#topTable').dataTable(defaultOptions);
            var oTable2 = $('#bottomTable').dataTable(defaultOptions2);

            $(window).bind('resize', function() {
                $('setTermsAndConditionsMiddle.dataTables_scrollBody').css('height', calcDataTableHeight());
                $('setTermsAndConditionsBottom.dataTables_scrollBody').css('height', calcDataTableHeight2());
                oTable1.fnAdjustColumnSizing();
                oTable2.fnAdjustColumnSizing();
            });
            //----------------------------------
            
            $('#selecctall').click(function(event) { //on click 
                if (this.checked) { // check select status
                    $('.checkbox1').each(function() { //loop through each checkbox
                        this.checked = true; //select all checkboxes with class "checkbox1"

                    });
                } else {
                    $('.checkbox1').each(function() { //loop through each checkbox
                        this.checked = false; //deselect all checkboxes with class "checkbox1"
                    });
                }
                var n = $("input:checked").length;
                var a = $(".checkedAmount");

                if (n > 0) {
                    $('.checkedCount').delay(300).slideDown(500);
                    $('.checkedCount').delay(3000).slideUp(500);
                    a.val(n - 1);
                } else {}
            });

            /*DATATABLES END*/

            // $('#loading').fadeOut(800);

            $('#loading').delay(300).fadeOut(300);

            $(".setTermsAndConditionsMiddle").show();
            $(".setTermsAndConditionsBottom").show();

            $('setTermsAndConditionsMiddle.dataTables_scrollBody').css('height', calcDataTableHeight());
            $('setTermsAndConditionsBottom.dataTables_scrollBody').css('height', calcDataTableHeight2());
            oTable1.fnAdjustColumnSizing();
            oTable2.fnAdjustColumnSizing();


            /*AUTOCOMPLETE*/
            $(function() {
                function log(message) {
                    $("<div>").text(message).prependTo("#log");
                    $("#log").scrollTop(0);
                }

                $("#maker").autocomplete({
                    source: "exe/autocompleteTermsAndConditions.php",
                    minLength: 2,
                    select: function(event, ui) {
                        log(ui.item ?
                            //"dbID: [ " + ui.item.id + " ] " + ui.item.label :
                            ui.item.label :
                            "Nothing selected, input was " + this.value);
                    }
                });
            });
        });

    </script>
    <style type="text/css">
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

    </style>

</head>

<body>
    <?php //variables
if (isset($_GET['search'])==true){
    $search = $_GET['search'];
    } else {
$search = "NULL";
    }

?>
    <div id='wrapper'>

        <div id='loading'>
            <?php
	$counter = 0; 
	$resultCounter = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` LIKE '%$search%'") or die(mysql_error());
	while ($rowCounter = mysql_fetch_assoc($resultCounter)){
	$counter++;
	}
    ?>
            <span class='loadingGifMain'><img src='<?php echo $path;?>/img/142.gif'><br>LOADING
                <?php echo $counter;?> Files ...</span></div>
        <?php
	//checked amount
	echo "<div class='checkedCount' style='
		display: none; 
		width: 250px; 
		height: 30px; 
		position: fixed; 
		top: 72px; 
		left: 0px; 
		z-index: 9001; 
		background-color: #FFF; 
		border: solid 2px #8F8F8F;
		line-height: 30px;
		padding-left: 10px;
		font-size: 16px;
		'>
		<input type='text' class='checkedAmount' style='width: 60px; border: none; font-size: 16px;'> レコード選択しました
	</div>";
	
	?>
        <?php require_once '../header.php';?>
        <div class='contents'>
            <!-- PAGE CONTENTS START HERE -->




            <form action='exe/exeSetTermsAndConditions.php?search=<?php echo $search;?>' method='POST' class='formLoad' id='termsAndConditionsSave'>
                <div class='setTermsAndConditionsTop'>
                    <div class='setTermsAndConditionsTopForm'>
                        <div style='float: left; margin-left: 10px;'>
                            <input type='checkbox' id='selecctall'> すべて選択<i class='fa fa-check'></i>
                        </div>
                        <div class="ui-widget" style='float: left; margin-left: 10px;'>
                            <label for="maker">dbID/メーカー: </label>
                            <input id="maker" name='id' style='width: 50px; height: 19px; text-align: center;'>
                        </div>
                        <div class="ui-widget" style='float: left;'>
                            <div id="log" style="padding-left: 10px; height: 21px; margin-top: 13px; width: 400px; overflow: hidden; line-height: 21px;" class="ui-widget-content"></div>
                        </div>
                        <div style='float: left; margin-left: 10px;'>
                            <!-- added a conditional to the navi if the basename = this page then set the save function to this form 
        			<input type='submit' class='go' onclick='showLoading();'> -->
                        </div>
                    </div>
                </div>
                <div class='setTermsAndConditionsMiddle'>
                    <table id='topTable'>
                        <thead>
                            <tr>
                                <th><i class='fa fa-check'></i></th>
                                <th style='min-width: 100px;'>品番</th>
                                <th>メーカー品番</th>
                                <th>シリーズ</th>
                                <th>タイプ</th>
                                <th style='min-width: 125px;'>メーカーPL</th>
                                <th style='min-width: 150px;'>PL</th>
                                <th>原価</th>
                                <th style='min-width: 150px;'>倍率</th>
                                <th>変更日</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
					$result = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` LIKE '%$search%'") or die(mysql_error());
					while ($row = mysql_fetch_assoc($result)){


						$plCurrentTermsId = $row['id'];
						$tfmNo = $row['tformNo'];
						$checkMarkCheck = $row['plCurrent'];
						$createdPLCURRENT = $row['created'];

						//check if the hinban exists in main
						/*
						 $resultNotExists = mysql_query("SELECT `tformNo` FROM `main` WHERE `tformNo` = '$tfmNo'");
							if(mysql_num_rows($resultNotExists) == 0) {
								echo $tfmNo."<br>";
								$mainNotExists = "<td style='background-color: red;'><a href='calculation.php?pr=1&id=$id'>".$tfmNo."</a><br>";

							} else {
							   $mainNotExists = "<td><a href='calculation.php?pr=1&id=$id'>".$tfmNo."</a><br>";
							}
						*/
						//----------------------------------

						$resultMain = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$tfmNo' ");
					 if(mysql_num_rows($resultMain) == 0) {
							  
								  $haiban = "";
								  $img = "";
								  $makerNo = "<img src='".$path."/img/filemaker.png'> <span style='color: red;'>FileMakerデーターありません</span>";
								  $tformPriceNoTax = 0;
								  $id = 0;
								  $mainNotExists = "<td style='background-color: #FFEBEB;'><a href='calculation.php?pr=1&id=$id'>".$tfmNo."</a><br>";
								  $type = "";
						 			$series = "";
							} else {

						while ($rowMain = mysql_fetch_assoc($resultMain)){
							  $haiban = $rowMain['memo'];
							  $imgURL = $rowMain['thumb'];
							  $makerNo = $rowMain['makerNo'];
							  $tformPriceNoTax = $rowMain['tformPriceNoTax'];
							  $id = $rowMain['id'];
							  $type = $rowMain['type'];
								$series = $rowMain['series'];
						}      
						$mainNotExists = "<td><a href='calculation.php?pr=1&id=$id'>".$tfmNo."</a><br>";
						}

						echo "<tr>";
						echo "<td style='width: 20px;'>";
						//check for input if 0 dont show checkbox! uncomment this to use function
						/*
						if ($checkMarkCheck != 0){
						echo "<input class='checkbox1' type='checkbox' name='$tfmNo'>";
						} else {
							echo "";
						}
						*/
						echo "<input class='checkbox1' type='checkbox' name='$tfmNo'>"; //commment this line if using above
						echo "</td>";

						//echo "<td><a href='calculation.php?pr=1&id=$id'>".$tfmNo."</a><br>";
						echo $mainNotExists;

						if($imgURL != ""){
							$thumRep = str_replace("img/img_phot/photo", "img/img_phot/photo_thum060", $imgURL);
							$img = "<img src ='".$filemakerImageLocation.$imgURL."' style='max-width: 45px; max-height: 45px;'>";
						} else {
							$img = "<li class='fa fa-picture-o' style='font-size: 40px; color: #CCC;'></li>";
						}
						echo $img;

						/*
						if($imgURL != ""){
						echo "<img src='http://www.tform.co.jp/$imgURL' style='max-width: 50px; max-height: 50px;'>";
						} else {
						echo "<li class='fa fa-picture-o' style='font-size: 50px; color: #CCC;'></li>";

						}
						*/
						echo "</td>";
						//echo "<td class ='".$setcol."'>".$row['type']."</td>";
						echo "<td>".$makerNo."</td>";
						echo "<td>".$series."</td>";
						echo "<td>".$type."</td>";
						// plcurrent QUERY
						$resultPl = mysql_query("SELECT * FROM sp_plcurrent WHERE `tformNo` = '$tfmNo' ")
						or die(mysql_error());
						while ($rowPl = mysql_fetch_assoc($resultPl)){

							$sp_disc_rate_id = $rowPl['sp_disc_rate_id'];
							$plCurrent = $rowPl['plCurrent'];

							$year = 0;
							$memo = 0;
							$maker = 0;
							$netTerm = 0;
							$currency = "";
							$created = 0;
							$modified = 0;
							$rate = 0;
							$percent = 0;
							$discount = 0;
							$discountPar = 0;
							$yenCost = 0;
							$exWorks = 0;
							$bairitsu = 0;
							$termsId = 0;

							if ($sp_disc_rate_id != 0){
								// get discount details


								//1.query
								$resultTermsAndConditions = mysql_query("SELECT * FROM `sp_disc_rate` WHERE `id` = '$sp_disc_rate_id'");
								while ($rowTermsAndCondtions = mysql_fetch_assoc($resultTermsAndConditions)){
								//2.setVariables
								 	$termsId = $rowTermsAndCondtions['id'];
								 	$year = $rowTermsAndCondtions['year'];
								 	$memo = $rowTermsAndCondtions['memo'];
									$colorId = $rowTermsAndCondtions['colorId'];
									$maker = $rowTermsAndCondtions['maker'];
									$netTerm = $rowTermsAndCondtions['netTerm'];
									$currency = $rowTermsAndCondtions['currency'];
									$created = $rowTermsAndCondtions['created'];
									$modified = $rowTermsAndCondtions['modified'];
									$rate = $rowTermsAndCondtions['rate'];
									$percent = $rowTermsAndCondtions['percent'];
									$discount = $rowTermsAndCondtions['discount'];
									$discountPar = $rowTermsAndCondtions['discountPar'];

								   $plNet = $discount * $plCurrent;

								   if ($currency == "YEN"){
									   $yenCost = $plCurrent;
								   } else {
								   $yenCost = $plNet * $rate * (1 + ($percent/100));
								   }
								   if($tformPriceNoTax != 0 && $yenCost != 0){
								   $bairitsu =  $tformPriceNoTax/$yenCost;
								   } else {
										$bairitsu = 0;
								   }
								}

							}
							if ($discount == 0){
									   $discount = 1;
							}
							$exWorks = $plCurrent*$discount;
							echo "<td>";
							//end of plcurrent QUERY
							echo $currency." ".number_format($exWorks, 2, ".", "")."</span><br>";
							echo "[".$plCurrent;
							echo "<a href='$path/p_Calculation/currentPlEdit.php?id=$plCurrentTermsId&plCurrent=".$plCurrent."&search=".$search."&tformNo=".$tfmNo."'>
							<span style='color: red;'> 改</span></a>"; 
							echo " (<span style='color: green;'>-".$discountPar."%</span>)]";
							echo "</td>";

							// end of plcurrent QUERY
							// discount QUERY
							if ($termsId != 0){
								 echo "<td>￥".$rate."/".$percent."%<br><span style='color: ".$colorId."'>".$maker." ".$year." (ID:".$termsId." - ".$memo.")</span></td>";
							} else {
								 echo "<td></td>";
							}
							echo "<td>";
							

					/* CHECK FOR HAIBAN AND SET HAIBAN COLOR */
					if (isHaibanNew($tfmNo) == true){
						echo "<span style='color: red;'> (廃番) </span>";
					} else if ($yenCost == 0 && isHaibanNew($tfmNo) == false ){
						echo "<i class='fa fa-exclamation-triangle' style='color: red'></i> ";
					}

						   // echo "￥".number_format($rowPl['yenCost'], 0, '.', ',');
							if ($yenCost != 0){
								echo "￥".number_format($yenCost,0,'.',',');
							} else {
								echo "割引条件設定必要";
							}
							echo "</td>";
							if($bairitsu != 0){
								echo "<td>".number_format($bairitsu, 2, '.','')."<br>(TFORM価格: ".number_format($tformPriceNoTax,0,'.',',').")</td>";
							} else {
								echo "<td></td>";
							}

							echo "<td>$createdPLCURRENT</td>";
							//end of plcurrent QUERY
							echo "</tr>";
						}
					}
					?>
                        </tbody>
                    </table>
                </div>
            </form>
            <div class='setTermsAndConditionsBottom'>
                <table id='bottomTable'>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>メーカー</th>
                            <th>年</th>
                            <th>メモ</th>
                            <th>レート</th>
                            <th>ペーセント</th>
                            <th>NET言語</th>
                            <th>通貨</th>
                            <th>割引条件(s1,s2,s3,s4,s5)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
    				$result = mysql_query("SELECT * FROM `sp_disc_rate`");
    				while ($row = mysql_fetch_assoc($result)){?>
                        <tr>
                            <td style='color: red; font-weight: 700;'>
                                <?php echo $row['id'];?>
                            </td>
                            <td>
                                <?php echo $row['maker'];?>
                            </td>
                            <td>
                                <?php echo $row['year'];?>
                            </td>
                            <td>
                                <?php echo $row['memo'];?>
                            </td>
                            <td>￥
                                <?php echo $row['rate'];?>
                            </td>
                            <td>
                                <?php echo $row['percent'];?>%</td>
                            <td>
                                <?php echo $row['netTerm'];?>
                            </td>
                            <td>
                                <?php echo $row['currency'];?>
                            </td>
                            <td>
                                <?php echo $row['discountPar'];?>%(
                                <?php 
                			echo $row['sp1Par'];
		           
        		            //DISPLAY PERCENTAGES IF NOT 0
        		            if ($row['sp2Par'] > 0){
        		            echo ", %".$row['sp2Par'];
        		            }
        		            if ($row['sp3Par'] > 0){
        		            echo ", %".$row['sp3Par'];
        		            }
        		            if ($row['sp4Par'] > 0){
        		            echo ", %".$row['sp4Par'];
        		            }
        		            if ($row['sp5Par'] > 0){
        		            echo ", %".$row['sp5Par'];
        		            }
                        			?>

                                )</td>

                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- PAGE CONTENTS END HERE -->
        </div>
    </div>
    <?php require_once '../master/footer.php';?>
</body>

</html>
