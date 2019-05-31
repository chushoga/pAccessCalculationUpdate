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
		} );
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
				    $search = "TC4";
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
				echo "<option>DEFAULT</option>";
				$selected = "";
				$resultSearch = mysql_query("SELECT DISTINCT `makerNo` FROM `main_hussl_t`");
				while ($rowSearch = mysql_fetch_assoc($resultSearch)){
				    if ($rowSearch['makerNo'] == $search){
				        $selected = "selected";
				    } else {
				        $selected = "";
				    }
				    echo "<option ".$selected.">".$rowSearch['makerNo']."</option>";
				}
				echo "</select>";
				echo "<input type='submit' class='submit'>";
				echo "</form>";

				// MAIN
				/*
				$resultMain = mysql_query("SELECT * FROM `main_hussl_t` WHERE `makerNo` = '$search'");
				while ($rowMain = mysql_fetch_assoc($resultMain)){
				    $makerNo = $rowMain['makerNo'];
				    $tformNo = $rowMain['tformNo'];
				    $l = $rowMain['l'];
				    $w = $rowMain['w'];
				    $h = $rowMain['h'];
				    $price = $rowMain['price'];
				}
*/
									
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
						echo "<th>長</th>";
						echo "<th>幅</th>";
						echo "<th>高</th>";
						echo "<th>色</th>";
						echo "<th>価格</th>";
						echo "</tr>";
						echo "</thead><tbody>";
						// MAIN
						$counter = 1;
						$resultMain = mysql_query("SELECT * FROM `main_hussl_t` WHERE `makerNo` = '$search'");
                		while ($rowMain = mysql_fetch_assoc($resultMain)){
                		    $makerNo = $rowMain['makerNo'];
                		    $tformNo = $rowMain['tformNo'];
                		    $l = $rowMain['l'];
                		    $w = $rowMain['w'];
                		    $h = $rowMain['h'];
                		    $price = $rowMain['price'];
                		    $img = ""; //set default img
                		    
                		    $tformNoImg = substr($tformNo, 3, -9);
                		    $tformNoCol = substr($tformNo, 11, -2);
                		    $tformNoCol2 = substr($tformNo, -2);
                		    
                		    //matsImg
                		    $resultMatsImg = mysql_query("SELECT * FROM `main_hussl_t_mats` WHERE `imgId` = '$tformNoImg'");
                		    while ($rowMatsImg = mysql_fetch_assoc($resultMatsImg)){
                		        $img = $rowMatsImg['img'];
                		    }
     
						    echo "<tr>";
						    echo "<td>".$counter."</td>";
						    //echo "<td style='max-width: 50px;'>";
						    //include("svg/".$makerNo.".svg");
						    //echo "</td>";
						    echo "<td><img src='img/model/".$img."' style='width: 60px;'></td>";
						    echo "<td>".$makerNo."</td>";
						    echo "<td>".$tformNo."</td>";
						    echo "<td>".$l."</td>";
						    echo "<td>".$w."</td>";
						    echo "<td>".$h."</td>";
						    echo "<td>";
                		    //matsColors
                		    
						    if ($tformNoCol == '7' || $tformNoCol == '8'){
						        $resultMatsCol = mysql_query("SELECT * FROM `main_hussl_t_mats` WHERE `matImgId` = '$tformNoCol'");
                    		    while ($rowMatsCol = mysql_fetch_assoc($resultMatsCol)){
                    		        $matMemo = $rowMatsCol['matMemo']; 
                    		        echo "<img src='img/colorSample/".$rowMatsCol['matImg']."' style='width: 20px;' title='".$rowMatsCol['matMemo']."'>";
                    		       
                    		    }   
						    
						    } else {
                    		    $resultMatsCol = mysql_query("SELECT * FROM `main_hussl_t_mats` WHERE `matImgId` = '$tformNoCol'");
                    		    while ($rowMatsCol = mysql_fetch_assoc($resultMatsCol)){
                    		        $matMemo = $rowMatsCol['matMemo']; 
                    		        echo "<img src='img/colorSample/".$rowMatsCol['matImg']."' style='width: 20px;' title='".$rowMatsCol['matMemo']."'>";
                    		       // echo "[".$tformNoCol."]";
                    		    } 
						    }
                		    
                		    echo "<br>";
                		    //matsColors2
                		    $resultMatsCol2 = mysql_query("SELECT * FROM `main_hussl_t_mats` WHERE `tTopId` = '$tformNoCol2'");
                		    while ($rowMatsCol2 = mysql_fetch_assoc($resultMatsCol2)){
                		        $tTop = $rowMatsCol2['tTop'];
                		       
                		        $resultMatsCol3 = mysql_query("SELECT * FROM `main_hussl_t_mats` WHERE `tTop` = '$tTop'");
                		    while ($rowMatsCol3 = mysql_fetch_assoc($resultMatsCol3)){
                		        if ($rowMatsCol3['tTopImg'] != ''){
                		       echo "<img src='img/colorSample/".$rowMatsCol3['tTopImg']."' style='width: 20px;' title='".$rowMatsCol3['tTopMemo']."'>";
                		        }
                		    }
                		    
                		        
                		    }
						    echo "</td>";
						    echo "<td>￥".number_format($price, 0, '',',')."</td>";
						   
						    echo "</tr>";
						    $counter++;
						}
						echo "</tbody>";
						echo "</table>";

						?>
						<!-- START OF SIM -->
						<?php
						/*
						 * TEST OUTPUT FOR 表
						 */
						
						// MAIN
						$countOld = "08";
						
						for ($i = 9; $i < 35; $i++){
    						    switch ($i){
    						        case '8': 
    						            $countLast = 08;
    						            break;
    						        case '9':
    						            $countLast = 09;
    						            break;
    						        default:
    						            $countLast = $i;
    						    }
    						    $searchCount = "08".$countLast;
    						   
    						   // echo $searchCount." | <br>";
    						$resultMain = mysql_query("SELECT * FROM `main_hussl_t` WHERE `makerNo` = '$search' && `tformNo` LIKE '%$searchCount%'");
                    		while ($rowMain = mysql_fetch_assoc($resultMain)){
                    		    $makerNo = $rowMain['makerNo'];
                    		    $tformNo = $rowMain['tformNo'];
                    		    
                    		    $price = $rowMain['price'];                		    
                    		    $tformNoCol = substr($tformNo, 6, -4);
                    		    $tformNoWidth = substr($tformNoCol, 0, -2);
                    		    $tformNoLength = substr($tformNoCol, -2);
    
                    		 if ($countOld != $countLast){
                    		      echo "<br>";
                    		  }
                    		  echo "<a href='' title='".$tformNo."'>".number_format($price,0,'',',')."</a> | ";
                    		 
                    		 $countOld = $countLast;
    						}
						}
		echo "<br><br><hr><br>";				
