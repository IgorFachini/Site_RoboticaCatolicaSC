<?php
$host = "localhost";
$user = "root";
$pass = "root";
$db = "dcecatol_wp";
$conn = mysql_connect($host, $user, $pass) or die (mysql_error());
@mysql_select_db($db);
?>
