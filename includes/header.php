<?php
include_once('functions/function.php');
$privilege=$_SESSION['prev']
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AKSU Screening portal</title>
	   <script src="<?php echo home_base_url();?>assets/js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/fonts/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo home_base_url();?>assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/Card-Deck.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/Footer-Clean.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/Material-Card.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/Search-Field-With-Icon.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/Features-Boxed.css" />
	<link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="<?php echo home_base_url();?>assets/css/themes/bootstrap.min.css"/>

</head>
<body style="background-image:url('<?php echo home_base_url();?>assets/img/bg.jpg');">
    <nav class="navbar navbar-default navbar-fixed-top navigation-clean" >
        <div class="container" >
            <div class="navbar-header"><a class="navbar-brand navbar-link" href="#">AKWA IBOM STATE UNIVERSITY</a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
			<!-------------------------super admin------------------------->
		
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav navbar-right" style="color:orange;">
                    <li class="active" role="presentation"><a href="screening-portal">Home </a></li>
                    <li role="presentation"><a href="candidate-profile">Screening</a></li>
                    <li role="presentation"><a href="system-setting">Settings </a></li>
					<li role="presentation"><a href="waec_settings">Waec Settings </a></li>
					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="">Generate Report <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
							<li role="presentation"><a href="Admission-list">Admission Report(unsorted)</a></li>
							<li role="presentation"><a href="report_new.php">Report(new Firstchoice)</a></li>
							<li role="presentation"><a href="report_sorted.php">Admission Report(new sorted)</a></li>
							<li role="presentation"><a href="awaiting_result.php">Awaiting Result List</a></li>
							<li role="presentation"><a href="DE_list.php">DE LIST</a></li>
							<li role="presentation"><a href="<?php  echo home_base_url();?>panel_report.php">Panel Summary Sheet</a></li>
                            <li role="presentation"><a href="result-verification">Result Verification</a></li>
                            <li role="presentation"><a href="screening-attendance">Attendance List</a></li>
							<li role="presentation"><a href="candidate_sign.php">Signature List</a></li>
							<li role="presentation"><a href="medical_attendance.php">Medical Attendance List</a></li>
							<li role="presentation"><a href="card-sales">Card sales List</a></li>
							<li role="presentation"><a href="refunds_report.php">Refund Report</a></li>
                            <!--<li role="presentation"><a href="#">Third Item</a></li>-->
                        </ul>
                    </li>
                    <li role="presentation"><a href="<?php echo home_base_url();?>logout.php">Logout</a></li>
                    
                </ul>
            </div>
			
        </div>
    </nav>