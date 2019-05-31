<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title;?></title>
<link rel="stylesheet"
		href="<?php echo $path;?>/css/tfProject/tfProjectInfo.css">
<?php
include_once '../master/config.php'; ?>
<script type="text/javascript">
$(document).ready( function() {
	  $(function() {
		    $( document ).tooltip();
	  });
	$('.variations').dataTable( {
		"bJQueryUI": true,
		"bPaginate": false,
		"bFilter": true,
		"bInfo": false
	});
	$('#loading').delay(300).fadeOut(300);
	$("button").click(function(e) {
		   $("select[name=search]").find("option[selected]").next()
		   .prop("selected",true);
		});
		} );
</script>
<style type="text/css">
.bLeft {
		background-color: #FFF;
		width: 25%;
		float: left;
}

.bRight {
		background-color: #FFF;
		width: 75%;
		float: left;
}

.colorChartFrame {
		width: 33.33333%;
		background-color: #FFF;
		float: left;
}

.colorChartSeat {
		width: 33.33333%;
		background-color: #FFF;
		float: left;
}

.colorChartBack {
		width: 33.33333%;
		background-color: #FFF;
		float: left;
}

h3 {
		text-align: center;
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
				//variables
				if(isset($_GET['search'])){
				    $search = $_GET['search'];
				} else {
				    $search = "ST3N-0";
				}
				$backFab = "img/defaultBlue.jpg";
                $seatFab = "img/defaultBlue.jpg";
                $frameFab = "img/defaultBlack.jpg";
                $back = "<image xlink:href='".$backFab."' x='0'y='0'width='10px'height='10px'/>";
                $seat = "<image xlink:href='".$seatFab."' x='0' y='0' width='10px' height='10px' />";
                $frame = "<image xlink:href='".$frameFab."' x='0' y='0' width='10px' height='10px' />";
                $stroke = "stroke:#000000;stroke-width:0.15;";
                $pattern ="
                	 <defs>
                        <pattern id='back' patternUnits='userSpaceOnUse' width='10' height='10'>
                            ".$back."
                        </pattern>
                        <pattern id='seat' patternUnits='userSpaceOnUse' width='10' height='10'>
                            ".$seat."
                        </pattern>
                        <pattern id='frame' patternUnits='userSpaceOnUse' width='10' height='10'>
                            ".$frame."
                        </pattern>
                    </defs>";
				// variables END

				echo "<form action='' method='GET'>";
				echo "<select name='search'>";
				//echo "<option>DEFAULT</option>";
				$selected = "";
				$resultSearch = mysql_query("SELECT * FROM `main_hussl_c_mats`");
				while ($rowSearch = mysql_fetch_assoc($resultSearch)){
				    if ($rowSearch['makerNo'] == $search){
				        $selected = "selected";
				    } else {
				        $selected = "";
				    }
				    echo "<option ".$selected.">".$rowSearch['makerNo']."</option>";
				}
				echo "</select>";
				echo "<input type='submit' class='submit' style='margin-left: 10px;'>";
				echo "<button style='margin-left: 10px; width: 50px;' class='submit'><i class='fa fa-arrow-right'></i></button>";
				echo "</form>";

				// MAIN
				$resultMain = mysql_query("SELECT * FROM `main_hussl_c` WHERE `makerNo` = '$search'");
				while ($rowMain = mysql_fetch_assoc($resultMain)){
				    $makerNo = $rowMain['makerNo'];
				    $tformNo = $rowMain['tformNo'];
				    $type = $rowMain['type'];
				    $price = $rowMain['price'];
				    $memo = $rowMain['memo'];
				    $kakakusettei = $rowMain['kakakusettei'];
				}
				//MATS
				$resultMats = mysql_query("SELECT * FROM `main_hussl_c_mats` WHERE `makerNo` = '$search'");
				while ($rowMats = mysql_fetch_assoc($resultMats)){
				    $series = $rowMats['series'];
				    $frame = $rowMats['frame'];
				    $seat = $rowMats['seat'];
				    $back = $rowMats['back'];
				    $w = $rowMats['w'];
				    $d = $rowMats['d'];
				    $h = $rowMats['h'];
				    $sh = $rowMats['sh'];
				    $stacking = $rowMats['stacking'];
				    $img = $rowMats['img'];    
				}
				//COLORS
				$frameColors = explode(",", $frame);
				$seatColors = explode(",", $seat);
				$backColors = explode(",", $back);
					
				echo "<br><hr><br>";
					
				?>

						
						<?php
						/*
						 * put the available 品番 for each modleNo and color choices?
						 */
						echo "<table class='variations'>";
						echo "<thead>";
						echo "<tr>";
						echo "<th>No.</th>";
						//echo "<th>svg</th>";
						echo "<th>img</th>";
						echo "<th>メーカー品番</th>";
						echo "<th>Tform品番</th>";
						echo "<th>タイプ</th>";
						echo "<th>スタキーング可能</th>";
						echo "<th>脚</th>";
						echo "<th>座</th>";
						echo "<th>背</th>";
						echo "<th>価格</th>";
						echo "<th>メモ</th>";
						echo "<th>価格設定用</th>";
						echo "</tr>";
						echo "</thead><tbody>";
						// MAIN
						$counter = 1;
						$resultMain = mysql_query("SELECT * FROM `main_hussl_c` WHERE `makerNo` = '$makerNo'");
						while ($rowMain = mysql_fetch_assoc($resultMain)){
						    $makerNo = $rowMain['makerNo'];
						    $tformNo = $rowMain['tformNo'];
						    $type = $rowMain['type'];
						    $price = $rowMain['price'];
						    $memo = $rowMain['memo'];
						    $kakakusettei = $rowMain['kakakusettei'];
						    $result = mysql_query("SELECT * FROM `main_hussl_c_mats` WHERE `makerNo` = '$makerNo'");
						    while ($row = mysql_fetch_assoc($result)){
						          $stacking = $row['stacking'];
						          if($stacking == 1){
						             $stack = "○";
						          } else {
						           $stack = "×";
						          }
						    }

						    
						    
                            $tformNoFab = substr($tformNo, 11, -2);
						    // FRAME品番.
						    $tformNoFrame = substr($tformNo, 7, -6);
						    $frameHinban = "";
						    $resultInner = mysql_query("SELECT * FROM `main_hussl_c_hinban` WHERE `variationId_frame` = '$tformNoFrame'");
						    while ($rowInner = mysql_fetch_assoc($resultInner)){
						        $frameHinban = $rowInner['variation_frame'];
						        $frameColorSampleArray = explode(",", $rowInner['variation_frame_sample']);
						    }
						    //-------------------------------
						    // SEAT品番.
						    $tformNoSeat = substr($tformNo, 8, -5);						    
						    
						    $seatHinban = "";
						    $resultInner = mysql_query("SELECT * FROM `main_hussl_c_hinban` WHERE `variationId_seat` = '$tformNoSeat'");
						    while ($rowInner = mysql_fetch_assoc($resultInner)){
						        $seatHinbanId = $rowInner['variationId_seat'];
						        $seatHinban = $rowInner['variation_seat'];
						    }
						    //-------------------------------
						    // BACK品番.
						    $tformNoBack = substr($tformNo, 9, -4);
						    $backHinban = "";
						    $resultInner = mysql_query("SELECT * FROM `main_hussl_c_hinban` WHERE `variationId_back` = '$tformNoBack'");
						    while ($rowInner = mysql_fetch_assoc($resultInner)){
						        $backHinbanId = $rowInner['variationId_back'];
						        $backHinban = $rowInner['variation_back'];
						    }
						    //-------------------------------
						    echo "<tr>";
						    echo "<td>".$counter."</td>";
						    //echo "<td style='max-width: 50px;'>";
						    //include("svg/".$makerNo.".svg");
						    //echo "</td>";
						    echo "<td><img src='img/model/".$img."' style='width: 60px;'></td>";
						    echo "<td>".$makerNo."</td>";
						    echo "<td>".$tformNo."</td>";
						    echo "<td>".$type."</td>";
						    echo "<td>".$stack."</td>";
						    echo "<td>".$frameHinban;
						    echo "<br>";
						    foreach($frameColorSampleArray as $value => $key){
						        echo "<img src='img/colorSample/".$key."' style='width: 20px;' title='".$key."'> ";
						        //echo"<br>";
						    }
						    echo "</td>";
						    echo "<td style='text-align: left;'>";
						    echo $seatHinban;
						    if ($seatHinbanId == '0'){
						        echo "<br>";
						        foreach($frameColorSampleArray as $value => $key){
						            echo "<img src='img/colorSample/".$key."' style='width: 20px;'> ";
						            //echo"<br>";
						        }
						    }
						    //check if different
						    if ($seatHinbanId == '1' OR $seatHinbanId == '2'){
						            echo "<br>";
    						        if ($tformNoFab == 'A'){
    						        //CAT A
    						        echo "cat.A ";
    						        $resultColors1 = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` LIKE '%A%'");
    						        while ($rowColors1 = mysql_fetch_assoc($resultColors1)){
    						            echo "<img src='img/colorSample/".$rowColors1['colorSample']."' style='width: 20px;' title='".$rowColors1['variation']."'>";
    						            //echo $rowColors['variation']."<br>";
    						        }
						        } else if ($tformNoFab == 'B'){
    						        echo "<br>";
    						        //CAT B
    						        echo "cat.B ";
    						        $resultColors2 = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` LIKE '%B%'");
    						        while ($rowColors2 = mysql_fetch_assoc($resultColors2)){
    						            echo "<img src='img/colorSample/".$rowColors2['colorSample']."' style='width: 20px;' title='".$rowColors2['variation']."'>";
    						            //echo $rowColors['variation']."<br>";
    						        }
						        } else if($tformNoFab == 'L') {
						        echo "<br>";
						        //LEATHER
						        echo "革張り ";
						        $resultColors3 = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` LIKE '%L%'");
						        while ($rowColors3 = mysql_fetch_assoc($resultColors3)){
						            echo "<img src='img/colorSample/".$rowColors3['colorSample']."' style='width: 20px;' title='".$rowColors3['variation']."'>";
						            //echo $rowColors['variation']."<br>";
						        }
						        }
						    }
						    if ($seatHinbanId == '3'){
						    echo "<br>";
						        //COLOR PLYWOOD
						        $resultColors1 = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` LIKE '%C%'");
						        while ($rowColors1 = mysql_fetch_assoc($resultColors1)){
						            echo "<img src='img/colorSample/".$rowColors1['colorSample']."' style='width: 20px;' title='".$rowColors1['variation']."'>";
						            //echo $rowColors['variation']."<br>";
						        }
						    }
						    echo "</td>";
						    echo "<td style='text-align: left;'>"; 
				//BACK STARTS HERE
				
						    echo $backHinban;
						    if ($backHinbanId == '0' OR $backHinbanId == '2' OR $backHinbanId == '3' OR $backHinbanId == 'X'){
						        echo "<br>";
						        foreach($frameColorSampleArray as $value => $key){
						            echo "<img src='img/colorSample/".$key."' style='width: 20px;'> ";
						            //echo"<br>";
						            
						        }
						    }
						    //check if different
						    if ($backHinbanId == 'F' OR $backHinbanId == 'R'){
						        echo "<br>";
						        if ($tformNoFab == 'A'){
    						        //CAT A
    						        echo "cat.A ";
    						        $resultColors1 = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` LIKE '%A%'");
    						        while ($rowColors1 = mysql_fetch_assoc($resultColors1)){
    						            echo "<img src='img/colorSample/".$rowColors1['colorSample']."' style='width: 20px;' title='".$rowColors1['variation']."'>";
    						            //echo $rowColors['variation']."<br>";
    						        } 
						        } else if($tformNoFab == 'B'){
    						        echo "<br>";
    						        //CAT B
    						        echo "cat.B ";
    						        $resultColors2 = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` LIKE '%B%'");
    						        while ($rowColors2 = mysql_fetch_assoc($resultColors2)){
    						            echo "<img src='img/colorSample/".$rowColors2['colorSample']."' style='width: 20px;' title='".$rowColors2['variation']."'>";
    						            //echo $rowColors['variation']."<br>";
    						        }
						        } else if ($tformNoFab == 'L'){
    						        echo "<br>";
    						        //LEATHER
    						        echo "革張り ";
    						        $resultColors3 = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` LIKE '%L%'");
    						        while ($rowColors3 = mysql_fetch_assoc($resultColors3)){
    						            echo "<img src='img/colorSample/".$rowColors3['colorSample']."' style='width: 20px;' title='".$rowColors3['variation']."'>";
    						            //echo $rowColors['variation']."<br>";
    						        }
						        }
						    }
						   
						    if ($backHinbanId == '1'){
						    echo "<br>";
						        //COLOR PLYWOOD
						        $resultColors1 = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` LIKE '%C%'");
						        while ($rowColors1 = mysql_fetch_assoc($resultColors1)){
						            echo "<img src='img/colorSample/".$rowColors1['colorSample']."' style='width: 20px;' title='".$rowColors1['variation']."'>";
						            //echo $rowColors['variation']."<br>";
						        }
						    }
						    
						    echo "</td>";
						    echo "<td>￥".number_format($price, 0, '',',')."</td>";
						    echo "<td>".$memo."</td>";
						    echo "<td>".$kakakusettei."</td>";

						    echo "</tr>";
						    $counter++;
						}
						echo "</tbody>";
						echo "</table>";


						?>
						
						<div class='bLeft'>
								<h3>
								<?php echo $makerNo;?>
								</h3>
								<img src='img/model/<?php echo $img;?>'
										style='width: 50%; margin-left: 25%;'>
						</div>
						<div class='bRight' style=''>
								<div class='colorChart'>
										<div class='colorChartFrame'>
												<h3>脚</h3>
												<?php
												//FRAMECOLORS
												foreach($frameColors as $value => $key){
												    //echo $key."<br>";
												    $resultColors = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` = '$key'");
												    while ($rowColors = mysql_fetch_assoc($resultColors)){
												        echo "<img src='img/colorSample/".$rowColors['colorSample']."' style='width: 20px;'>";
												        echo $rowColors['variation']."<br>";
												    }
												}

												?>
										</div>
										<div class='colorChartSeat'>
												<h3>座</h3>
												<?php
												//FRAMECOLORS
												foreach($seatColors as $value => $key){
												    //echo $key."<br>";
												    $resultColors = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` = '$key'");
												    while ($rowColors = mysql_fetch_assoc($resultColors)){
												        echo "<img src='img/colorSample/".$rowColors['colorSample']."' style='width: 20px;'>";
												        echo $rowColors['variation']."<br>";
												    }
												}
												?>
										</div>
										<div class='colorChartBack'>
												<h3>背</h3>
												<?php
												//FRAMECOLORS
												foreach($backColors as $value => $key){
												    //echo $key."<br>";
												    $resultColors = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` = '$key'");
												    while ($rowColors = mysql_fetch_assoc($resultColors)){
												        echo "<img src='img/colorSample/".$rowColors['colorSample']."' style='width: 20px;'>";
												        echo $rowColors['variation']."<br>";
												    }
												}
												?>
										</div>
								</div>

						</div>
						<div class='clear'></div>
						<!-- PAGE CONTENTS END HERE -->
				</div>
		</div>
		<?php require_once '../master/footer.php';?>
</body>
</html>
