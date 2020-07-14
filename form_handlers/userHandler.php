<?php
include('../connect.php');
include('../../functions/function.php');

	
			/* $staffname="ubong";
			$username="ub@see.com";
			$pass="tree";
			$prev=1;
			$panelid=4;
			$pass="tree";	
			*/
								$staffname=mysqli_real_escape_string($con,(trim($_POST['staffname'])));
								$username=mysqli_real_escape_string($con,(trim($_POST['username'])));
								$pass=mysqli_real_escape_string($con,(trim($_POST['pass'])));
								$prev=mysqli_real_escape_string($con,(trim($_POST['prev'])));
								$panelid=mysqli_real_escape_string($con,(trim($_POST['panelid']))); 
								$pswd=password_hash($pass,PASSWORD_BCRYPT);

								$fields=array('pre_id' => '','staff_name' => $staffname,'Username' => $username,'password' => $pswd,'Panel' => $panelid,'Privilege' => $prev);


								$sqlf =Insert2DbTb($con,$fields,'screening_users');
								if($sqlf){

									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-6 hidden-print\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> privilege Submitted Sucessfully</strong>
											  
										</div></div>";

								}else{echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-6\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error Submitting privilege</strong>
										</div></div>";}
				

?>