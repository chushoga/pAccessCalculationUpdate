<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>

	<?php include_once '../master/config.php';
	
	// get the list name from TOP
	if(isset($_GET['id'])){
		$listName = $_GET['id'];
	} else {
		$listName = false;
	}
	
        //set the file save name and date
        $savFileDate = date('Y_m_d');
        $saveFileName = $listName;
    
	?>
	
	<style>
		/* -------------------------- */
		/* GENERAL */
		/* -------------------------- */
		textarea:focus, input:focus {
			outline: none;
		}

		*:focus {
			outline: none;
		}
		
		/* -------------------------- */
		/* CONTENTS */
		/* -------------------------- */
		#contents {
			position: absolute;
			top: 55px;
			width: 100%;
			bottom: 0px;
			overflow: auto;
		}
		
		#contents table {
			width: 100%;
		}
		
		/* -------------------------- */
		/* BUTTONS */
		/* -------------------------- */
		
		.isHaiban {
			background: crimson;
			color: white;
			font-weight: 700;
			padding-left: 5px;
			padding-right: 5px;
		}
		
		
		.toggle-vis {
			float: left;
			height: 85px;
			width: 85px;
			margin: 2px;
			position: relative;
		}
		
		.toggle-vis i {
			font-size: 32px;
			color: #8E8E8E;
		}
		
		.toggle-vis .btnTxt{
			display: block;
			position: absolute;
			bottom: 0px;
			text-align: center;
			width: 100%;
			padding-bottom: 3px;
		}
		.buttonSelected {
			opacity: 0.3;
		}
		
		#listNavi span {
			float: left;
			margin-left: 5px;
			margin-top: 2px;
		}
		#listNavi span:hover {
			cursor: pointer;
		}
		
		#dialogFilter .neededByExcel {
			background: linear-gradient(to bottom, rgba(255,207,207,1) 0%,rgba(237,165,165,1) 100%);
			border: 1px solid #E08989;
		}
		#dialogFilter .neededByExcel i{
			color: #E08989;
		}
		#dialogFilter .memoBox {
			background: linear-gradient(to bottom, rgba(255,207,207,1) 0%,rgba(237,165,165,1) 100%);
			border: 1px solid #E08989;
			width: 16px;
			height: 16px;
			display: block;
			float: left;
			margin-right: 4px;
		}
		
		/* -------------------------- */
		/* TOOLTIP */
		/* -------------------------- */
		
		#toolTip {
			display: none;
			z-index: 50;
			position: fixed;
			width: 300px;
			height: 25px;
			outline: 2px solid #595959;
			color: #595959;
			background: #FFFFFF;
			top: 25px;
			left: calc(50% - 150px);
			text-align: center;
		}
		
		/* -------------------------- */
		/* EDIT PRICE LIST */
		/* -------------------------- */
		
		.editPrice:hover {
			cursor: pointer;
			opacity: 0.7;
		}
		
		
		#dialogEditPricesImg {
			width: "100%";
			height: 200px;
			overflow: hidden;
		}
		
		#dialogEditPricesImg img {
			height: 100%;
			display: block;
			margin: auto;
		}
		
		.editPriceContents {
			outline: 1px solid #000000;
			margin-bottom: 10px;
			padding: 4px;
			margin-top: 10px;
			font-size: 18px;
		}
		
		.editPriceContents input{
			width: 100px;
		}
		
		/* -------------------------- */
		/* SPECIAL ITEMS */
		/* -------------------------- */
		
		#dialogSpecialItems #leftBox {
			width: 50%; 
			height: 300px;
			float: left;
			overflow:auto;
		}
		
		#dialogSpecialItems #rightBox {
			width: 50%; 
			height: 300px;
			float: left; 
			overflow:auto;
		}
	
		.tableImg img{
			max-width: 45px;
			max-height: 45px;
		}
		
		.specialItemsBox {
			position: relative;
			height: 40px;
			padding-left: 4px;
			margin-bottom: 5px;
			overflow: hidden;
			background: linear-gradient(to bottom, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%);
		}
		
		#dialogSpecialItems input {
			float: right;
		}
		#dialogSpecialItems .fa-search {
			float: right;
			font-size: 20px;
			margin-left: 5px;
		}
		
		
		/* -------------------------- */
		/* NAVI */
		/* -------------------------- */
		#listNavi {
			position: absolute;
			top: 20px;
			width: 100%;
			height: 35px;
			background-color: #8E8E8E;
		}
		
		#listNameHeader {
			float: left;
			line-height: 35px;
			margin-left: 10px;
			margin-right: 5px;
			color: #FFFFFF;
			font-size: 18px;
		}
		
		/* -------------------------- */
		/* EDIT LIST PROPS */
		/* -------------------------- */
		.tableShared {
			width: 100%;
			border-collapse: collapse;
		}
		
		.tableShared td {
		}
		
		.tableSharedHover td:hover {
			opacity: 0.5;
			cursor: pointer;
		}
		
		#dialogUpdateListProps .tableShared td,
		#dialogUpdateListProps .tableShared th {
			height: 20px;
			line-height: 20px;
			padding: 2px;
			text-align: center;
			border: 1px solid black;
		}
		
		.hinbanSelected {
			background: lightskyblue !important;
			color: #FFFFFF;
		}
		
		.removeItem {
			width: 20px;
			height: 20px;
			float: right;
			text-align: center;
			background: #D15656;
			border: none;
		}
		
		.addItem {
			width: 20px;
			height: 20px;
			float: right;
			text-align: center;
			background: #6AD156;
			border: none;
		}
		
		.removeItemSpecial {
			position: absolute;
			top: 0px;
			right: 0px;
			width: 20px;
			height: 40px;
			float: right;
			text-align: center;
			background: #D15656;
			border: none;
		}
		
		.addItemSpecial {
			position: absolute;
			top: 0px;
			right: 0px;
			width: 20px;
			height: 40px;
			float: right;
			text-align: center;
			background: #6AD156;
			border: none;
		}

		.hiddenRowStyle {
			color: #CCCCCC;
			outline: 1px solid #FFFFFF;
		}
		
		.hiddenRowStyle td {
			background: #8E8E8E !important;
		}
		
		/* -------------------------- */
		/* SEARCH FOR NEW ITEMS		  */
		/* -------------------------- */
		
		#searchForNewItemsContent .bottomBox {
			position: absolute;
			height: 30px;
			bottom: 0px;
			right: 0px;
		}
		
		#searchForNewItemsContent .bottomBox button{
			padding: 5px;
			width: 100px;
		}
		
		#searchForNewItemsContent .topBox {
			height: 355px;
			overflow: auto;
		}
		
		#dialogSearchForNewItems table {
			border-collapse: collapse;
			width: 100%;
		}
		
		#dialogSearchForNewItems th, td {
			border: 1px solid #CCCCCC;
		}
        
		
	</style>
	
		<script type="text/javascript">
			$(document).ready(function() {

				// GLOBAL VARABILES
				var persistantTformNo;
				var listName = "<?php echo $listName;?>";
				var reloadPage = false;
				
				// SET PAGE TITLE
				$("#listNameHeader").html(listName);
				
				// ----------------
				
				// --------------------------------------------------------------------------
				/*DATATABLES START*/
				// --------------------------------------------------------------------------
				var defaultOptions = {
						"bJQueryUI": true,
						"bPaginate": false,
						"bInfo": false,
						"sScrollX" : "100%",
						"bFilter": true,
						"order": [[ 2, "asc" ]],
						"columnDefs": [
							{
								"targets": [ 0, 8 ],
								"visible": false,
								"searchable": true
							}
						]
				};
				
				var oTable;
		
				LoadMainTable(listName);
				// --------------------------------------------------------------------------
				/*DATATABLES END*/
				// --------------------------------------------------------------------------
				
				function LoadMainTable(listname){
					$.ajax({
					type: "post",
					url: "exe/exeListProcess.php",
					data: "action=listSearch" + "&listName=" + listName,
					success: function (data) {
						// go through results
						
						// counter for excel data output
						var excelRowCounter = 2;
						
						for(var i = 0; i < data.length; i++){

							// isHIDDEN
							var isHidden = data[i].isHidden;
							
							// SET THE ROW COLOR TO HIDDEN IF HIDDEN
							var hiddenRowStyle = "";
							if(isHidden == 1){
								hiddenRowStyle = "hiddenRowStyle";
							}
							
							var str = "";
								str += "<tr class='targetRow "+hiddenRowStyle+"'>";
								str += "<td>"+isHidden+"</td>";
								str += '<td class="tableImg targetThis imageLink" data-imglink="'+data[i].imageLink+'" data-origvalue="'+data[i].image+'" \>'+data[i].image+'</td>';
								str += "<td style='white-space: nowrap;'>"+data[i].tformNo+"</td>";
							
							// Prep set variables
							var str2a = [];
							var str2b = [];
							var str2c = [];
							
							var str2d = []; // history bairitsu
							var str2dVal = []; // history bairitsu for calculation
							var str2dYear = [];  // year for the pricelist used
							
							var str2e = [];
							var str2f = [];
							
							var str2g = []; // pricelist
							var str2gVal = []; // pricelist for calculation
							var str2gYear = []; // year for the pricelist used
							
							var str2h = []; // percent
							var str2hVal = []; //percent for calculation
							
							var str2i_rate = []; // just rate
							var str2i_percent = []; // just percent
							
							var str2j = []; // shiire
							var str2jVal = []; // shiire for calculation
							
							var str2k = []; // orderNo;
							
							var excelTotalCounter = [];
						
							// HAIBAN
							var haiban;
							
							if (data[i].haiban == true){
								haiban =  "<td>廃番</td>";
							} else {
								haiban =  "<td></td>";
							}
							
							// WEB
							var webHyoji;
							
							if (data[i].webHyoji == true){
								webHyoji =  "<td>1</td>";
							} else {
								webHyoji =  "<td></td>";
							}
							
							// SET
							var isSet;
							if (data[i].isSet == true){
								isSet =  "<td>x</td>";
							} else {
								isSet =  "<td></td>";
							}
							
							// SERIES and SIZE
							var series =  "<td>"+data[i].series+"</td>";
							var productSize =  "<td>"+data[i].productSize+"</td>";
						
							// --------------------------------------------------------------------
							// SET CONTENTS LOOP
							// --------------------------------------------------------------------
							
							for(var j = 0; j < data[i].setContents.length; j++){
								
								if (data[i].setConents === undefined){
									
									// MAKER NO --
									str2a += data[i].setContents[j].makerNo + "<br>";
									
									// ORDER NO --
									str2k += data[i].setContents[j].orderNo + "<br>";
									
									// TFORM NO --
									// SET CONTENTS HAIBAN --
									// add a css tag for haiban instead of saying haiban
									if (data[i].isSet == false){
										str2b += "<span class='setCounter'>x</span>";
									} else {
										if (data[i].setContents[j].haiban == true) {
											str2b += "<span class='setCounter isHaiban'  style='white-space: nowrap;'>"+data[i].setContents[j].tformNo + " (廃番)</span>";
										} else {
											str2b += "<span class='setCounter' style='white-space: nowrap;'>"+data[i].setContents[j].tformNo+"</span>";
										}
									}
									// SPECIAL ITEM --
									// if special add a special item tag.
									if (data[i].setContents[j].specialItem == true) {
										str2b += " <span style='color: #ADADAD; white-space: nowrap;'><i class='fa fa-star'></i></span>";
									}
									
									str2b += "<br>"; // add to end of the line
									
									// HISTORY PL --
									str2c += data[i].setContents[j].plHistory + "<br>";
									
									// HISTORY BAIRITSU --
									str2d += data[i].setContents[j].plHistoryBai + "<br>";
									str2dVal += "<span class='targetThis historyBairitsu' data-origvalue='"+data[i].setContents[j].plHistoryBai+"' data-calc='=(((N"+excelRowCounter+"-K"+excelRowCounter+")/K"+excelRowCounter+")*100)'>"+data[i].setContents[j].plHistoryBai+"</span><br>";
									str2dYear += "<span style='font-size: 9px; font-weight: bold; white-space: nowrap; color: "+data[i].setContents[j].historyColorId+" ;'>"+data[i].setContents[j].historyYear+ "/" +  data[i].setContents[j].historyMemo + "</span><br>";
									
									// CURRENCY
									str2e += data[i].setContents[j].currency + "<br>";
									
									// CURRENT PL
									// set the edit price list button here too.
									var data_hb = "";
									// dont show wrench if the current price is null
									if(data[i].setContents[j].plCurrent == null){

										data_hb = '';
										
									} else {
									
										data_hb = '<i style="color: #CCCCCC; float: right;" class="fa fa-wrench editPrice targetThis imageLink" \
													data-img="'+data[i].image+'" \
													data-hb="'+data[i].setContents[j].tformNo+'" \
													data-makerhb="'+data[i].setContents[j].makerNo+'"\
													data-currentpl="'+data[i].setContents[j].plCurrent+'"\
													></i>';
									}
									
									str2f += data[i].setContents[j].plCurrent + data_hb + "<br>";
									
									// DISCOUNT PERCENT
									str2gVal += "<span class='targetThis discountParCalc' data-origvalue='"+data[i].setContents[j].discountPar+"%' data-calc='"+data[i].setContents[j].discountPar+"'>"+data[i].setContents[j].discountPar+"%</span><br>";
									str2g += data[i].setContents[j].discountPar + "%<br>";
									str2gYear += "<span style='font-size: 9px; font-weight: bold; white-space: nowrap; color: "+data[i].setContents[j].plCurrentColorId+" ;'>"+data[i].setContents[j].currentYear+ "/" +  data[i].setContents[j].currentMemo + "</span><br>";
									
									// NET
									str2hVal += "<span class='targetThis netPrice' data-origvalue='"+data[i].setContents[j].net+"' data-calc='=(N"+excelRowCounter+"*((100-O"+excelRowCounter+")/100))'>"+data[i].setContents[j].net+"</span><br>";
									
									str2h += data[i].setContents[j].net +"<br>";
									
									
									// RATE AND PERCENT
									str2i_rate += data[i].setContents[j].rate+ "<br>";
									str2i_percent += data[i].setContents[j].percent+ "<br>";
									
									// SHIIRE
									var num = data[i].setContents[j].shiire;
									if(num != null){
										num = num.toLocaleString("ja-JP", {style: "currency", currency: "JPY"});
									} else {
										num = num;
									}
									
									// prep string for excel calc
									var str2jString = '=IF(M'+excelRowCounter+'="YEN",N'+excelRowCounter+',P'+excelRowCounter+'*(Q'+excelRowCounter+'*((R'+excelRowCounter+'/100)+1)))';
									str2jVal += "<span class='targetThis shiireCalc' data-origvalue='"+num+"' data-calc='"+str2jString+"'>"+num+"</span><br>";
									str2j += num + "<br>";
									
									excelTotalCounter.push(excelRowCounter); // for the total amount save the row number for calculation
									
									// CHECK IF it is hidden or not and only count if is false for the excel counter. I know... its kinda backwards...
									if(isHidden == 0){
										excelRowCounter++; // counter for Excel
									}
									
								}
							}
						
							// --------------------------------------------------------------------
							
							var totalPrice = data[i].totalPrice; // set the total price
							
							// change the price to to japanese currency if not empty.
							if(totalPrice != null){
								totalPrice = totalPrice.toLocaleString("ja-JP", {style: "currency", currency: "JPY"});
							} else {
								totalPrice = totalPrice;
							}
						
							var clc = excelTotalCounter[0]+(excelTotalCounter.length-1);// sets which cells to total up.
							
							var totalPriceVal = "<span class='targetThis setTotal' data-origvalue='"+totalPrice+"' data-calc='=SUM(S"+excelTotalCounter[0]+":S"+clc+")'>"+totalPrice+"</span><br>";
							
							var tformPriceNoTax = parseFloat(data[i].tformPriceNoTax); // convert to float
								tformPriceNoTax = tformPriceNoTax.toLocaleString("ja-JP", {style: "currency", currency: "JPY"}); // convert to japanese currency string
							
							var tformPriceNoTaxVal = "<span class='targetThis tformPriceNoTaxCalc' data-origvalue='"+tformPriceNoTax+"' data-calc='"+data[i].tformPriceNoTax+"'>"+tformPriceNoTax+"</span><br>";
							
							var totalBairitsuVal = "<span class='targetThis totalBairitsu' data-origvalue='"+data[i].bairitsu+"' data-calc='=(V"+excelTotalCounter[0]+"/T"+excelTotalCounter[0]+")'>"+data[i].bairitsu+"</span><br>";
							
							var str3 = "<td>"+tformPriceNoTaxVal+"</td>";
								
							// Append the data to the table
							$("#mainTable tbody").append(
								str+haiban+webHyoji+series+productSize+
								"<td>"+str2a+"</td>"+
								"<td>"+str2k+"</td>"+
								"<td>"+str2b+"\n</td>"+
								"<td>"+str2c+"</td>"+
								"<td>"+str2dYear+"</td>"+
								"<td>"+str2dVal+"</td>"+
								"<td>"+str2e+"</td>"+
								"<td>"+str2f+"</td>"+
								"<td>"+str2gYear+"</td>"+
								"<td>"+str2gVal+"</td>"+
								"<td>"+str2hVal+"</td>"+
								"<td>"+str2i_rate+"</td>"+
								"<td>"+str2i_percent+"</td>"+
								"<td>"+str2jVal+"</td>"+
								"<td>"+totalPriceVal+"</td>"+
								"<td>"+totalBairitsuVal+"</td>"+
								str3+"</tr>"
							);
							
						}
						
						// Inialize the table
						oTable = $('#mainTable').DataTable(defaultOptions);
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
						// TOGGLE VISIBILITY FOR COLUMNS
						$('.toggle-vis').on( 'click', function (e) {
							e.preventDefault();
							
							// Get the column API object
							var column = oTable.column( $(this).attr('data-column') );
							
							// Toggle the buttons selected class
							console.log(column.visible());
							 
							// Toggle the visibility
							column.visible( ! column.visible() );
							
							$(this).toggleClass("buttonSelected");
							
						});
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
						// Add what you need to the datatable toolbar here
						$(".dataTables_filter").append('<a href="#"><span style="float: right; margin-left: 10px;" class="fa-stack fa-lg" id="openFilterOptions" title="フィルターColumn設定">\
							<i style="color: #FFFFFF;" class="fa fa-square fa-stack-2x"></i>\
							<i style="color: #8E8E8E;" class="fa fa-filter fa-stack-1x fa-inverse"></i>\
							</span></a>\
						');
					
					
						// -----------------------------------
						// Clear Loading Screen
						// -----------------------------------
						$('#loading').delay(300).fadeOut(300);
						// -----------------------------------

						// fix some css for the filter
						$('.dataTables_wrapper .dataTables_filter input').css({height: "30px"});


						// -------------------------------------------------------------------------------------------------------------------
						/* HIDE SHOW HAIBAN ITEMS */
						// -------------------------------------------------------------------------------------------------------------------
						var allowFilter = ['mainTable']// array to set which tables are allowed to use this.
						var isHaibanHidden = false;

						$.fn.dataTableExt.afnFiltering.push(
							function(oSettings, aData, iDataIndex) {

								if ( $.inArray( oSettings.nTable.getAttribute('id'), allowFilter ) == -1 )
								{
									// if not table should be ignored
									return true;
								}

								if (isHaibanHidden && aData[3] == "") {
									return true;
								}
								if (!isHaibanHidden && aData[3] != " ") {
									return true;
								}

								return false;
							}
						);

						// TOGGLE THE HAIBAN HERE
						$('#hideHaiban').on("click", function(e) {

							isHaibanHidden = !isHaibanHidden; // toggle ishaiban hidden

							if(isHaibanHidden == true){
								$('#hideHaiban i').css({"opacity": 0.25});
							} else {
								$('#hideHaiban i').css({"opacity": 1});
							}

							oTable.draw();
						});

						$('#openFilterOptions').hover(function(e) {
							ShowToolTip($(this).attr("title"));
						});

						$('#listNavi span').hover(function(e) {
							ShowToolTip($(this).attr("title"));
						});
						
						
						// -------------------------------------------
						// NaviButtons
						// -------------------------------------------
						
						var isRecordHidden = true;
						// hide the hidden items
						$.fn.dataTableExt.afnFiltering.push(
							function(oSettings, aData, iDataIndex) {

								if (isRecordHidden && aData[0] == "0") {
									return true;
								}
								
								if (!isRecordHidden && aData[0] != " ") {
									return true;
								}
								
								return false;
							}
						);
						
						
						// -- TOGGLE HIDDEN ITEMS

						 $('#toggleHiddenItems').on( 'click', function (e) {
							e.preventDefault();

							isRecordHidden = !isRecordHidden; // toggle if record is hidden or not

							// Get the column API object
							var column = oTable.column( $(this).attr('data-column') );

							// Toggle the visibility
							//column.visible( ! column.visible() );

							$(this).toggleClass("buttonSelected");

							oTable.draw();

						});
						
						// ------------------------------------------------------------
						// CONVERT TO EXCEL CALCULATION
						// TODO: TEMP Rest Button
						// ------------------------------------------------------------
						$("#excelCalculationBtnShowAllCols").on("click", function(){
							oTable.columns([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]).visible(true);
							oTable.columns.adjust().draw(false);
						});

						// -------------------------------------------
						
						oTable.draw();
						
						// -------------------------------------------------------------------------------------------------------------------

						},
						error: function (err) {
							console.log("Hmmmm.... ERROR!!!!!!" + err);
                            console.log(err.responseText);
						}
					
						// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
						//<¯¯¯><¯¯¯><¯¯¯><¯¯¯><¯¯¯>   <¯¯¯><¯¯¯><¯¯¯><¯¯¯><¯¯¯><¯¯¯><¯¯¯><¯¯¯><¯¯¯><¯¯¯><¯¯¯><¯¯¯>
						// \U/  \N/  \D/  \E/  \R/     \C/  \O/  \N/  \S/  \T/  \R/  \U/  \C/  \T/  \I/  \O/  \N/
						//  ▼    ▼    ▼    ▼    ▼       ▼    ▼    ▼    ▼    ▼    ▼    ▼    ▼    ▼    ▼    ▼    ▼
						// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
						
						//var rowNumber = oTable.rows( { order: 'applied' } ).nodes().indexOf( this );
						
						// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
						//  ▲    ▲    ▲    ▲    ▲       ▲    ▲    ▲    ▲    ▲    ▲    ▲    ▲    ▲    ▲    ▲    ▲
						// /U\  /N\  /D\  /E\  /R\     /C\  /O\  /N\  /S\  /T\  /R\  /U\  /C\  /T\  /I\  /O\  /N\
						//<___><___><___><___><___>   <___><___><___><___><___><___><___><___><___><___><___><___>
						// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
						
					});
				}
				
				
// ###################################################################################################################################
				/*
				var table = $('#mainTable').DataTable();
 
				$('#mainTable').on( 'click', 'tr', function () {
					var id = table.row( this ).id();

					alert( 'Clicked row id '+id );
				} );
*/
				// show the tool top when hovering over the edit pricelist button
				$("#saveWrapper").on("mouseenter mouseleave", ".editPrice", function() {
					ShowToolTip($(this).data("hb"));
				});
				
				// ******************************************************
				// DIALOG BOXES **
				// for popup boxes no depending on the ajax call
				// *******************************************************
				
				// -- Search For New Items --
				$("#dialogSearchForNewItems").dialog({
					autoOpen: false,
					modal: true,
					height: 510,
					width: 750
				});
				
				$("#dialogSearchForNewItems #newItemsSearchBar").on("change keyup", function(){
					
					var search = $(this).val();
					
					// check if more that 3 chars before query to help speed things up a bit.
					if(search.length > 2){
						
						SearchForNewItems(listName, search);
						
					} else {
						// clear out the table is less than 3 characters
						$("#dialogSearchForNewItems table tbody").empty();
					}
					
				});
				
				$("#newItemSearchAddBtn").on("click", function(){
					
					//alert("NOT FINISHED YET BAMM!!!");
					
					var arr = [];
					jQuery("#dialogSearchForNewItems table input").each(function(){
						var currentElement = $(this);
						var value = currentElement.attr("data-tf");
						
						// check if it is checked...
						if($(this).is(":checked")){
							arr.push(value);
						}
						
					});
					
					// AJAX
					// input into the current list
					SearchForNewItemsAdd(listName, arr);
					
				});
				
				$("#newItemSearchCancelBtn").on("click", function(){
					$("#dialogSearchForNewItems").dialog("close");
				});
				
				$("#searchForNewItemsBtn").on("click", function(){
					$("#dialogSearchForNewItems").dialog("open");
				});
			
				
				// -- Special Items -- 
				// TODO: do not this dialog box, can remove after make sure: remember to remove html too
				$("#dialogSpecialItems").dialog({
					autoOpen: false,
					modal: true,
					height: 410,
					width: 600
				});

				// -- Edit Prices --
				$("#dialogEditPrices").dialog({
					autoOpen: false,
					modal: true,
					height: 475,
					width: 310,
					buttons: {
								"OK": function() {
									
									// send the data to process page for update
									EditMakerPrice(listName, $(this).find("h1").attr("data-tformnohb"), $(this).find("input").val());
									
									if ($(this).find("input").val() != ""){
										reloadPage = true;
									}
									
									$( this ).dialog("close");
								},
								"キャンセル": function() {
									$( this ).dialog("close");
								}
							}
				});
				

				// ******************************************************
				// EDIT PRICES
				// ******************************************************
				
				// open the edit pricelist price dialog and prepar for editing
				$("#saveWrapper").on("click", ".editPrice", function(){
					var hb = $(this).data("hb");
					var makerhb = $(this).data("makerhb");
					var img = $(this).data("img");
					var curPL = $(this).data("currentpl");
					var editPricesDialogH1 = $("#dialogEditPrices h1");
					var editPricesDialogH2 = $("#dialogEditPrices h2");
					
					//editPricesDialogH1.attr("data-tformnohb", hb);
					$("#dialogEditPrices h1").attr("data-tformnohb", hb);
					
					editPricesDialogH1.text(hb);
					editPricesDialogH2.text(makerhb);

					// clear data before showing new data
					$("#dialogEditPrices input").val("");
					$("#dialogEditPricesImg").val("");
					$("#dialogEditPrices #currentPL").text("");
					// ----------------------------------------

					// set the text for the current price here
					$("#dialogEditPrices #currentPL").text(curPL);

					// set the image here
					$("#dialogEditPricesImg").html(img);

					// open the dialog
					$("#dialogEditPrices").dialog("open");
					
				});

				// *******************************************************

				// -------------------------------------------
				// Edit Special Items
				// -------------------------------------------

				$(".specialItemsOpenBtn").on("click", function(){
					var tf = $(this).data("tf");

					$("#dialogSpecialItems h1").text(tf);
					$("#dialogSpecialItems").dialog("open");

				});
				// ---------------------------------------
				
				$("#dialogEditPrices").on("dialogclose", function(){
					
					// if flag is set to true then reload the page
					if(reloadPage){
						location.reload();
					}
					
				});
				
				// -------------------------------------------
				// EDIT SPECIAL ITEMS
				// -------------------------------------------
				
				$("#openSpecialItems").on("click", function(){
					
					$("#dialogSpecialItems").dialog("open");
					UpdateSpecialItems(listName);
					
				});
				
				$("#dialogSpecialItems input").on("keyup paste", function(){
					var search = $("#dialogSpecialItems input").val();
					//UpdateSpecialItems(listName);
					
					
					// check if more that 3 chars before query to help speed things up a bit.
					if(search.length > 2){
						
						SearchForSpecialItems(listName, search);
						
					} else {
						// clear out the box is less than 3 characters
						$("#rightBoxContents").empty();
					}
				});
				
				$("#rightBoxContents").on("click", ".addItemSpecial", function(){
					
					//console.log("clicked RIGHT: " + $(this).data("hbid"));
					AddSpecialItems(listName, $(this).data("hbid"));
				});
				
				$("#leftBoxContents").on("click", ".removeItemSpecial", function(){
					
					//console.log("clicked LEFT: " + $(this).data("hbid"));
					RemoveSpecialItems(listName, $(this).data("hbid"));
				});
			
				/* ******************************************************
				** DIALOG BOXES **
				** for popup boxes
				****************************************************** */

				// -- OPEN filter options
				$("#saveWrapper").on("click", "#openFilterOptions", function(){
					
					// open the dialog box
					$("#dialogFilter").dialog("open"); 
					
					// --------------------------------------------------------------------------------------------------------
					// Iterate over the buttons in the dialogFilter and apply correct CSS formating for each button found
					// depending on its visibility.
					// --------------------------------------------------------------------------------------------------------
						$("#dialogFilter").find('.toggle-vis').each(function(){
							
							// get the table column data
							var column = oTable.column( $(this).attr('data-column') );
							
							// RESET class css
							$(this).removeClass("buttonSelected"); 
							
							// If the column is NOT visible then toggle .buttonSelected class for the button
							if(!column.visible()){
								$(this).toggleClass("buttonSelected");
							}
							
						});
					// --------------------------------------------------------------------------------------------------------
				});

				// create 2 dialog boxes for filter and exel confirmation
				$(function() {
					var dialogFilter;
					var dialogConfirm;

					// on index page initialize the csv upload dialog box
					dialogFilter = $("#dialogFilter").dialog({
						autoOpen: false,
						modal: true,
						height: 500,
						width: 1010
					});

					// EXCEL export dialog
					dialogConfirm = $( "#dialog-confirm" ).dialog({
						autoOpen: false,
						resizable: false,
						height: "auto",
						width: 450,
						modal: true,
						buttons: {
							/*
							"イメージなし": function() {
								// Toggle the visibility of image column which happens to be column number 1
								oTable.column(1).visible(false);
								outputExcel("mainTable",listName);
								$( this ).dialog( "close" );
							},
							"イメージあり": function() {
								oTable.column(1).visible(true);
								outputExcel("mainTable",listName);
								$( this ).dialog( "close" );
							},
							*/
							"書き出し": function() {
								
								// SET ALL COLUMNS TO VISIBLE -----------------------------------------------------------------
								
								$.when(convertTableToExcelCalculation()).done(function(x){
									outputLargeExcel("mainTable", listName);
								});
								
								//convertTableToExcelCalculation();
								//outputLargeExcel("mainTable", listName);
								
								/*
								oTable.column(1).visible(true);
								oTable.columns([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]).visible(true);
								oTable.columns.adjust().draw(false);
								
								// CONVERT TO EXCEL FORMULA -------------------------------------------------------------------
								
								jQuery(".targetThis").each(function(){
									var currentElement = $(this);
									var value = currentElement.attr("data-calc");

									currentElement.html(value);
								});
								*/
								// OUTPUT EXCEL -------------------------------------------------------------------------------
								
//outputLargeExcel("mainTable", listName);
								
								// RESET TO ORIG VALUES -----------------------------------------------------------------------
						/*
								jQuery(".targetThis").each(function(){
									var currentElement = $(this);
									var value = currentElement.attr("data-origvalue");

									currentElement.html(value);
								});
						*/
								// CLOSE WINDOW -------------------------------------------------------------------------------
								
								$( this ).dialog( "close" );
							},
							"キャンセル": function() {
								$( this ).dialog( "close" );
							}
						}

					});
					
				}); // end of dialog boxes
				
				// -------------------------------------------
				// EXPORT EXCEL NEW!!!! TODO: REMOVE OLD ONE.
				// -------------------------------------------
				
				$("#listDownloadExcel").click(function(e) {
					e.preventDefault();
					
					// open remove image dialog
					$( "#dialog-confirm" ).dialog("open");
					
				});
				
				// -------------------------------------------
			
				// -------------------------------------------
				// LIST PROPERTIES WINDOW
				// List Properties
				// -------------------------------------------
				// Initalize the window
				$("#dialogUpdateListProps").dialog({
					autoOpen: false,
					modal: true,
					height: 400,
					width: 750
				});
				
				// RELOAD THE PAGE
				$("#dialogUpdateListProps").on("dialogclose", function(){
					
					// if flag is set to true then reload the page
					if(reloadPage){
						location.reload();
					}
					
				});
			
				// -------------------------------------------
				// LIST PROPERTIES WINDOW
				// On Navi button click open and run
				// inital functions
				// -------------------------------------------
				
				$("#openListProps").on("click", function(){
					
					$("#dialogUpdateListProps h1").html(listName+"<span></span>");
					$("#dialogUpdateListProps").dialog("open"); // open dialog box
					
										
					GetListContents(listName); // get the current list contents
					
					GetAllSpecialItems(listName); // get all the special items
					
				});

				// -------------------------------------------
				// LIST PROPERTIES WINDOW
				// Button onClick calls
				// -------------------------------------------
				// -- ADD special items
				$("#specialItemsListAll").on("click", "button",	function(e){
					
					var specialItemNo = $(this).data("hb_add_special"); // set the special item no.
					var hb = $(this).data("hb");
					
					// make sure hb is not null before running the funciton
					if(hb != null){
						SpecialItemAdd(listName, hb, specialItemNo); // add the special item
					}
					
				});
				
				// -- REMOVE special items
				$("#specialItemsPerSelection").on("click", "button", function(e){
					
					var specialItemNo = $(this).data("hb_remove_special"); // set the special item no.
					var hb = $(this).data("hb");
					
					// make sure hb is not null before running the funciton
					if(hb != null){
						SpecialItemRemove(listName, hb, specialItemNo); // add the special item
					}
					
				});
				
				// -------------------------------------------
				// LIST PROPERTIES WINDOW
				// Update SP list Contents depending on what you clicked
				// -------------------------------------------
				
				$("#dialogUpdateListProps").on("click", ".selectHB", function(){
				
					// remove previous hinbanSelected classes
					$("#dialogUpdateListProps .tableShared td").removeClass("hinbanSelected");
					
					// toggle selected color
					$(this).toggleClass("hinbanSelected");
					
					var tfNo = $(this).data("hb");
					
					// Set the global tformNo here to get access to some persistant CSS changes
					persistantTformNo = tfNo;
					
					// update the title to what you have selected
					$("#dialogUpdateListProps h1 span").text("("+tfNo+")");
					
					// RELOAD/Update
					GetSpecialItems(listName, tfNo); // get the special items for the tform no
					GetAllSpecialItems(listName, tfNo); // get all the special items for the list
					
				});
				
				// -------------------------------------------
				// LIST PROPERTIES WINDOW
				// Update SP list Contents depending on what you clicked
				// -------------------------------------------
				
				$("#dialogUpdateListProps").on("click", ".selectHiddenToggle", function(){
					
					var tfNo = $(this).data("hb");
					
					HideItem(listName, tfNo);
				});
				
				// ------------------------------------------------------------
				// CONVERT TO EXCEL CALCULATION
				// Toggle data attributes to show the excel calculation formula
				// ------------------------------------------------------------
				$("#excelCalculationBtn").on("click", function(){
					
					jQuery(".targetThis").each(function(){
						var currentElement = $(this);
						var value = currentElement.attr("data-calc");
					
						currentElement.html(value);
					});
					
				});
				
				// ------------------------------------------------------------
				// CONVERT TO EXCEL CALCULATION
				// TODO: TEMP Rest Button
				// ------------------------------------------------------------
				$("#excelCalculationBtnReset").on("click", function(){
					
					jQuery(".targetThis").each(function(){
						var currentElement = $(this);
						var value = currentElement.attr("data-origvalue");
					
						currentElement.html(value);
					});
					
				});
				
				// ------------------------------------------------------------
				// CONVERT TO EXCEL CALCULATION
				// ------------------------------------------------------------
				// THIS IS FOR TESTING, DONT INCLUDE IN MAIN CODE.
				$("#newRefreshBtn").on("click", function(){
					// convertTableToExcelCalculation();
				});
                
                $("body").on("click", "#dialogSearchForNewItemsSelectAll", function(){
                    $("#searchNewItemsTable tbody input:checkbox").prop('checked', this.checked);
                });
               
				
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
// ____ ____ ____ ____ ____ ____ ____ ____ ____
//||F |||U |||N |||C |||T |||I |||O |||N |||S ||
//||__|||__|||__|||__|||__|||__|||__|||__|||__||
//|/__\|/__\|/__\|/__\|/__\|/__\|/__\|/__\|/__\|
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
				
				// ------------------------------------------------------------
				// CONVERT TO EXCEL CALCULATION
				// ------------------------------------------------------------
				function convertTableToExcelCalculation (){
					
					// start counting from row 1.
					var rowCounter = 1;

					jQuery(".targetRow").each(function() {

						var setTot = $(this).find('.setCounter').length;
						rowCounter += setTot;
						
						// offset for the current row
						var offsetRowCounter = ((rowCounter-setTot)+1);
                        
                        // -------------------------------------------------------------------
						// | set image link to path only for the macro to work |
						// -------------------------------------------------------------------
                        $(this).find('.imageLink').each(function(){
                           var a = $(this).attr("data-imglink");
                            $(this).html(a);
                        });
						
						
						// -------------------------------------------------------------------
						// | set percentage |
						// ------------------------
						$(this).find('.discountParCalc').each(function(){
							var a = $(this).attr("data-calc");
							$(this).html(a);
						});
						
						// -------------------------------------------------------------------
						// | set percentage |
						// ------------------------
						$(this).find('.tformPriceNoTaxCalc').each(function(){
							var a = $(this).attr("data-calc");
							$(this).html(a);
						});
						
						// -------------------------------------------------------------------
						// | set history bairitsu |
						// ------------------------
						
							var i = 0;
							$(this).find('.historyBairitsu').each(function(){
								
								// Find the correct ALPHABET based on the current postion of the td.
								// 1. get index of the current td.
								// 2. convert the id into an uppercase alphabet. (Uppercase start from 65)
								// 3. depending on the location of the needed variables in the caluclation
								//    add or subtract from the current index to get the correct letter.
								// ie: visIdx = String.fromCharCode(65 + visIdx); // is the current index converted to alphabet
								var visIdx = $(this).closest('td').index();
								var a = String.fromCharCode(65 + (visIdx-2));
								var b = String.fromCharCode(65 + (visIdx+2));
								
								
								var x = offsetRowCounter + i;
								var historyBairitsuCalc = "=((("+b+""+x+"-"+a+""+x+")/"+a+""+x+")*100)";
								$(this).html(historyBairitsuCalc);

								i++;
							});
						
						// -------------------------------------------------------------------
						// | set net price |
						// -----------------
						
							var i = 0;
							$(this).find('.netPrice').each(function(){
								
								var visIdx = $(this).closest('td').index();
								var a = String.fromCharCode(65 + (visIdx-3));
								var b = String.fromCharCode(65 + (visIdx-1));

								var x = offsetRowCounter + i;
								var netPriceCalc = "=(1-("+b+""+x+"/100))*"+a+""+x;
								$(this).html(netPriceCalc);

								i++;
							});
						
						// -------------------------------------------------------------------
						// | set exchange rate |
						// ---------------------
						
							var i = 0;
							$(this).find('.shiireCalc').each(function(){
								
								var visIdx = $(this).closest('td').index();
								var a = String.fromCharCode(65 + (visIdx-7));
								var b = String.fromCharCode(65 + (visIdx-6));
								var c = String.fromCharCode(65 + (visIdx-3));
								var d = String.fromCharCode(65 + (visIdx-2));
								var e = String.fromCharCode(65 + (visIdx-1));

								var x = offsetRowCounter + i;
								//var shiireCalc = '=IF(M'+x+'="YEN",N'+x+',P'+x+'*(Q'+x+'*((R'+x+'/100)+1)))';
								var shiireCalc = '=IF('+a+''+x+'="YEN",'+b+''+x+','+c+''+x+'*('+d+''+x+'*(('+e+''+x+'/100)+1)))';
								$(this).html(shiireCalc);

								i++;
							});
						
						// -------------------------------------------------------------------
						
						// -------------------------------------------------------------------
						// | set total value |
						// ---------------------
						
							var i = 0;
							$(this).find('.setTotal').each(function(){
								
								var visIdx = $(this).closest('td').index();
								var a = String.fromCharCode(65 + (visIdx-1));
								

								var x = offsetRowCounter + i;
								//var shiireCalc = '=IF(M'+x+'="YEN",N'+x+',P'+x+'*(Q'+x+'*((R'+x+'/100)+1)))';
								//var shiireCalc = '=IF('+a+''+x+'="YEN",'+b+''+x+','+c+''+x+'*('+d+''+x+'*(('+e+''+x+'/100)+1)))';
								//$(this).html(shiireCalc);
								
								//var setTotal = $(this).find(".setTotal");
								var setTotalCalc = "=SUM("+a+""+ offsetRowCounter + ":"+a+"" + rowCounter + ")";
								
								$(this).html(setTotalCalc);

								i++;
							});
						
						// -------------------------------------------------------------------
						
						
						// -------------------------------------------------------------------
						// | set total bairitsu |
						// ----------------------
						
							var i = 0;
							$(this).find('.totalBairitsu').each(function(){
								
								var visIdx = $(this).closest('td').index();
								var a = String.fromCharCode(65 + (visIdx-1));
								var b = String.fromCharCode(65 + (visIdx+1));
								

								var x = offsetRowCounter + i;
								//var shiireCalc = '=IF(M'+x+'="YEN",N'+x+',P'+x+'*(Q'+x+'*((R'+x+'/100)+1)))';
								//var shiireCalc = '=IF('+a+''+x+'="YEN",'+b+''+x+','+c+''+x+'*('+d+''+x+'*(('+e+''+x+'/100)+1)))';
								//$(this).html(shiireCalc);
								
								//var totalBairitsu = $(this).find(".totalBairitsu");
								var totalBairitsuCalc = "=("+b+""+offsetRowCounter+"/"+a+""+offsetRowCounter+")";
								//totalBairitsu.html(totalBairitsuCalc);
								
								$(this).html(totalBairitsuCalc);

								i++;
							});
						
						// -------------------------------------------------------------------
						
						// set total value
						/*
						var setTotal = $(this).find(".setTotal");
						var setTotalCalc = "=SUM(S" + offsetRowCounter + ":S" + rowCounter + ")";
						setTotal.html(setTotalCalc);
						*/
						// set total bairitsu
						/*
						var totalBairitsu = $(this).find(".totalBairitsu");
						var totalBairitsuCalc = "=(V"+offsetRowCounter+"/T"+offsetRowCounter+")";
						totalBairitsu.html(totalBairitsuCalc);
						*/
						//var currentElement = $(this).find(".row_id");
						//currentElement.html(value);

						//var totalCalculation = $(this).find(".totalCalc");
						//totalCalculation.html(value);


					});
					
					
				}
	
				// -------------------------------------------
				// LIST PROPERTIES WINDOW
				// Get the current list contents
				// -------------------------------------------
				
				function GetListContents(listName){
					
					$.ajax({
						type: "post",
						url: "exe/exeUpdateListProps.php",
						data: "listName=" + listName + "&action=GetListContents",
						success: function (data) {
							
							var box = $("#specialItemsList"); // grab the table id and store in variable.
							
							box.find("tbody").empty(); // clear the tbody before appending more
							
							
							$("#dialogUpdateListProps .tableShared td").removeClass("hinbanSelected"); // remove previous hinbanSelected classes
							
							
							// append the lines here for each special
							// item that is already matched with the tformNo
							for(var i = 0; i < data.length; i++){
								
								//initialize
								var star = "";
								var checked = "";
								var isHinbanSelected = "";
								var isHaiban = "";
								var isWeb = "";
								
								// check if it was the previously selected tformNo so we can add the isSelected class for css highlighting
								if(data[i].tformNo == persistantTformNo){
									// toggle selected color
									isHinbanSelected = "hinbanSelected";
								}
								
								// check if has special items or not and add a star
								if(data[i].specialItems.length > 0){
									star = " <span style='color: #ADADAD; float: right;'><i class='fa fa-star'></i></span>";
								} else {
									star = "";
								}
								
								
								// check if checked as hidden or not
								if(data[i].isHidden == 1){
									checked = "checked";
								} else {
									checked = "";
								}
								
								// check if haiban or not
								if(data[i].isHaiban){
									isHaiban = "<span style='color: crimson;'>(廃番)</span>";
								}
								
								// check if web or not
								if(data[i].isWeb){
									isWeb = "<span style='color: green;'> <i class='fa fa-globe fa-lg'></i></span>";
								} else {
									isWeb = "";
								}
								
								// append a new row for each item in the list
								var conts = 
									"<tr>\
									<td><input class='selectHiddenToggle' data-hb='"+data[i].tformNo+"' style='width: 100%;' type='checkbox' "+checked+"></td>\
									<td class='selectHB "+ isHinbanSelected +"' data-hb='"+data[i].tformNo+"'><span style='float: left;'>"+data[i].tformNo + " " + isHaiban + "</span> " + star + " </td>\
									<td>" + isWeb +　"</td>\
									</tr>";
								
								box.find("tbody").append(conts);
							}
							
						},
						error: function(e){
							// return an error here.
							alert("STEINS GATE ERROR!!!"+ e);
						}
					});
					
				}
				
				// -------------------------------------------
				// LIST PROPERTIES WINDOW
				// Get Special Items registered to the tformNo
				// listname, tformNo
				// -------------------------------------------
				
				function GetSpecialItems(listName, tformNo){
					
					$.ajax({
						type: "post",
						url: "exe/exeUpdateListProps.php",
						data: "tformNo="+ tformNo + "&listName=" + listName + "&action=GetSpecialItems",
						success: function (data) {
							
							var dat = data.split(","); // split the returned data into an array
							
							var box = $("#specialItemsPerSelection"); // grab the table id and store in variable.
							
							box.find("tbody").empty(); // clear the tbody before appending more
							
							// append the lines here for each special
							// item that is already matched with the tformNo
							
							if(dat[0].length != 0){
							
								for(var i = 0; i < dat.length; i++){
									
									// append a new row for each item in the list
									var conts = "<tr>\
													<td>" + dat[i] + "<button class='removeItem' data-hb='"+tformNo+"' data-hb_remove_special='"+dat[i]+"'> <i class='fa fa-minus'></i> </button></td>\
												</tr>";
									box.find("tbody").append(conts);
									
								}
								
							}
							
						},
						error: function(e){
							// return an error here.
							alert("dialogUpdateListProps onClick -- STEINS GATE ERROR!!!"+ e);
						}
					});
				}
				
				// -------------------------------------------
				// LIST PROPERTIES WINDOW
				// Get All Special Items registered to the list
				// and fill the List Properties window 
				// listname, tformNo
				// -------------------------------------------
				
				function GetAllSpecialItems(listName, tformNo){
					
					// incase tformNo is not set do not add the data attribute for the tform no.
					var tf = "";
					if(tformNo == null){
						tf = tf;
					} else {
						tf = "data-hb='"+tformNo+"'";
					}
					
					// Run ajax
					$.ajax({
						type: "post",
						url: "exe/exeUpdateListProps.php",
						data: "listName=" + listName + "&action=GetSpecialItemsAll",
						success: function (data) {
							
							var dat = data.split(","); // split the returned data into an array
							
							var box = $("#specialItemsListAll"); // grab the table id and store in variable.
							
							box.find("tbody").empty(); // clear the tbody before appending more
							
							for(var i = 0; i < dat.length; i++){
							
								// append a new row for each item in the list
								var conts = "<tr>\
												<td>" + dat[i] + "<button class='addItem' " + tf + " data-hb_add_special='"+dat[i]+"'> <i class='fa fa-plus'></i> </button></td>\
											</tr>";
							
								box.find("tbody").append(conts);
							}
							
						},
						error: function(e){
							// return an error here.
							alert("STEINS GATE ERROR!!!"+ e);
						}
					});
				}
				
				// -------------------------------------------
				// LIST PROPERTIES WINDOW
				// Add special item to the currently selected
				// tformNo.
				// listName, tformNo, specialItemNo
				// -------------------------------------------
				
				function SpecialItemAdd(listName, tformNo, specialItemNo){
					
					//AJAX HERE TO ADD ITEM
					$.ajax({
						type: "post",
						url: "exe/exeUpdateListProps.php",
						data: "listName=" + listName + "&action=SpecialItemAdd" + "&tformNo="+tformNo+"&itemToAdd="+specialItemNo,
						success: function (data) {
							
							ReloadPage(); // toggle reload page flag
							
							// reload the list contents
							GetListContents(listName);
							
							// reload the special items
							GetSpecialItems(listName, tformNo);
						},
						error: function(e){
							// return an error here.
							alert("SpecialItemAdd -- STEINS GATE ERROR!!!"+ e);
						}
					});
					
				}

				// -------------------------------------------
				// LIST PROPERTIES WINDOW
				// Remove special item from the currently 
				// selected tformNo.
				// listName, tformNo, specialItemNo
				// -------------------------------------------
				
				function SpecialItemRemove(listName, tformNo, specialItemNo){
					
					//AJAX HERE TO ADD ITEM
					$.ajax({
						type: "post",
						url: "exe/exeUpdateListProps.php",
						data: "listName=" + listName + "&action=SpecialItemRemove" + "&tformNo="+tformNo+"&itemToRemove="+specialItemNo,
						success: function (data) {
							
							ReloadPage(); // toggle reload page flag
							
							// reload the list contents
							GetListContents(listName);
							
							// reload the special items
							GetSpecialItems(listName, tformNo);
						},
						error: function(e){
							// return an error here.
							alert("SpecialItemRemove -- STEINS GATE ERROR!!!"+ e);
						}
					});
				}

				// -------------------------------------------
				// LIST PROPERTIES WINDOW
				// Hide/Show Items
				// listName, tformNo
				// -------------------------------------------
				
				function HideItem(listName, tformNo){
					
					//AJAX HERE TO ADD ITEM
					$.ajax({
						type: "post",
						url: "exe/exeUpdateListProps.php",
						data: "listName=" + listName + "&action=HideItem" + "&tformNo="+tformNo,
						success: function (data) {
							
							ReloadPage(); // toggle reload page flag
							
						},
						error: function(e){
							// return an error here.
							alert("ItemHide -- STEINS GATE ERROR!!!"+ e);
						}
					});
					
				}

				// -------------------------------------------
				// EDIT MAKER PRICE WINDOW
				// Edit the maker list price
				// listName, tformNo, newPrice
				// -------------------------------------------
				
				function EditMakerPrice(listName, tformNo, newPrice){
					
					// START AJAX HERE!!!!!
					$.ajax({
						type: "post",
						url: "exe/exeUpdateListProps.php",
						data: "listName=" + listName + "&action=UpdateMakerPrice" + "&tformNo="+tformNo+ "&newPrice="+newPrice,
						success: function (data) {
							
							console.log(data);
							
							
						},
						error: function(e){
							console.log(e);
							// return an error here.
							//alert("EditMakerPrice -- STEINS GATE ERROR!!!"+ e);
						}
					});
				}
				
				// -------------------------------------------
				// RELOAD PAGE
				// Set reload page flag if changes made to
				// anything in the list properties window.
				// add this to callback of following functions:
				// ---------------------
				// SpecialItemAdd()    |
				// SpecialItemRemove() |
				// HideItem()          |
				// ---------------------
				// -------------------------------------------
				
				function ReloadPage(){
					reloadPage = true;
				}
				
				// -------------------------------------------
				// Show Tool Tip
				// -------------------------------------------
				function ShowToolTip(message) {
					$("#toolTip").toggle();
					$("#toolTip h1").text(message);
				}
				
				// -------------------------------------------
				// Export Excel
				// -------------------------------------------
				function outputExcel(tableid, listName){
					//getting data from our table
					var data_type = 'data:application/vnd.ms-excel';
					var table_div = document.getElementById(tableid);
					var table_html = table_div.outerHTML.replace(/ /g, '%20');

					var a = document.createElement('a');
					a.href = data_type + ', ' + table_html;
					a.download = listName + Math.floor((Math.random() * 9999999) + 1000000) + '.xls';
					
					a.click(); // TEMP WHILE WORKING ON BLOB
					
	
				}
				
				// -------------------------------------------
				// DOWNLOAD LARGE EXCEL
				// -------------------------------------------
				/*
				$("#confirm_btn").on("click", function(){
					outputLargeExcel("mainTable", "ALMAR_LIST");
				});
				*/
				function outputLargeExcel(tableid, listName){
					//getting data from our table
					
					
					// ************************************************************************************************
					
					
					function dataURItoBlob(dataURI, callback) {
						
						var binStr = atob(dataURI.split(',')[1]),
							len = binStr.length,
							arr = new Uint8Array(len),
							mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]

						for (var i = 0; i < len; i++) {
							arr[i] = binStr.charCodeAt(i);
						}

						return new Blob([arr], {
							type: mimeString
						});

					}
					
					var dataURI_DL = function () {
						
						var data_type = 'data:application/vnd.ms-excel;base64,';
						var table_div = document.getElementById(tableid);
						var table_html = table_div.outerHTML.replace(/ /g, ' ');


						var dataURI = data_type + btoa(unescape(encodeURIComponent(table_html)));


						var blob = dataURItoBlob(dataURI);
						
						
						

						var url = URL.createObjectURL(blob);

						var blobAnchor = document.getElementById('blob');
						var dataURIAnchor = document.getElementById('dataURI');
						
						// name plus timestamp
						blobAnchor.download = dataURIAnchor.download = listName + jQuery.now() + '.xls';
						
						blobAnchor.href = url;
						dataURIAnchor.href = dataURI;
						
						document.getElementById('blob').click();
						
						blobAnchor.onclick = function() {
							requestAnimationFrame(function() {
							  URL.revokeObjectURL(url);
							})
						};
						
						// ------------------------------------------------
						// CONVERT THE DATA BACK INTO THE ORIG STYLE DATA,
						// this will remove the excel formatting.
						//-------------------------------------------------
						restoreTableFormat();
						
					};
					
					
					function start() {
						
						var blobAnchor = document.getElementById('blob');
						
						var xhr = new XMLHttpRequest();
						xhr.responseType = 'blob';
						xhr.onload = function() {
							status.textContent = 'converting';
							var fr = new FileReader();
							fr.onload = dataURI_DL;
							fr.readAsDataURL(this.response);
						};
						
						
						
						xhr.open('GET', blobAnchor.href);
						xhr.send();
						
						//confirm_btn.parentNode.removeChild(confirm_btn);
						
					};

					//confirm_btn.onclick = start;
					start();
					// ************************************************************************************************
				}

				
				// ------------------------------------------------
				// CONVERT THE DATA BACK INTO THE ORIG STYLE DATA,
				// this will remove the excel formatting.
				//-------------------------------------------------
				function restoreTableFormat(){
					jQuery(".targetThis").each(function(){
						var currentElement = $(this);
						var value = currentElement.attr("data-origvalue");

						currentElement.html(value);
					});
				}
				
				
				// -------------------------------------------
				// SPECIAL ITEMS MENU
				// Get All Special Items registered to the list
				// listname
				// -------------------------------------------
				
				function UpdateSpecialItems(listName){
					
					
					// Run ajax
					$.ajax({
						type: "post",
						url: "exe/exeUpdateListProps.php",
						data: "listName=" + listName + "&action=GetSpecialItemsAll",
						success: function (data) {
							
							var dat = data.split(","); // split the returned data into an array
							
							var box = $("#leftBoxContents"); // grab the table id and store in variable.
							
							box.empty(); // clear the contents before appending more
							
							// Append a new box for each item in the list
							for(var i = 0; i < dat.length; i++){
							
								var conts = "<div class='specialItemsBox'>" + dat[i] + "<button class='removeItemSpecial' data-hbid='"+dat[i]+"'><i class='fa fa-minus'></i></button></div>";
							
								// check if the list is empty, if do not then there will be an empty box in the div.
								if (dat[0] != "") {
									box.append(conts);
								}
							}
							
						},
						error: function(e){
							// return an error here.
							alert("STEINS GATE ERROR!!!"+ e);
						}
					});
				}
				
				// -------------------------------------------
				// SPECIAL ITEMS MENU
				// Search Main for items to add to the special
				// items list.
				// listName, tformNo
				// -------------------------------------------
				
				function SearchForSpecialItems(listName, tformNo){
				
					// Run ajax
					$.ajax({
						type: "post",
						url: "exe/exeEditListSpecialItems.php",
						data: "listName=" + listName + "&tformNo=" + tformNo + "&action=SearchForSpecialItems",
						success: function (data) {
														
							var box = $("#rightBoxContents"); // grab the table id and store in variable.
							
							box.empty(); // clear the tbody before appending more
							
							// for each item in the returned array append to the right right box
							for(var i = 0; i < data.length; i++){
								
								var conts = "<div class='specialItemsBox'>" + data[i].tformNo + "<br>" + data[i].type + "<button class='addItemSpecial' data-hbid='"+data[i].tformNo+"'><i class='fa fa-plus'></i></button></div>";
							
								box.append(conts);
							}
							
						},
						error: function(e){
							// return an error here.
							alert("STEINS GATE ERROR!!!"+ e);
						}
					});
				}
				
				// -------------------------------------------
				// SPECIAL ITEMS MENU
				// Add Items to special items
				// items list.
				// tformNo
				// -------------------------------------------
				
				function AddSpecialItems(listName, tformNo){
					
					// Run ajax
					$.ajax({
						type: "post",
						url: "exe/exeEditListSpecialItems.php",
						data: "listName=" + listName + "&tformNo=" + tformNo + "&action=AddSpecialItems",
						success: function (data) {
							console.log(data);
							// Update the current list contents
							UpdateSpecialItems(listName);
						},
						error: function(e){
							// return an error here.
							alert("STEINS GATE ERROR!!!"+ e);
						}
					});
				}
				
				// -------------------------------------------
				// SPECIAL ITEMS MENU
				// Remove Items to special items
				// items list.
				// tformNo
				// -------------------------------------------
				function RemoveSpecialItems(listName, tformNo){
					
					// Run ajax
					$.ajax({
						type: "post",
						url: "exe/exeEditListSpecialItems.php",
						data: "listName=" + listName + "&tformNo=" + tformNo + "&action=RemoveSpecialItems",
						success: function (data) {
							
							// Update the current list contents
							UpdateSpecialItems(listName);
						},
						error: function(e){
							// return an error here.
							alert("STEINS GATE ERROR!!!"+ e);
						}
					});
				
				}
				
				
				// -------------------------------------------
				// SPECIAL FOR NEW ITEMS
				// Search Main for new items to add to the list
				// listName, tformNo
				// -------------------------------------------
				
				function SearchForNewItems(listName, tformNo){
				
                    var fileMakerImageLocation = $("#filemakerImageLocation").val();
                    
					// Run ajax
					$.ajax({
						type: "post",
						url: "exe/exeNewItemSearchAndUpdate.php",
						data: "listName=" + listName + "&tformNo=" + tformNo + "&action=SearchForNewItems",
						success: function (data) {
							
							// CLEAR OUT TABLE BEFORE NEW DATE IS PUT IN
							$("#dialogSearchForNewItems table tbody").empty();

							
							var dt = data;
							
							// TODO: testSORT
							data.sort(function(a,b){
								if(a["haiban"] > b["haiban"]) return 1;
								if(a["haiban"] < b["haiban"]) return -1;
								if(a["web"] < b["web"]) return 1;
								if(a["web"] > b["web"]) return -1;
								if(a["tformNo"] > b["tformNo"]) return 1;
								if(a["tformNo"] < b["tformNo"]) return -1;
								return 0;
							});
							
							
							
							for(var i = 0; i < data.length; i++){
								
								// checkbox --
								var data1 = "<td><input type='checkbox' data-tf='"+data[i].tformNo+"' style='width: 25px; height: 25px; margin: 5px;'></td>";

								// image --
								var data2 = "";
								
								// check if image blank empty
								if( data[i].thumb == "" ){
									data2 = "<td><i class='fa fa-image' style='font-size: 40px; color: #CCC;'></i></td>";
								} else {
									data2 = "<td><img src='"+fileMakerImageLocation+data[i].thumb+"' style='width: 50px'></td>";
                                    //data2 = "<td>"+fileMakerImageLocation+data[i].thumb+"</td>";
								}
								
								// tformNo --
								var data3 = "<td>"+data[i].tformNo+"</td>";
								
								// haiban --
								var data4 = "";
								
								if(data[i].haiban){
									data4 = "<td>廃番</td>";
								} else {
									data4 = "<td></td>";
								}
								
								// web --
								var data5 = "";
								if(data[i].web){
									var data5 = "<td>WEB</td>";
								} else {
									var data5 = "<td></td>";
								}
								
								
								// maker no --
								var data6 = "<td>"+data[i].makerNo+"<br>"+data[i].orderNo+"</td>";
								
								// type --
								var data7 = "<td>"+data[i].type+"</td>";
								
								// final concat
								var final = "<tr>"+data1+data2+data3+data4+data5+data6+data7+"</tr>";

								$("#searchForNewItemsContent table tbody").append(final);
								
							
							}
							
						},
						error: function(e){
							// return an error here.
							console.log("STEINS GATE ERROR!!!"+ e);
						}
					});
				}
				
				
				// -------------------------------------------
				// SPECIAL FOR NEW ITEMS
				// Search Main for new items to add to the list
				// listName, tformNo
				// -------------------------------------------
				
				function SearchForNewItemsAdd(listName, tformNo){
				
					// Run ajax
					$.ajax({
						type: "post",
						url: "exe/exeNewItemSearchAndUpdate.php",
						data: "listName=" + listName + "&tformNo=" + tformNo + "&action=AddNewItems",
						success: function (data) {
                        
                        console.log("SUCCESS: ");
						console.log(data);
						location.reload();
							
						},
						error: function(e){
							// return an error here.
							console.log("STEINS GATE ERROR!!!");
                            console.log(e);
						}
					});
                    
				}
			
			});
	
		</script>
