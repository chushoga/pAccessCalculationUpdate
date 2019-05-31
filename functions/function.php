
<?php
/*
 * SPINNER/pageLoader
 */
function pageLoader(){
	echo "<div id='ajax-loading'>
    	<div class='loadingBack'></div>
        	<div class='loadingText'>
            	<div class='container'>
                    <div class='ring blue'>
                    </div>
                <div id='content'>
                	<span>ローディング</span>
                </div>
                </div>
        	</div>
    	</div>";
}


//MESSAGE FUNCTIONS: pass the type of message and what message you want. -----------------------------------

function message($type,$message){

	switch ($type){
		case "error":
			echo "<div class='error'><i class='fa fa-times-circle'></i> error MESSAGE!! $message</div>";
			break;
		case "success":
			echo "<div class='success'><i class='fa fa-check-circle'></i> success $message</div>";
			break;
		case "warning":
			echo "<div class='warning'><i class='fa fa-warning'></i> warning <span style='color: red;'> $message </span></div>";
			break;
		case "info":
			echo "<div class='info'><i class='fa fa-info-circle'></i> info $message</div>";
	    break;
	    case "required":
	        echo "<div class='required'><i class='fa fa-asterisk'></i> required</div>";
	    break;	        
	    default:
	        echo "No Error Message";
    }

}
//MESSAGE FUNCTIONS: END-------------------------------------------------------------------------------------

// REMOVE SESSIONS

function sesRemove(){
	session_start();
	
	if(isset($_SESSION['views']))
	  unset($_SESSION['views']);
	  
	//header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
//TRUNCATE FUNCTION
//$number is the number to truncate
//$decimals is how many decimal places to cut off.
  function truncate2($number, $decimals)
{
  $point_index = strrpos($number, '.'); 
  return substr($number, 0, $point_index + $decimals+ 1);
}
//truncate func BETTER FUNCTION CHANGED TO THIS.

function truncate($val, $f="0")
{
    if(($p = strpos($val, '.')) !== false) {
        $val = floatval(substr($val, 0, $p + 1 + $f));
    }
    return $val;
}


/* ***************************************************************************
 * expense.php STARTS HERE TO MATCH UP THE CORRECT RATE WITH THE CORRECT ORDER NUMBER
 * ***************************************************************************
 */
function multi_array_search($search_for, $search_in) {
    foreach ($search_in as $element) {
        if ( ($element === $search_for) || (is_array($element) && multi_array_search($search_for, $element)) ){
            return true;
        }
    }
    return false;
}

function isHaiban($tformNo){
        //echo $tformNo." test";
        $isHaiban = true;
        $query = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$tformNo'");
        while($row = mysql_fetch_assoc($query)){
            $haiban = $row['memo'];
            $pos = mb_strpos($row['memo'], "廃番");
            if($pos !== false || mb_strpos($row['memo'], "メーカー") == true){
                //echo $tformNo." is haiban<br>";
            } else {
                $isHaiban = false;
            }
        }
        return $isHaiban;
}

/* search main table for the correct tform number and check 3 conditions for being haiban or not */
function isHaibanNew($tformNo){
        $isHaiban = true; // start with saying that this is true and only change to false if all checks are set
        $query = mysql_query("SELECT `cancelMaker`, `cancelTform`, `cancelSelling` FROM `main` WHERE `tformNo` = '$tformNo'");
        while($row = mysql_fetch_assoc($query)){
			
			$cancelMaker = $row['cancelMaker'];
			$cancelTform = $row['cancelTform'];
			$cancelSelling = $row['cancelSelling'];
           
            if($cancelMaker == true || $cancelTform == true || $cancelSelling == true){
            } else {
                $isHaiban = false;
            }
        }
        return $isHaiban;
}

function mb_str_split($str) {
   // split multibyte string in characters
   // Split at all positions, not after the start: ^
   // and not before the end: $
   $pattern = '/(?<!^)(?!$)/u';
   return preg_split($pattern,$str);
}    

function url_exists($url) {
   $headers = @get_headers( $url);
   $headers = (is_array($headers)) ? implode( "\n ", $headers) : $headers;

   return (bool)preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers);
}
?>