<?php require_once 'master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
a {
		text-decoration: none;
		color: #000;
}

a:hover {
		color: RED;
}
. {
	margin: auto;
}
.menuBarIndex button {
	width: 100%;
	height: 30px;
}
.menuBarIndex img {
	display: block;
    margin-left: auto;
    margin-right: auto;
    width: 64px;
}
.bonus_entry_progress {
    border: solid 1px;
    width: 200px;
    height: 18px;
    
}
 
.bonus_entry_bar {
   background: #d80000;
background: -moz-linear-gradient(left,  #d80000 22%, #8fc400 53%);
background: -webkit-gradient(linear, left top, right top, color-stop(22%,#d80000), color-stop(53%,#8fc400));
background: -webkit-linear-gradient(left,  #d80000 22%,#8fc400 53%);
background: -o-linear-gradient(left,  #d80000 22%,#8fc400 53%);
background: -ms-linear-gradient(left,  #d80000 22%,#8fc400 53%);
background: linear-gradient(to right,  #d80000 22%,#8fc400 53%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d80000', endColorstr='#8fc400',GradientType=1 );

} 
 
.bonus_progress_text {
    position: relative;
    top:-17px; 
    left: 5px;
    font-size: 10px;
    
    }
</style>
<script type="text/javascript">
$(window).on('resize', function () {
	  allRecords.fnAdjustColumnSizing();
	  window.alert("test");
	} );
</script>
<?php 
$progress = 80;

require_once 'master/config.php';
require_once 'functions/function.php';
 require_once 'functions/generalJavascriptFunctions.php';
?>
</head>
<body>
<div id='wrapper'>
<div class='menuBarIndex' style='width: 200px; margin-left: auto; margin-right: auto; margin-top: 100px;'>
<br>
<img alt="pAccess" src="img/logo.png">
<br>
pAccess(tformプログラムアクセス)
<br><br>

	<!-- <button onClick="window.open('p_tfProject/tfProject.php?pr=0','mywindow3','width=1905,height=980, top=0, left=0, resizable=yes')" value='' class='submit'>TFプロジェクト</button> -->
	<br>
	<br>
	<button onClick="window.open('p_Calculation/calculation.php?pr=1', 'BaseWindow1', 'width=1905,height=980, top=0, left=0, resizable=yes')" class='clearAll'>販売価格設定</button>
	<br>
	<br>
	<button onClick="window.open('p_tfProject/tfProject.php?pr=2', 'BaseWindow2', 'width=1905,height=980, top=0, left=0, resizable=yes')" class='update'>tformプロジェクト</button>
	<br>
	<br>
	<button onClick="window.open('p_expense/expense.php?pr=3', 'BaseWindow3', 'width=1905,height=980, top=0, left=0, resizable=yes')" class='go'>オーダー別経費計算</button>
	<br>
	<br>
	<button onClick="window.open('p_order/order.php?pr=4', 'BaseWindow4', 'width=1905,height=980, top=0, left=0, resizable=yes')" class='calcBtn'>オーダー別単価計算</button>
	<br>
	<br>
	<button onClick="window.open('../productViewer/guiInterface.php', 'BaseWindow5', 'width=1905,height=980, top=0, left=0, resizable=yes')" class='husslBtn'>HUSSL仕上・色シミュレータ</button>
	<br>
	<br>
	<br>
	<br>
	<!-- 
<div class="bonus_entry_progress">
    <div class="bonus_entry_bar" style="width:<?php echo $progress ?>%">
        &nbsp;
    </div>
    <div class="bonus_progress_text">
        <?php echo 'progress' ?>: <?php echo $progress ?>%
    </div>
</div> -->

</div>

<!--
<button class='go'> go </button>
<button class='update'> update </button>
<button class='clearAll'> clearAll </button>
<button class='submit'> submit </button>
<button class='upload'> upload </button>
<button class='printBtn'> printBtn </button>
<button class='saveBtn'> saveBtn </button>
<button class='editBtn'> editBtn </button>
<button class='calcBtn'> calcBtn </button>
<button class='delBtn'> delBtn </button>
<button class='delEntryBtn'> del </button>
<button class='cancelBtn'> cancel </button>
<button class='saveSmallBtn'> save </button>
-->
</div>
</body>
</html>
