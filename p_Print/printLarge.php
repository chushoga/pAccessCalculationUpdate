<!DOCTYPE HTML>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<title>PRINT STICKERS</title>


	<style type="text/css">
		@CHARSET "UTF-8";
		* {
			margin: 0px;
			padding: 0px;
		}
		
		body {
			margin: 0;
			padding: 0;
			background-color: #FFF;
			font-family: "meiryo";
		}
		
		* {
			box-sizing: border-box;
			-moz-box-sizing: border-box;
		}
		
		.clear {
			clear: both;
		}
		
		.page {
			width: 793.7007874016px;
			min-height: 1122.519685039px;
			padding: 0cm;
			margin: 1cm auto;
			background-color: #FFF;
			position: relative;
		}
		
		.sticker {
			position: relative;
			width: 264px;
			height: 160px;
			background-color: #FFF;
			float: left;
			outline: 1px dashed #000;
			padding-left: 20px;
			padding-right: 20px;
			padding-top: 15px;
		}
		
		.mid {
			width: 100%;
			height: 22px;
			background-color: #FFF;
			overflow: hidden;
		}
		
		.footer {
			width: 100%;
			height: 20px;
			background-color: #FFF;
		}
		
		.mid input {
			width: 100%;
			height: 22px;
			border: none;
			background: none;
			line-height: 22px;
			font-size: 16px;
		}
		
		.footer input{
			background: none;
			border: none;
			width: 100%;
			height: 20px;
			font-size: 10px;
			color: #8E8E8E;
			text-align: right;
			line-height: 20px;
		}
		
		/* CONTROLS */
		#controls {
			position: absolute;
			right: -155px;
			width: 150px;
			height: 1122.519685039px;
			background-color: #FFF;
		}
		
		#reset, #print, #save {
			border: none;
			width: 70px;
			height: 70px;
			float: left;
			border-radius: 12px;
			color: #8E8E8E;
			margin-left: 3px;
			margin-bottom: 3px;
			outline: none;
		}
		
		#reset:hover, #print:hover, #save:hover, .resetSingle:hover {
			opacity: 0.75;
			cursor: pointer;
		}
		
		.resetSingle {
			position: absolute;
			right: 5px;
			top: 5px;
			color: #CCC;
			border: none;
		}
		
		.resetSingle:hover {
			color: firebrick;
		}
		
		@page {
			size: 210mm 297mm;
			margin: 0;
		}
		
		@media print {
			.page {
				margin: 0;
				border: initial;
				padding: 0px;
				width: 795px;
				min-height: initial;
				box-shadow: initial;
				background: initial;
			}
			.sticker {
				outline: none;
			}
			
			
			#controls, .resetSingle {
				display: none;
			}
			
			/* REMOVE PLACEHOLDERS */
			::-webkit-input-placeholder { /* WebKit browsers */
				color: transparent;
			}
			:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
				color: transparent;
			}
			::-moz-placeholder { /* Mozilla Firefox 19+ */
				color: transparent;
			}
			:-ms-input-placeholder { /* Internet Explorer 10+ */
				color: transparent;
			}
		}
	</style>
	
	<link rel="stylesheet" href="../css/font-awesome.css">

	<script src="../js/jquery-1.10.2.js"></script>
	
	<script>
		$(document).ready(function(){
			
			/* SET VARIABLES */
			var resetBtn = $("#reset");
			var resetSingle = $(".resetSingle")
			var printBtn = $("#print");
			
			var inputs = $(".info");
			var postalCode = $('.postalCode');
			var smallMemo = $('.smallMemo');
			
			/* ******************************************************
			** CLEAR INPUTS **
			** clears the inputs when the user clicks reset
			****************************************************** */
			
			// RESET ALL
			resetBtn.on("click", function(){
				if (confirm('すべてクリアしますか？')) {
					inputs.val(' ');
				} else {
					console.log("canceld");
				}
			});
			
			// RESET SINGLE
			resetSingle.on("click", function(){
				$(this).parent().find("input").val(' ');
			});
			
			/* ******************************************************
			** PRINT **
			** invoke the print screen
			****************************************************** */
			
			printBtn.on("click", function(){
				window.print();
			});
			
			/* ******************************************************
			** CHANGE TO UPPERCASE **
			** change maker name input to uppercase automatically
			****************************************************** */
			smallMemo.focusout(function() {
				this.value = this.value.toUpperCase();
			});
			
			/* ******************************************************
			** ADD POSTAL CODE SYMBOL **
			** automatically add the postal code sympbol after out of focus
			****************************************************** */
			postalCode.focusout(function() {
				$(this).val("〒"+ $(this).val());
			});
			
			/* ---------------------------------------------------------------------------------------- */
		});
	</script>

</head>

<body>
	<!-- START OF PAGE -->
	
	<div class="page">
	<!-- CONTORLS -->
		<div id="controls">
			<button id="reset"> <i class="fa fa-trash fa-3x"></i></button>
			<button id="print"><i class='fa fa-print fa-3x'></i></button>
			<button id="save"><i class='fa fa-save fa-3x'></i></button>
		</div>
	<!-- CONTROLS END -->
	</div>
	
	<!-- END OF PAGE -->
	
	<script>
		/*  CREATE PAGE SCRIPT */
		for(var i = 0; i < 3; i++){
			for(var j = 0; j < 7; j++){
				printBlock();
			}
		}


		function printBlock() {

			var block = "\
					<div class='sticker'>\
							<div class='resetSingle'><i class='fa fa-trash'></i></div>\
							<div class='mid'><input class='info postalCode' placeholder ='〒"+i+"000-"+j+"000'></div>\
							<div class='mid'><input class='info' placeholder='田中　ひろ'></div>\
							<div class='mid'><input class='info' placeholder='大洋金物株式会社'></div>\
							<div class='mid'><input class='info' placeholder='大阪市中央区高津3-15-34'></div>\
							<div class='mid'><input class='info' placeholder='その他めも○○○○○○○○○'></div>\
							<div class='footer'><input class='info smallMemo' placeholder='D K HP'></div>\
					<div>";

			$(".page").append(block);
		}
	</script>
</body>

</html>