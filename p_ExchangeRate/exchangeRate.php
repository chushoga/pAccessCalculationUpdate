<?php
date_default_timezone_set('Asia/Tokyo'); // SET TIMEZONE TO JAPAN
require_once '../master/dbconnect.php'; // CONNECT TO THE DATABASE
?>

	<!DOCTYPE HTML>
	<html lang="jp">

	<head>
		<!-- INCLUDES HERE -->
		<!-- JQUERY -->
		<?php
			$path = "/pAccess";
		?>
		
			<!-- --------------- CSS --------------- -->
			<link rel="stylesheet" href="<?php echo $path;?>/css/font-awesome.css">
		
			<!-- jquery -->
			<link rel="stylesheet" href="<?php echo $path;?>/css/jquery-ui.css">
			
			<!-- datatabels -->
			<link rel="stylesheet" href="<?php echo $path;?>/css/jquery.dataTables.css">
		
			<!-- --------------- JS --------------- -->
			<script type="text/javascript" src="<?php echo $path;?>/js/jquery-1.12.1.min.js"></script>
			<script type="text/javascript" src="<?php echo $path;?>/js/jquery-ui.js"></script>
		
			<script type="text/javascript" src="<?php echo $path;?>/js/jquery.dataTables.js"></script>

			<script type="text/javascript" src="js/Chart.js"></script>
			<script type="text/javascript" src="js/onLoad.js"></script>
			


			<meta charset="utf-8">
			<style>
				* {
					padding: 0px;
					margin: 0px;
				}
				body {
					font-family: "メイリオ";
					font-size: 12px;
				}
				
				table {
					width: 100%;
					text-align: center;
					border-collapse: collapse;
				}
				
				td,
				th {
					border: 1px solid #CCC;
					padding: 5px;
				}
				
				#wrapper {
					width: 100%;
					margin: auto;
				}
				
				#graphContents {
					position: absolute;
					top: 50px;
					height: 30%;
					padding-left: 10px;
					padding-right: 10px;
					width: calc(100% - 20px);
					
				}
				
				#tableContents {
					position: absolute;
					top: calc(30% + 55px);
					bottom: 0px;
					padding-left: 10px;
					padding-right: 10px;
					width: calc(100% - 20px);
					overflow: auto;
				}
				
				.boxSearchShared {
					height: 35px;
					line-height: 35px;
					float: left;
					padding: 5px;
					outline: 1px solid #CCC;
				}
				
				#boxMaker {
					opacity: 0.5;
				}
				
				#boxAllMaker {
					opacity: 0.5;
				}
				#boxAllMaker input{
					height: 30px;
					width: 30px;
					float: left;
					border: none;
					text-align: center;
					outline: none;
				}
				
				#boxCurrency {
					opacity: 0.5;
				}
				
				#boxFromTo input {
					width: 100px;
					height: 30px;
					font-size: 16px;
					text-align: center;
				}
				
				#search {
					height: 50px;
					background: #3E3E3E;
					color: #FFFFFF;
				}
				
				#boxSearch {
				
				}
				
				#searchBtn {
					height: 35px;
					width: 35px;
					font-size: 18px;
					background: #CCC;
					border: none;
					text-align: center;
					outline: none;
				}
				
				#searchBtn:hover {
					cursor: pointer;
					opacity: 0.7;
				}
				
				#totals {
					float: left;
					width: 200px;
					height: 35px;
					font-size: 10px;
					margin-left: 10px;
				}
				
				#totalAverage {
					color: #A1D490;
				}
				
				#canvasWrapper {
					height: 100%;
					width: 100%;
				}
				
				
			</style>
		
	</head>

	<body>

		<div id="wrapper">
			<div id="search">
				
				<!-- SEARCH MAKER -->
				<div id="boxMaker" class="boxSearchShared">
					MAKER: <input type="text" id="searchMaker" value="">
				</div>
				
				<!-- SEARCH ALL MAKERS -->
				<div id="boxAllMaker" class="boxSearchShared">
					すべてのメーカー検索 <input type="checkbox" id="searchAllMakers" name="searchAllMakers">
				</div>
				
				<!-- SEARCH CURRENCY-->
				<div id="boxCurrency" class="boxSearchShared">
				CURRENCY:
					<select id="searchCurrency">
						<option value='' selected>選ぶ</option>
						<option value='EUR' selected>EUR</option>
						<option value='US$'>US$</option>
						<option value='CNY'>CNY</option>
						<option value='JPY'>JPY</option>
						<option value='DKK'>DKK</option>
						<option value='SGD'>SGD</option>
					</select>
				</div>
				
				<!-- SEARCH FROM / TO-->
				<div id="boxFromTo" class="boxSearchShared">
					日付: <input type="text" id="searchFrom" name="searchFrom">


					 ～ <input type="text" id="searchTo" name="searchTo">
				</div>
				
				<!-- SEARCH BUTTON -->
				<div id="boxSearch" class="boxSearchShared">
					<button id="searchBtn"><i class="fa fa-search"></i></button>
				</div>
					
				<div id="totals">
					外貨代金合計: <span id="totalMakerPL"></span><br>
					商品代金(￥)合計: <span id="totalProduct"></span><br>
					為替レート平均: <span id="totalAverage"></span><br>
				</div>
			</div>
			<div id="graphContents">
				<div id="canvasWrapper">
					<canvas id="myChart" height="50"></canvas>
				</div>
			</div>
		
			<div id="tableContents">
				<table id="generalTable">
					<thead>
						<tr>
							<th>id</th>
							<th>オーダー</th>
							<th>メーカー</th>
							<th>送金日</th>
							<th>CUR</th>
							<th>外貨代金</th>
							<th>為替レート</th>
							<th>商品代金(￥)</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</body>

	</html>