<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title;?></title>
<?php include_once '../master/config.php'; ?>
	
	<link rel="stylesheet" type="text/css" href="css/removeOldFilemakerData.css">
	
	<script type="text/javascript" src="js/removeOldDataonLoad.js"></script>

</head>
<body>
	<div id='wrapper'>
		<div id='loading'><span class='loadingGifMain'> <img src='<?php echo $path;?>/img/142.gif'><br> LOADING ... </span></div>
		<?php require_once '../header.php'; ?>
		<div class='contents'>
			<!-- PAGE CONTENTS START HERE -->
			
			<h1 style='width: calc(100% - 40px); padding: 20px;'>REMOVE OLD FILEMAKER CONTENT</h1>
			
			<div id="leftContentWrapper">
				<h3>[ 1 ] CSVフォーマート</h3>
				<div id='exampleBox'>
					<span class='attention'>
						※ CSVデーターのみ <br>
						※ BOMなしのUTF-8エンコード<br>
						※ メーカーを混ぜてはいけない。ADFなら、ADFのTFORM品番CSVのみです。
					</span>
					<br><br>
					<table>
						<tbody>
							<tr><th>ADF70-0001-001</th></tr>
							<tr><th>ADF73-0001-001</th></tr>
							<tr><th>ADF70-0001-001</th></tr>
						</tbody>
					</table>
				</div>
				
				<br>
				<br>

				<h3>[ 2 ] CSV 選ぶ</h3>
				<div id="filemakerDropBoxWrapper">

					<form method="POST" enctype="multipart/form-data" id="csvForm">
						<label for="csvFileInput">
							<i class="fa fa-cloud-upload fa-5x" style="color: #7BC7E0;"></i>
						</label>
						<input type="hidden" name="action" value="GetFileMakerMatches" readonly="readonly">
						<input type="file" name='files' id='csvFileInput' accept='.csv'>
					</form>
					<span id="selectedFileNameText"></span>

					<button id="submitBtn">CSVチェック発動</button>

				</div>

			
				
			</div>
			
			<div id="rightContentWrapper">
				<h3>[ 3 ] Missing from Filemaker</h3>
				
				<div id='nav'>
					<button id="removeItemsBtn"><img src="../img/favicon.ico"> 全体のpAccessから削除</button>
				</div>
				
				<div class='clear'></div>
				<br>
				
				<table id='differenceTable'>
					<thead>
						<tr>
							<th>pAccess ID</th>
							<th>tformNo</th>
							<th>maker</th>
							<th>type</th>
							<th><i class='fa fa-list'></i> In List</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
				
			</div>
			<!-- PAGE CONTENTS END HERE -->
		</div>
	</div>
<?php require_once '../master/footer.php';?>
	
	<!-- ************ -->
	<!-- DIALOG BOXES -->
	<!-- ************ -->

	<!-- MESSAGE BOX -->
	<div id="dialogMessage">
		<div id="messageContent">
			<h1>ERROR WARNING INFO</h1>
			<br><hr><br>
			<p class="message">More details about the particular error goes here.</p>
			<br>
			<p class='messageComment'>Contact the admin for details</p>
			<br>
			<p class='errorCode'>Error Code: 401</p>
		</div>
		<br><hr><br>
		<button class="btn closeDialogBtn dialogButton"><i class="fa fa-check fa-2x"></i></BUTTON>
	</div>
	
	<div id="pageOverlay" class='hideMe'></div>
	
</body>
</html>
