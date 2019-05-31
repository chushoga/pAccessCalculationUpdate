/* LEFT */

$.ajax({
	type: "post",
	url: "orderQuery.php",
	data: "action=getLeft",
	success: function(data) {
	
	//console.log(JSON.stringify(data));
	
	var left = $("#left");
	var contentsL = $("#contentsL");

	var contL = "";
		
	for(var i = 0; i < data.length; i++) {
		
		var contL = "<tr id='"+data[i].orderNo+"'>\
			<td><input type='text' value='"+data[i].orderNo+"'></td>\
			<td>"+data[i].makerName+"</td>\
			<td>"+data[i].date+"</td>\
		</tr></a>\
	";
		
		contentsL.find("tbody").append(contL);
	}

	},
	error: function(err) {
		console.log("error LEFT" + err);
	}
});
