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
				"bInfo": false,
				"iDisplayLength": 100
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
					numberOfMonths: 3,
					onClose: function(selectedDate) {
						$("#to").datepicker("option", "minDate", selectedDate);

					}
				});

				$("#to").datepicker({
					dateFormat: 'yy-mm-dd',
					defaultDate: "+1w",
					changeMonth: true,
					numberOfMonths: 3,
					onClose: function(selectedDate) {
						$("#from").datepicker("option", "maxDate", selectedDate);
					}
				});
			});

			//------------------------------------
			// REMOVE LOADING OVERLAY
			//------------------------------------

			$('#loading').delay(300).fadeOut(300);

			//------------------------------------
		});

	</script>
	
	<!-- ----------- -->
	<!-- ON PAGE CSS -->
	<!-- ----------- -->
	
	<style type="text/css">
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
		if ($search == 'すべて'){
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
				<?php
					
					// SHOW date searched for
					echo " [<span style='color: red;'> ".$from."</span> ~ <span style='color: green;'> ".$to."</span> | ".$search." ] ";
				?>
					
					<!-- ------------------------------------ -->
					<!-- SEARCH FORM -->
					<!-- ------------------------------------ -->
					<form method='GET' action='expenseHistorySimple.php' style='float: right; margin: 2px;'>
						<div style='float: left;'>
							<label for="from">から <i class="fa fa-calendar"></i></label>
							<input type="text" id="from" name="from" value='<?php echo $from;?>' style='width: 80px; text-align: center;'>
							<label for="to">に <i class="fa fa-calendar"></i></label>
							<input type="text" id="to" name="to" value='<?php echo $to;?>' style='width: 80px; text-align: center;'>
						</div>
						
						<!-- FIXME: [x]remove ui-widget class -->
						<div class="" style='float: left; margin-right: 40px; margin-left: 10px;'>
							 キーワード <input type="text" name='search' value='<?php echo $search; ?>'>
						</div>
						
						<div style='float: left;'>
							<input type='hidden' name='pr' value='<?php echo $pr;?>'>
							<input type="submit" class='submit' value='検索'>
						</div>
						
						<div style='clear: both;'></div>
						
					</form>

				<div id='saveWrapper'>
					
					<!-- ------------------------------------ -->
					<!-- START TABLE -->
					<!-- ------------------------------------ -->
					<table style='font-size: 9px; border-collapse: collapse;' id='allRecords'>
						<thead>
							<tr>
								<th style='min-width: 100px;'>
									メーカー品番
								</th>
								<th style='min-width: 100px;'>
									Tform品番
								</th>

								<?php
									
									$result1 = mysql_query("SELECT DISTINCT `orderNo` FROM `order` WHERE `date` BETWEEN '$from' AND '$to' $normalSearch ORDER BY `date` DESC");
									while ($row1 = mysql_fetch_assoc($result1)) {

										// Set the order number here
										$order = $row1['orderNo'];
										
										// Get the date of the order
										$result2 = mysql_query("SELECT `date` FROM `order` WHERE `orderNo` = '$order'");
										
										// query order table for the date.
										while ($row2 = mysql_fetch_assoc($result2)){
											$date = $row2['date'];
										}
										
										echo "<th style='min-width: 70px; border-right: solid 1px #000;'>".$order."<br>".$date."</th>";

										// add the order number to the order array so we can loop though and get the contents.
										$orderArray[] = $order;
										
									}
								?>
							</tr>
						</thead>
						<tbody>
							<?php
							
							// QUERY the order table for the information between the search dates.
							// CHANGES: removed * and instead only selected the tformNo and makerNo from order table
							// NOTE: check if we really need to use GROUP BY in the query.
							$result = mysql_query("SELECT `tformNo`, `makerNo` FROM `order`  WHERE `date` BETWEEN '$from' AND '$to' $normalSearch GROUP BY `tformNo` ORDER BY `date` DESC");
							
							while ($row = mysql_fetch_assoc($result)){
							
								$tformNo = $row['tformNo'];
								
								// FUTURE: remove this inline styling and add text-align center to all the table cells.
								echo "<tr style='text-align: center;'>";
								
								echo "<td>".$row['makerNo']."</td><td>".$row['tformNo']."</td>";

								// go through orderArray and put the required final prices in <td>
								foreach ($orderArray as $value => $key){

									// PUT THE QUERY FOR PULLING DATA FROM ORDER WHERE = $key
									
									//SET DEFAULT VARIABLE VALUES
									
									$finalUnitPrice = "-";
									
									//---------------------------
									
									// CHANGED: select * to finalUnitPrice
									$result1 = mysql_query("SELECT `finalUnitPrice` FROM `order` WHERE `orderNo` = '$key' AND `tformNo` = '$tformNo'");
									
									while ($row1 = mysql_fetch_assoc($result1)){
										$finalUnitPrice = $row1['finalUnitPrice'];
									}
									
									if ($finalUnitPrice != '-'){
										echo "<td style='border-right: solid 1px #000;'>".number_format($finalUnitPrice, 0, '',',')."</td>";
									} else {
										echo "<td style='border-right: solid 1px #000;'>".$finalUnitPrice."</td>";
									}
									

								}

							echo "</tr>";
							}
?>
										</tbody>
									</table>
								</div>
								<!-- END OF SAVEWRAPPER -->
								<!-- PAGE CONTENTS END HERE -->
					</div>
			</div>
			<?php require_once '../master/footer.php';?>
	</body>

	</html>
