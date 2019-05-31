<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title;?></title>
	
	<?php
		// -------------------------------
		// INCLUDE CONFIG
		// -------------------------------
	
		include_once '../master/config.php';
		
		// -------------------------------
	?>
	
	<script type="text/javascript">
		
		// -------------------------------
		// DOC READY
		// -------------------------------
		$(document).ready(function() {

			//------------------------------------
			// DATATABLES INITALIZATION
			//------------------------------------

			//options
			var defaultOptions = {
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				"sScrollX": "100%",
				"bPaginate": false,
				"bInfo": true,
				"iDisplayLength": 100,
				"order": [[1, "asc"]]
			};
			
			//options
			var calcDataTableHeight = function() {
				// navi: 20px + uiToolbar: 38px + thHeight: 25px + toolBarFooter: 40px; = 123px 
				var navi = 20;
				var uiToolbar = 38;
				var thHeight = 31;
				var toolBarFooter = 52;
				var minusResult = navi + uiToolbar + thHeight + toolBarFooter;
				var h = Math.floor($(window).height() - minusResult);
				return h + 'px';
			};

			defaultOptions.sScrollY = calcDataTableHeight();

			var oTable = $('#allRecords').dataTable(defaultOptions);

			$(window).bind('resize', function() {
				$('div.dataTables_scrollBody').css('height', calcDataTableHeight());
				oTable.fnAdjustColumnSizing();
			});

			//------------------------------------
			// SEARCH -> DATEPICKER OPTIONS
			//------------------------------------

			$(function() {

				$("#from").datepicker({
					dateFormat: 'yy-mm-dd',
					defaultDate: "+1w",
					changeMonth: true,
					numberOfMonths: 1,
					onClose: function(selectedDate) {
						$("#to").datepicker("option", "minDate", selectedDate);

					}
				});

				$("#to").datepicker({
					dateFormat: 'yy-mm-dd',
					defaultDate: "+1w",
					changeMonth: true,
					numberOfMonths: 1,
					onClose: function(selectedDate) {
						$("#from").datepicker("option", "maxDate", selectedDate);
					}
				});
			});

			//------------------------------------
			// REMOVE LOADING OVERLAY
			//------------------------------------

			$('#loading').delay(200).fadeOut(300);

			//------------------------------------
		});

	</script>
	
	<!-- ----------- -->
	<!-- ON PAGE CSS -->
	<!-- ----------- -->
	
	<style type="text/css">

		#infoBar {
			height: 40px;
			background-color: #CCC;
			font-size: 16px;
			line-height: 40px;
		}
		
		#infoBar input[type=text]{
			height: 36px;
			margin-top: 2px;
			min-width: 100px;
			font-size: 18px;
			padding: none;
			border: none;
			text-align: left;
		}
		
		#infoBar button {
			height: 36px;
			margin-top: 2px;
			font-size: 16px;
			border: none;
			padding-left: 20px;
			padding-right: 20px;
		}
		
		#infoBar .headerText {
			margin-left: 20px;
			font-weight: 700;
		}
		
		div.ui-datepicker{
		 font-size: 16px;
		}
		
		#loading {
			position: absolute;
			z-index: 9000;
			top: 0px;
			bottom: 0px;
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
	<?php
	
		// ---------------------------
		// GET AND SET PAGE VARIABLES
		// ---------------------------
	
		// DATE -> FROM
		if(isset($_GET['from'])){
			$from = $_GET['from'];
		} else {
			$from = '';
		}
		
		// DATE -> TO
		if(isset($_GET['to'])){
			$to = $_GET['to'];
		} else {
			$to = '';
		}
	
		// SEARCH
		if(isset($_GET['search'])){
			$search = $_GET['search'];
		} else {
			$search = '';
		}
		
		// FIXME: Remove if ($search == 'すべて'){  this and work it into the normal search thing.
		// SEARCH ALL WORK INTO ABOVE
		if ($search == ''){
			$normalSearch = "";
		} else {
			$normalSearch = "AND `tformNo` LIKE '%$search%'";
		}
		
		// EXCEL FILE SAVE NAME.
		$saveFileName = $search."-".$from."_".$to;
		
		// FOR VISUALS ONLY
		$savFileDate = $from."～".$to;
	?>
	<div id='wrapper'>
		
		<!-- ------------------------------------ -->
		<!-- LOADING SCREEN -->
		<!-- ------------------------------------ -->
		
		<div id='loading'>
			<span class='loadingGifMain'>
				<img src='<?php echo $path;?>/img/142.gif'><br>
				LOADING ...
			</span>
		</div>
		
		<!-- ------------------------------------ -->
