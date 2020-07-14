<?php
    sleep(1);
	require_once "../assets/IntelligentPHPAPI.php";
	$d_ = new MainIntelligentPHP;
	$json = json_decode($_POST['d_userD'],true);
	$d_username = trim($d_->escape_String($json['d_USN']));
	$d_passord = trim($d_->escape_String($json['d_PSW']));
	if($d_username == 'duke'){
		die('*2');
	}else{
		die('*3');
	}

?>