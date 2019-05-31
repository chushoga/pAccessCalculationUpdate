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
	 $(function() {
		    $.widget( "custom.iconselectmenu", $.ui.selectmenu, {
		      _renderItem: function( ul, item ) {
		        var li = $( "<li>", { text: item.label } );
		 
		        if ( item.disabled ) {
		          li.addClass( "ui-state-disabled" );
		        }
		 
		        $( "<span>", {
		          style: item.element.attr( "data-style" ),
		          "class": "ui-icon " + item.element.attr( "data-class" )
		        })
		          .appendTo( li );
		 
		        return li.appendTo( ul );
		      }
		    });

		    $( "#legOptions" )
		      .iconselectmenu()
		      .iconselectmenu( "menuWidget")
		        .addClass( "ui-menu-icons avatar" );
		    $( "#backOptions" )
		    .iconselectmenu()
		    .iconselectmenu( "menuWidget")
		      .addClass( "ui-menu-icons avatar" );
		    $( "#seatOptions" )
		    .iconselectmenu()
		    .iconselectmenu( "menuWidget")
		      .addClass( "ui-menu-icons avatar" );
		  });
	 $('#loading').delay(300).fadeOut(300);
		$("button").click(function(e) {
			   $("select[name=search]").find("option[selected]").next()
			   .prop("selected",true);
			});
		} );
</script>

  <style>
  
.clear {
		clear: both;
}

#leftWrapper {
	position: fixed;
	background-color: #FFF;
	left: 0px;
	top: 0px;
	bottom: 0px;
	width: 50%;
}


#rightWrapper {
	position: fixed;
	left: 50%;
	top: 0px;
	bottom: 0px;
	width: 50%;
	overflow: auto;
}
.chairWrapper {
	width: 400px;
	margin-right: auto;
	margin-left: auto;
	margin-bottom: 10px;
}
.chairContainer {
		width: 400px;
		margin-right: auto;
		margin-left: auto;
}

.chairInfo {
		width: 100%;
		height: 100%;
		border-top: 1px solid #000;
		font-size: 12px;
}
.chairInfoTableTop{
	margin-left: auto; 
	margin-right: auto;
	text-align: center;
}
.chairInfoTableBottom td {
	border: 1px solid #CCC;
	width: 100%;
	padding: 2px;
	padding-left: 4px;
}
.chairInfoTableBottom th {
	padding-right: 2px;
	padding-left: 4px;
}
.chairInfo th {
	font-weight: normal;
}
.chairInfo img {
		width: 100px;
}
.chairInfo select {
	width: 100px;
}
#loading {
	position: fixed;
	z-index: 9000;
	width: 100%;
	height: 100%;
	background-color: #FFF;
}

.loadingGifMain {
	background-color: #FFF;
	width: 150px;
	height: 10px;
	position: absolute;
	left: 50%;
	top: 50%;
	margin-left: -75px;
	margin-top: -10px;
	text-align: center;
}
  </style>
