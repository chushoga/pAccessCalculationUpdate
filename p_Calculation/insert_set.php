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

		$('#table_id111').dataTable( {
			"sScrollY": ($(window).height() - 200),
			"bJQueryUI": true,
			"bPaginate": false,
			"scrollX": true

		 	 } );
		$('#table_id22222').dataTable( {
			"bJQueryUI": true,
			"bFilter": false,
			"bInfo": false,
			"bLengthChange": false,
			"bPaginate": false,
			
			"sPaginationType": "full_numbers"
				
	  } );
		/*DATATABLES START*/
		var defaultOptions = {
    	    "bJQueryUI": true,
    		"sPaginationType": "full_numbers",
    		"sScrollX" : "100%",
    		"bPaginate": false,
    		"iDisplayLength": 100
		};//options
		var defaultOptions2 = {
		    "bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"sScrollX" : "100%",
			"bPaginate": false,
			"iDisplayLength": 100
		};//options
		var calcDataTableHeight = function() {
			// navi: 20px + uiToolbar: 38px + thHeight: 25px + toolBarFooter: 40px; = 123px 
		    var navi = 0;
		    var uiToolbar = 0;
		    var thHeight = 0;
		    var toolBarFooter = 176;
		    var minusResult = navi + uiToolbar + thHeight + toolBarFooter;
		    var h = Math.floor($(window).height() - minusResult);
		    return h + 'px';
		};
		defaultOptions.sScrollY = calcDataTableHeight();
		defaultOptions2.sScrollY = calcDataTableHeight();
		var oTable = $('#table_id').dataTable(defaultOptions);
		var oTable = $('#table_id2').dataTable(defaultOptions);

		 $(window).bind('resize', function () {
			 $('div.dataTables_scrollBody').css('height',calcDataTableHeight());
				oTable.fnAdjustColumnSizing();
		  } );
	/*DATATABLES END*/
	$('#loading').delay(300).fadeOut(300);
// set auto complete for type search
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
	          .attr( "title", "すべて表示" )
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
	 
	      _removeIfInvalid: function( event, ui ) {
	 
	        // Selected an item, nothing to do
	        if ( ui.item ) {
	          return;
	        }
	 
	        // Search for a match (case-insensitive)
	        var value = this.input.val(),
	          valueLowerCase = value.toLowerCase(),
	          valid = false;
	        this.element.children( "option" ).each(function() {
	          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
	            this.selected = valid = true;
	            return false;
	          }
	        });
	 
	        // Found a match, nothing to do
	        if ( valid ) {
	          return;
	        }
	 
	        // Remove invalid value
	        this.input
	          .val( "" )
	          .attr( "title", value + " didn't match any item" )
	          .tooltip( "open" );
	        this.element.val( "" );
	        this._delay(function() {
	          this.input.tooltip( "close" ).attr( "title", "" );
	        }, 2500 );
	        this.input.autocomplete( "instance" ).term = "";
	      },
	 
	      _destroy: function() {
	        this.wrapper.remove();
	        this.element.show();
	      }
	    });
	  })( jQuery );
	 
	  $(function() {
	    $( "#combobox" ).combobox();
	    $( "#toggle" ).click(function() {
	      $( "#combobox" ).toggle();
	    });
	  });
	  // END search
		$(window).resize(function() {
			  console.log($(window).height());
			  $('.dataTables_scrollBody').css('height', ($(window).height() - 200));	
			});
		} );
</script>
<style type="text/css">
.oneQuarterBox {
	width: 25%;
	background-color: #FFF;
	float: left;
}

.threeQuarterBox {
	width: 75%;
	background-color: #FFF;
	float: left;
}

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
	padding: 5px 10px;
}

