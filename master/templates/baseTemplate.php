<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title;?></title>
<link rel="stylesheet" href="<?php echo $path;?>/css/tfProject/tfProjectInfo.css">
<?php
include_once '../master/config.php'; ?>
<script type="text/javascript">
$(document).ready( function() {
	$('#loading').delay(300).fadeOut(300);
		} );
</script>
<style type="text/css">
</style>
</head>
<body>
	<div id='wrapper'>
	<div id='loading'>
    		<span class='loadingGifMain'>
    			<img src='<?php echo $path;?>/img/142.gif'><br>
    			LOADING ...
    		</span>
	</div>
    	<?php require_once '../header.php';?>
    	<div class='contents'>
    		<!-- PAGE CONTENTS START HERE -->
    		
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>