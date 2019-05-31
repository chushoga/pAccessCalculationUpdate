<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
?>
<!DOCTYPE HTML>
<html lang="jp">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- CSS -->
		<link rel="stylesheet" href="css/help.css">
		<link rel="stylesheet" href="css/font-awesome.css">
		
		<!-- ADD THE SCRIPTS HERE -->
		<script src="js/jquery-3.1.1.min.js"></script><!-- jQuery -->
		<script src="js/onReady.js"></script> <!-- Put this last for the onready script -->
		
		
		<!-- STYLE -->
		<style></style>
	</head>
	<body>
		<div id="help_left"><?php include "menu.html"; ?></div>
		<div id="help_right"><?php include "contents/changeLog.html"?></div>
	</body>
</html>