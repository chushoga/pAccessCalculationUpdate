// ******************************************************
// General ERROR
// ******************************************************
function showGeneralError(
	icon = 'fa fa-chain-broken',
	errorTitle = 'UNDEFINED TITLE',
	errorLine = 'UNDEFINED LINE NUMBER',
	errorMessage = 'UNDEFINED MESSAGE',
	hint = 'UNDEFINED HINT') {

	// NOTE: maybe an onError() funciton would have be better but for now this will work.
	// clear any title, csv name, or row count from the csv preview table.
	$("#uploadTableTitle").text(''); // set table upload name
	$("#csvTitle").text(''); // set csv file name
	$("#csvTitleInfo").text(''); // set table upload name
	$("#dialogCheckUploadTable thead").empty();
	$("#dialogCheckUploadTable tbody").empty();
	
	var txt = '\
		<div class="notySpecialIconBox"><i class="' + icon + '"></i></div>\
		<div class="notySpecialMessageBox">\
		<div class="notySpecialErrorTitle">' + errorTitle + '</div>\
		<div class="notySpecialErrorMessage">\
		ERROR: ' + errorMessage + ' <br>\
		<i class="fa fa-info-circle"></i> ' + hint + '</div>\
		</div>';
		
	var n = noty({
		layout: 'topRight',
		theme: 'defaultTheme',
		type: 'error',
		text: txt
	});

	$(".csvInputFile").replaceWith($(".csvInputFile").val('').clone(true)); // clear the file input so ready for next choice
}

// ******************************************************
// CSV UPLOAD ERROR
// ******************************************************
function showError(
	icon = 'fa fa-chain-broken',
	errorTitle = 'UNDEFINED TITLE',
	errorLine = 'UNDEFINED LINE NUMBER',
	errorMessage = 'UNDEFINED MESSAGE',
	hint = 'UNDEFINED HINT') {

	// NOTE: maybe an onError() funciton would have be better but for now this will work.
	// clear any title, csv name, or row count from the csv preview table.
	$("#uploadTableTitle").text(''); // set table upload name
	$("#csvTitle").text(''); // set csv file name
	$("#csvTitleInfo").text(''); // set table upload name
	$("#dialogCheckUploadTable thead").empty();
	$("#dialogCheckUploadTable tbody").empty();
	
	var txt = '\
		<div class="notySpecialIconBox"><i class="' + icon + '"></i></div>\
		<div class="notySpecialMessageBox">\
		<div class="notySpecialErrorTitle">' + errorTitle + '</div>\
		<div class="notySpecialErrorMessage">\
		[CSV Line: ' + errorLine + ']<br>\
		ERROR: ' + errorMessage + ' <br>\
		<i class="fa fa-info-circle"></i> ' + hint + '</div>\
		</div>';
		
	var n = noty({
		layout: 'topRight',
		theme: 'defaultTheme',
		type: 'error',
		text: txt
	});

	$(".csvInputFile").replaceWith($(".csvInputFile").val('').clone(true)); // clear the file input so ready for next choice
}

// ******************************************************
// CSV UPLOAD PREVIEW
// ******************************************************

