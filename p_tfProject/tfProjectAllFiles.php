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
});
</script>
</head>
<body>

	<div id='wrapper'>
	<script type="text/javascript">function doSomething(){
	    alert('hi');
	}</script>
    	<?php require_once '../header.php';?>
    	<div class='contents'>
    		<!-- PAGE CONTENTS START HERE -->
    		<div style='width: 100%; margin-right: auto; margin-left: auto; font-size: 12px; background-color: #FFF;'>
										<table id='allRecords'>
												<thead>
														<tr>
																<th>id</th>
																<th>プロジェクト名</th>
																<th>現場住所</th>
																<th>date</th>
														</tr>
												</thead>
												<tbody>

												<?php
												$result = mysql_query("SELECT * FROM tfProject") or die(mysql_error());
												while ($row = mysql_fetch_assoc($result)){
												   
												    echo "<tr>";
												    echo "<td><a href='tfProject.php?pr=2&id=".$row['id']."'><button style='width: 100%; height: 20px; '>".$row['id']."</button></a></td>";
												    echo "<td>".$row['projectName']."</td>";
												    echo "<td>".$row['place']."</td>";
												    echo "<td>".$row['date']."</td>";
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