</head>
<div id='wrapper'>
	<div id='loading'>
		<span class='loadingGifMain'> <img src='<?php echo $path;?>/img/142.gif'><br> LOADING ... </span>
	</div>
	<?php require_once '../header.php';?>
    <input id="filemakerImageLocation" type="hidden" value="<?php echo $filemakerImageLocation; ?>">;
		<div id="listNavi">
			<div id="listNameHeader"></div>
			<span id="openListProps" class="fa-stack fa-lg" title="オプション設定">
				<i style="color: #FFFFFF;" class="fa fa-square fa-stack-2x"></i>
				<i style="color: #8E8E8E;" class="fa fa-list fa-stack-1x fa-inverse"></i>
			</span>
			
			<span id="toggleHiddenItems" class="fa-stack fa-lg" data-column="0" title="アイテム表示・非表示">
				<i style="color: #FFFFFF;" class="fa fa-square fa-stack-2x"></i>
				<i style="color: #8E8E8E;" class="fa fa-eye-slash fa-stack-1x fa-inverse"></i>
			</span>
			
			<span id="hideHaiban" class="fa-stack fa-lg" title="廃番表示・非表示">
				<i style="color: #FFFFFF;" class="fa fa-square fa-stack-2x"></i>
				<i style="color: #C9385A;" class="fa fa-ban fa-stack-1x"></i>
			</span>
			<span id="openSpecialItems" class="fa-stack fa-lg" title="オプションリスト修正">
				<i style="color: #FFFFFF;" class="fa fa-square fa-stack-2x"></i>
				<i style="color: #8E8E8E;" class="fa fa-star fa-stack-1x fa-inverse"></i>
			</span>
			
			<!-- ------------------------------------------------------
				USED FOR EXPORT OF BLOB DATA
				TODO: Work on a way to do this without the actual links.
			-->
			<a id="blob"></a>
			<a id="dataURI"></a>
			<!-- --------------------------------------------------- -->
			
			<!-- START These are the buttons for testing the export of excel with the calculations intact -->
			
			<!--
			<span style="float:right;" id="newRefreshBtn" class="fa-stack fa-lg" title="DONT CLICK!!!!">
				<i style="color: #FFFFFF;" class="fa fa-square fa-stack-2x"></i>
				<i style="color: #8E8E8E;" class="fa fa-warning fa-stack-1x fa-inverse"></i>
			</span>
			
			<span style="float:right;" id="excelCalculationBtn" class="fa-stack fa-lg" title="EXCEL計算式にコンバート">
				<i style="color: #FFFFFF;" class="fa fa-square fa-stack-2x"></i>
				<i style="color: #8E8E8E;" class="fa fa-calculator fa-stack-1x fa-inverse"></i>
			</span>
			
			<span style="float:right;" id="excelCalculationBtnReset" class="fa-stack fa-lg" title="EXCEL計算式に RESET">
				<i style="color: #FFFFFF;" class="fa fa-square fa-stack-2x"></i>
				<i style="color: #8E8E8E;" class="fa fa-refresh fa-stack-1x fa-inverse"></i>
			</span>
			
			<span style="float:right;" id="excelCalculationBtnShowAllCols" class="fa-stack fa-lg" title="EXCEL計算式に RESET">
				<i style="color: #FFFFFF;" class="fa fa-square fa-stack-2x"></i>
				<i style="color: #8E8E8E;" class="fa fa-bomb fa-stack-1x fa-inverse"></i>
			</span>
			-->
			
			<span style="float:right;" id="searchForNewItemsBtn" class="fa-stack fa-lg" title="Search for new items to insert to list">
				<i style="color: #FFFFFF;" class="fa fa-square fa-stack-2x"></i>
				<i style="color: #8E8E8E;" class="fa fa-search fa-stack-1x fa-inverse"></i>
			</span>
			<!-- These are the buttons for testing the export of excel with the calculations intact END -->
			
		</div>
		<div id='contents'>
			<!-- PAGE CONTENTS START HERE -->
