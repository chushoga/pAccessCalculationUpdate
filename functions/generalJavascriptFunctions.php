<script type="text/javascript">
function popupwindow(url, title, w, h) {
	  var left = (screen.width/2)-(w/2);
	  var top = (screen.height/2)-(h/2);
	  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	}
function popupWindowNew(url, w, h) {
	  var left = (screen.width/2)-(w/2);
	  var top = (screen.height/2)-(h/2);
	  var randomNumber = Math.floor((Math.random()*100)+1); 
	  return window.open(url, randomNumber, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	}

function showImage(){
	$(".loadingGif").toggle();
}
function showLoading(){
	$('#loading').delay(300).fadeIn(300);
	//$(".loadingGif").toggle();
}
</script>