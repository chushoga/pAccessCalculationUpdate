$(document).ready(function(){
	
	// ******************************************************************************************
	// GLOBAL VARIABLES
	// ******************************************************************************************

	// ******************************************************************************************
	//  _____                 _   _
	// |  ___|   _ _ __   ___| |_(_) ___  _ __  ___
	// | |_ | | | | '_ \ / __| __| |/ _ \| '_ \/ __|
	// |  _|| |_| | | | | (__| |_| | (_) | | | \__ \
	// |_|   \__,_|_| |_|\___|\__|_|\___/|_| |_|___/
	// ******************************************************************************************
	
	// ******************************************************************************************
	/* MESSAGES */
	// ******************************************************************************************
	// --------------------------------------
	// MESSAGE DIALOG
	// types[ "error", "warning", "success" ] => message
	// --------------------------------------
	function LoadMessage(type, message){
		
		//TODO: ADD MORE TYPES
		
		switch(type){
			case "error":
				$("#pageOverlay").removeClass("hideMe"); // show the opacity layer
				
				$("#dialogMessage h1").html("ERROR <i class='fa fa-ban' style='color: crimson;'></i>");
				
				$("#dialogMessage .message").text(message);
				
				$("#dialogMessage .messageComment").text("Contact Admin for details.");
				
				$("#dialogMessage .errorCode").text("ErrorCode: 101");
				
				$("#dialogMessage").dialog("open");
				break;
			case "success":
				$("#pageOverlay").removeClass("hideMe"); // show the opacity layer
				
				$("#dialogMessage h1").html("SUCCESS <i class='fa fa-check' style='color: green;'></i> ");
				
				$("#dialogMessage .message").text(message);
				
				$("#dialogMessage .messageComment").text("");
				
				$("#dialogMessage .errorCode").text("");
				
				
				$("#dialogMessage").dialog("open");
				break;
			case "info":
				$("#pageOverlay").removeClass("hideMe"); // show the opacity layer
				
				$("#dialogMessage h1").html("INFO <i class='fa fa-info-circle' style='color: #14ADE0;'></i> ");
				
				$("#dialogMessage .message").text(message);
				
				$("#dialogMessage .messageComment").text("");
				
				$("#dialogMessage .errorCode").text("");
				
				
				$("#dialogMessage").dialog("open");
				break;
		}
	}
	
	
	// ******************************************************************************************
	/* FORM */
	// ******************************************************************************************
	
	// submit the file input to get info for csv
	function SubmitFilemakerCSV(data){
		$.ajax({
			type: "POST",
			url: "exe/processOldFileMakerData.php",
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data){
				
				if(data == ""){
					LoadMessage("info", "No Cleaning needed! Everything is ok!");
				}
				
				if (data != "error"){

					var table = $("#differenceTable tbody");

					// clear table first.
					table.empty();

					for(var i = 0; i < data.length; i++){

						var content = "\
						<tr>\
							<td>"+data[i].id+"</td>\
							<td class='tfNoID'>"+data[i].tformNo+"</td>\
							<td>"+data[i].maker+"</td>\
							<td>"+data[i].type+"</td>\
							<td>"+data[i].listName+"</td>\
						</tr>\
					";

						table.append(content);

					}
				} else {
					LoadMessage("error", data + ": Check CSV. If Maker name does not match for all then error. If not saved as BOMなしwill get error.");
				}
			},
			error: function(e){
				
				LoadMessage("error", "No CSV or Empty CSV selected. Check format and try again.");
			}
		});
	}

	// ******************************************************************************************
	//  _____                 _
	// | ____|_   _____ _ __ | |_ ___
	// |  _| \ \ / / _ \ '_ \| __/ __|
	// | |___ \ V /  __/ | | | |_\__ \
	// |_____| \_/ \___|_| |_|\__|___/
	// ******************************************************************************************
	
	// ******************************************************************************************
	/* FORM */
	// ******************************************************************************************
	
	// -- Submit Form --
	$("body").on("click", "#submitBtn", function(){
		
		// --------------------------------------------------------
		// TEST CHECK, uncomment this once IsSameMaker is fixed.
		
		var form = $("#csvForm");
		var data = new FormData(form[0]);
		
		var input = $.trim($("#searchInput").val());
		
		SubmitFilemakerCSV(data);
		// check if not empty first
		/*
		if(input.length > 0){
			
		} else {
			console.log("empty");
		}
		*/
		// --------------------------------------------------------
		
	});
	
	// -- open file callback --
	$("#csvFileInput").on("change", function(e){
		var fileName = e.target.files[0].name;
		var target = $("#selectedFileNameText");
		
		target.text(fileName);
	});
	
	
	// ******************************************************************************************
	// DIALOG BOXES
	// ******************************************************************************************
	
	// close dialog button
	$(".closeDialogBtn").on("click", function(){
		$(this).closest('.ui-dialog-content').dialog('close');
	});
	
	// remove overlay for dialog box
	// triggered from the dialogMessage box
	function overlay(){
		$("#pageOverlay").addClass("hideMe");
	}
	
	// MESSAGE BOX
	$("#dialogMessage").dialog({
		autoOpen: false,
		width: 600,
		dialogClass: 'noTitleBar',
		close: overlay
	});
	
	// ******************************************************************************************
	/* REMOVE FROM PACCESS */
	// ******************************************************************************************
	$("#removeItemsBtn").on("click", function(){
		
		var table = $("#differenceTable tbody");
		var arr = [];
		
		table.find(".tfNoID").each(function(){
			arr.push($(this).text());
		});
		
		if(arr != ""){
			$.ajax({
				type: "POST",
				url: "exe/processRemoveOldFileMakerData.php",
				data: {result:JSON.stringify(arr)},
				success: function(data){

					// Clear the table
					var table = $("#differenceTable tbody");
					table.empty();

					LoadMessage("success", "DELETED: " + arr);

				},
				error: function(e){
					LoadMessage("error", "Could not delete: " + arr);
				}
			});
		} else {
			LoadMessage("error", "There is nothing to delete" + arr);
		}
	});
	
	// ******************************************************************************************
	//  ___       _ _   _       _ _          _   _
	// |_ _|_ __ (_) |_(_) __ _| (_)______ _| |_(_) ___  _ __
	//  | || '_ \| | __| |/ _` | | |_  / _` | __| |/ _ \| '_ \
	//  | || | | | | |_| | (_| | | |/ / (_| | |_| | (_) | | | |
	// |___|_| |_|_|\__|_|\__,_|_|_/___\__,_|\__|_|\___/|_| |_|
	// ******************************************************************************************
	
	// remove loading screen
	$('#loading').delay(300).fadeOut(300);
	
	// ******************************************************************************************
	
});