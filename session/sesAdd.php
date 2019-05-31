<?php session_start();
foreach ($_POST as $key => $value){
     if(isset($_SESSION[$key])){
         $_SESSION[$key] = $_SESSION[$key]+$value;

     } else if ($value == ""){
          //$_SESSION[$key] = "NONE";
     }
        else {
            $_SESSION[$key] = $value;
        }
 if (isset($_SESSION['table_id_length'])){
     unset($_SESSION['table_id_length']);
 }
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>