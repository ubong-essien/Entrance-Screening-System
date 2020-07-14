<?php 
session_start();
unset($_SESSION['screenmed']);
unset($_SESSION['screenpanel']);
unset($_SESSION['screensuper']);
unset($_SESSION['prev']);
unset($_SESSION['panel']);
session_destroy();
header('location:login.php');

?>