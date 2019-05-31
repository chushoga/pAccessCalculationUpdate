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
/*DATATABLES START*/
	var defaultOptions = {
				"bJQueryUI": true,
				"bPaginate": false,
				"sScrollX" : "100%",
				"iDisplayLength": 100
				};//options
	var calcDataTableHeight = function() {
		// navi: 20px + uiToolbar: 38px + thHeight: 25px + toolBarFooter: 40px; = 123px 
	    var navi = 20;
	    var uiToolbar = 38;
	    var thHeight = 31;
	    var toolBarFooter = 40;
	    var minusResult = navi + uiToolbar + thHeight + toolBarFooter;
	    var h = Math.floor($(window).height() - minusResult);
	    return h + 'px';
	};
	defaultOptions.sScrollY = calcDataTableHeight();
	
	var oTable = $('#allRecords').dataTable(defaultOptions);

	 $(window).bind('resize', function () {
		 $('div.dataTables_scrollBody').css('height',calcDataTableHeight());
		oTable.fnAdjustColumnSizing();
	  } );
/*DATATABLES END*/

	 $('#loading').delay(300).fadeOut(300);


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
    $search = "";
}
$saveFileName = $search;
$savFileDate  = date('D, d M Y H:i:s');

?>
		<div id='wrapper'>
				<div id='loading'>
				<?php
				$counter = 0;
				$resultCounter = mysql_query("SELECT * FROM `main` WHERE `tformNo` LIKE '%$search%'") or die(mysql_error());
				while ($rowCounter = mysql_fetch_assoc($resultCounter)){
				    $counter++;
				}
				?>
						<span class='loadingGifMain'><img
								src='<?php echo $path;?>/img/142.gif'><br>LOADING <?php echo $counter;?>
								Files ...</span>
				</div>
				<?php require_once '../header.php';?>
				
				<div class='contents'>
						<!-- PAGE CONTENTS START HERE -->
						
						<div
								style='width: 100%; margin-right: auto; margin-left: auto; font-size: 12px; background-color: #FFF;'>
								<div id='saveWrapper'>
				
								<table id='allRecords'>
										<thead>
												<tr>
														<th>DBid</th>
														<th>廃番</th>
														<th>Tform品番</th>
														<th>メーカー品番</th>
														<th>メーカ－</th>
														<th>セット</th>
												</tr>
										</thead>
										<tbody>
										<?php
										$result = mysql_query("SELECT * FROM `main` WHERE `tformNo` LIKE '%$search%' ") or die(mysql_error());
										while ($row = mysql_fetch_assoc($result)){
										    $tformNo = $row['tformNo'];
										    $makerNo = $row['makerNo'];
										    $maker = $row['maker'];
										    $series = $row['series'];
										    $mainId = $row['id'];
										    $rate = 0;
										    $percent = 0;
										    $discount = 0;
										    $set = $row['set'];
										  
										    //results for sp_plcurent
										    $resultCurrent = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` = '$tformNo' ") or die(mysql_error());
										    if (mysql_num_rows($resultCurrent) == false){
										        $sp_plCurrent = "<span style='color: red;'>メーカーPL無し</span>";
										        $sp_disc_rate_id = 0;
										    }
										    while ($rowCurrent = mysql_fetch_assoc($resultCurrent)){
										        $sp_plCurrent = $rowCurrent['plCurrent'];
										        $sp_disc_rate_id = $rowCurrent['sp_disc_rate_id'];
										        	
										        //query for the detailed rate info
										        	
										        	
										        $resultTerms = mysql_query("SELECT * FROM `sp_disc_rate` WHERE `id` = '$sp_disc_rate_id' ") or die(mysql_error());
										        if (mysql_num_rows($resultTerms) == true){
										            while ($rowTerms = mysql_fetch_assoc($resultTerms)){
										                $rate = $rowTerms['rate'];
										                $percent = $rowTerms['percent'];
										                $discountPar = $rowTerms['discountPar'];
										            }
										        }
										    }


										    //end of results for sp_plcurrent

										    echo "<tr>";
										    echo "<td><a href='calculation.php?pr=1&id=".$mainId."'><button style='width: 100%; height: 20px;'>".$mainId."</button></a></td>";
										    echo "<td>";
											/* CHECK FOR HAIBAN AND SET HAIBAN COLOR */
												if (isHaibanNew($tformNo) == true){
												echo "<span style='color: red;'> (廃番)</span>";
												}
											echo "</td>";
										    
										    echo "<td style='min-width: 120px;'>".$tformNo."</td>";
										    echo "<td style ='max-width: 150px; overflow: hidden;'>$makerNo</td>";
										    if ($series != ''){
										        echo "<td>".$maker."/".$series."</td>";
										    } else {
										        echo "<td>".$maker."</td>";
										    }
										    //Maker Price List(before discount)
										    echo "<td>";
										    $array1  = str_replace(",", " ", $set);
										    $matches1 = explode(" ", $array1);
										    
										    //print_r($matches1);//debugging
										    
										    foreach ($matches1 as $value){
										    	if(!empty($value)){
										            echo $value;
										             echo "<br>";
										    	}
										    		
										    }
										    echo "</td>";

										    echo "</tr>";
										}
										?>
										</tbody>
								</table>
								
				</div> <!-- SAVE WRAPPER ENDS HERE -->
						</div>
						<!-- PAGE CONTENTS END HERE -->
						
				</div>
		</div>
		<?php require_once '../master/footer.php';?>
</body>
</html>

