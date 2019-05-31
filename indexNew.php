<?php require_once 'master/head.php';?>
	<!DOCTYPE HTML>
	<html lang="jp">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- JQUERY -->
		<?php
			$path = "/pAccess";
		?>

		<script src="<?php echo $path;?>/js/jquery-1.10.2.js"></script>
		<script type="text/javascript" src="<?php echo $path;?>/js/jquery-ui.js"></script>
		<link rel="stylesheet" href="<?php echo $path;?>/css/jquery-ui.css">

		<!-- CSS -->
		<link rel="stylesheet" href="<?php echo $path;?>/css/font-awesome.css">
		<!-- index (dashboard)css -->
		<link rel="stylesheet" href="<?php echo $path;?>/css/dashboard.css">
		<!-- font Awsome -->

		<!-- PACE progress bar -->
		<link rel="stylesheet" href="<?php echo $path;?>/css/pace.css">
		<script type="text/javascript" src="<?php echo $path;?>/js/pace.min.js"></script>

		<!-- On Load Dialog setup -->
		<script type="text/javascript" src="<?php echo $path;?>/js/onLoad.js"></script>

		<!-- CSV to Array -->
		<script type="text/javascript" src="<?php echo $path;?>/js/CSVToArray.js"></script>

		<!-- Notify Boxes -->
		<script type="text/javascript" src="<?php echo $path;?>/js/noty/packaged/jquery.noty.packaged.js"></script>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet">

		<!-- SCROLL BARS -->
		<link rel="stylesheet" href="<?php echo $path;?>/css/jquery.mCustomScrollbar.css">
		<script type="text/javascript" src="<?php echo $path;?>/js/jquery.mCustomScrollbar.js"></script>

	</head>

	<body>
		
		
		<div id='wrapper'>

			
			<!-- DIALOGUES HERE -->
			<div id="dialogCheckUpload" class='csvDialogBox' title="CSVアップロード確認">

				<h1>メーカー価格登録 [IDあり]</h1>
				<h2 id="makerPricelistUpdateCSVName"></h2>
				<h4 span='color: crimson;'>※10行プレビューです。</h4>
				<br>
				<table id="dialogCheckUploadTable1111111">
					<thead>
						<tr>
							<th>Tform 品番</th>
							<th>新メーカー価格</th>
							<th>取引条件 ID</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>

			<!-- UPLOAD AREA -->
			<div id="updateContainer">
				<div id="updateContainerTop"  class='customScrollbar'>
					<!-- **************************************************************************************** -->
					<!-- FILEMAKER INFO AREA -->
					<!-- **************************************************************************************** -->
					<div class='downloadAreaContainer customScrollbar'>
						<h1>Filemaker アップデート</h1>
						<div class='downloadAreaContainerUpper' >
							
							<!-- [ upload CSV ] -->
							<input type='file' id='filemakerInputfile' class='csvInputFile' 
								   data-uploadname='Filemaker アップデート'
								   data-columncount='17'
								   data-tformnopos='1'
								   data-headers="FM ID,
												Tform品番,
												タイプ,
												メーカー名,
												シリーズ,
												メーカー品番,
												Tform価格(税別),
												FM ID,
												FMIDセット内容,
												TFORM品番セット内容,
												イメージ,
												サムネール,
												メモ,
												web表示,
												メーカー廃番,
												Tform廃番,
												廃番終了"
								   style='display: none;'>
							<a href="javascript:document.getElementById('filemakerInputfile').click();">
								<div class='chooseFileBtn'>
									<i class='fa fa-folder'></i>
								</div>
							</a>
							<!-- [ download EXCEL MACRO ] -->
							<a href="master/FILEMAKER_MACRO.bas" download="FileMakerUpdateMacro.bas">
								<div class='downloadMacro'>
									<i class='fa fa-file-code-o fa-1x'></i>
								</div>
							</a>
							<div class='clear'></div>
						</div>
						<div class='downloadAreaContainerLower customScrollbar'>
							<div class='viewTable customScrollbar'>
								<table>
									<thead>
										<tr>
											<th>FM ID</th>
											<th>Tform品番</th>
											<th>タイプ</th>
											<th>メーカー名</th>
											<th>シリーズ</th>
											<th>メーカー品番</th>
											<th>Tform価格(税別)</th>
											<th>FMIDセット内容</th>
											<th>TFORM品番セット内容</th>
											<th>イメージ</th>
											<th>サムネール</th>
											<th>メモ</th>
											<th>web表示</th>
											<th>メーカー廃番</th>
											<th>Tform廃番</th>
											<th>廃番終了</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>3303</td>
											<td>FLN72-0402-001</td>
											<td>鋼板ホーローバス</td>
											<td>KALDEWEI</td>
											<td>Corpo Duo</td>
											<td></td>
											<td>817000</td>
											<td>3303</td>
											<td>16793, 16792, 24196</td>
											<td>FLN72-0402-A01, FLN73-9932-000, FAC73-9932-000</td>
											<td>photo/FLN72-0402-001_1_1_1.jpg</td>
											<td>photo/FLN72-0402-001_0_1.jpg</td>
											<td></td>
											<td>1</td>
											<td>1</td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class='clear'></div>
						</div>
					</div>

					<!-- **************************************************************************************** -->
					<!-- メーカー価格登録 INFO AREA -->
					<!-- **************************************************************************************** -->
					<div class='downloadAreaContainer customScrollbar'>
						<h1>メーカー価格登録</h1>
						<div class='downloadAreaContainerUpper'>
							
							<!-- [ upload CSV ] -->
							<input type='file' id='makerPricelistInputfile' class='csvInputFile' 
								   data-uploadname='メーカー価格 アップデート'
								   data-columncount='3'
								   data-tformnopos='0'
								   data-headers='Tform品番,
												 新価格,
												 取引条件ID'
								   style='display: none;'>
							<a href="javascript:document.getElementById('makerPricelistInputfile').click();">
								<div class='chooseFileBtn'>
									<i class='fa fa-folder'></i>
								</div>
							</a>
							
							<div class='clear'></div>
						</div>
						<div class='downloadAreaContainerLower customScrollbar'>
							<div class='viewTable customScrollbar'>
								<table>
									<thead>
										<tr>
											<th>Tform品番</th>
											<th>新価格</th>
											<th>取引条件ID</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>ADF70-0001-001</td>
											<td>123456</td>
											<td>34</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class='clear'></div>
						</div>
					</div>

					<!-- **************************************************************************************** -->
					<!-- 価格設定リスト INFO AREA -->
					<!-- **************************************************************************************** -->

					<div class='downloadAreaContainer'>
						<h1>価格設定リスト</h1>
						<div class='downloadAreaContainerUpper'>
							<div class='chooseFileBtn'><i class='fa fa-folder'></i></div>
							<div class='clear'></div>
						</div>
						<div class='downloadAreaContainerLower'>
							<div class='viewTable'>
								<table>
									<thead>
										<tr>
											<th>Tform品番</th>
											<th>リスト名</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>FLN70-6501-001</td>
											<td>GROHE_LIST_2016</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class='clear'></div>
						</div>
					</div>

					<!-- **************************************************************************************** -->
					<!-- オーダー(オーダー別単価計算) INFO AREA -->
					<!-- **************************************************************************************** -->

					<div class='downloadAreaContainer'>
						<h1>オーダー(オーダー別単価計算)</h1>
						<div class='downloadAreaContainerUpper'>
							<div class='chooseFileBtn'><i class='fa fa-folder'></i></div>
							<!-- [ download EXCEL MACRO ] -->
							<a href="master/FILEMAKER_MACRO.bas" download="FileMakerUpdateMacro.bas">
								<div class='downloadMacro'>
									<i class='fa fa-file-code-o fa-1x'></i>
								</div>
							</a>
							<div class='clear'></div>
						</div>
						<div class='downloadAreaContainerLower'>
							<div class='viewTable'>
								<table>
									<thead>
										<tr>
											<th>メーカー価格</th>
											<th>Tform品番</th>
											<th>メーカー品番</th>
											<th>オーダーNo.</th>
											<th>入出庫日</th>
											<th>数量</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>352.26</td>
											<td>FLN70-6501-001</td>
											<td>3151</td>
											<td>2548</td>
											<td>2016.07.06</td>
											<td>12</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class='clear'></div>
						</div>
					</div>
					<!-- **************************************************************************************** -->
					
				</div><!-- end of upper half of right side -->
				<div id="updateContainerBottom">
					<!-- CSV preview AREA -->
					<div>
						<div class="btnCSVPreviewCancel"><i class='fa fa-ban'></i> キャンセル</div>
						<div class='btnCSVPreviewOk'><i class='fa fa-upload'></i> 出撃</div>
						
						<div id='csvTitleTop'>
							<div class='csvTitleTopInfo'>
								<span id='uploadTableTitle' style="font-weight: 700; color: crimson;"></span>
							</div>
							
							<div  class='csvTitleTopInfo'>
								<span id='csvTitle'></span>
							</div>
							
							<div  class='csvTitleTopInfo'>
								<span id='csvTitleInfo'></span>
							</div>
						</div>
					</div>
					
					<div class='clear'></div>
					
					
					
					<div id="csvPreviewContainer" class='customScrollbar'>
							<table id="dialogCheckUploadTable">
								<thead></thead>
								<tbody></tbody>
							</table>
					</div>
					
					
				</div>
			</div><!-- updateContainer END -->
		</div><!-- WRAPPER END -->

		<!-- CSV upload functions -->
		<script type="text/javascript" src="<?php echo $path;?>/js/csvUpload.js"></script>


	</body>

	</html>