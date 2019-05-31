<?php require_once '../master/head.php';?>
<!DOCTYPE html>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>pAccess</title>
<?php require_once '../master/config.php'; ?>
<style type="text/css"></style>
</head>
<body id="index">


		<div class="wrapper">
		<?php
		require_once '../functions/function.php';
		require_once '../header.php';
		?>

				<div id="mainBody">
						<!-- DATA START -->
						<div class="fullBox">
								<div
										style='width: 400px; height: auto; margin-left: auto; margin-right: auto; margin-top: 100px; font-size: 16px;'>
										<?php
										//variables
										$tformNo = $_GET['tformNo'];
										$id = $_GET['id'];
										$plCurrent = $_GET['plCurrent'];
										$search = $_GET['search'];
										//------------
																				
										$result = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$tformNo'");
										
										while ($row = mysql_fetch_assoc($result)){
										    // main variables
										    $img = $row['img'];
										    $makerNo = $row['makerNo'];
										    $maker = $row['maker'];
										    $series = $row['series'];
										}
										if($img != '' OR $img != '0' OR $img != ' '){
										echo "<img src='http://www.tform.co.jp/".$img."' style='width: 400px;'>";
										} else {
										     echo "<li class='fa fa-picture-o' style='font-size: 100px; color: #CCC;'></li><br>";
										}
										
										
										echo "
		<form action='$path/p_Calculation/exe/exeCurrentPlEdit.php' method='post'>
		$tformNo<br>
		<input type='hidden' name='tformNo' value='$tformNo'>
		<input type='hidden' name='search' value='$search'>
		<input type='hidden' name='id' value='$id'>
		MakerNo: <span style=' font-size: 11px; color: red;'>$makerNo<br></span>
		Maker: <span style=' font-size: 11px; color: red;'>$maker<br></span>
		Series: <span style=' font-size: 11px; color: red;'>$series<br><br></span>
		
		
		
			新しい価格入れてください <span style='color: green;'>➡</span><input type='text' name='newPrice' value='$plCurrent'>
			<br>
			<input type='submit' value='決定' class='submit' style='float: left;'>
		</form>";
		
		?>
		<input type="button" value="キャンセル"
		style='float: left; padding: 2px; margin-left: 5px;'
		class='cancelBtn'
		onClick="location.href='setTermsAndConditions.php?search=<?php echo $search;?>&pr=1'">
								</div>
						</div>
						<!-- DATA FINISHED -->
				</div>
		</div>

</body>
</html>
