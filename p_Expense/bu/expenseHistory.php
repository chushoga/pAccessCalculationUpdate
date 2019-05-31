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
				"bPaginate": false,
				"bInfo": false,
				"iDisplayLength": 100
				};//options
	var calcDataTableHeight = function() {
		// navi: 20px + uiToolbar: 38px + thHeight: 25px + toolBarFooter: 40px; = 123px 
	    var navi = 20;
	    var uiToolbar = 38;
	    var thHeight = 31;
	    var toolBarFooter = 52;
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
  $(function() {
	  
	    $( "#from" ).datepicker({
		    dateFormat: 'yy-mm-dd',
	        defaultDate: "+1w",
	        changeMonth: true,
	        numberOfMonths: 3,
	        onClose: function( selectedDate ) {
	          $( "#to" ).datepicker( "option", "minDate", selectedDate );
	          
	        }
	      });
	      $( "#to" ).datepicker({
	    	dateFormat: 'yy-mm-dd',
	        defaultDate: "+1w",
	        changeMonth: true,
	        numberOfMonths: 3,
	        onClose: function( selectedDate ) {
	          $( "#from" ).datepicker( "option", "maxDate", selectedDate );
	        }
	      });
	    });
  $(function() {
	//  $('#from').datepicker({dateFormat: 'dd/mm/yy'});
});
		} );
</script>
<style type="text/css">
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 2px 10px;
  }
  
</style>
  <script>
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "すべて表示する" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },

      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
    $( "#combobox" ).combobox();
  });
  $(document).ready( function() {
	     $('#loading').delay(300).fadeOut(300);
			} );
  </script>
  <style type="text/css">
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
</head>
<body>
<?php 
//setVARIABLES
    if(isset($_GET['from'])){
        $from = $_GET['from'];
    } else {
        $from = '';
    }
    if(isset($_GET['to'])){
        $to = $_GET['to'];
    } else {
        $to = '';
    }
    if(isset($_GET['search'])){
            $search = $_GET['search'];
        
    } else {
        $search = '';
    }
   if ($search == 'すべて'){
       $normalSearch = "";
   } else {
       $normalSearch = "AND `tformNo` LIKE '%$search%'";
   }

	$saveFileName = $search."-".$from."_".$to;
	$savFileDate = $from."～".$to;
?>
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
    		<?php echo " [<span style='color: red;'> ".$from."</span> ~ <span style='color: green;'> ".$to."</span> | ".$search." ] ";?>
    		
    		<form method='GET' action='expenseHistory.php' style='float: right; margin: 2px;'>
    		<div style='float: left;'>
        		<label for="from">から <i class="fa fa-calendar"></i></label>
                <input type="text" id="from" name="from" value='<?php echo $from;?>' style='width: 80px; text-align: center;'>
                <label for="to">に <i class="fa fa-calendar"></i></label>
                <input type="text" id="to" name="to" value='<?php echo $to;?>' style='width: 80px; text-align: center;'>
               	  キーワード 
               	  </div>
               	  
               	  <div class="ui-widget" style='float: left; margin-right: 40px; margin-left: 10px;'> 
                  <select id="combobox" name='search'>
                  <option value='選ぶ'>選ぶ</option>
                  <option value='すべて'>すべて</option>
                  <?php 
                  //get all first chars from the order list
                  $makerArray[] = "";
                  $resultMakerSelect = mysql_query("SELECT DISTINCT `tformNo` FROM `order` ORDER BY `tformNo`");
                  while ($rowMakerSelect = mysql_fetch_assoc($resultMakerSelect)){
                     // echo $rowMakerSelect['tformNo']."<br>";
                     $inCheck = substr($rowMakerSelect['tformNo'], 0, -11);
                    
                      if(!in_array($inCheck, $makerArray)){
                      $makerArray[]= $inCheck;
                      }
                  }
                  echo"<br>";
                  foreach ($makerArray as $key){
                      //echo $key."<br>";
                      //to get the maker name
                        
                        $makerName = "";
                        $selected = "";
                        
                        $result = mysql_query("SELECT `orderNo` FROM `order` WHERE `tformNo` LIKE '%$key%'");
                		while ($row = mysql_fetch_assoc($result)){
                		    $orderMakerSetting = $row['orderNo'];
                		    for($i=1;$i<10;$i++){
                		        
                		         $result2 = mysql_query("SELECT `orderNo_$i`,`makerName_$i`  FROM `expense` WHERE `orderNo_$i` = '$orderMakerSetting'");
                		    while ($row2 = mysql_fetch_assoc($result2)){
                		        $makerName = strtoupper($row2['makerName_'.$i]);
                		        //echo $i." - ".$makerName."<br>";
                		    }
                		    }
                		   
                		}
                      //END to get the maker name
                      if ($search == $key){
                          $selected = "selected='selected'";
                      } else {
                          $selected = "";
                      }
                      echo " <option value='".$key."' ".$selected.">".$key." [ ".$makerName."]</option>";
                  }
                  
                  ?>
                   
                    
                  </select>
                </div>
                <div style='float: left;'>
               
               	 <!--  <input type="text" name="search" value='<?php echo $search;?>' style='width: 80px; text-align: center;'> -->
                <input type='hidden' name='pr' value='<?php echo $pr;?>' >
                <input type="submit" class='submit' value='検索'>
                </div>
                 <div style='clear: both;'></div>
			</form>
    		<?php 
	
