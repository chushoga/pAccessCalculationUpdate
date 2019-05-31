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
		} );
</script>
<style type="text/css">
.uploadForm {
	width: 400px;
	background-color: #FFF;
	margin-top: 35px;
	margin-left: auto;
	margin-right: auto;
	text-align: center;
	}
</style>
</head>
<body>
	<div id='wrapper'>	
    	<?php require_once '../header.php';?>
    	<div class='contents'>
    		<!-- PAGE CONTENTS START HERE -->
    		<div class='uploadForm'>
    		<?php
                echo "<form method='POST' action='exe/exeplUpdate.php' enctype='multipart/form-data'>";
                echo "<h3>メーカーPLインポート</h3>";
                echo "<input type='file' name='filename' style='border: #CCC 2px solid;'>";
                echo "<br><br><br><br>";
                echo "<input type='submit' value='アップロード' class='go'>";
                echo "</form>";
            ?>
</div>
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>