.search-input {
	border: 1px solid #d3d3d3;
	background: #e6e6e6 url("../images/ui-bg_glass_75_e6e6e6_1x400.png") 50% 50% repeat-x;
	font-weight: normal;
	color: #555555;
	padding: 5px 10px;
	margin-left: 30px;
	margin-right: 10px;
}
</style>
</head>
<body>
	<div id='wrapper'>
		<div id='loading'>
			<span class='loadingGifMain'> <img src='<?php echo $path;?>/img/142.gif'><br> LOADING ... </span>
		</div>
		<?php require_once '../header.php';?>
		<div class='contents'>
			<!-- PAGE CONTENTS START HERE -->
		<?php
		//set variables//
		$selected = "";

		if(isset($_GET['tformNo']) && $_GET['tformNo'] != ''){
			$find = $_GET['tformNo'];
		} else {
			if(isset($_GET['findCat']) && $_GET['findCat'] != ''){

				$find = $_GET['findCat'];
			} else {
				$find = "NULL";
			}
		}
		if(isset($_GET['findCat'])){
			$findCat = $_GET['findCat'];
			if ($findCat == 'すべて'){
				$findCat = '';
			}
			$filterFunc = " (`type` LIKE '%$findCat%') AND ";
		} else {
			$findCat = "";
			$filterFunc = "";
		}

		$findFunc = " (`tformNo` LIKE '%$find%' OR
						     `type` LIKE '%$find%' OR
							 `makerNo` LIKE '%$find%' OR
							 `maker` LIKE '%$find%') OR ";

		//
		////////////////

		?>
			<div class="threeQuarterBox">
				<div style="width: 95%; margin: auto;">
					<!-- START THE FORM HERE -->

				<?php
				echo "<form action='' method='get'>";
				echo "<input type='hidden' name='pr' value='1'>";
				echo "<span style='float: left; margin:10px;'>";
				echo "<select name='findCat' style='width: 100px;' id='combobox'>";
				echo "<option>すべて</option>";

				$result = mysql_query("SELECT DISTINCT type FROM main" ) or die(mysql_errno());
				while ($row = mysql_fetch_assoc($result)){
					if (isset($_GET['findCat']) && $row['type'] == $_GET['findCat']){
						$selected = "selected='selected'";
					} else {
						$selected = "";
					}
					echo "<option $selected>".$row['type']."</option>";
				}
				echo "<input type='text' name='tformNo' value='$find' class='search-input'>";
				echo "<input type='submit' class='go' value='検索' style='height: 27px;' >";

				echo "</select>";
				echo "</span>";
				echo "</form>";
				// SELECT FROM TYPES END ------------------------
				?>
					<form id='update' action='../session/sesAdd.php' method='POST'>

						<button class="update" type='submit' value='アップデート' style='float: right; margin: 10px; width: 60px; height: 27px;'>
							<i class="fa fa-plus"></i> ADD
						</button>
						<br> <br>

						<table id="table_id">
						<?php
						$result = mysql_query("SELECT * FROM `main` WHERE $filterFunc $findFunc `set` = '0'  ORDER BY `tformNo`") or die(mysql_error());
						echo
		        "<thead><tr>
		        	<th>TFORM品番</th>
		        	<th>DBid</th>
		        	<th>タイプ</th>
		        	<th>メーカー</th>
		        	<th>シリーズ</th>
		        	<th>メーカー品番</th>
		        	<th>イメージ</th>
		        	<th>数</th>
		        </tr></thead>";
						echo "<tbody>";
						while ($row = mysql_fetch_assoc($result)){
							$tformNo = $row['tformNo']; // declare the tform number from the first fetch array.
							$resultInner = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$tformNo'") or die(mysql_error()); // inner query to show the inner results from main like the img link etc.
							while ($rowInner = mysql_fetch_assoc($resultInner)){
								$id = $rowInner['id'];
								echo "<tr>";
								if (isset($_SESSION[$row['tformNo']])){
									echo "<td style='background-color: #FF8787;'><a href='calculation.php?pr=1id=";
									echo $id;
									echo "' tabindex=-1>".$row['tformNo']."</td>";
								} else {
									echo "<td style='min-width: 100px;'><a href='calculation.php?pr=1&id=";
									echo $id;
									echo "' tabindex=-1>".$row['tformNo']."</a></td>";
								}
								echo "<td>".$row['id']."</td>";
								echo "<td style='min-width: 100px;'>".$rowInner['type']."</td>";
								echo "<td>".$rowInner['maker']."</td>";
								echo "<td>".$rowInner['series']."</td>";
								echo "<td style='max-width: auto;'>".$row['makerNo']."</td>";
									
								if ($rowInner['img'] == '0' || $rowInner['img'] == ''){
									echo "<td style='min-width: 50px;'><li class='fa fa-picture-o' style='font-size: 60px; color: #CCC;'></li></td>";
								} else if(strpos($rowInner['img'], 'set_img') !== false){
									echo "<td style='min-width: 50px;'><img src ='".$rowInner['img']."' class='imgL' height='60px'></td>";
								} else if(strpos($rowInner['img'], 'single_img') !== false){
									echo "<td style='min-width: 50px;'><img src ='".$rowInner['img']."' class='imgL' height='60px'></td>";
								}else {
									$thumRep = str_replace("img/img_phot/photo", "img/img_phot/photo_thum120", $rowInner['img']);
									echo "<td style='min-width: 50px;'><img src ='http://www.tform.co.jp/".$thumRep."' height='60px'></td>";
								}
								echo "<td><input type='text' name='".$rowInner['tformNo']."' style='width: 60px;'></td>";
								echo "</tr>";
							}
						}
						echo "</tbody>";
						?>
						</table>
					</form>

					<!-- END THE FORM HERE -->
				</div>
			</div>
			<?php
			//////////////////// end of first half ///////////////////////
			?>
			<div class="oneQuarterBox" style="overflow: auto;">
			<?php

			echo "<div style='width: 95%; height: auto; background-color: #FFF; margin-left: auto; margin-right: auto; margin-top: 10px;'>";
			//--------------------
			echo "<div style= 'float: left; margin-right: 10px;'>";
			echo "<form action='exe/exeSet.php' method='POST'>
								<input type='text' name='tformNo' class='search-input' style='margin-left: 0px; margin-right: 5px; width: 100px;' placeholder='XXX00-0000-000' maxlength='14'>
								<button type='submit' class='submit' style='margin-bottom: 10px; height: 27px; width: 27px; font-size: 18px;'><li class='fa fa-save'></li></button>
							</form>";
			echo "</div>";
			//--------------------
			echo "<div style='float: right;'>";
			echo "<form action='../session/sesDestroy.php' method='POST'>
							<button class='clearAll' type='submit' style='height: 27px;'><i class='fa fa-recycle'></i> すべてクリア</button>
							</form>";
			echo "</div>";
			//-------------------
			echo "<table id='table_id2'>";
			echo "<thead>";
			echo "<tr>";
			echo "
					    	<th>イメージ</th>
					    	<th >Tform品番</th>
					    	<th>数</th>
					    	<th>クリア</th>
					    	";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";

			foreach ($_SESSION as $key => $value){

				if ($key == "percent1"){

				} else if ($key == "percent2"){

				} else if ($key == "rate1"){

				} else if ($key == "rate2") {

				} else if ($key == "maker") {

				} else if ($key == "makertable") {

				} else if ($key == "currency") {
				} else if ($key == "currency1") {
				} else if ($key == "currency2") {
				}else {
					$result = mysql_query("SELECT * FROM main WHERE `tformNo` = '$key' ORDER BY tformNo") or die(mysql_error());

					echo "<tr>";
					while ($row = mysql_fetch_assoc($result)){
						$rightId = $row['id'];
						if ($row['img'] == '0' || $row['img'] == ''){
							echo "<td style='min-width: 50px;'><li class='fa fa-picture-o' style='font-size: 60px; color: #CCC;'></li></td>";
						} else if(strpos($row['img'], 'set_img') !== false){
							echo "<td style='min-width: 50px;'><img src ='".$row['img']."' class='imgL' height='60px'></td>";
						} else if(strpos($row['img'], 'single_img') !== false){
							echo "<td style='min-width: 50px;'><img src ='".$row['img']."' class='imgL' height='60px'></td>";
						}else {
							$thumRep = str_replace("img/img_phot/photo", "img/img_phot/photo_thum120", $row['img']);
							echo "<td style='min-width: 50px;'><img src ='http://www.tform.co.jp/".$thumRep."' height='60px'></td>";
						}
					}
					echo "<td><a href='calculation.php?pr=1&id=".$rightId."'>$key</a></td>";
					echo "<td>$value</td>";
					echo "<td><a href='../session/sesRemoveItem.php?tformNo=".$key."' style='color: red; font-size: 14px;'> <li class='fa fa-trash-o'></li> </a></td>";
					echo "</tr>";
				}
			}
			echo "</table>";
			echo "</tbody>";

			echo "</div>";

			?>
			</div>
			<div class="holder"></div>
			<!-- Holder div for the hidden content -->
			<!-- PAGE CONTENTS END HERE -->
		</div>
	</div>
	<?php require_once '../master/footer.php';?>
</body>
</html>
