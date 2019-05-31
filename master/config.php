<!-- CSS LINK START -->
<link rel="stylesheet" href="<?php echo $path;?>/css/font-awesome.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/fonts.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/general.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/navi.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/buttons.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/spinner.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/jquery.dataTables.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/jquery.dataTables_themeroller.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/tables.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/about.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/messages.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/expense/expense.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/calculation/calculation.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/calculation/plUpload.css">
<link rel="stylesheet" href="<?php echo $path;?>/css/pace.css">

<!-- JAVASCRIPT START -->
<!-- JQUERY JS -->
<script type="text/javascript" src="<?php echo $path;?>/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo $path;?>/js/jquery-ui.js"></script>

<!-- OTHER JS -->
<script type="text/javascript" src="<?php echo $path;?>/js/excellentexport.js"></script>
<script type="text/javascript" src="<?php echo $path;?>/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo $path;?>/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="<?php echo $path;?>/js/dataTables.jqueryui.js"></script>
<script type="text/javascript" src="<?php echo $path;?>/js/jquery.quickfit.js"></script>
<script type="text/javascript" src="<?php echo $path;?>/js/fieldChooser.js"></script>
<script type="text/javascript" src="<?php echo $path;?>/js/pace.min.js"></script><!-- PACE progress bar -->

<!-- FAVICON -->
<link rel='shortcut icon' href='<?php echo $path;?>/img/favicon.ico?v=2' type='image/x-icon' />

<?php
//SET BASE PAGE FILE NAME:
$baseName = basename($_SERVER['PHP_SELF']);

//SET IMAGE LOCATION
$filemakerImageLocation = "http://160.86.229.76/db_img/";

//SET LANGUAGE
$languageChoice = 0;
$languageResult = mysql_query("SELECT * FROM `settings` WHERE `id` = '1'");
while ($languageRow = mysql_fetch_assoc($languageResult)){
    $languageChoice = $languageRow['language'];
}
if ($languageChoice == 1){
    echo "<link rel='stylesheet' href='$path/css/japaneseFont.css'>";
    }
?>