function previewCSVUpload(colCount, tblHeaders, tfNoPos, readerResult) {

	/* set variables */
	var columnLength = colCount; // set the expected row length
	var arr = CSVToArray(readerResult, ",");
	var breakLoopCount = 9; // break from the loop after set amount of times(this is only a preview of the data)
	var tableHeaders = tblHeaders.split(",");
	var tformNoPosition = tfNoPos;
	
	/* set the file information */
	var showingLow = breakLoopCount+1;
	if(arr.length < showingLow){
		showingLow = arr.length;
	}
	$("#csvTitleInfo").text("[ Showing " + showingLow + " of " + arr.length +  " rows ]"); // set the name of the chosen file to the id

	/* start checks */

	for (var i in arr) {

		// ###########################################################################################
		// check for missing columns and empty rows
		// ###########################################################################################

		if (arr[i].length != columnLength) {

			/* show the error */
			var errorMessage = 'Expected: [' + columnLength + '] / Actual: [' + arr[i].length + ']. Check column count.';
			showError('fa fa-bug', 'Columns do not match excpected count.', (parseInt(i) + parseInt(1)), errorMessage, 'You may have an empty line somewhere.');
			/* ************** */
			
			return; // exit function
		}

		// ###########################################################################################
		// check if item already exsists or not and if should overwrite or ignore!!
		// ###########################################################################################


		// ###########################################################################################
		// check if the first column is a 0 for auto incrementing to the database.
		// ###########################################################################################

		//if (arr[i][0] != 0) {
		//
		//	/* show the error */
		//	var errorMessage = 'Expected: 0 in column [0] / Actual: ' + arr[i][0] + ' in column [0]. Check column contents.';
		//	showError('fa fa-bug', 'Contents of column [0] incorrect', (parseInt(i) + parseInt(1)), errorMessage, 'column [0] needs to be 0 for auto incrementing'); // show the error
		//	/* ************** */
		//
		//	return; // exit function
		//}

		// ###########################################################################################

	}
	// ###########################################################################################
	// CHECK TFORM NO
	// ###########################################################################################

	var tformNoArr = []; // start empty array to check tformNo

	for (var i in arr) {
		
		// ###########################################################################################
		// check if Tform no is letters, numbers and dashes only
		// ###########################################################################################

		// check if tformNo is letters numbers and dashes only
		var reg = new RegExp('^[A-z0-9-]*$'); // accept uppercase letters, numbers from 0-9 and dashes (ABC70-0000-001)
		var tformNoCheck = reg.test(arr[i][tformNoPosition]); // set the boolean of the test function, if anything other than the expression is inside the test, it returns false.

		if (tformNoCheck == false) {

			/* show the error */
			var errorMessage = 'Restricted Characters used: [' + arr[i][tformNoPosition] + ']';
			showError('fa fa-bug', 'Unsupported characters used.', '', errorMessage, 'Only (A-z, 0-9, and -) allowed. <br>Check for whitespace and/or illegal characters');
			/* ************** */

			return; // exit function
		}

		// if the tform number passed the regex then push into array
		tformNoArr.push(arr[i][tformNoPosition]);
	}

	// ###########################################################################################
	// check if there are doubles in the tformNo Column
	// ###########################################################################################

	var sorted_arr = tformNoArr.slice().sort(); // use slice to clone the array so the original array won't be modified

	var results = [];
	for (var i = 0; i < arr.length - 1; i++) {
		if (sorted_arr[i + 1] == sorted_arr[i]) {
			results.push(sorted_arr[i]);
		}
	}

	if (results.length != 0) {

		/* show the error */
		var errorMessage = 'Double Tform Numbers: [' + results + '].';
		showError('fa fa-bug', 'Double Tform Numbers.', '', errorMessage, 'Remove Doubles and try again');
		/* ************** */

		return; // exit function
	}

	/* checks finished */

	// Create the table header titles
	$("#dialogCheckUploadTable thead").append("<tr>"); // add the starting tr

	// add contents of the table headers

	for (var i = 0; i < tableHeaders.length; i++) {
		$("#dialogCheckUploadTable thead").append("<td>" + tableHeaders[i] + "</td>");
	}

	$("#dialogCheckUploadTable tbody").append("</tr>"); // add the ending /tr


	// Start the loop for previewing the CSV contents.
	for (var i = 0; i < arr.length && i <= breakLoopCount; i++) {

		$("#dialogCheckUploadTable tbody").append("<tr>"); // add the starting tr

		for (var j = 0; j < arr[i].length; j++) {

			$("#dialogCheckUploadTable tbody").append("<td>" + arr[i][j] + "</td>"); // set the text in the preview box
		}

		$("#dialogCheckUploadTable tbody").append("</tr>"); // add the ending /tr

	}

	$.noty.closeAll(); // close all noty dialog boxes

}

// ******************************************************
// LOADING AND CHECKING CSV SCRIPTS
// for popup boxes
// ******************************************************

$('.csvInputFile').on('change', function (e) {
	
	// remove previous table contents before load. This prevents needing to refresh page on multiple inputs
	$("#dialogCheckUploadTable thead").empty();
	$("#dialogCheckUploadTable tbody").empty();
	
	var f = this.value;
	var filename = f.replace(/^.*\\/, "");

	$("#csvTitle").text(filename); // set the name of the chosen file to the id

	var uploadName = $(this).data('uploadname'); // name of the data-uploadName to we can decide what column count and checks to do.
	var columnCount = $(this).data('columncount'); // column count
	var tableHeaders = $(this).data('headers'); // <th> headers feed in as an array
	var tformNoPosition = $(this).data('tformnopos'); // what postion the tformNo is in for checking purpose.

	$("#uploadTableTitle").text(uploadName); // set table upload name
	//-------------------------

	if (e.target.files != undefined) {
		var reader = new FileReader();

		reader.onload = function (e) {

			// *************************************************************************

			previewCSVUpload(columnCount, tableHeaders, tformNoPosition, e.target.result);

			// *************************************************************************
			
		};

		reader.readAsText(e.target.files.item(0));
	}

	return false;

	//--------------------
});

// ******************************************************
// Cancel Upload Button
// Clear the file input and close all dialog windows.
// ******************************************************
// TODO: remove this function if not using the dialogue preview option
$('.btnCSVPreviewCancel').click(function () {
	$(".csvDialogBox").dialog("close"); // close the dialog box
});
