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
</script>
<style type="text/css">



@page {
    size: 21cm 29.7cm;
    margin: 5mm 5mm 5mm 5mm; /* change the margins as you want them to be. */
    
}

@media all {
	.page-break	{ 
		display: none; 
	}
}

@media print {
	
	table {float: none !important; position: relative !important; display: block !important; }
  	div { float: none !important; position: relative !important; display: block !important;}
    .page-break { display: block !important; page-break-inside: avoid; page-break-after: always; position: relative; float: none !important;}

    table{
    	transform: scale(0.9);
    	transform-origin: top left;
    	
    }
    .tableWrapper {
    	margin-top: -20px;
    }
}


</style>
</head>
<body>
    		<?php 
    		//variables
    		// make sure $page always = something
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
    		    $setQuery = "SELECT * FROM `tfProject` WHERE `id` = '$recordId'";
    		} else {
    		    $setQuery = "SELECT * FROM `tfProject` WHERE `id` LIKE '%$search%' OR `projectName` LIKE '%$search%' OR `date` LIKE '%$search%'";
    		}
    		    
    		
    		
    		//get total amount of results.
    		$iAmount = 0;
    		$resultAmount = mysql_query("$setQuery");
    		$searchEmptyCheck2 = mysql_num_rows($resultAmount);
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
						     if ($row['date'] == ""){
        			        $saveFileDate = 1;
            			    } else {
            			        $savFileDate = $row['date'];
            			    }
            			    if ($row['projectName'] == ""){
            			        $saveFileProjectName = "tformProject";
            			    } else {
            			        $saveFileProjectName = $row['projectName'];
            			    }
            		        $saveFileName = $saveFileProjectName."_".$savFileDate;
						}
			 
		    //----------------------------------
    		?>
	<div id='wrapper'>
	
    	<?php require_once '../header.php';?>
    	<!-- PAGE CONTENTS START HERE -->
    	<div id='statusBar'>
    		<?php if ($record <= 0){?>
        		<button class='recordCycleBtnDisabled' style='cursor: default;'>◀ </button>
        		
    		<?php }
        	else{ ?>
        		<button class='recordCycleBtn' onClick="location.href='tfProject.php?pr=2&record=<?php echo $previous;?>&search=<?php echo $search;?>'">◀ </button>
        		
        	<?php }
        	 if($iRecord == $iAmount || $searchEmptyCheck2  == 0){ 
    		    
    		?>
        		<button class='recordCycleBtnDisabled' style='cursor: default;'>▶ </button>
        		
    		<?php }
    		else { ?>
    		    <button class='recordCycleBtn' onClick="location.href='tfProject.php?pr=2&record=<?php echo $next;?>&search=<?php echo $search;?>'">▶ </button>
    		    
    		
    		<?php }	?>
        		<?php echo $iRecord." of ".$iAmount;
        		echo " (search: ".$search.")<br>";
        	?>
    		</div>
    	<div class='tfProjectContents'>
    		
    		
						<?php
						

						// PART TO GET THE AMOUNT OF TIMES TO SHOW DATA BLOCKS------------
						$count = 0;
						$paraCount = 0;
						$result = mysql_query("$setQuery ORDER BY ID ASC LIMIT $record, 1");
						$searchEmptyCheck = mysql_num_rows($result);
						while ($row = mysql_fetch_assoc($result)){
						    
						    $id = $row['id']; //set id from the query(changes depending on the record number in the $_GET...
						   
						    for ($i = 1; $i <= 20; $i++){
						        if (
						        $row['archNo_'.$i] == '' &&
						        $row['type_'.$i] == '' &&
						        $row['itemCount_'.$i] == '' &&
						        $row['maker_'.$i] == '' &&
						        $row['series_'.$i] == '' &&
						        $row['tformNo_'.$i] == '' &&
						        $row['makerNo_'.$i] == '' &&
						        $row['finish_'.$i] == '' &&
						        $row['currency_'.$i] == '' &&
						        $row['priceList_'.$i] == 0 &&
						        $row['generalDisc_'.$i] == 0 &&
						        $row['projectDisc_'.$i] == 0 &&
						        $row['rate_'.$i] == 0 &&
						        $row['percent_'.$i] == 0 &&
						        $row['memo_'.$i] == '' &&
						        $row['mitsumori_'.$i] == 0 &&
						        $row['retailPrice_'.$i] == 0
						        ){
						            //echo $i."NULL";
						        } else {
						            //echo $i."TRUE";
						            $count++;
						            
						        }
						    }
						}
						// END OF COUNT BLOCK ------------------------------------------
						
						//CHECK HERE IF NO FILES FOUND THEN DONT SHOW....
						if ($searchEmptyCheck != 0){
						
						?>
								<div class='tableWrapper'>
										<div id='saveWrapper'>
										<table class="tg" style="table-layout: fixed; width: 1254px">
												<colgroup>
														<col style="width: 119px">
														<col style="width: 90px">
														<col style="width: 116px">
														<col style="width: 85px">
														<col style="width: 80px">
														<col style="width: 82px">
														<col style="width: 80px">
														<col style="width: 122px">
														<col style="width: 122px">
														<col style="width: 119px">
														<col style="width: 85px">
														<col style="width: 154px">
												</colgroup>
												<?php
												$result = mysql_query("SELECT * FROM tfProject WHERE `id` = '$id'");
												while ($row = mysql_fetch_assoc($result)){

												    echo "<tr>
												    <th class='tg-s6z3'  style='background-color: #CCC;'>id</th>
												    <th class='tg-s6z3' colspan='2'  style='background-color: #CCC;'>プロジェクト名</th>
												    <th class='tg-s6z3' colspan='3'  style='background-color: #CCC;'>現場住所</th>
												    <th class='tg-s6z3'  style='background-color: #CCC;'>date</th>
												    <th class='tg-031e' colspan='5' rowspan='2'
																style='border: none;'></th>
																</tr>
																<tr>
																<td class='tg-s6z2'>
																".$row['id']."
																</td>
																<td class='tg-s6z2' colspan='2'>".$row['projectName']."</td>
																<td class='tg-s6z2' colspan='3'>".$row['place']."</td>
																<td class='tg-s6z2'>".$row['date']."</td>
																</tr>";
												}
												?>
										</table>

										<br>
										<!-- START OF LOOP -->

										<?php
										// SET THE ADDING TOTAL VARIABLES BEFORE ADDING
										$totalGenka = 0;
										$totalSales = 0;
										//----------------------------------------------
										for ($i = 1; $i <= $count; $i++){
										    $result = mysql_query("SELECT * FROM tfProject WHERE `id` = '$id'");
										    while ($row = mysql_fetch_assoc($result)){

										        echo "
										        
										<table class='tg' style='table-layout: fixed; width: 1254px;'>
												<colgroup>
														<col style='width: 119px'>
														<col style='width: 90px'>
														<col style='width: 116px'>
														<col style='width: 85px'>
														<col style='width: 80px'>
														<col style='width: 82px'>
														<col style='width: 80px'>
														<col style='width: 122px'>
														<col style='width: 122px'>
														<col style='width: 119px'>
														<col style='width: 85px'>
														<col style='width: 154px'>
												</colgroup>


												<tr>
														<td class='tg-s6z3' style='background-color: #EEE; '>図面番号</td>
														<td class='tg-s6z3' colspan='2' style='background-color: #EEE; '>商品</td>
														<td class='tg-s6z3' colspan='4' style='background-color: #EEE; '>数量</td>
														<td class='tg-031e' colspan='5' rowspan='2'
																style='border: none;'></td>
												</tr>
												<tr>
														<td class='tg-s6z2' >".$row['archNo_'.$i]."</td>
														<td class='tg-s6z2' colspan='2'>".$row['type_'.$i]."</td>
														<td class='tg-s6z2' colspan='4'>".$row['itemCount_'.$i]."</td>
												</tr>



												<tr>
														<td class='tg-s6z2' rowspan='4'>";
										        if ($row['image_'.$i] == ''){
										            echo "<form id='form_$i' action='exe/exeImgUpload.php' enctype='multipart/form-data' method='POST'>
														
														<input type='hidden' name='id' value='$id'>
														<input type='hidden' name='imgId' value='image_$i'>
														<div class='inputWrapper' style='height: 100px; width: 100px; margin: auto; text-align: center; line-height: 100px;'>
														<input class='fileInput hidden' type='file' name='file' id='file_$i' > 
														</div>
														</form>";
										        } else {
										            
										             echo "<form id='form_$i' action='exe/exeImgUpload.php' enctype='multipart/form-data' method='POST'>
														
														<input type='hidden' name='id' value='$id'>
														<input type='hidden' name='imgId' value='image_$i'>
														<div class='inputWrapper' style='height: auto; width: auto; margin: auto; text-align: center;'>
														 <img src='../".$row['image_'.$i]."' style='max-width: 115px; max-height: 137px;'>
														<input class='fileInput hidden' type='file' name='file' id='file_$i' > 
														</div>
														</form>";
										        }

										        echo "
														</td>
														<td class='tg-s6z3' style='background-color: #CCC;'>メーカー</td>
														<td class='tg-s6z3'  style='background-color: #CCC;'>シリーズ</td>
														<td class='tg-s6z3' colspan='2'  style='background-color: #CCC;'>tformNo</td>
														<td class='tg-s6z3' colspan='2'  style='background-color: #CCC;'>モデルNO.</td>
														<td class='tg-s6z3' colspan='5'  style='background-color: #CCC;'>仕様</td>

												</tr>
												<tr>
														<td class='tg-s6z2'>".$row['maker_'.$i]."</td>
														<td class='tg-s6z2'>".$row['series_'.$i]."</td>
														<td class='tg-s6z2' colspan='2'>".$row['tformNo_'.$i]."</td>
														<td class='tg-s6z2' colspan='2'>".$row['makerNo_'.$i]."</td>
														<td class='tg-s6z2' colspan='5'>".$row['finish_'.$i]."</td>
												</tr>

												<tr>
														<td class='tg-s6z3'  style='background-color: #CCC;'>通貨</td>
														<td class='tg-s6z3'  style='background-color: #CCC;'>PL価格</td>
														<td class='tg-s6z3'  style='background-color: #CCC;'>通常値引</td>
														<td class='tg-s6z3'  style='background-color: #CCC;'>プロジェクト値引</td>
														<td class='tg-s6z3'  style='background-color: #CCC;'>NET Price</td>
														<td class='tg-s6z3'  style='background-color: #CCC;'>rate</td>
														<td class='tg-s6z3'  style='background-color: #CCC;'>経費</td>
														<td class='tg-s6z3'  style='background-color: #CCC;'>仕入原価</td>
														<td class='tg-s6z3'  style='background-color: #CCC;'>仕入合計</td>
														<td class='tg-s6z3' colspan='2'  style='background-color: #CCC;'>memo</td>

												</tr>
												<tr>
														<td class='tg-s6z2'>".$row['currency_'.$i]."</td>
														<td class='tg-s6z2'>".number_format($row['priceList_'.$i], 2, '.',',')."</td>
														<td class='tg-s6z2'>".$row['generalDisc_'.$i]."</td>
														<td class='tg-s6z2'>".$row['projectDisc_'.$i]."</td>
														<td class='tg-s6z2'>".number_format($row['priceList_'.$i]*(1-($row['generalDisc_'.$i]/100))*(1-($row['projectDisc_'.$i]/100)), 2, '.',',')."</td>
														<td class='tg-s6z2'>".$row['rate_'.$i]."</td>
														<td class='tg-s6z2'>".$row['percent_'.$i]."</td>
														<td class='tg-s6z2'>￥".number_format($row['priceList_'.$i]*(1-($row['generalDisc_'.$i]/100))*(1-($row['projectDisc_'.$i]/100))*$row['rate_'.$i]*(1+($row['percent_'.$i]/100)), 0, '.',',')."</td>
														<td class='tg-s6z2'>￥".number_format($row['itemCount_'.$i]*intval($row['priceList_'.$i]*(1-($row['generalDisc_'.$i]/100))*(1-($row['projectDisc_'.$i]/100))*$row['rate_'.$i]*(1+($row['percent_'.$i]/100))), 0, '.',',')."</td>
														<td class='tg-031e' colspan='2'>".$row['memo_'.$i]."</td>
												</tr>
												<tr>
														<td class='tg-031e' colspan='7' rowspan='2'></td>
														<td class='tg-s6z3'>倍率</td>
														<td class='tg-s6z3'>見積単価</td>
														<td class='tg-s6z3'>販売価格（税別）</td>
														<td class='tg-s6z3'>掛率</td>
														<td class='tg-s6z3'>上代 (倍率)</td>
												</tr>
												<tr>";
										        if ($row['rate_'.$i] == 0 || $row['percent_'.$i] == 0){
										            echo "<td class='tg-s6z2'>0</td>";
										        } else {
										        echo "<td class='tg-s6z2'>".number_format($row['mitsumori_'.$i]/intval($row['priceList_'.$i]*(1-($row['generalDisc_'.$i]/100))*(1-($row['projectDisc_'.$i]/100))*$row['rate_'.$i]*(1+($row['percent_'.$i]/100))), 2, '.','')."<br></td>";
										        }
										        echo "<td class='tg-s6z2'>￥".number_format($row['mitsumori_'.$i], 0, '.',',')."</td>
														<td class='tg-s6z2'>￥".number_format($row['mitsumori_'.$i]*$row['itemCount_'.$i], 0, '.',',')."</td>";
										        //prevent division by 0
										        if($row['mitsumori_'.$i] == 0 || $row['retailPrice_'.$i] == 0){
										            echo "<td class='tg-s6z2'>0</td>";
										        } else {
										            echo "<td class='tg-s6z2'>".number_format($row['mitsumori_'.$i]/$row['retailPrice_'.$i], 2, '.','')."</td>";

										        }
										        
										        //BAIRITSU
										        $shiire = $row['priceList_'.$i]*(1-($row['generalDisc_'.$i]/100))*(1-($row['projectDisc_'.$i]/100))*$row['rate_'.$i]*(1+($row['percent_'.$i]/100));
										        $retailPrice = intval($row['retailPrice_'.$i]);
												
										        if($retailPrice == 0 || $shiire == 0){
										        	$baiRitsu = 0;
										        } else {
										       		$baiRitsu =  $retailPrice / $shiire;
										        }


										        echo "<td class='tg-s6z2'>￥".number_format(intval($row['retailPrice_'.$i]), 0, '.',',')."
														(".number_format($baiRitsu,2,'.','').")
														</td>
												</tr>
												</table>
												<br>
												";
										        $totalGenka += $row['itemCount_'.$i]*intval($row['priceList_'.$i]*(1-($row['generalDisc_'.$i]/100))*(1-($row['projectDisc_'.$i]/100))*$row['rate_'.$i]*(1+($row['percent_'.$i]/100)));
										        $totalSales += $row['mitsumori_'.$i]*$row['itemCount_'.$i];
										        echo "<script>
                                                		document.getElementById('file_$i').onchange = function() {
                                                		    document.getElementById('form_$i').submit();
                                                		}
                                                </script>";
										         
										        // check the count and break if not the last one	
										        $paraCount++;
										        if($paraCount == 5 && $i != $count){
										        //echo "<DIV style='page-break-before:always'></DIV>";
									            echo "<!--////////////////////// BREAK HERE BREAK HERE ////////////////// -->";
												echo "<div class='page-break'></div>";
												echo "<!--////////////////////// BREAK HERE BREAK HERE ////////////////// -->";
										           $paraCount = 0;
										        }
										        

										    }
										}
										?>

										<!-- END OF LOOP -->
										<br>
										<table class="tg" style="table-layout: fixed; width: 1254px">
												<colgroup>
														<col style="width: 119px">
														<col style="width: 90px">
														<col style="width: 116px">
														<col style="width: 85px">
														<col style="width: 80px">
														<col style="width: 82px">
														<col style="width: 80px">
														<col style="width: 122px">
														<col style="width: 122px">
														<col style="width: 119px">
														<col style="width: 85px">
														<col style="width: 154px">
												</colgroup>

												<tr>
														<td class="tg-031e" colspan="8" rowspan="2"
																style='border: none;'></td>
														<td class="tg-s6z4">仕入合計</td>
														<td class="tg-s6z4">販売合計</td>
														<td class="tg-s6z4" colspan="2"
																style='background-color: Gold;'>粗利</td>
												</tr>
												<tr>
														<td class="tg-s6z2">￥<?php echo number_format($totalGenka, 0, '.',',');?>

														</td>
														<td class="tg-s6z2">￥<?php echo number_format($totalSales, 0, '.',',');?>
														</td>
														<td class="tg-s6z2"><?php 
														if (($totalSales-$totalGenka) == 0 || $totalSales == 0){
														    echo " - ";
														} else {
														    echo number_format((($totalSales-$totalGenka)/$totalSales)*100, 2, '.',',')."%";
														}

														//echo number_format((($totalSales-$totalGenka)/$totalSales)*100, 2, '.',',')."%";


														?>
														</td>
														<td class="tg-s6z2"><?php echo "￥".number_format(intval($totalSales-$totalGenka), 0, '.',',');?>
														</td>
												</tr>
										</table>
										</div> <!-- saveWrapper END -->
										<br> <br>
										<!-- DATA FINISHED -->
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

