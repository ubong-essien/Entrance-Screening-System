<?php
error_reporting(0);
include('includes/loginheader.php');
include('includes/connect.php');
?>

<body >
<div class="row" style="margin-top:50px;">

<div class="col-md-7 col-xs-7 col-md-offset-1" style="background-image:url('assets/img/studfade.png');background-repeat:no-repeat;background-attachment:fixed;background-position: center;">

<h1 style="color:#003300;font-family:times new romans;text-align:center;">WELCOME <br/>TO<br/>AKWA IBOM STATE UNIVERSITY<br/>SCREENING PORTAL</h1><br/><br/><br/><br/><br/> <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<?php
if($_POST){
	$user=trim(mysqli_real_escape_string($con,$_POST['username']));
	  
	$pass=trim(mysqli_real_escape_string($con,$_POST['password']));
if(!empty($user) && !empty($pass)){
	  
	 $login_user=chklogin($user,$pass,$con);
	  
	}
}
?>
<p style="color:red;">ENTER YOUR USERNAME AND PASSWORD</p>
<p style="color:blue;font-family:monospace;font-weight:bold;">....powered by AKSU ICT</p>

</div>
<div class="col-md-4 col-xs-4">
<div class="login-box" style="width:350px;height:auto;background-color:#ffffff;margin-top:50px;border-radius:7px;border:2px solid blue;margin-bottom:100px;margin-right:100px;">
  <div class="login-logo" style="padding-left:1px;padding-top:5px;margin-left:120px">
    <a href="login.php"><img src="assets/img/logoban.png" alt=""><br /></a> 
  </div><p style="text-align:center;font-family:arial;">AKSU STAFF LOGIN</p>
  <p class="login-box-msg" style="font-family:monospace;text-align:center;">SIGN IN TO START YOUR SESSION</p><hr />
<div class="login-box-body" style="width:350px;height:auto; margin-top:20px;padding-left:20px;padding-top:5px;">
   <form action="login.php" method="post">
      <div class="form-group has-feedback" style="line-height:20px;">
       Username:<input type="email" class="form-control" name="username" placeholder="Email"style="width:300px;" required>
        
      </div>
      <div class="form-group has-feedback" >
        Password:<input type="password" class="form-control" name="password" placeholder="Password" style="width:300px;" required>
       
      </div>
     
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="width:300px;">LOGIN</button>
     
		</form><hr />
	</div>
		<marquee><b style="color:red;padding:5px;">Contact ICT if you have problem logging in</b></marquee>
		</div>
</div>
</div>
</body>