<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';
if(isset($_GET['list'])){
	$list = "&list=".$_GET['list'];
} else {
	$list = "";
}

echo $list;

if(isset($_GET['search'])){
	$pr = $_GET['pr'];
	$search = $_GET['search'];
	$id = $_GET['historyid'];
	if(isset($_GET['record'])){
		$record = $_GET['record'];
	} else {
		$record = "0";
	}

	$order = sprintf ('DELETE FROM `sp_history` WHERE id=%d',
	mysql_real_escape_string($id)
	);
	 
	$result = mysql_query($order);  //order executes
	if($result){
		header("Location: ../calculation.php?pr=".$pr."&search=".$search."&record=".$record."&message=success".$list);

	}else{
		header("Location: ../calculation.php?pr=".$pr."&search=".$search."&record=".$record."&message=error".$list);

	}

} else {
	header ("location: ../calculation.php?pr=1&message=error&info=履歴レコードは存在ありません！");
	 
}


?>