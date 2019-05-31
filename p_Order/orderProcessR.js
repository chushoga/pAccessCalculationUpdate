/* RIGHT */

/* on click of the left menu run this to load the right side */
var contentsL = $("#contentsL");

contentsL.find("td").on("click", function () {
	console.log("clicked");
});

//function updateRight() {
	$.ajax({
		type: "post",
		url: "orderQuery.php",
		data: "action=getRight&orderNo=2400",
		success: function (data) {

			var right = $("#right");
			var contentsR = $("#contentsR");

			var contR = "";

			for (var i = 0; i < data.length; i++) {

				var contR = "<tr>\
		<td class='normalInput'><input type='text' value='" + data[i].makerNo + "'></td>\
		<td class='normalInput'><input type='text' value='" + data[i].tformNo + "'></td>\
		<td class='normalInput'><input type='text' value='" + data[i].date + "'></td>\
		<td class='normalInput'><input type='text' value='" + data[i].quantity + "'></td>\
		<td class='normalInput'><input type='text' value='" + data[i].currency + "'></td>\
		<td class='normalInput'><input type='text' value='" + data[i].priceList + "'></td>\
		<td class='normalInput'><input type='text' value='" + data[i].discount + "'></td>\
		<td class='normalInput'>X</td>\
		</tr>\
	";

				contentsR.find("tbody").append(contR);
			}

		},
		error: function (err) {
			alert("error RIGHT");
		}
	});
//}