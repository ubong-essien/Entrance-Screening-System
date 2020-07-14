<?php 
/* $dbhost="localhost";
$dbuser="aksuedu_putme";
$dbpassword="aksu_putme";
$db="aksuedu_putme"; */
$dbhost="localhost";
$dbuser="root";
$dbpassword="";
$db="putme";

$con = mysqli_connect($dbhost,$dbuser,$dbpassword,$db);
//var_dump($con);
if(!$con){
	
	die("<p>Database Connection Failed</p>". mysqli_error($con));
}
?>

