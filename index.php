<?php
require_once 'master/head.php';
?>
	<!DOCTYPE HTML>
	<html lang="jp">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
		
		<?php
			$path = "/pAccess";
			
			// set up session data
			if (isset($_SESSION["loggedIn"])){
				$loggedIn = $_SESSION["loggedIn"];
			} else {
				$loggedIn = "";
			}
		?>
		
		
<!-- JQUERY -->
		<script src="<?php echo $path;?>/js/jquery-1.10.2.js"></script>
		<script type="text/javascript" src="<?php echo $path;?>/js/jquery-ui.js"></script>
		<link rel="stylesheet" href="<?php echo $path;?>/css/jquery-ui.css">

		<!-- CSS -->
		<link rel="stylesheet" href="<?php echo $path;?>/css/font-awesome.css">
        <link rel="stylesheet" href="<?php echo $path;?>/fonts/fontawesome-free-5.5.0-web/css/all.css">
		<!-- index (dashboard)css -->
		<link rel="stylesheet" href="<?php echo $path;?>/css/indexMenu.css">
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
			
		<script>
			$(document).ready(function() {
				
				/* ANIMATE THE REMOVAL OF BLUR ON THE WRAPPER */
				var removeBlur = false;
				
				// ******************************************************
				// Check if logged in
				// ******************************************************
				var loggedIn = "<?php echo $loggedIn; ?>";
				if (loggedIn != ""){
					//set logName
					var logName = $("#logName");
					logName.html("Welcome " + loggedIn);
					removeBlur = true;
					clearOverlay();
					$.noty.closeAll(); // close all noty dialog boxes
				}
				
				// ******************************************************
				// PREVENT TAB from working on this page
				// ******************************************************
				/*$(document).on('keydown', function(e)
				{
					if(e.keyCode == 9)
					{
						e.preventDefault();
					}
				});*/
				
				// ******************************************************
				// CREATE MENU BUTTONS FOR EACH PROGRAM
				// ******************************************************
				
				function menuBox(program, location, baseWindow, title, icon, info, width, height) {
					
					//set default info
					if (info == null) {
						info = "説明なし";
					} else {
						info = info;
					}
					
					// check button type to put into proper container
					// program for #top
					// admin for #bottom
					// defaults to #top
					
					var buttonType = "";
					
					switch(program){
						case "program":
							buttonType = "#top";
							break;
						case "admin":
							buttonType = "#bottom";
							break;
						default:
							buttonType = "#top";
							break;
					}
					
					// control this class in the login function
					// -----------------------------------------------
					
					$(buttonType).append("<button class='menuBtn "+program+"' id='" + baseWindow + "' data-info='"+info+"' tabindex='-1'><div class='menuBoxIcon'><i class='" + icon + "'></i></div><div class='menuBoxText'>" + title + "</div></button>");
					
					$("#" + baseWindow).click(function() {
						
						var left = screen.width/2 - width/2;
						var top = screen.height/2 - height/2;
						
						var windowOutput = "width="+width+", height="+height+", top="+top+", left="+left+", resizable=yes";
						
						// To open it with browser controls set width and height variables to 0 when calling this function
						if(width == 0 || height == 0){
							windowOutput = "";
						}
						
						window.open(location, baseWindow, windowOutput);
                        
					});
				}

				/* IF LOGGED IN AS ADMIN ADD THESE BUTTONS */
				function AdminLoginExceptions(accessLevel){
					
					if (loggedIn == "howe" || accessLevel == "1"){
							menuBox("admin", "../../pChangeSys/index.php", "BaseWindow13", "商品変更説明", "fa fa-archive fa-2x", "商品変更説明", 0, 0);
							menuBox("admin", "../../librarySys/index.php", "BaseWindow12", "新図書館", "fa fa-book fa-2x", "新図書館", 0, 0);
							menuBox("admin", "../../DesignPro/index.php", "BaseWindow11", "社長デザイン", "fa fa-cube fa-2x", "社長のデザイン", 0, 0);
							menuBox("admin", "p_Help/help.php", "BaseWindow7", "Help", "fa fa-question-circle fa-2x", "This will contian a help manual for all the listed programs", 1200, 900);
							menuBox("admin", "", "BaseWindow8", "CSV Upload", "fa fa-code fa-2x", "CSVアップロード", 1200, 900);
							menuBox("admin", "", "BaseWindow9", "Users", "fa fa-address-book fa-2x", "ユーザー設定", 1200, 900);
							menuBox("admin", "../productViewer/index.php", "BaseWindow6", "HUSSL Sim", "fa fa-puzzle-piece fa-2x", "HUSSLの3D所品シミュレーション(作成中)", 1200, 900);
					}
				
				}
				
				// Create the menu bar
				menuBox("program", "p_Calculation/calculation.php?pr=1", "BaseWindow1", "販売価格設定", "fa fa-calculator fa-2x", "TFORMの商品新価格設定", 1200, 900);
				menuBox("program", "p_tfProject/tfProject.php?pr=2", "BaseWindow2", "tformプロジェクト", "fa fa-home fa-2x", "プロジェクトシミュレーション", 1600, 900);
				
				menuBox("program", "p_Order/order.php?pr=4", "BaseWindow4", "オーダー別単価計算", "fa fa-bank fa-2x", "オーダー内容を設定する", 1600, 900);
				menuBox("program", "p_Expense/expense.php?pr=3", "BaseWindow3", "オーダー別経費計算", "fa fa-eur fa-2x", "オーダーの計算表・書類保存・ダウンロード", 1200, 900);
				
				menuBox("program", "../claimSys/index.php", "BaseWindow5", "CLAIM SYSTEM", "fa fa-globe fa-2x", "クレームの管理システムクレジットノート請求書類作成", 1200, 900);
				menuBox("program", "p_ExchangeRate/exchangeRate.php", "BaseWindow10", "為替レート履歴", "fas fa-history fa-2x", "為替レートの履歴", 1200, 900);
                
				$("#top").append("<a href='../../hachuListSys/'><button class='menuBtn program' data-info='発注システム' tabindex='-1'><div class='menuBoxIcon'><i class='fa fa-truck fa-2x'></i></div><div class='menuBoxText'>発注システム</div></button></a>");
                $("#top").append("<a href='../../csvFromMail/'><button class='menuBtn program' data-info='GMAILからメールアドレス取り出す' tabindex='-1'><div class='menuBoxIcon'><i class='fab fa-mailchimp fa-2x'></i></div><div class='menuBoxText'>メール書き出す</div></button></a>");
				
				// Admin Options
				AdminLoginExceptions();

				// ******************************************************
				// SCROLLBAR
				// scrollbar initalization set theme here
				// ******************************************************
				
				$(".customScrollbar").mCustomScrollbar({
					theme: "minimal",
					axis: "xy",
					advanced: {
						updateOnContentResize: true
					},
					advanced:{
						updateOnSelectorChange: "table"
					}
				});

				$('#backgroundImg').fadeOut(50);
				
				// ******************************************************
				// LOGIN
				// check server if login info is correct
				// ******************************************************
				$(".loginSubmit").on("click", function(){
				
					//get details from the login form
					var user = $("#userName").val(); // login name
					var password = $("#userPassword").val(); // password
					
					// check server to see if the correct user name and password exist and enter if so.
					$.ajax({
						type: "post",
						url: "master/exeLogin.php",
						data: "action=login&user="+user+"&password="+password,
						success: function(data) {
							
							// set login name
							var logName = $("#logName");
							logName.html("Welcome " + data.user);
							AdminLoginExceptions(data.accessLevel);
							$("#loginBox").toggle();
							removeBlur = true;
							clearOverlay();
							$.noty.closeAll(); // close all noty dialog boxes
						},
						error: function(err) {
							console.log("ADD ERROR SCRIPT HERE");
							// ERROR MESSAGE HERE
							/* show the error */
							var errorMessage = 'ユーザー名かパスワード間違っています。';
							showGeneralError('fa fa-key', 'エラー', 0, errorMessage, '入れ直して下さい。');
							/* ************** */
						}
					});
				});
				
				// Also use the Enter key when focused and hit enter to trigger the login click event.
				$(".loginSubmit").keypress(function(e){
					if(e.which == 13){
						// ENTER IS PRESSED
						$(".loginSubmit").click();// Trigger the login event above.
					}
				});
				
				// ---------------------------------------------------------
				/* CLEAR THE OVERLAY */
				function clearOverlay(){
					if(removeBlur == true) {
				
						// Clear the loading screen
						$('#loading').delay(300).fadeOut(300);

						// Toggle the de-blurring
						$(function() {
							$({blurRadius: 10}).animate({blurRadius: 0}, {
								duration: 500,
								easing: 'swing', // or "linear"
												 // use jQuery UI or Easing plugin for more options
								step: function() {
									$('#wrapperIndex').css({
										"-webkit-filter": "blur("+this.blurRadius+"px)"
									});
								}
							});
						});
					}
				}
				
				
				/* UPDATE INFO BOX */
				$("body").on("mouseenter", ".menuBtn", function(){
					$("#infoBox").toggle();
					$("#infoBox").html("<i class='fa fa-info-circle'></i> " + $(this).data("info"));
				});
				$("body").on("mouseleave", ".menuBtn", function(){
					$("#infoBox").toggle();
				});
				
			}); // END OF DOC READY
		</script>
	</head>

	<body>
		<!-- DIALOGUES HERE -->
		<!-- checked if logged in here -->
		<?php
		//unset($_SESSION["loggedIn"]);
			if (isset($_SESSION["loggedIn"])){
				// need to log in
			} else {
				// run the login codes
				
			
		?>
		
		<div id="loginBox">
			<div class="header"><img src="img/logoGS.png"><br>Paccess</div>
			<div class="loginInputWrapper">
				<div class="loginInputIcon"><i class='fa fa-user-circle'></i></div>
				<div class="loginInputText"><input type="text" value="" id='userName' autofocus></div>
			</div>
			<div class='clear'></div>
			<div class="loginInputWrapper">
				<div class="loginInputIcon"><i class='fa fa-key'></i></div>
				<div class="loginInputText"><input type="password" id='userPassword'></div>
			</div>
			<div class='clear'></div>
			<div class="loginSubmit" tabindex="0"><i class='fa fa-arrow-right'></i></div>
		</div>
		
		<?php } ?>
		
		<!-- LOADING SCREEN -->
		<div id='loading'></div>

		<div id='wrapperIndex'>
			
			<!-- TOP HEADER BOX -->
			<div id="topHeader">
				<img src="img/favicon.ico" style="width: 16px; height: 16px;"><span style='font-size: 22px; font-weight: 700; color: #FFFFFF;'> TFORM PROGRAM ACCESS</span>
				<a href="master/exeLogout.php" tabindex="-1"><i class="fas fa-sign-out-alt" style="color: #FFF; font-size: 22px; margin-left: 10px; float: right;"> <span id="logName"></span> ログアウト</i></a><br><br>
			</div>
			
			<!-- BUTTON BOX -->
			<div id="outterContainer">
								
				<h1>Programs/プログラム</h1>
				<div id="top"></div>

				<hr><br>

				<h1>System Administration/システムアドミニストレータ</h1>
				<div id="bottom"></div>
				
			</div>
			
			<!-- INFO BOX -->
			<div id='infoBox'></div>

		</div><!-- WRAPPER END -->
		
		<!-- CSV upload functions AND ERROR FUNCTION -->
		<script type="text/javascript" src="<?php echo $path;?>/js/csvUpload.js"></script>
		
	</body>

	</html>