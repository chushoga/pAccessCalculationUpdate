$(document).ready(function() {

	/* ******************************************************
	** DIALOG BOXES **
	** for popup boxes
	****************************************************** */
	$(function() {
		var dialogCheckCSV;

    // on index page initialize the csv upload dialog box
		dialogCheckCSV = $("#dialogCheckUpload").dialog({
			autoOpen: false,
			modal: true,
			height: 500,
			width: 800
		});

  }); // end of dialog boxes

}); // end of dom ready
