$(document).ready(function(){
	
	// ---------------------------------------------------------
	// Window Setup
	// ---------------------------------------------------------
	
	// SET THE RIGHT AND LEFT DIVS
	var left = $("#help_left");
	var right = $("#help_right");
	
	// ON CLICK EVENT FOR DYNAMIC CONTENT
	// Load the data attribute of link to the right side.
	$(document.body).on("click", "li[data-link]", function(){
		
		// get the contents of the click and put into var
		var contents = $(this).data("link");
		
		// load the corrisponding html file into the right side.
		right.load("contents/"+contents+".html");
		
	});
	
	// ---------------------------------------------------------
	// Menu Controls
	// ---------------------------------------------------------
	
	// prepend the icons to the list
	$(".header").prepend("<i class='fa fa-angle-double-right'></i> ");
	$(".link").prepend("<i class='fa fa-angle-right'></i> ");
	
	// toggle hidden class on the header click
	$(".header").on("click", function(){

		// toggle arrows
		$(this).find("i").toggleClass("fa-angle-double-right fa-angle-double-down");
		
		// toggle hidden list members
		$(this).next("ul").toggle();
		
	});
	
	//search
	var searchContents = $("#searchInput");
	
	searchContents.change(function(){
		console.log("change!!!");
	});

});