<?php
		require_once '../header.php';?>
			<div class='contents'>
				
				<!-- ------------------------------------ -->
				<!-- PAGE CONTENTS START HERE -->
				<!-- ------------------------------------ -->
				<div id="infoBar">
					
					<!-- ------------------------------------ -->
					<!-- SEARCH FORM -->
					<!-- ------------------------------------ -->
					<form method='GET' action='expenseHistorySuperSimple.php' style=''>
						<span class="headerText">一番最近の最終単価一覧</span>
						<?php
						// SHOW date searched for
						echo " [<span style=''> ".$from."</span> - <span style=''> ".$to."</span> ] <span style='font-weight: 700;'>".$search."</span> ";
						?>
						<div style='float: right;'>
							<input type='hidden' name='pr' value='<?php echo $pr;?>'>
							<button>検索 <i class="fa fa-search"></i></button>
						</div>
						
						<!-- FIXME: [x]remove ui-widget class -->
						<div class="" style='float: right; margin-left: 10px;'>
							 キーワード <input type="text" name='search' value='<?php echo $search; ?>'>
						</div>
						
						<div style='float: right;'>
							<label for="from"><i class="fa fa-calendar fa-lg"></i></label>
							<input type="text" id="from" name="from" value='<?php echo $from;?>' style='text-align: center;'>
							<label for="to"> ～ </label>
							<input type="text" id="to" name="to" value='<?php echo $to;?>' style='text-align: center;'>
						</div>
						
						<div style='clear: both;'></div>
						
					</form>
				</div>
				<div id='saveWrapper'>
					<?php
					
					echo "<table style='border-collapse: collapse;' id='allRecords'>";
					echo "<thead>";
					echo "<tr>
							<th>メーカー品番</th>
							<th>Tform品番</th>
							<th>オーダーNo.</th>
							<th>日付</th>
							<th>掛率</th>
							<th>最終単価</th>
						</tr>";
					echo "</thead>";
					echo "<tbody>";
					
					// PUT THE QUERY FOR PULLING DATA FROM ORDER WHERE = $key
									
									//SET DEFAULT VARIABLE VALUES
									
									$finalUnitPrice = "-";
									
									//---------------------------
									
									// CHANGED: select * to finalUnitPrice
									
									//$result1 = mysql_query("SELECT `finalUnitPrice` FROM `order` WHERE `orderNo` = '$key' AND `tformNo` = '$tformNo'");
									
                                    $sql = "
										SELECT p.`id`, 
											p.`tformNo`, 
											p.`makerNo`,
											p.`orderNo`,
											p.`finalUnitPrice`,
											p.`discount`,
											p.`date`
											FROM `order` p 
											WHERE p.`date` 
											BETWEEN '$from' AND '$to' AND 
												p.`tformNo` LIKE '%$search%' AND (p.`tformNo`, p.`date`) IN
													(
													SELECT p2.`tformNo`, MAX(p2.`date`) FROM
														`order` p2 WHERE 
														p.`tformNo` = p2.`tformNo`
													) ORDER BY `p`.`tformNo`
									";
									$resultNew = mysql_query($sql);
									//echo $sql;
									while ($rowNew = mysql_fetch_assoc($resultNew)){
										$finalUnitPrice = $rowNew['finalUnitPrice'];
									
									echo "<tr>";
										echo "<td>";
											echo $rowNew['makerNo'];
										echo "</td>";
										echo "<td>";
											echo $rowNew['tformNo'];
										echo "</td>";
										echo "<td>";
											echo $rowNew['orderNo'];
										echo "</td>";
										echo "<td>";
											echo $rowNew['date'];
										echo "</td>";
										
										// WORKS JUST HIDING THE DISCOUNT FOR THIS FORMAT
										echo "<td>";
											echo $rowNew['discount'];
										echo "</td>";
										
										echo "<td>";
											echo $rowNew['finalUnitPrice'];
										echo "</td>";
									echo "</tr>";
									}
									/*
									if ($finalUnitPrice != '-'){
										echo "<td style='border-right: solid 1px #000;'>".number_format($finalUnitPrice, 0, '',',')."</td>";
									} else {
										echo "<td style='border-right: solid 1px #000;'>".$finalUnitPrice."</td>";
									}
									*/

									$finalPriceArray[] = $finalUnitPrice;
								
							
					
					echo "</tbody>";
					echo "</table>";
					
					?>
					</div><!-- SAVE WRAPPER -->
					<!-- ------------------------------------ -->
					<!-- START TABLE -->
					<!-- ------------------------------------ -->
				
								
								<!-- END OF SAVEWRAPPER -->
								<!-- PAGE CONTENTS END HERE -->
					</div>
			</div>
			<?php require_once '../master/footer.php';?>
	</body>

	</html>