/*
 *  W90
 */
						$countOld = "08";
						
						for ($i = 9; $i < 35; $i++){
    						    switch ($i){
    						        case '8': 
    						            $countLast = 08;
    						            break;
    						        case '9':
    						            $countLast = 09;
    						            break;
    						        default:
    						            $countLast = $i;
    						    }
    						    $searchCount = "09".$countLast;
    						   
    						   // echo $searchCount." | <br>";
    						$resultMain = mysql_query("SELECT * FROM `main_hussl_t` WHERE `makerNo` = '$search' && `tformNo` LIKE '%$searchCount%'");
                    		while ($rowMain = mysql_fetch_assoc($resultMain)){
                    		    $makerNo = $rowMain['makerNo'];
                    		    $tformNo = $rowMain['tformNo'];
                    		    
                    		    $price = $rowMain['price'];                		    
                    		    $tformNoCol = substr($tformNo, 6, -4);
                    		    $tformNoWidth = substr($tformNoCol, 0, -2);
                    		    $tformNoLength = substr($tformNoCol, -2);
    
                    		 if ($countOld != $countLast){
                    		      echo "<br>";
                    		  }
                    		  echo "<a href='' title='".$tformNo."'>".number_format($price,0,'',',')."</a> | ";
                    		 
                    		 $countOld = $countLast;
    						}
						}
			echo "<br><br><hr><br>";				
