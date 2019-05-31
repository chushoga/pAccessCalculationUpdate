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
		}
		
		* {
			box-sizing: border-box;
			-moz-box-sizing: border-box;
		}
	
		
		.page {
			width: 215.9mm;
			min-height: 279.4mm;
			margin: 1cm auto;
			position: relative;
			padding-left: 6.35mm;
			padding-top: 19.05mm;
			outline: 1px solid cyan;
		}
		
		.card {
			position: relative;
			width: 203.2mm;
			height: 50.8mm;
			background-color: #FFF;
			float: left;
			outline: 1px dashed #000;
			padding-left: 20px;
			padding-right: 20px;
			padding-top: 15px;
		}
		
		.blue {
			background-color: #DBFFFF;
		}
		
		.red {
			background-color: #FFDBDB;
		}
		
		.green {
			background-color: #EDFFDB;
		}
		
		@page {
			size: 215.9mm 279.4mm;
			margin: 0;
		}
		
		@media print {
			.page {
				margin: 0;
				border: initial;
				width: 215.9mm;
				min-height: initial;
				box-shadow: initial;
				background: initial;
				outline: none;
			}
			.card {
				outline: none;
			}
		}

	</style>

	<link rel="stylesheet" href="../css/font-awesome.css">

	<script src="../js/jquery-1.10.2.js"></script>

	<script>
		$(document).ready(function() {
			
			printBlock("blue");
			printBlock("red");
			printBlock("green");
			printBlock("green");
			printBlock("red");

			function printBlock(color) {

				var block = "<div class='card " + color + "'>CONTENT<div>";

				$(".page").append(block);
			}
		});

	</script>

</head>

<body>

	<div class="page"></div>


</body>

</html>
