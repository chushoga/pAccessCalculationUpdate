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
include_once '../master/config.php';
if(isset($_GET['jump'])){
    $jump = $_GET['jump'];
    } else { 
    $jump = "";
}
?>
<script type="text/javascript">
$(document).ready( function() {

/*DATATABLES START*/
	var defaultOptions = {
			
			  "bJQueryUI": true,
				"sPaginationType": "full_numbers",
				"sScrollX" : "100%",
				"iDisplayLength": 100,
				"aaSorting": [[0,'desc']],
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
	 $('div.dataTables_filter input').focus();
	 $('div.dataTables_filter input').val("<?php echo $jump;?>");
	 
	 $(function() {
			e = $.Event('keyup');
			e.keyCode= 82; // press r key to refresh Cap Sensative
			$('input').trigger(e);
		});
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
    		<div style='width: 100%; margin-right: auto; margin-left: auto; font-size: 12px; background-color: #FFF;'>
										<table id='allRecords'>
												<thead>
														<tr>
																<th>DBid</th>
																<th>オーダーNo.</th>
                                                                <th>河合完成</th>
                                                                <th>上杉完成</th>
                                                                <th>全体完成</th>
																<th>メーカー</th>
																<th>入荷日</th>
																<th>フォワーダー</th>
																<th>Vessel</th>
														</tr>
												</thead>
												<tbody>

												<?php
													
												$result = mysql_query("SELECT * FROM `expense` ") or die(mysql_error());
												while ($row = mysql_fetch_assoc($result)){
												   $id = $row['id'];
												    echo "<tr>";
												    echo "<td><a href='expense.php?pr=3&id=".$row['id']."'><button style='width: 100%; height: 20px;'>".$row['id']."</button></a></td>";
												     echo "<td>";
												    unset($temp);
												    unset($tempMaker);
												    for($i = 1; $i < 10; $i++){
												        $temp[] = $row['orderNo_'.$i]; 
												        $tempMaker[] = $row['makerName_'.$i];
												        }
												        $orderArray = array_unique($temp);
												        foreach ($orderArray as $value => $key){
												            if ($key != ''){
												             echo $key." ";
												            } else {
												                
												            }
												            
												        }
												    echo "</td>";
                                                    
                                                    /* FINISHED CHECK START */
                                                    // set the finished checkbox Views
                                                    $finishedCheckboxResults = mysql_query("SELECT * FROM expense WHERE `id` = '$id' ") or die(mysql_error());
                                                    while ($finishedCheckboxRow = mysql_fetch_assoc($finishedCheckboxResults)){
                                                        $finUser_01 = $finishedCheckboxRow['finUser_01']; // user 1 finished
                                                        $finUser_02 = $finishedCheckboxRow['finUser_02']; // user 2 finished
                                                        $finAll = $finishedCheckboxRow['finAll']; // all finished
                                                    }

                                                    /* SET THE FINISHED CHECKED*/
                                                    if($finUser_01 == 1){
                                                        $user_01_isFinished = '●';
                                                    } else {
                                                        $user_01_isFinished = '×';
                                                    }
                                                    // ----------------------------
                                                    if($finUser_02 == 1){
                                                        $user_02_isFinished = '●';
                                                    } else {
                                                        $user_02_isFinished = '×';
                                                    }
                                                    // ----------------------------
                                                    if($finAll == 1){
                                                        $all_isFinished = '●';
                                                    } else {
                                                        $all_isFinished = '×';
                                                    }
                                                    
                                                    
                                                    echo "<td>$user_01_isFinished</td>";
                                                    echo "<td>$user_02_isFinished</td>";
                                                    echo "<td>$all_isFinished</td>";
                                                    
                                                    /* FINISHED CHECK FINISHED */
												    echo "<td style='font-size: 9px;'>";
												    //start of maker code
												$makerArray = array_unique($tempMaker);
												        foreach ($makerArray as $value => $key){
												            if ($key != ''){
												             echo " [ ".$key." ] <br>";
												            } else {
												                
												            }
												        }
													    
												    echo "</td>";
												    
												    //end of maker code
												    
												    echo "<td>".$row['date']."</td>";
												    echo "<td>".$row['forwarder']."</td>";
												    echo "<td>".$row['vessle']."</td>";
												    echo "</tr>";
												    
												}
													
												?>

												</tbody>
										</table>
								</div>
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>

	<?php   require_once '../master/footer.php';?>

</body>
</html>

