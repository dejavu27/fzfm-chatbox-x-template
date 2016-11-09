<?php
$con = mysql_connect('localhost','friendzo_cbox','Dejavu2016!!');
mysql_select_db('friendzo_cbox',$con);
echo mysql_query("UPDATE `users` SET `active` = 0 WHERE `last_request_time` <= ".(time()- 5*60)." ");
?>