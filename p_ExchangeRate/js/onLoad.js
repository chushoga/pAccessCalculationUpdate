$(document).ready(function () {
	
	// on windows resize
	$(window).resize(function(){
	
	});
	
	// SET DATEPICKER JQUERY
	$("#searchFrom").datepicker({
		dateFormat: 'yy-mm-dd'
	});
	$("#searchTo").datepicker({
		dateFormat: 'yy-mm-dd'
	});
	
	// start datatables
	var oTable = $("#generalTable").DataTable({
		info: false,
		paging: false,
		order: [[ 3, "asc" ]],
		fixedHeader: true,
		"columnDefs": [
			{ className: "getPLTotal", "targets": [5] },
			{ className: "getProductTotal", "targets": [7] }
		]
	});

	// ----------------------------------------
	// Check if array contains a string already
	// returns true if already inside.
	// ----------------------------------------
	function eleContainsInArray(arr, element) {
		if (arr != null && arr.length > 0) {
			for (var i = 0; i < arr.length; i++) {
				if (arr[i] == element) {
					return true;
				}
			}
		}
		return false;
	}
	// ----------------------------------------
	
	// ----------------------------------------
	// Query database based on input from
	// search bar
	// ----------------------------------------
	
	// -- Results arrays --
	var dataRates = [];
	var dataDates = [];
	var datesAndRates = [];
	
	// ********************************************* //
	// CREATE GRAPH
	// !! this just initalizes the chart. There is 
	// !! no actual data yet so it just sets at size.
	// ********************************************* //
	
	var ctx = $("#myChart");
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: dataDates,
			datasets: [{
				label: 'EURO',
				data: dataRates,
				lineTension: 0.1,
				backgroundColor: "rgba(75,192,192,0.4)",
				borderColor: "rgba(75,192,192,1)",
				borderCapStyle: 'butt',
				borderDash: [],
				borderDashOffset: 0.0,
				borderJoinStyle: 'miter',
				pointBorderColor: "rgba(64,156,156,1)",
				pointBackgroundColor: "#fff",
				pointBorderWidth: 3,
				pointHoverRadius: 5,
				pointHoverBackgroundColor: "rgba(75,192,192,1)",
				pointHoverBorderColor: "rgba(220,220,220,1)",
				pointHoverBorderWidth: 2,
				pointRadius: 1,
				pointHitRadius: 10,
				spanGaps: true
			}]
		},
		options: {
			scales: {
				display : true,
				yAxes: [{
						position: "left",
						scaleLabel: {
						display: true,
						labelString: "為替レート",
						fontSize: "12"
					},
					ticks: {
						beginAtZero: true
					}
				}]
			},
			animation: {
				during: 2000,
				easing: "easeOutCubic"
			}
		}
	});
	// ********************************************* //
	
	// ********************************************* //
	// TOGGLE MAKER or CURRENCY
	// ********************************************* //
	// -- css toggle properties
	var cssOptionsFocus = {"opacity": 1, "background-color": "#CCC", "color": "#000" };
	var cssOptionsFocusOff = {"opacity": 0.7, "background-color": "white", "color": "#CCC" };
	var toggleMaker = false; // set as default to true;
	var toggleAllMaker = false;
	var toggleCurrency = true;
	
	// -- toggle currency
	$("#searchCurrency").on('click', function(){
		$("#searchMaker").val(""); // reset maker text search box
		$("#searchAllMakers").attr('checked', false); // remove check from search all makers
		
		// set opacity
		$("#boxMaker").css(cssOptionsFocusOff);
		$("#boxAllMaker").css(cssOptionsFocusOff);
		$("#boxCurrency").css(cssOptionsFocus);
		
		// toggles
		toggleMaker = false;
		toggleAllMaker = false;
		toggleCurrency = true;
	});
	
	// -- toggle maker
	$("#searchMaker").on('click', function(){
		$("#searchCurrency").val(""); // reset currency dropdown list
		$("#searchAllMakers").attr('checked', false);
		
		// set opacity
		$("#boxMaker").css(cssOptionsFocus);
		$("#boxAllMaker").css(cssOptionsFocusOff);
		$("#boxCurrency").css(cssOptionsFocusOff);
		
		// toggles
		toggleMaker = true;
		toggleAllMaker = false;
		toggleCurrency = false;
	});
	
	// -- toggle search all makers
	$("#searchAllMakers").on('click', function(){
		$("#searchCurrency").val(""); // reset currency dropdown list
		$("#searchMaker").val("");
		
		// set opacity
		$("#boxMaker").css(cssOptionsFocusOff);
		$("#boxAllMaker").css(cssOptionsFocus);
		$("#boxCurrency").css(cssOptionsFocusOff);
		
		// toggles
		toggleMaker = false;
		toggleAllMaker = true;
		toggleCurrency = false;
	});
	
	
	// ********************************************* //
	// BINDING
	// ********************************************* //
	// -- press the search button on enter click
	// -- if the maker input has focus
	$("#searchMaker").bind("keyup", function(e){
		if(e.keyCode === 13) {
			genTable(); // generate the table
		}
	});
	// *********************************************
	
	$("#searchBtn").on("click",function() {
		genTable(); // generate the table
	});
	
	// ********************************************* //
	// CHECK FOR DUPLICATES IN Array
	// returns bool (true for in array)
	// ********************************************* //
	function checkForDoubles(arr, needle1, needle2){
		
		var isInArray = false;
		
		if(arr.length != 0){
			for(var i = 0; i < arr.length; i++){
				
				if (arr[i][0] == needle1 && arr[i][1] == needle2) {
					isInArray = true;
					break;
				}
				
			}
			
		}
		return isInArray;
	}
	
	
	function genTable(){
		
		// START OF FUNCTION
		// clear current table body
		oTable.clear();
		
		// -- Search VARS --
		
		// first check if searching for maker or currency
		// search maker
		// search currency
		var searchForMaker = false;
		var searchForCurrency = false;
		
		
		var searchMaker = $("#searchMaker").val();
		var searchCurrency = $("#searchCurrency").val();
		
		// Check if searching all makers.
		var searchAllMakers = false;

		if($("#searchAll").is(":checked")){
			searchAllMakers = true;
		} else {
			searchAllMakers = false;
		}
		
		// --------
		var searchAllCurrency = false;
		
		if(searchCurrency != ""){
			searchAllCurrency = true;
			//console.log(searchCurrency);
		} else {
			searchAllCurrency = false;
			//console.log("DONT SEARCH FOR CURRENCY");
		}
		
		
		var searchFrom = $("#searchFrom").val();
		var searchTo = $("#searchTo").val();

		$.ajax({
			type: "post",
			url: "exe/process.php",
			data: "action=getMain" + "&searchFrom=" + searchFrom + "&searchTo=" + searchTo,
			success: function (data) {
				
				// clear the arrays first before putting new data into it.
				//dataRates = [];
				dataDates = [];
				datesAndRates = [];
			
				for (var j = 1; j < data.length; j++) {
					for (var i = 1; i < 21; i++) {
// LOOP START ------------------------------------------------------------------------------------------------------------------
				// FIRST CHECK IF DATE WITHIN BOUNDS AND IF NOT IGNORE
						var a = Date.parse(data[j]['date_' + i]);
						var b = Date.parse(searchFrom);
						var c = Date.parse(searchTo);
						if(a >= b && a <= c){

							var id = data[j]['id'];
							var orderNo = data[j]['orderNo_' + i];
							var makerName = data[j]['makerName_' + i];
							var currency = data[j]['currency1_' + i];
							var amount = data[j]['currency2_' + i];
							var date = data[j]['date_' + i];
							var rate = data[j]['rate_' + i];
							var kawaseTotal;

							// -----------------------------------------------------
							// FOR CHECKING IF DATE IS SET OR NOT.
							// IF NOT SET TO THE RECORD DATE AND NOT INDIVIDUAL RATE
							if (date == null || date == "0000-00-00" || date == "") {
								date = data[j]['date'];
							} else {
								date = date;
							}

							// ***********************************************

							// CALCULATE TRUE KAWASE RATE --------------------------
							// a = price * kawase rate
							// b = sum of all a
							// c = sum of all price
							// total = b / c

							// inner for loop and break out after the current id no
							// longer matches the prevous id.
							// --------------------------------------------------------

							var tempKawaseA = 0;
							var tempKawaseB = 0;
							var tempKawaseC = 0;
							var tempKawaseTotal = 0;

							for (var a = 1; a < 21; a++) {
								 if (data[j]['makerName_' + a].toUpperCase() == makerName.toUpperCase()){
									 tempKawaseA = parseFloat(data[j]['currency2_' + a]) * parseFloat(data[j]['rate_' + a]);
									 tempKawaseB += tempKawaseA;
									 tempKawaseC += parseFloat(data[j]['currency2_' + a]);
								 }
							}
							tempKawaseTotal = tempKawaseB / tempKawaseC;

							// ignore blank maker names and rates
							// TODO: do we need this?? It is not used here...
							var kawaseWith2Decimals = 0;
							if(makerName != "" && rate != 0){
								//kawaseWith2Decimals = tempKawaseTotal.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
							}

							// -----------------------------------------------------

							// calculated yen price
							var yenOrderSubTotal = amount * rate ;
							/*
							var lineInput = "<td>" + id + "(date_"+i+")</td>" +
								"<td>" + orderNo + "</td>" +
								"<td>" + makerName + "</td>" +
								"<td>" + date + "</td>" +
								"<td>" + currency + "</td>" +
								"<td>" + amount + "</td>" +
								"<td>" + rate + "</td>" +
								"<td>" + yenOrderSubTotal + "</td>";
							*/
							var lineInput = {
								"0": id,
								"1": orderNo,
								"2": makerName,
								"3": date,
								"4": currency,
								"5": amount,
								"6": rate,
								"7": yenOrderSubTotal.toFixed(0)
							};


							var divider = "<td colspan='8'>"+ parseFloat(kawaseWith2Decimals) + "</td>"

							// ------------------------------------------------------------------------------------------------
							//
							// -- SETUP SEARCH CONDITIONS --
							//
							// ------------------------------------------------------------------------------------------------
							// SEARCH ALL MAKERS
							// ------------------------------------------------------------------------------------------------



							if(toggleAllMaker){
								if (orderNo != "" && rate != 0) {
									//$("#generalTable tbody").append("<tr>"+lineInput+"</tr>");
									//console.log("search all makers");
									oTable.row.add( lineInput ).draw();

									// first check if there are doubles, if there are do not put into the array...
									if(checkForDoubles(datesAndRates, date, rate) == false){

										// add dates and rates to array
										dataDates.push(date);
										dataRates.push(rate);

										// combine date and rate into one array for sorting
										datesAndRates.push([date,rate]);

									}

								}
							}

							// ------------------------------------------------------------------------------------------------
							// SEARCH BY MAKER
							// ------------------------------------------------------------------------------------------------

							if(toggleMaker) {
								// change maker names to uppercase in both cases to check.
								if ((makerName.toUpperCase() == searchMaker.toUpperCase()) && orderNo != "" && rate != 0) {
									//$("#generalTable tbody").append("<tr>"+lineInput+"</tr>");
									//console.log("search maker");
									oTable.row.add( lineInput ).draw();

									// first check if there are doubles, if there are do not put into the array...
									if(checkForDoubles(datesAndRates, date, rate) == false){

										// add dates and rates to array
										dataDates.push(date);
										dataRates.push(rate);

										// combine date and rate into one array for sorting
										datesAndRates.push([date,rate]);
									}
								}
							}

							// ------------------------------------------------------------------------------------------------

							// ------------------------------------------------------------------------------------------------
							// SEARCH BY CURRENCY
							// ------------------------------------------------------------------------------------------------

							if(toggleCurrency) {
								// change maker names to uppercase in both cases to check.
								if (currency == searchCurrency && orderNo != "" && rate != 0) {
									//$("#generalTable tbody").append("<tr>"+lineInput+"</tr>");
									//console.log("search currency");
									oTable.row.add( lineInput ).draw();
									// first check if there are doubles, if there are do not put into the array...
									if(checkForDoubles(datesAndRates, date, rate) == false){

										// add dates and rates to array
										dataDates.push(date);
										dataRates.push(rate);

										// combine date and rate into one array for sorting
										datesAndRates.push([date,rate]);
									}
								}
							}

						}	else {
							//console.log("skipped ----------------- [ " + data[j]['orderNo_' + i] + " ]------------------");
						}
// INNER LOOP FINISH ------------------------------------------------------------------------------------------------------------------
					}
// OUTTER LOOP FINISH ------------------------------------------------------------------------------------------------------------------
				}

				//-----------------------------------------------------------------
				
				// clear these arrays to prepare them for the sorted array
				dataRates = [];
				dataDates = [];
				
				// Sort the dates and rates array and then re-input them into
				// single arrays.
				var tempArray = [];
				tempArray = datesAndRates.sort();
				
				for(var i = 0; i < datesAndRates.length; i++){
					
					dataDates.push(tempArray[i][0]);
					dataRates.push(tempArray[i][1]);
				}
				
				// ----------------------------------------
				// functions for min max in array
				// min = dataRatesMin()
				// max = dataRatesMax()
				// ----------------------------------------
				Array.prototype.dataRatesMax = function (){
					return Math.round(Math.max.apply(null, this) + 1);
				};
				
				Array.prototype.dataRatesMin = function(){
					return Math.round(Math.min.apply(null, this) - 1);
				};
				// ----------------------------------------
			
				// update Chart
				myChart.destroy();

				myChart = new Chart(ctx, {
					type: 'line',
					data: {
						labels: dataDates,
						datasets: [{
							label: $("#searchCurrency option:selected").text(),
							data: dataRates,
							lineTension: 0.1,
							backgroundColor: "rgba(75,192,192,0.4)",
							borderColor: "rgba(75,192,192,1)",
							borderCapStyle: 'butt',
							borderDash: [],
							borderDashOffset: 0.0,
							borderJoinStyle: 'miter',
							pointBorderColor: "rgba(64,156,156,1)",
							pointBackgroundColor: "#fff",
							pointBorderWidth: 3,
							pointHoverRadius: 5,
							pointHoverBackgroundColor: "rgba(75,192,192,1)",
							pointHoverBorderColor: "rgba(220,220,220,1)",
							pointHoverBorderWidth: 2,
							pointRadius: 1,
							pointHitRadius: 10,
							spanGaps: true
						}]
					},
					options: {
						scales: {
							display : true,
							yAxes: [{
									position: "left",
									scaleLabel: {
									display: true,
									labelString: "為替レート",
									fontSize: "12"
								},
								ticks: {
									min: dataRates.dataRatesMin(),
									max: dataRates.dataRatesMax(),
									beginAtZero: true
									}
							}]
						},
						animation: {
							during: 2000,
							easing: "easeOutCubic"
						}
					}
				});
				
				//---------------------------------------------------------------
				// UPDATE THE TOTALS AND AVERAGES TO BE SHOWN IN THE NAVI
				//---------------------------------------------------------------
				
				// grab the toals
				var getPLTotal = 0;
				var getProductTotal = 0;
				
				// get average
				
				$("tbody .getPLTotal").each(function(){
					getPLTotal += parseFloat($(this).text());
				});
				
				$("tbody .getProductTotal").each(function(){
					getProductTotal += parseFloat($(this).text());
				});

				var averageRate = (getProductTotal / getPLTotal);
				
				// set text totals.
				$("#totals #totalMakerPL").text($("#searchCurrency option:selected").text() + " " + getPLTotal.toLocaleString("en-US"));
												
				$("#totals #totalProduct").text(new Intl.NumberFormat("en", {
					style: "currency",
					currency: "JPY"
				}).format(getProductTotal));
				$("#totals #totalAverage").text(averageRate.toFixed(2));
				
				//---------------------------------------------------------------v
			},
			error: function (err) {
				console.log("Hmmmm.... ERROR!!!!!!" + err);
			}
		});
		
		
		}
	// -------------------------------------------------------------
	// END OF FUNCTION

});