<style type="text/css">
.partsBox h2 {
background: #9e9e9e;
background: -moz-linear-gradient(top,  #9e9e9e 0%, #959595 50%, #8c8c8c 51%, #999999 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#9e9e9e), color-stop(50%,#959595), color-stop(51%,#8c8c8c), color-stop(100%,#999999));
background: -webkit-linear-gradient(top,  #9e9e9e 0%,#959595 50%,#8c8c8c 51%,#999999 100%);
background: -o-linear-gradient(top,  #9e9e9e 0%,#959595 50%,#8c8c8c 51%,#999999 100%);
background: -ms-linear-gradient(top,  #9e9e9e 0%,#959595 50%,#8c8c8c 51%,#999999 100%);
background: linear-gradient(to bottom,  #9e9e9e 0%,#959595 50%,#8c8c8c 51%,#999999 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9e9e9e', endColorstr='#999999',GradientType=0 );

color: #FFF;
padding-left: 10px;
font-weight: normal;
font-size: 12px;
}

.partsBox {
background: #f6f8f9;
background: -moz-linear-gradient(top,  #f6f8f9 0%, #EDEDED 100%, #f5f7f9 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f6f8f9), color-stop(100%,#EDEDED), color-stop(100%,#f5f7f9));
background: -webkit-linear-gradient(top,  #f6f8f9 0%,#EDEDED 100%,#f5f7f9 100%);
background: -o-linear-gradient(top,  #f6f8f9 0%,#EDEDED 100%,#f5f7f9 100%);
background: -ms-linear-gradient(top,  #f6f8f9 0%,#EDEDED 100%,#f5f7f9 100%);
background: linear-gradient(to bottom,  #f6f8f9 0%,#EDEDED 100%,#f5f7f9 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f6f8f9', endColorstr='#f5f7f9',GradientType=0 );
}




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

    	<?php
//variables
if(isset($_GET['search'])){
    $search = $_GET['search'];
} else {
    $search = "ST3N-0";
}

//$fileName = "ST4N1AP";
$fileName = $search;
//$fileName = "ST4N-G";
$productName = $fileName;
$backFab = "img/defaultBlue.jpg";
$seatFab = "img/defaultBlue.jpg";
//$seatFab = "CSP31_Vincennes2.jpg";
$frameFab = "img/defaultBlack.jpg";

$back = "<image xlink:href='".$backFab."' x='0'y='0'width='15px'height='15px'/>";
$seat = "<image xlink:href='".$seatFab."' x='0' y='0' width='15px' height='15px' />";
$frame = "<image xlink:href='".$frameFab."' x='0' y='0' width='15px' height='15px' />";
$stroke = "stroke:#000000;stroke-width:0.15;";

$pattern ="
	 <defs>
        <pattern id='back' patternUnits='userSpaceOnUse' width='15' height='15'>
            ".$back."
        </pattern>
        <pattern id='seat' patternUnits='userSpaceOnUse' width='15' height='15'>
            ".$seat."
        </pattern>
        <pattern id='frame' patternUnits='userSpaceOnUse' width='15' height='15'>
            ".$frame."
        </pattern>
    </defs>";

//more variables

			//MATS
				$resultMats = mysql_query("SELECT * FROM `main_hussl_c_mats` WHERE `makerNo` = '$search'");
				while ($rowMats = mysql_fetch_assoc($resultMats)){
				    $series = $rowMats['series'];
				    $frame = $rowMats['frame'];
				    $seat = $rowMats['seat'];
				    $back = $rowMats['back'];
				    $w = $rowMats['w'];
				    $d = $rowMats['d'];
				    $h = $rowMats['h'];
				    $sh = $rowMats['sh'];
				    $stacking = $rowMats['stacking'];
				    $img = $rowMats['img'];    
				}
				//COLORS
				$frameColors = explode(",", $frame);
				$seatColors = explode(",", $seat);
				$backColors = explode(",", $back);

?>

<div id='leftWrapper'>


		<div class='chairWrapper'>
				<div class='chairContainer'>
				<a href='husslContents.php'>椅子 HUSSL品番チェック</a><br>
				<a href='husslContentsTable.php'>テーブル HUSSL品番チェック</a><br>
				<br><hr><br>
				<?php 
				
				
				echo "<form action='' method='GET'>";
				echo "<select name='search'>";
				echo "<option>DEFAULT</option>";
				$selected = "";
				$resultSearch = mysql_query("SELECT * FROM `main_hussl_c_mats`");
				while ($rowSearch = mysql_fetch_assoc($resultSearch)){
				    if ($rowSearch['makerNo'] == $search){
				        $selected = "selected";
				    } else {
				        $selected = "";
				    }
				    echo "<option ".$selected.">".$rowSearch['makerNo']."</option>";
				}
				echo "</select>";
				echo "<input type='submit' class='submit'>";
				echo "<button style='margin-left: 10px; width: 50px;' class='submit'><i class='fa fa-arrow-right'></i></button>";
				echo "</form>";
				?>
				<br><hr><br>
				
				<h1 style='text-align: center;'><?php echo $productName;?></h1>
				<?php
				include("svg/".$fileName.".svg");

				echo "<br>";
				?>
				</div>
				<div class='chairInfo'>
						<table class='chairInfoTableTop'>
								<tr>
									<th>脚</th>
									<th>背</th>
									<th>座</th>
								</tr>
								<tr>
									<td><img alt="<?php echo $chairModel;?>"
											src="<?php echo $frameFab;?>" id='frameThumb'>
									</td>									
									<td><img alt="<?php echo $chairModel;?>"
											src="<?php echo $seatFab;?>" id='seatThumb'>
									</td>
									<td><img alt="<?php echo $chairModel;?>"
											src="<?php echo $backFab;?>" id='backThumb'>
									</td>
								</tr>
								<tr>
									<td>
									
									</td>
								</tr>
						</table>
						<br>
						<table class='chairInfoTableBottom'>
						<tr>
							<th>Tform品番: </th>
							<td>HJN04-1222-A01</td>
						</tr>
						<tr>
							
							<th>脚: </th>
							<td><input type='text' value='デフォルト' id='frameName' style='border: none; width: 100%; text-align: left;'></td>
							
						</tr>
						<tr>
							<th>座: </th>
							<td><input type='text' value='デフォルト' id='seatName' style='border: none; width: 100%; text-align: left;'></td>
						</tr>
						<tr>
							<th>背: </th>
							<td><input type='text' value='デフォルト' id='backName' style='border: none; width: 100%; text-align: left;'></td>
						</tr>
						</table>
						<br>
						合計:<span style='float:right; font-size: 18px; color: green; margin-right: 15px; margin-bottom: 10px;'>￥12,233</span>
						<div class='clear'></div>
				</div>
		</div>
	</div>
	
<div id='rightWrapper'>
<div style='width: 100%;' class='partsBox'>
<h2>脚</h2>
    <?php 
//FRAMECOLORS
$counter = 0;
$counterFrame = 0;
foreach($frameColors as $value => $key){
    //echo $key."<br>";
    $resultColors = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` = '$key'");
    while ($rowColors = mysql_fetch_assoc($resultColors)){
       if ($counter == 0){
        }
                echo "<div style='float: left; margin-left: 5px; width: 200px;'>";
                echo "<a href='#' id='frameBtn_".$counterFrame."'><img src='img/colorSample/".$rowColors['colorSample']."' style='width: 20px; margin-right: 3px;'>";
                echo $rowColors['variation']."</a>";
                echo "</div>";
     // check to see if 3 rows, if 3 the break line and reset counter, if not add to counter
        if ($counter == 2){
            echo "<div class='clear'></div>";
            $counter = 0;
        } else {
            $counter++;
        }
     //--------------------  $typeBefore = substr($rowColors['variationId'],0,-2);
     ?>
     	<script type="text/javascript">
    		 $("a#frameBtn_<?php echo $counterFrame;?>").click(function(){
    			 var value = $('#frame image');
    			 var valueThumb = $('#frameThumb');
    			 var valueName = $('#frameName');
    			 value.attr('xlink:href', '<?php echo "img/colorSample/".$rowColors['colorSample'];?>');
    			 valueThumb.attr('src', '<?php echo "img/colorSample/".$rowColors['colorSample'];?>');
    			 valueName.val('<?php echo $rowColors['variation'];?>');
    		});
	</script>	
     <?php 
     $counterFrame++; //frame counter
    }
}
 echo "<div class='clear'></div>";
?>  
</div>
<div style='width: 100%;' class='partsBox'>
	<h2>座</h2>
<?php 
//SEATCOLORS

$counter = 0;
$counterSeat = 0;
$typeBefore = "";
$typeAfter = "null";
foreach($seatColors as $value => $key){
    //echo $key."<br>";
    $resultColors = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` = '$key'");
    while ($rowColors = mysql_fetch_assoc($resultColors)){
        $typeBefore = substr($rowColors['variationId'],0,-2);
            //echo $type;
             if ($typeBefore != $typeAfter){
                echo "<div class='clear'></div><br><hr><br>";
                $counter = 0;
            }
            
                    echo "<div style='float: left; margin-left: 5px; width: 200px;'>";
                    echo "<a href='#' id='seatBtn_".$counterSeat."'><img src='img/colorSample/".$rowColors['colorSample']."' style='width: 20px; margin-right: 3px;'>";
                    echo $rowColors['variation']."</a>";
                   // echo $typeBefore." =? [".$typeAfter."]";
                    echo "</div>";
                
         // check to see if 3 rows, if 3 the break line and reset counter, if not add to counter
       
            if ($counter == 2){
                echo "<div class='clear'></div>";
                $counter = 0;
            } else {
                $counter++;
            }
           
            
        $typeAfter = $typeBefore;
     //--------------------  
     ?>
     	<script type="text/javascript">
    		 $("a#seatBtn_<?php echo $counterSeat;?>").click(function(){
    			 var value = $('#seat image');
    			 var valueThumb = $('#seatThumb');
    			 var valueName = $('#seatName');
    			 value.attr('xlink:href', '<?php echo "img/colorSample/".$rowColors['colorSample'];?>');
    			 valueThumb.attr('src', '<?php echo "img/colorSample/".$rowColors['colorSample'];?>');
    			 valueName.val('<?php echo $rowColors['variation'];?>');
    		});
	</script>	
     <?php
      
     $counterSeat++; //seat counter
    }
}

?>  
</div>
<div style='width: 100%;' class='partsBox'>
	<h2>背</h2>
<?php 
//SEATCOLORS

$counter = 0;
$counterBack = 0;
$typeBefore = "";
$typeAfter = "null";
foreach($backColors as $value => $key){
    $resultColors = mysql_query("SELECT * FROM `main_hussl_c_colors` WHERE `variationId` = '$key'");
    while ($rowColors = mysql_fetch_assoc($resultColors)){
        $typeBefore = substr($rowColors['variationId'],0,-2);
            //echo $type;
             if ($typeBefore != $typeAfter){
                echo "<div class='clear'></div><br><hr><br>";
                $counter = 0;
            }
            
                    echo "<div style='float: left; margin-left: 5px; width: 200px;'>";
                    echo "<a href='#' id='backBtn_".$counterBack."'><img src='img/colorSample/".$rowColors['colorSample']."' style='width: 20px; margin-right: 3px;'>";
                    echo $rowColors['variation']."</a>";
                   // echo $typeBefore." =? [".$typeAfter."]";
                    echo "</div>";
                
         // check to see if 3 rows, if 3 the break line and reset counter, if not add to counter
       
            if ($counter == 2){
                echo "<div class='clear'></div>";
                $counter = 0;
            } else {
                $counter++;
            }
           
            
        $typeAfter = $typeBefore;
     //--------------------  
     ?>
     	<script type="text/javascript">
    		 $("a#backBtn_<?php echo $counterBack;?>").click(function(){
    			 var value = $('#back image');
    			 var valueThumb = $('#backThumb');
    			 var valueName = $('#backName');
    			 value.attr('xlink:href', '<?php echo "img/colorSample/".$rowColors['colorSample'];?>');
    			 valueThumb.attr('src', '<?php echo "img/colorSample/".$rowColors['colorSample'];?>');
    			 valueName.val('<?php echo $rowColors['variation'];?>');
    		});
	</script>	
     <?php
      
     $counterBack++; //seat counter
    }
}

?>  
</div>
<div class='clear'></div>
<div style='width: 100%; height: 40%;' class='partsBox'>
	<h2>保存したスタイル</h2>
	
	<div style='width: 150px; height: 200px; margin-top: 15px; margin-right: 10px; float: left;'>	
	<?php include("svg/".$fileName.".svg");?>
	<br><h4 style='text-align: center;'>ST4N1AP</h4>
	</div>
	
	<div style='width: 150px; height: 200px; margin-top: 15px; margin-right: 10px; float: left;'>	
	<?php include("svg/".$fileName.".svg");?>	
	<br><h4 style='text-align: center;'>ST4N1A</h4>
	</div>
	
	<div style='width: 150px;  height: 200px; margin-top: 10px; margin-bottom: 10px; margin-right: 10px; float: left;'>	
	<?php include("svg/ST4N+HAPRV.svg");?>
	<br><h4 style='text-align: center;'>ST4N+HAPRV</h4>
		
	</div>
	<div class='clear'></div>
</div>
<br>
</div>
<div class='clear'></div>

    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>
	<?php require_once '../master/footer.php';?>

</body>
</html>