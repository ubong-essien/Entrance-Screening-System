<?php
// session_set_cookie_params(0);
session_start();
require_once "IntelligentPHPAPI.php";
$_ = new MainIntelligentPHP();//form this in another class
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$usanm = $_->escape_string($_POST['userNm']);
	$pasw = $_->escape_string($_POST['pawd']);
	$tbflNames = "*";
	$tbName = "admin_tb";
	$werConditn = "Username = '$usanm'";
	$werConditn2 = "Password = '$pasw'";
	//$sql ="SELECT $tbflNames FROM $tbName WHERE $werConditn AND $werConditn2";echo $sql; exit;
	$getpaswuser = $_->selectDtaFrmDBNOLIMITATTwoCDN($tbflNames,$tbName,$werConditn,$werConditn2);
	if($getpaswuser->num_rows > 0){
		$_SESSION['pasw'] = $pasw;
		die("@|");
	}
}
?>