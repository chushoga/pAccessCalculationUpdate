<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title;?></title>
<?php
include_once '../master/config.php'; ?>
<script type="text/javascript">
$(document).ready( function() {
	$('.contents').show(); // use with pageLoader()
	$('#ajax-loading').delay(100).fadeOut(600); // use with pageLoader()
		} );
</script>

<style type="text/css">
.contents {
    display: none;
    }
</style>
</head>
<body>
	<div id='wrapper'>
    	<?php require_once '../header.php';?>
    	<?php pageLoader();?>
    	<div class='contents'>
    		<!-- PAGE CONTENTS START HERE -->
    		<div class='fullBox' style='background-color: #FFF; min-height: 500px;'>
    		

    		
    		<h1>INDEX</h1>
  
    		
								<img src='<?php echo $path;?>/img/readme_img/readme1.jpg' style='width: 100%;'>
								<p style='text-align: center;'>1.FMファイル⇒エクスポート</p>
								<br>
								<img src='<?php echo $path;?>/img/readme_img/readme2.jpg' style='width: 100%;'>
								<p style='text-align: center;'>2.スキップ</p>
								<br>
								<img src='<?php echo $path;?>/img/readme_img/readme3.jpg' style='width: 100%;'>
								<p style='text-align: center;'>PRODUCT_NUMBER_FULL</p>
								<p style='text-align: center;'>商品名＿和文</p>
								<p style='text-align: center;'>メーカー名＿欧文</p>
								<p style='text-align: center;'>シリーズ名＿欧文</p>
								<p style='text-align: center;'>メーカー品番</p>
								<p style='text-align: center;'>Tform価格</p>
								<p style='text-align: center;'>＿セット構成部品品番::構成部品品番</p>
								<p style='text-align: center;'>PRODUCT_FILENAME</p>
								<p style='text-align: center;'>伝票詳細表記</p>
								<p style='text-align: center;'>WEB表示</p>
								
								<br>
								<img src='<?php echo $path;?>/img/readme_img/readme4.jpg' style='width: 100%;'>
								<p style='text-align: center;'>4.右クリックコードを表示する</p>
								<br>
								<p>FILEMAKERマクロダウンロード<a href='FILEMAKER_MACRO.bas' style='color: #0099FF; font-size: 20px;'> 右クリック、リンク先保存</a></p><br>
								<img src='<?php echo $path;?>/img/readme_img/readme5.jpg' style='width: 100%;'>
								<p style='text-align: center;'>5.ファイル⇒ファイルインポート</p>
								<br>
								<img src='<?php echo $path;?>/img/readme_img/readme6.jpg' style='width: 100%;'>
								<p style='text-align: center;'>6.MODULE1ダブルクリックプレイ押します※一回だけでしばらくお待ちください。</p>
								<br>
								<img src='<?php echo $path;?>/img/readme_img/readme7.jpg' style='width: 100%;'>
								<p style='text-align: center;'>7.DONE!</p>
								<br>
								<img src='<?php echo $path;?>/img/readme_img/readme8.jpg' style='width: 100%;'>
								<p style='text-align: center;'>1.名前付けて保存。</p>
								<p style='text-align: center;'>2.CSV</p>
								<br>
								<img src='<?php echo $path;?>/img/readme_img/readme9.jpg' style='width: 100%;'>
								<p style='text-align: center;'>9.プログラムから開く（メモで）</p>
								<br>
								<img src='<?php echo $path;?>/img/readme_img/readme10.jpg' style='width: 100%;'>
								<p style='text-align: center;'>1.名前付けて保存。</p>
								<p style='text-align: center;'>1.UTF-8</p>
								<p style='text-align: center;'>1.すべてのファイル。</p>
								<br>
								<img src='<?php echo $path;?>/img/readme_img/readme11.jpg' style='width: 100%;'>
								<p style='text-align: center;'>1.CHOOSE FILE</p>
								<p style='text-align: center;'>2.アップロード</p>
								<br>
								
								
								</div>
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>
</body>
</html>