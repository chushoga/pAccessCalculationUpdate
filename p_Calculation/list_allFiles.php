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
	/*DATATABLES START*/
	var defaultOptions = {
			  "bJQueryUI": true,
				"sPaginationType": "full_numbers",
				"sScrollX" : "100%",
				 "order": [[ 2, "asc" ]],
				"iDisplayLength": 100
				};//options
	var calcDataTableHeight = function() {
		// navi: 20px + uiToolbar: 38px + thHeight: 25px + toolBarFooter: 40px; = 123px 
	    var navi = 20;
	    var uiToolbar = 38;
	    var thHeight = 31;
	    var toolBarFooter = 40;
	    var minusResult = navi + uiToolbar + thHeight + toolBarFooter;
	    var h = Math.floor($(window).height() - minusResult);
	    return h + 'px';
	};
	defaultOptions.sScrollY = calcDataTableHeight();
	
	var oTable = $('#allRecords').dataTable(defaultOptions);

	 $(window).bind('resize', function () {
		 $('div.dataTables_scrollBody').css('height',calcDataTableHeight());
		oTable.fnAdjustColumnSizing();
	  } );
/*DATATABLES END*/
	// LOADING
		$('#loading').delay(300).fadeOut(300);
		} );
</script>
<style type="text/css">
	/* Push */
	@-webkit-keyframes push {
	  50% {
		-webkit-transform: scale(0.95);
		transform: scale(0.95);
	  }

	  100% {
		-webkit-transform: scale(1);
		transform: scale(1);
	  }
	}

	@keyframes push {
	  50% {
		-webkit-transform: scale(0.95);
		transform: scale(0.95);
	  }

	  100% {
		-webkit-transform: scale(1);
		transform: scale(1);
	  }
	}

	.listSelectButton {
		width: 100%;
		height: 40px;
		border: none;
		background: lightSkyBlue;
	}
	
	

</style>
	
	<script>
		$(document).ready(function(){
			$(".listSelectButton").on("mouseover", function(){
				$(this).closest("tr").css({"opacity":"0.5"})
			});
			
			$(".listSelectButton").on("mouseleave", function(){
				$(this).closest("tr").css({"opacity":"1"})
			});
		});
	
	</script>
	
</head>
<body>
	
<?php //variables
if (isset($_GET['search'])==true){
    $search = $_GET['search'];
    } else {
$search = "";
    }

?>
	<div id='wrapper'>	
	<div id='loading'>
			<span class='loadingGifMain'> <img src='<?php echo $path;?>/img/142.gif'><br> LOADING ... </span>
		</div>
    	<?php require_once '../header.php';?>
    	<div class='contents'>
    		<!-- PAGE CONTENTS START HERE -->
    		<div style='width: 100%; margin-right: auto; margin-left: auto; font-size: 12px; background-color: #FFF;'>
                <table id='allRecords'>
                        <thead>
                            <tr>
                                <th>id</th>
                                <!-- <th style='color: white; background-color: red;'>新規layout</th> -->
                                <th>ロック</th>
                                <th>メーカー</th>
                                <th>リスト名</th>
                                
                                <th>作成日</th>
                                <th>リスト削除</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $result = mysql_query("SELECT id, maker, listName, created, locked FROM `makerlistcontents` WHERE `listName` LIKE '%$search%' || `listName` LIKE '%$search%'") or die(mysql_error());
                        while ($row = mysql_fetch_assoc($result)){
                            $id = $row['id'];
                            $maker = $row['maker'];
                            $listName = $row['listName'];
                            
                            $created = $row['created'];
                            $locked = $row['locked'];


                            echo "<tr>";
                            echo "<td><a href='list_calculation.php?pr=1&id=".$listName."'><button class='listSelectButton'>".$id."</button></a></td>";
                          //echo "<td><a href='list_single.php?pr=1&id=".$listName."'><button style='width: 100%; height: 20px; background-color: pink;'>".$id."</button></a></td>";
                            echo "<td><a href='exe/exeSetListLock.php?id=".$id."'>
                                    <div style='width: 100%; color: #555555;'>";
                            if ($locked == 0){
                                echo "<i class='fa fa-lock'></i>";
                            } else {
                                echo "<i class='fa fa-unlock'></i>";
                            }
                            echo "</div>
                                  </a></td>";
                            echo "<td>".$maker."</td>";
                            echo "<td>".$listName."</td>";
                            
                            echo "<td>".$created."</td>";
                            echo "<td>";
                            if ($locked == 0){
                                     echo "<div style='width: 100%; background-color: #DDD; color: #FFF;'> 
                                            <i class='fa fa-times'></i>
                                        </div>
                                    ";
                                } else {

                                    echo " 
                                    <a href='exe/exeSetListDelete.php?listName=".$listName."&id=".$id."' onClick='return confirm(\"リストは完全に削除しますか？リストは戻せないけどいいでしょうか？\")'>
                                        <div style='width: 100%; background-color: red; color: #FFF;'>
                                            <i class='fa fa-times'></i>
                                        </div>
                                    </a>
                                    ";

                                }

                            echo "</td>";

                            //discount Rate
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                </table>
        </div>
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>