<!-- FILTER --------------------------------------------------------------------------------------->
			<div id="dialogFilter" title="列表示フィルター">
				<span style="color: crimson;">※ ボッタンクリックしたら、列は表示・非表示します。</span><br>
				<span style="color: crimson;">※ WEB表示、オーダー品番のデフォルトは非表示に設定しています。</span><br>
				<span class="memoBox"></span> <span style="color: crimson;">色のボタンはEXCEL計算式の為必要です。その列非表示にしたら計算は間違いになります。ご注意ください。</span><br>
				<br><hr><br>
				<button class='toggle-vis' data-column="0"><i class="fa fa-eye-slash"></i><span class="btnTxt">表示</span></button>
				<button class='toggle-vis' data-column="1"><i class="fa fa-image"></i><span class="btnTxt">イメージ</span></button>
				
				<button class='toggle-vis' data-column="2"><i class="fa fa-barcode"></i><span class="btnTxt">Tform品番</span></button>
				
				
				
				<button class='toggle-vis' data-column="3">
					<span class="fa-stack fa-lg">
					  <i style="color: #DB4F4F;" class="fa fa-ban fa-stack-2x text-danger"></i>
					</span>
					<span class="btnTxt">廃番</span>
				</button>
				<button class='toggle-vis' data-column="4"><i class="fa fa-check-square-o"></i><span class="btnTxt">WEB表示</span></button>
				<button class='toggle-vis' data-column="5"><i class="fa fa-sitemap"></i><span class="btnTxt">シリーズ</span></button>
				<button class='toggle-vis' data-column="6"><i class="fa fa-arrows"></i><span class="btnTxt">サイズ</span></button>
				<button class='toggle-vis' data-column="7"><i class="fa fa-barcode"></i><span class="btnTxt">メーカー品番</span></button>
				<button class='toggle-vis' data-column="8"><i class="fa fa-barcode"></i><span class="btnTxt">オーダー品番</span></button>
				<div class="clear"></div>
				<br><hr><br>
				<!-- Excel Needs the following columns for calculation -->
				<button class='toggle-vis neededByExcel' data-column="9"><i class="fa fa-sitemap"></i><span class="btnTxt">セット</span></button>
				<button class='toggle-vis neededByExcel' data-column="10"><i class="fa fa-money"></i><span class="btnTxt">前PL</span></button>
				
				<button class='toggle-vis neededByExcel' data-column="11"><i class="fa fa-calendar"></i><span class="btnTxt">履歴日付</span></button>
				
				<button class='toggle-vis neededByExcel' data-column="12"><i class="fa fa-line-chart"></i><span class="btnTxt">値上率</span></button>
				<button class='toggle-vis neededByExcel' data-column="13"><i class="fa fa-eur"></i><span class="btnTxt">通貨</span></button>
				<button class='toggle-vis neededByExcel' data-column="14"><i class="fa fa-money"></i><span class="btnTxt">PL</button>
					
				<button class='toggle-vis neededByExcel' data-column="15"><i class="fa fa-calendar"></i><span class="btnTxt">日付</span></button>
					
				<button class='toggle-vis neededByExcel' data-column="16"><i class="fa fa-line-chart"></i><span class="btnTxt">値引率</span></button>
				<button class='toggle-vis neededByExcel' data-column="17"><i class="fa fa-money"></i><span class="btnTxt">NET</span></button>
				
				<button class='toggle-vis neededByExcel' data-column="18"><i class="fa fa-jpy"></i><span class="btnTxt">為替</span></button>
				<button class='toggle-vis neededByExcel' data-column="19"><i class="fa fa-percent"></i><span class="btnTxt">経費</span></button>
					
				<button class='toggle-vis neededByExcel' data-column="20"><i class="fa fa-jpy"></i><span class="btnTxt">仕入原価</span></button>
				<button class='toggle-vis neededByExcel' data-column="21"><i class="fa fa-jpy"></i><span class="btnTxt">原価合計</span></button>
				<button class='toggle-vis neededByExcel' data-column="22"><i class="fa fa-line-chart"></i><span class="btnTxt">倍率</span></button>
				<button class='toggle-vis neededByExcel' data-column="23"><i class="fa fa-shopping-cart"></i><span class="btnTxt">販売価格</span></button>
			</div>
				
