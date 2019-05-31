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
           
            //----------------------------------
            // SELECT ALL ITEMS
            //----------------------------------
            $('#selecctall').click(function(event) { //on click 
                if (this.checked) { // check select status
                    $('.checkbox1').each(function() { //loop through each checkbox
                        if($(this).closest("tr").is(":hidden")){
                            
                        } else {
                            this.checked = true; //select all checkboxes with class "checkbox1"
                        }
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

            //----------------------------------
            // AUTOCOMPLETE
            //----------------------------------
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
            
            //----------------------------------
            // -- added on 2018-11-28 by Howe
            // start
            //----------------------------------
           
            // Get contents of all the special conditions and show them here.
            var contents = "";

            $.ajax({
                type: "post",
                url: "exe/exeSetTermsAndConditionsNew.php",
                data: "action=GetAllTermsAndConditions",
                success: function(data){
                    
                    for(var i = 0; i < data.length; i++){
                      
                        contents += "<tr>";
                        contents += "<td style='color: red; font-weight: 700;'>";
                        contents += data[i].id;
                        contents += "</td>";
                        
                        contents += "<td>";
                        contents += data[i].maker;
                        contents += "</td>";
                        
                        contents += "<td>";
                        contents += data[i].year;
                        contents += "</td>";
                        
                        contents += "<td>";
                        contents += data[i].memo;
                        contents += "</td>";
                        
                        contents += "<td>";
                        contents += data[i].rate;
                        contents += "</td>";
                        
                        contents += "<td>";
                        contents += data[i].percent;
                        contents += "</td>";
                        
                        contents += "<td>";
                        contents += data[i].netTerm;
                        contents += "</td>";
                        
                        contents += "<td>";
                        contents += data[i].currency;
                        contents += "</td>";
                        
                        contents += "<td>";
                        contents += data[i].discountPar;
                        contents += "%(";
                        contents += data[i].sp1Par;
                        
                        //DISPLAY PERCENTAGES IF NOT 0
                        if (data[i].sp2Par > 0){
                            contents += ", %" + data[i].sp2Par;
                        }
                        if (data[i].sp3Par > 0){
                            contents += ", %" + data[i].sp3Par;
                        }
                        if (data[i].sp4Par > 0){
                            contents += ", %" + data[i].sp4Par;
                        }
                        if (data[i].sp5Par > 0){
                            contents += ", %" + data[i].sp5Par;
                        }
                        
                        contents += ")</td>";
                        contents += "</tr>";
                        
                    }
                    //----------------------------------
                    // append the data to the bottom table
                    //----------------------------------
                    $("#bottomTable tbody").html("");// clear out any old data here.
                    $("#bottomTable tbody").append(contents); // insert the new data here.
                    
                },
                error: function(e){
                    console.log(e);
                }
            });
            
            // filter contents
            function filterContents(tableName, search){
                
                var searchCurrent = search.toLowerCase();

                if(searchCurrent.length >= 3){

                    $(tableName + " tbody tr").hide();

                    $(tableName + " tr td").each(function(){
                        if($(this).text().toLowerCase().indexOf(""+searchCurrent+"") != -1){
                            $(this).closest('tr').show();
                        }
                    });

                } else {
                    // Hide all records while searchCurrent is not 0
                    if(searchCurrent.length != 0){
                        $(tableName + " tbody tr").hide();
                    } else {
                        $(tableName + " tbody tr").show();
                    }
                }
                
            }
                
            // filter top table
            $("body").on("change keyup", "#topTableFilter input", function(){
                
                var apple = $(this).val();
                filterContents("#topTable", apple);
                    
            });
            
            // filter bottom table
            $("body").on("change keyup", "#bottomFilter input", function(){
                
                var apple = $(this).val();
                filterContents("#bottomTable", apple);
                    
            });
            
            // ------------------------------
            // close
            // ------------------------------
            
            // hide the loading screen here.
            $("#loading").hide();
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
        
        #setTermsAndConditionsBottomNew {
            width: 100%;
            height: 200px;
            z-index: 999999;
            position: absolute;
            bottom: 0px;
            outline: 1px solid #CCC;
            background: #CCC;
        }
        
        #bottomFilter {
            height: 30px;
            float: right;
            margin-right: 10px;
        }
        
        #bottomFilter input {
            width: 300px;
            height: 20px;
            margin-top: 3px;
        }
        
        #setTermsAndConditionsBottomContents {
            width: 100%;
            height: 170px;
            overflow: auto;
        }
        
        #setTermsAndConditionsBottomContents table {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
        }
        
        #setTermsAndConditionsBottomContents td, th {
            border: 1px solid #8d8d8d;
        }
        
        #setTermsAndConditionsBottomContents tr:nth-child(odd) td {
            background: #FFFFFF;
        }
        
        #setTermsAndConditionsBottomContents tr:nth-child(1) th {
            background: #888;
            color: #FFF;
        }
        
        #topTableFilter {
            height: 30px;
            float: right;
            padding-right: 10px;
            width: calc(100% - 10px);
            line-height: 30px;
            background: #888;
        }
        
        #topTableFilter input {
            width: 300px;
            height: 20px;
            margin-top: 3px;
            float: right;
        }
        
        #topTableWrapper {
            position: absolute;
            top: 100px;
            left: 0px;
            right: 0px;
            bottom: 200px;
            overflow: auto;
        }
        
        #topTable {
            width: 100%;
            border-collapse: collapse;
        }
        
        #topTable th, td {
            border: 1px solid #CCC;
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
            <span class='loadingGifMain'>
                <img src='<?php echo $path;?>/img/142.gif'>
                <br>
                LOADING
            </span>
        </div>
    
        <!-- show how many are checked -->
        <div class='checkedCount' style='
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
        </div>
	
	
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
                
                <div id="topTableFilter"><input type="text"><span style="float: right; margin-right: 5px; color: #FFF;">フィルター: </span></div>
                
                <div id='topTableWrapper'>
                    <table id='topTable'>
                        <thead>
                            <tr style='background: #888; color: #FFF;'>
                                <th><i class='fa fa-check'></i></th>
                                <th>FM id</th>
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
					$result = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` LIKE '%$search%' ORDER BY `tformNo`") or die(mysql_error());
					while ($row = mysql_fetch_assoc($result)){

						$plCurrentTermsId = $row['id'];
						$tfmNo = $row['tformNo'];
                        $productId = $row['productId'];
						$checkMarkCheck = $row['plCurrent'];
						$createdPLCURRENT = $row['created'];

						//----------------------------------
// ------------------------------------------------------------------------------------------------------------------------------------
						$resultMain = mysql_query("SELECT * FROM `main` WHERE `productId` = '$productId'");
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
                         
                            $mainNotExists = "<a href='calculation.php?pr=1&id=$id'>".$tfmNo."</a><br>";
                         
                        }
// ------------------------------------------------------------------------------------------------------------------------------------
						echo "<tr>";
						echo "<td style='width: 20px;'>";
						echo "<input class='checkbox1' type='checkbox' name='$productId'>"; //commment this line if using above
						echo "</td>";
                        echo "<td>".$productId."</td>";
                        
                        echo "<td>";
						echo $mainNotExists;

						if($imgURL != ""){
							$thumRep = str_replace("img/img_phot/photo", "img/img_phot/photo_thum060", $imgURL);
							$img = "<img src ='".$filemakerImageLocation.$imgURL."' style='max-width: 45px; max-height: 45px;'>";
						} else {
							$img = "<li class='fa fa-picture-o' style='font-size: 40px; color: #CCC;'></li>";
						}
                        
						echo $img;

						echo "</td>";
						
						echo "<td>".$makerNo."</td>";
						echo "<td>".$series."</td>";
						echo "<td>".$type."</td>";
                        
						// plcurrent QUERY
						$resultPl = mysql_query("SELECT * FROM sp_plcurrent WHERE `productId` = '$productId' ")
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
            <div id='setTermsAndConditionsBottomNew'>
                <div id="bottomFilter">
                    フィルター: <input type="text">
                </div>
                <div id="setTermsAndConditionsBottomContents">
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
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <!-- PAGE CONTENTS END HERE -->
        </div>
    </div>
    <?php require_once '../master/footer.php';?>
</body>

</html>
