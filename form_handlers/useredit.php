<?php
error_reporting(0);
require_once('../functions/function.php');
include('../includes/header.php');
include('../includes/connect.php');

if (!empty($_GET) && isset($_GET['id'])){
	
				$id=mysqli_real_escape_string($con,(trim($_GET['id'])));
					echo $id;
					$sel_prev=getAllRecord($con,"screening_users",$where="pre_id='$id'","","");
					$row=mysqli_fetch_array($sel_prev);
	
				}
					//header('location:../settings.php');
					
					

?>
	<div class="row" style="padding-top:50px;">
                <div class="col-md-4 col-lg-4 col-sm-6 col-md-offset-4 col-lg-offset-4 col-sm-offset-2 col-xs-12" style="padding-left:35px;padding-right:25px;">
                    <div class="panel panel-primary ">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-user"></i> EDIT USER</h3>
                        </div>
                        <div class="panel-body">
                         <form role="form" action="useredit.php" method="post" id="userform"  enctype="multipart/form-data">
					<div class="form-group input-group"> 
                            <span class="input-group-addon">Staff Name</span>
                            <input type="text" name="staffname" value="<?php echo $row['staff_name'];?>" class="form-control" id="staffname"/>
                        </div>
						
						
					<div class="form-group input-group"> 
                            <span class="input-group-addon">Username</span>
                            <input type="email" name="username" value="<?php $row['Username'];?>" class="form-control" id="username"/>
                        </div>
					<div class="form-group input-group"> 
                            <span class="input-group-addon">Password</span>
                            <input type="password" name="pass" class="form-control" id="password"/>
                        </div>
					<div class="form-group input-group">
                            <span class="input-group-addon"> Priviledge level</span>
                            <select name="prev" class="form-control" id="privil" required>
							<option value="">-please select-</option>
							<option value="1" <?php if($row['Privilege']==1){echo "selected";}?>>Medical Staff</option>
							<option value="2" <?php if($row['Privilege']==2){echo "selected";}?>>Panel Admin</option>
							<option value="3" <?php if($row['Privilege']==3){echo "selected";}?>>Super Admin</option>
							</select>
                        </div>
						<div class="form-group input-group" id="panel">
                            <span class="input-group-addon"> Assigned Panel</span>
                            <select name="panel" class="form-control" id="panel" required >
				<option name="" >-please select-</option>
				<option value="1" <?php if($row['Panel']==1){echo "selected";}?>>panel 1</option>
				<option value="2" <?php if($row['Panel']==2){echo "selected";}?>>panel 2</option>
				<option value="3" <?php if($row['Panel']==3){echo "selected";}?>>panel 3</option>
				<option value="4" <?php if($row['Panel']==4){echo "selected";}?>>panel 4</option>
				<option value="0" <?php if($row['Panel']==0){echo "selected";}?>>All Panels</option>
				   </select>
                        </div>
						<input type="hidden" name="userid" class="form-control" value="<?php echo $id; ?>" id="id"/>
						
                         <input class="btn btn-success" name="submit" type="submit" value="UPDATE"/>

                      

                    </form>
					 <div id="result"></div>
					
					<br/>
					<table class="table table-bordered table-hover">
					 <thead>
      <tr>
        <th>Priviledge Type</th>
		<th>Priviledge id</th>
      </tr>
    </thead><tbody>
				
					<tr><td>Medical Staff</td><td>1</td></tr>
					<tr><td>Panel Admin</td><td>2</td></tr>
					<tr><td>Super Admin</td><td>3</td></tr>
					</tbody>
					</table>
						</div>
                    </div>
					
					<?php
					if(!empty($_POST) && $userupdate=mysqli_real_escape_string($con,(trim($_POST['submit'])))){
								$userid=mysqli_real_escape_string($con,(trim($_POST['userid'])));
								$staffname=mysqli_real_escape_string($con,(trim($_POST['staffname'])));
								$username=mysqli_real_escape_string($con,(trim($_POST['username'])));
								$pass=mysqli_real_escape_string($con,(trim($_POST['pass'])));
								$prev=mysqli_real_escape_string($con,(trim($_POST['prev'])));
								$panelid=mysqli_real_escape_string($con,(trim($_POST['panel']))); 
								$pswd=password_hash($pass,PASSWORD_BCRYPT);

								$fields=array('staff_name' => $staffname,'Username' => $username,'password' => $pswd,'Panel' => $panelid,'Privilege' => $prev);


								$sqlupdate=Updatedbtb($con,'screening_users',$fields,"pre_id='$userid'");
								
								if($sqlupdate==true){

									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-10 hidden-print\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> privilege Submitted Sucessfully</strong>
											  
										</div></div>";
										//header('Location:../settings.php');

								}else{echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-10\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error Submitting privilege</strong>
										</div></div>";}
					
					
					}else{
						echo "fill user form";
					}
					?>
                </div>
					
</div>							