<!-- EXCEL OPTIONS --------------------------------------------------------------------------------------->
			<div id="dialog-confirm" title="EXCEL">
				書き出しオプション選んでください。<br>
				<br><span style="color: crimson;"><i class="fa fa-warning"></i> イメージの列表示している場合は数分かかる可能性があります。</span>
			</div>

<!-- SPECIAL ITEMS ------------------------------------------------------------------------------------------>
			<div id="dialogSpecialItems" title="オプションリスト修正"><h1>Special Items 品番</h1>

				<div id="leftBox">
				
					<div style="height: 30px; width: 100%;">リスト内容</div>
					<div id="leftBoxContents"></div>
				</div>
				<div id="rightBox">
					
					<div style="height: 30px; width: 100%;"><i class="fa fa-search"></i><input type="text"></div>
					<div id="rightBoxContents"></div>
				</div>

			</div>
				
<!-- EDIT PRICES --------------------------------------------------------------------------------------->
			<div id="dialogEditPrices" title="メーカー価格修正">
				
					<h1 data-tformnohb="">Edit Prices</h1>
					<h2>makerNo</h2>
				
					<div id="dialogEditPricesImg"></div>
					
					<div class="editPriceContents">現在メーカー価格: <span id="currentPL"></span></div>
					<div class="editPriceContents">新メーカー価格:　<input type="number" min="0"></div>
					
			</div>

