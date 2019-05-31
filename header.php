<div id="header">
<?php 

// SET REQUIRED FILES
    require_once 'functions/function.php';
    require_once 'functions/generalJavascriptFunctions.php';
// -------------------
// GET MESSAGES
    if(isset($_GET['message'])) {    
        $message = $_GET['message'];
    }else{
	    $message = "";
    }
    if(isset($_GET['info'])) {   
        $info = $_GET['info'];
    }else{
		$info = "";
    }
    if (isset($_GET['message']) && isset($_GET['info'])){
        message($message, $info);
    } else if(isset($_GET['message'])) {
        message($message, "");
    }
// -------------------
//SET NAVI HERE
    //check which program is running and start the appropriate navi.
    /*
     * 1. Calculation Program
     * 2. Tform Project Program
     * 3. Tform Order Program
     */
    if(isset($_GET['pr'])){
        $pr = $_GET['pr'];
    } else {
        $pr = 0;
       
    }
    if ($pr == 1){
        require_once 'navi_1.php';
    }
    if ($pr == 2){
        require_once 'navi_2.php';
    }
    if ($pr == 3){
        require_once 'navi_3.php';
    }
    if ($pr == 4){
        require_once 'navi_4.php';
    }
?>
</div>