//query to test if we can pull out records from the order tables.
            $makerName = "";
            $result = mysql_query("SELECT DISTINCT `orderNo` FROM `order` WHERE `date` BETWEEN '$from' AND '$to' $normalSearch ORDER BY `date`");
    		while ($row = mysql_fetch_assoc($result)){
    		    $orderMakerSetting = $row['orderNo'];
    		    for($i=1;$i<10;$i++){
    		        
    		         $result2 = mysql_query("SELECT * FROM `expense` WHERE `orderNo_$i` = '$orderMakerSetting'");
    		    while ($row2 = mysql_fetch_assoc($result2)){
    		        $makerName = strtoupper($row2['makerName_'.$i]);
    		        //echo $i." - ".$makerName."<br>";
    		    }
    		    }
    		   
    		}
	        ?>
	        <div id='saveWrapper'>
    		<table style='font-size: 9px; border-collapse: collapse;' id='allRecords'>
    		<thead>
        		<tr>
        			<th style='min-width: 100px;'><?php echo $makerName;?><br>メーカー品番</th>
        			<th style='min-width: 100px;'>Tform品番</th>
        	<?php
        	$currency = "";
        	
    		$result1 = mysql_query("SELECT DISTINCT `orderNo` FROM `order` WHERE `date` BETWEEN '$from' AND '$to' $normalSearch ORDER BY `date`");
    		while ($row1 = mysql_fetch_assoc($result1)){
    		    $order = $row1['orderNo'];
    		    $result2 = mysql_query("SELECT * FROM `order` WHERE `orderNo` = '$order'");
    		    while ($row2 = mysql_fetch_assoc($result2)){
    		        $date = $row2['date'];
    		        $currency = $row2['currency'];
    		     
    		       
    		    }
    		     
        		//echo "<th style='border-left: solid 1px #000; min-width: 100px; color: green;'>".$row1['orderNo']."<br>".$date."</th>";
        		echo "<th style='border-left: solid 1px #000; min-width: 50px;'>".$order."<br>数量</th>";
        		//echo "<th style='min-width: 80px;'>PRICE</th>";
        		//echo "<th style='min-width: 60px;'>DISCOUNT</th>";
        		//echo "<th style='min-width: 60px;'>NET(".$currency.")</th>";
        		//echo "<th style='min-width: 70px;'>輸入単価</th>";
        		echo "<th style='min-width: 70px; border-right: solid 1px #000;'>".$date."<br>最終単価</th>";
        		$orderArray[] = $row1['orderNo'];
        		}
    		?>
        		</tr>
    		</thead>
    		<tbody>
    		    		<?php 
    		
    		$result = mysql_query("SELECT * FROM `order`  WHERE `date` BETWEEN '$from' AND '$to' $normalSearch GROUP BY `tformNo` ORDER BY `date`");
    		while ($row = mysql_fetch_assoc($result)){
    		    $tformNo = $row['tformNo'];
    		    echo "<tr style='text-align: center;'>";
        		echo "<td>".$row['makerNo']."</td>
        			  <td>".$row['tformNo']."</td>";
        		
        		foreach ($orderArray as $value => $key){
    		
        		// PUT THE QUERY FOR PULLING DATA FROM ORDER WHERE = $key
        		//SET DEFAULT VARIABLE VALUES
        		$price = "";
	            $discount = "0";
	            $rate = "";
	            $quantity = "";
	            $finalUnitPrice = "0";
	            //---------------------------
    		    $result1 = mysql_query("SELECT * FROM `order` WHERE `orderNo` = '$key' AND `tformNo` = '$tformNo'");
		        while ($row1 = mysql_fetch_assoc($result1)){
		            $price = $row1['priceList'];
		            $discount = $row1['discount'];
		            $rate = $row1['rate'];
		            $quantity = $row1['quantity'];
		            $finalUnitPrice = $row1['finalUnitPrice'];
		            
		        }    
        		    
        		//echo "<td style='border-left: solid 1px #000; min-width: 50px; color: green;'>".$key."</td>";
        		echo "<td style='border-left: solid 1px #000; '>".$quantity."</td>";
        		//echo "<td style=''>￥10,000</td>";
        		//echo "<td style=''>".$discount."%</td>";
        		//echo "<td style=''>$rate</td>";
        		//echo "<td style=''>￥29,733</td>";
        		echo "<td style='border-right: solid 1px #000;'>".number_format($finalUnitPrice, 0, '',',')."</td>";
        		
        		}
        		
        		echo "</tr>";
        		}
    		?>
    		</tbody>
    		</table>
    		 </div><!-- END OF SAVEWRAPPER -->
    		<!-- PAGE CONTENTS END HERE -->
    	</div>
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>