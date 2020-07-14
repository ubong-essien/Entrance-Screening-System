<?php

$dbhost="localhost";
$dbuser="root";
$dbpassword="";
$db="putme";

$con = mysqli_connect($dbhost,$dbuser,$dbpassword,$db);
//var_dump($con);
if(!$con){
	
	die("<p>Database Connection Failed</p>". mysqli_error("database connection;"));
}






?>
<>