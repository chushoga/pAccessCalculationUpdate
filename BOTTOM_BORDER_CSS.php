<!DOCTYPE HTML>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title></title>
<?php
//SET STYLES HERE
if(isset($_POST['color1'])){
	$color1 = $_POST['color1'];
} else {
	$color1 = "#0A8EFA";
}
if(isset($_POST['color2'])){
	$color2 = $_POST['color2'];
} else {
	$color2 = "#0A8EFA";
}

?>

<style>

h1 {	
	color: #5E5E5E;
	margin-left: 20px;
	font-size: 12px;
}
.box1 {
	background: #FCFCFC; 
	border-left: 1px solid #CCC;
	border-right: 1px solid #CCC; 
	border-top: 1px solid #CCC; 
	margin:10px；
}
.box2 {
	width: 100%;
	height: 3px;	
	
background-image: -webkit-gradient(
	linear,
	left top,
	right top,
	color-stop(0.5, <?php echo $color1;?>),
	color-stop(0.5, <?php echo $color2;?>)
);
background-image: -o-linear-gradient(right, <?php echo $color1;?> 50%, <?php echo $color2;?> 50%);
background-image: -moz-linear-gradient(right, <?php echo $color1;?> 50%, <?php echo $color2;?> 50%);
background-image: -webkit-linear-gradient(right, <?php echo $color1;?> 50%, <?php echo $color2;?> 50%);
background-image: -ms-linear-gradient(right, <?php echo $color1;?> 50%, <?php echo $color2;?> 50%);
background-image: linear-gradient(to right, <?php echo $color1;?> 50%, <?php echo $color2;?> 50%);
}
</style>
</head>
<body>
<br>
<div>
	<form method="POST" action="">
		COLOR 1: <input type='text' name='color1' value='<?php echo $color1; ?>'><br>
		COLOR 2: <input type='text' name='color2' value='<?php echo $color2; ?>'><br>
		<input type='submit' value='決定'>
	</form>
	<br>
	<form method="POST" action="">
		<input type='submit' value='リセット'>
	</form>
</div>
<br><hr><br>
<div class='box1'>
<h1>
	テスト テスト<br><br>
</h1>
<div class="box2" style=''></div>
</div>

</body>
</html>