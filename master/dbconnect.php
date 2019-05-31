<?php //home connect
mysql_connect('localhost','admin','pass') or die(mysql_error());
mysql_select_db('tanka') or die(mysql_error());
mysql_query('SET NAMES UTF8');
?>
