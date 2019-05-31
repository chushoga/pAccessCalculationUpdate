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
	/*DATATABLES START*/
	var defaultOptions = {
			  "bJQueryUI": true,
				"sPaginationType": "full_numbers",
				"sScrollX" : "100%",
				"aaSorting": [[0, 'desc']],
				"iDisplayLength": 100
				};//options
	var calcDataTableHeight = function() {
		// navi: 20px + uiToolbar: 38px + thHeight: 25px + toolBarFooter: 40px; = 123px 
	    var navi = 20;
	    var uiToolbar = 38;
	    var thHeight = 28;
	    var toolBarFooter = 43;
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
		} );
</script>
<style type="text/css">
</style>
</head>
<body>
	<div id='wrapper'>	
    	<?php require_once '../header.php';?>
    	<div class='contents'>
    		<!-- PAGE CONTENTS START HERE -->
    		<!-- showGeneralHistory -->

    		<table id='allRecords'>
    		<thead>
    		<tr>
    		<th>アクション</th>
    		<th>メモ</th>
    		<th>日付</th>
    		</tr>
    		</thead>
    		<tbody>
            <?php
    		//echo "<h3>修正履歴</h3>";
    		    $result = mysql_query("SELECT * FROM `sp_history_general`");
    		    while ($row = mysql_fetch_assoc($result)){
    		        switch ($row['action']){
    		            case 'INS':
    		                $color = 'green'; 
    		                break;
    		            case 'UPD':
		                    $color = 'blue';
		                    break;
	                    case 'DEL':
		                    $color = 'red';
		                    break;
	                    default:
	                        $color = '#000';
	                        break;
    		        }
    		        
    		        echo " <tr>";
    		         echo "<td>".$row['created']."</td>";
    		        echo "<td style='color: $color;'>".$row['action']."</td>";
    		        echo "<td style='text-align: left;'>".$row['memo']."</td>";
    		       
    		        echo " </tr>";
    		    }
            ?>
           
            </tbody>
            </table>

    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>