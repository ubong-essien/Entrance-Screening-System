<?php
include_once('functions/function.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
	  <!-- <script src="<?php //echo home_base_url();?>assets/js/jquery.min.js"></script>-->
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/fonts/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo home_base_url();?>assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/Card-Deck.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/Footer-Clean.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/Material-Card.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/Search-Field-With-Icon.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/Features-Boxed.css" />
    
</head>
<body style="background-image:url('<?php echo home_base_url();?>assets/img/bg.jpg');">
    <nav class="navbar navbar-default navbar-fixed-top navigation-clean" >
        <div class="container" >
            <div class="navbar-header"><a class="navbar-brand navbar-link" href="#">AKWA IBOM STATE UNIVERSITY</a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav navbar-right" style="color:orange;">
                    <li class="active" role="presentation"><a href="index.php">Home </a></li>
                    <li role="presentation"><a href="<?php echo home_base_url();?>profile.php">Screening</a></li>
                   <!-- <li role="presentation"><a href="<?php //echo home_base_url();?>settings.php">Settings </a></li>-->
					
                    <li role="presentation"><a href="<?php echo home_base_url();?>logout.php">Logout</a></li>
                    
                </ul>
            </div>
        </div>
    </nav>