/*
 *  W100
 */
						$countOld = "08";
						
						for ($i = 10; $i < 35; $i++){
    						    switch ($i){
    						        case '8': 
    						            $countLast = 08;
    						            break;
    						        case '9':
    						            $countLast = 09;
    						            break;
    						        default:
    						            $countLast = $i;
    						    }
    						    $searchCount = "10".$countLast;
    						   
    						   // echo $searchCount." | <br>";
    						$resultMain = mysql_query("SELECT * FROM `main_hussl_t` WHERE `makerNo` = '$search' && `tformNo` LIKE '%$searchCount%'");
                    		while ($rowMain = mysql_fetch_assoc($resultMain)){
                    		    $makerNo = $rowMain['makerNo'];
                    		    $tformNo = $rowMain['tformNo'];
                    		    
                    		    $price = $rowMain['price'];                		    
                    		    $tformNoCol = substr($tformNo, 6, -4);
                    		    $tformNoWidth = substr($tformNoCol, 0, -2);
                    		    $tformNoLength = substr($tformNoCol, -2);
    
                    		 if ($countOld != $countLast){
                    		      echo "<br>";
                    		  }
                    		  echo "<a href='' title='".$tformNo."'>".number_format($price,0,'',',')."</a> | ";
                    		 
                    		 $countOld = $countLast;
    						}
						}
									echo "<br><br><hr><br>";				
/*
 *  W11
 */
						$countOld = "08";
						
						for ($i = 9; $i < 35; $i++){
    						    switch ($i){
    						        case '8': 
    						            $countLast = 08;
    						            break;
    						        case '9':
    						            $countLast = 09;
    						            break;
    						        default:
    						            $countLast = $i;
    						    }
    						    $searchCount = "11".$countLast;
    						   
    						   // echo $searchCount." | <br>";
    						$resultMain = mysql_query("SELECT * FROM `main_hussl_t` WHERE `makerNo` = '$search' && `tformNo` LIKE '%$searchCount%'");
                    		while ($rowMain = mysql_fetch_assoc($resultMain)){
                    		    $makerNo = $rowMain['makerNo'];
                    		    $tformNo = $rowMain['tformNo'];
                    		    
                    		    $price = $rowMain['price'];                		    
                    		    $tformNoCol = substr($tformNo, 6, -4);
                    		    $tformNoWidth = substr($tformNoCol, 0, -2);
                    		    $tformNoLength = substr($tformNoCol, -2);
    
                    		 if ($countOld != $countLast){
                    		      echo "<br>";
                    		  }
                    		  echo "<a href='' title='".$tformNo."'>".number_format($price,0,'',',')."</a> | ";
                    		 
                    		 $countOld = $countLast;
    						}
						}
									echo "<br><br><hr><br>";				
/*
 *  W12
 */
						$countOld = "08";
						
    						    $searchCount = "1212";
    						   
    						   // echo $searchCount." | <br>";
    						$resultMain = mysql_query("SELECT * FROM `main_hussl_t` WHERE `makerNo` = '$search' && `tformNo` LIKE '%$searchCount%'");
                    		while ($rowMain = mysql_fetch_assoc($resultMain)){
                    		    $makerNo = $rowMain['makerNo'];
                    		    $tformNo = $rowMain['tformNo'];
                    		    
                    		    $price = $rowMain['price'];                		    
                    		    $tformNoCol = substr($tformNo, 6, -4);
                    		    $tformNoWidth = substr($tformNoCol, 0, -2);
                    		    $tformNoLength = substr($tformNoCol, -2);
    
                    		 if ($countOld != $countLast){
                    		      echo "<br>";
                    		  }
                    		  echo "<a href='' title='".$tformNo."'>".number_format($price,0,'',',')."</a> | ";
                    		 
                    		 $countOld = $countLast;
    						}
						
									echo "<br><br><hr><br>";				
		?>
						
						
						<!-- PAGE CONTENTS END HERE -->
				</div>
		</div>
		<?php require_once '../master/footer.php';?>
</body>
</html>
