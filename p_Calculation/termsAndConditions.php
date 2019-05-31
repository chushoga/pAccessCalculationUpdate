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
				"bPaginate": false,
				"sPaginationType": "full_numbers",
				"sScrollX" : "100%",
				"iDisplayLength": 100
				};//options
	var calcDataTableHeight = function() {
		// navi: 20px + uiToolbar: 38px + thHeight: 25px + toolBarFooter: 40px; = 123px 
	    var navi = 20;
	    var topBlock = 200;
	    var tableHeader = 38;
	    var thHeight = 31;
	    var toolBarFooter = 40;
	    var minusResult = navi + topBlock + thHeight + tableHeader + toolBarFooter;
	    var h = Math.floor($(window).height() - minusResult);
	    return h + 'px';
	};
	defaultOptions.sScrollY = calcDataTableHeight();
	
	var oTable = $('#bottomTable').dataTable(defaultOptions);

	 $(window).bind('resize', function () {
		 $('div.dataTables_scrollBody').css('height',calcDataTableHeight());
			oTable.fnAdjustColumnSizing();
	  } );
/*DATATABLES END*/
		} );
</script>
<style type="text/css">
.topBlock{
	width: 1600px;
	height: 200px;
	margin-left: auto;
	margin-right: auto;
	background-color: #CCC;
	}
.topBlockHalf{
	width: 50%;
	background-color: #CCC;
	float: left;
	height: 200px;
}
.bottomBlock {
	width: 1600px;
	height: auto;
	margin-left: auto;
	margin-right: auto;
	background-color:#FFF;
	}
.bottomBlock table{
	width: 100%;
	}
.termsAndConditionsTopTableWrapper {
	width: 100%;
	height: auto;
	margin-top: 10px;
	background-color: #CCC;
	}
	
.termsAndConditionsTopTableWrapper th{
	max-width: 75px;
	text-align: right;
	padding-right: 10px;
	}	
.termsAndConditionsTopTableWrapper td{
	text-align: right;
	padding-right: 10px;
	}
.termsAndConditionsTopTableWrapper table{
	width: 500px;
	background-color: #FFF;
	margin-left: auto;
	margin-right: auto;
}		
.termsAndConditionsTopTableWrapper input[type=text]{
	width: 100%;
	height: 24px;
}
.termsAndConditionsTopTableWrapper select{
	width: 100%;
	height: 24px;
}
.hitsuyou {
	color: red;
	}
</style>
</head>
<body>
	<div id='wrapper'>	
    	<?php require_once '../header.php';?>
    	<div class='contents'>
    		<!-- PAGE CONTENTS START HERE -->
    		<div class='topBlock'>
    		<form name='inputForm' id='termsAndConditionsInputForm' method='post' action='exe/exeTermsAndConditions.php'
										onsubmit="return validateTermsAndConditionsForm()">
    			<div class='topBlockHalf'>
        			<div class="termsAndConditionsTopTableWrapper">
                		<table>
                    			<tr><th><span class='hitsuyou'>※</span>メーカー</th><td><input type='text' name='maker' value='' style='width: 50%; float:left;'>色: <input type='color' name='colorId' value='#000000'></td>
                    			<tr><th><span class='hitsuyou'>※</span>年(例：1970)</th><td><input type='text' name='year' maxlength="4" size="4"></td></tr>
                    			<tr><th><span class='hitsuyou'>※</span>メモ(N45,PL2014...)</th><td><input type='text' name='memo'></td></tr>
                    			<tr><th><span class='hitsuyou'>※</span>レート(￥)</th><td><input type='text' name='rate'></td></tr>
                    			<tr><th><span class='hitsuyou'>※</span>パーセント(%)</th><td><input type='text' name='percent'></td></tr>
                    			<tr><th><span class='hitsuyou'>※</span>NET条件</th><td>
                    			<select name="netTerm">
    								<option value="">選ぶ</option>
    								<option value="EXW" >EXW</option>
    								<option value="FOB">FOB</option>
    								<option value="FCA">FCA</option>
    								<option value="DDU">DDU</option>
    							</select>
                    			</td></tr>
                    	</table>
            		</div>
    			</div>
    			<div class='topBlockHalf'>
        			<div class="termsAndConditionsTopTableWrapper">
            			<table>
            					<tr><th><span class='hitsuyou'>※</span>通貨</th><td>
                					<select name="currency">
    									<option value="">選ぶ</option>
    									<option value="EUR">€ EUR</option>
    									<option value="USD">$ USD</option>
    									<option value="YEN">￥ YEN</option>
    									<option value="RMB">元 RMB</option>
    								</select>
            					</td></tr>
                    			<tr><th><span class='hitsuyou'>※</span>割引条件1(%)</th><td><input type='text' name='sp1'></td></tr>
                    			<tr><th>割引条件2(%)</th><td><input type='text' name='sp2'></td></tr>
                    			<tr><th>割引条件3(%)</th><td><input type='text' name='sp3'></td> </tr>
                    			<tr><th>割引条件4(%)</th><td><input type='text' name='sp4'></td></tr>
                    			<tr><th>割引条件5(%)</th><td><input type='text' name='sp5'></td></tr>
							
                		</table>
            		</div>
    			</div>
    		</form>
    		</div>
    		
    		
    		
    		<div class='bottomBlock' id='saveWrapper'>

    			<table id='bottomTable'>
    				<thead>
            			<tr>
                			<th>id</th>
                			<th>メーカー</th>
                			<th>年</th>
                			<th>メモ</th>
							<th>色</th>
                			<th>レート</th>
                			<th>パーセント</th>
                			<th>NET条件</th>
                			<th>通貨</th>
                			<th>割引条件(s1,s2,s3,s4,s5)</th>
                			<th>修正</th>
                			<th>削除</th>
                			
            			</tr>
    				</thead>
    				<tbody>
    				<?php 
    				$result = mysql_query("SELECT * FROM `sp_disc_rate`");
    				while ($row = mysql_fetch_assoc($result)){?>
            			<tr>
							<?php 
						  	echo "
								<td>".$row['id']."</td>
								<td>".$row['maker']."</td>
								<td>".$row['year']."</td>
								<td>".$row['memo']."</td>
								<td style='background: ".$row['colorId'].";'>".$row['colorId']."</td>
								<td>".$row['rate']."</td>
								<td>".$row['percent']."%</td>
								<td>".$row['netTerm']."</td>
								<td>".$row['currency']."</td>
								<td>".$row['discountPar']."%(".$row['sp1Par']."%";
															   
								//DISPLAY PERCENTAGES IF NOT 0
								if ($row['sp2Par'] > 0){
								echo ", %".$row['sp2Par'];
								}
								if ($row['sp3Par'] > 0){
								echo ", %".$row['sp3Par'];
								}
								if ($row['sp4Par'] > 0){
								echo ", %".$row['sp4Par'];
								}
								if ($row['sp5Par'] > 0){
								echo ", %".$row['sp5Par'];
								}
                        		echo ")";
							?>
                			</td>
                			<td><a href ='editTermsAndConditions.php?pr=1&id=<?php echo $row['id']?>'><i class='fa fa-cog' style='color: green;'></i></a></td>
                			<td style='text-align: center;'>
                    			<a href ='del/delTermsAndConditions.php?id=<?php echo $row['id']?>' onclick='return confirmAction()' style='color: red; font-size: 14px;'>
                    				<li class='fa fa-times'></li>
                    			</a>
                			</td>
            			</tr>
        			<?php } ?>
        			</tbody>
        		</table>
        		
    		</div>

    		<div class='clear'></div>
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>