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
		
		<!-- CONFIG -->
		<?php include_once '../master/config.php'; ?>
		
		<!-- SPECIAL CSS -->
		<link rel="stylesheet" href="orderNew.css">
			
		<!-- ON LOAD -->
		<script type="text/javascript">
			$(document).ready(function(){

			}); // END OF DOC READY
		</script>
	</head>

	<body>

		<?php
			// VARIABLES
		if (isset($_GET['orderNo'])){
			$orderNo = $_GET['orderNo'];
		} else {
			$orderNo = '';
		}
		//---------
		?>
		
		<div id="left">
			<div id="leftMenuBar"><i class="fa fa-save menuIcon"></i></div>
			
			
			<!-- BLOCK SETUP -->
			<div id="contentsL">
				<table>
					<thead>
						<tr>
							<th>orderNo</th>
							<th>Maker</th>
							<th>date</th>
						</tr>
						<tr>
							<th><input type="text" placeholder="検索"></th>
							<th><input type="text" placeholder="検索"></th>
							<th><input type="text" placeholder="検索"></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<!-- BLOCK FINISHED -->
		</div>

		<div id="right">
			<div id="rightMenuBar"><i class="fa fa-cog menuIcon"></i></div>
			<!-- BLOCK SETUP -->
			<div id="contentsR">
			<table>
					<thead>
						<tr>
								<th>メーカー品番</th>
								<th>tform品番</th>
								<th>入荷日</th>
								<th>数量</th>
								<th>通貨</th>
								<th>PRICE</th>
								<th>掛率</th>
								<th>削除</th>
						</tr>
						<tr>
							<th class="normalInput">
								<input type="text" placeholder="" disabled="disabled">
							</th>
							<th class="normalInput">
								<input type="text" placeholder="" disabled="disabled">
							</th>
							<th class="copyDown">
								<input type="text" placeholder="コーピー">
								<i class="fa fa-arrow-down" style=""></i>
							</th>
							<th class="normalInput">
								<input type="text" placeholder="" disabled="disabled">
							</th>
							<th class="copyDown">
								<input type="text" placeholder="コーピー">
								<i class="fa fa-arrow-down" style=""></i>
							</th>
							<th class="normalInput">
								<input type="text" placeholder=""disabled="disabled">
							</th>
							<th class="copyDown">
								<input type="text" placeholder="コーピー">
								<i class="fa fa-arrow-down" style=""></i>
							</th>
							<th class="normalInput">
								<input type="text" placeholder=""disabled="disabled">
							</th>
							
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<!-- BLOCK FINISHED -->
		</div>
		
		<!-- JS INSERT -->
		<script src="orderProcessL.js"></script>
		<script src="orderProcessR.js"></script>
	</body>
</html>