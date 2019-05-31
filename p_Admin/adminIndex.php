<?php require_once '../master/head.php';?>
	<!DOCTYPE HTML>
	<html lang="jp">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
			include_once '../master/config.php';
		?>
		<script>
			$(document).ready(function() {

			});
		</script>
	</head>

	<body>
		<!-- LOADING SCREEN -->
		<div id='loading'></div>
		ADD AJAX TEST HERE
		
		
		<script>
		$.ajax({
			type: "post",
			url: "exe/processUsers.php",
			data: "action=testData",
			success: function(data) {

				for(var i = 0; i < data.length; i++) {
					console.log(data[i].id);
					console.log(data[i].name);
					console.log(data[i].password);
					console.log(data[i].accessLevel);
				}
			},
			error: function(err) {
				console.log("error in your script somewhere");
			}
		});

		</script>
	</body>

	</html>