<!-- LIST PROPERTIES --------------------------------------------------------------------------------------->
			<div id="dialogUpdateListProps" title="オプション設定">
				<h1><span></span></h1><br>
				<div style="width: 100%; height: 300px;">
					<!-- ============================================================================= -->
					<div style="width: 250px; height: 300px; overflow: auto; background-color: #FFFFFF; float: left; margin-right: 10px;">
						<table id="specialItemsList" class="tableShared tableSharedHover">
							<thead>
								<tr>
									<th>表示</th>
									<th>tform品番</th>
									<th>WEB</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
					
					<!-- ============================================================================= -->
					<div style="width: 200px; height: 300px; overflow: auto; background-color: #FFFFFF; float: left;  margin-right: 10px;">
						<table id="specialItemsPerSelection" class="tableShared">
							<thead>
								<tr>
									<th>SPアイテム <i class="fa fa-star" style="color: #8E8E8E"></i></th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
					<!-- ============================================================================= -->
					
						<div style="width: 225px; height: 300px; overflow: auto; background-color: #FFFFFF; float: left;  margin-right: 10px;">
						<table id="specialItemsListAll" class="tableShared">
							<thead>
							<tr>
								<th>SPアイテム修正</th>
							</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
					<!-- ============================================================================= -->
				</div>
				
			</div>

