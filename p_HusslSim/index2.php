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

</head>
<body>
	<div id='wrapper'>	
    	<?php require_once '../header.php';?>
    	<div class='contents'>
    		<!-- PAGE CONTENTS START HERE -->
    		
    		
    		
            <a href='#' id='currencyBtn_1'>LEATHER</a><br>
            <a href='#' id='currencyBtn_2'>CLOTH</a><br>
            <a href='#' id='currencyBtn_3'>WOOD</a><br>
 
            <svg version="1.1" id="&#x30EC;&#x30A4;&#x30E4;&#x30FC;_1"
            	 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="105.513px"
            	 height="80.789px" viewBox="0 0 105.513 80.789" style="enable-background:new 0 0 105.513 80.789;" xml:space="preserve">
             	 <defs>
                    <pattern id='frame' patternUnits='userSpaceOnUse' width='10' height='10'>
                        <image xlink:href='beech_bleached_clear_lacquered.jpg' x='0'y='0'width='10px'height='10px' />
                    </pattern>
                </defs>
            <polygon style="fill:url(#frame); stroke:#060001;stroke-width:0.15;" points="64.392,52.845 0.878,79.872 23.175,20.413 104.256,0.818 "/>
            </svg>
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>
	<?php require_once '../master/footer.php';?>
	<?php for($i=0;$i<10;$i++){?>
	<script type="text/javascript">
    		 $("a#currencyBtn_<?php echo $i;?>").click(function(){
    			 var value = $('#frame image');
    			 value.attr('xlink:href', '17113nero.jpg');
    		});
	</script>
	<?php }?>
</body>
</html>