<!-- SEARCH FOR NEW ITEMS ------------------------------------------------------------------------------------------>
			<div id="dialogSearchForNewItems" title="新規アイテム検索">
				※現在のリスト品番以外の品番検索
                <input style='margin-left: 10px; width: 16px; height: 16px;' type="checkbox" id='dialogSearchForNewItemsSelectAll'><span style='color: crimson; font-weight: 700;'>SELECT ALL</span></span>
				<div style="float:right;">
					<input type="text" style="height: 22px;" id="newItemsSearchBar">
					<span style="" id="" class="fa-stack fa-lg" title="Search">
						<i style="color: #8E8E8E;" class="fa fa-square fa-stack-2x"></i>
						<i style="color: #FFFFFF;" class="fa fa-search fa-stack-1x fa-inverse"></i>
					</span>
				</div>
				<div class="clear"></div>
					<br><hr><br>
				
				<div id="searchForNewItemsContent">
					<div class="topBox">
						<table id="searchNewItemsTable">
							<thead>
								<tr>
									<th>☑</th>
									<th style="width: 50px;">IMG</th>
									<th style="width: 150px;">TF品番</th>
									<th style="width: 40px;">廃番</th>
									<th>WEB表示</th>
									<th>メーカー品番<br>オーダー品番</th>
									<th>タイプ</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
					<div class="bottomBox">
						<button id="newItemSearchAddBtn">ADD</button>
						<button id="newItemSearchCancelBtn">CANCEL</button>
					</div>
				</div>
			</div>
<!-- TOOLTIPS --------------------------------------------------------------------------------------->
			<div id="toolTip"><h1 style="font-weight: normal; font-size: 16px; line-height: 30px;"></h1></div>

			<div id='saveWrapper'><!-- save wrapper -->
				<table id="mainTable">
					<thead>
						<tr>
							<th>表示</th>
							<th>イメージ</th>
							<th>Tform品番</th>
							<th>廃番</th>
							<th>WEB表示</th>
							<th>シリーズ</th>
							<th>サイズ</th>
							<th>メーカー品番</th>
							<th>オーダー品番</th>
							<th>セット</th>
							<th>前PL</th>
							<th>年/メモ</th>
							<th>値上率</th>
							<th>通貨</th>
							<th>PL</th>
							<th>年/メモ</th>
							<th>値引率</th>
							<th>NET</th>
							<th>為替</th>
							<th>経費</th>
							<th>仕入原価</th>
							<th>原価合計</th>
							<th>倍率</th>
							<th>販売価格</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div><!-- save wrapper -->
			<!-- PAGE CONTENTS END HERE -->
		</div>
</div>
<?php require_once '../master/footer.php';?>
	</body>
</html>

