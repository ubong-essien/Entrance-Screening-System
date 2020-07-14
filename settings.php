<?php 
error_reporting(0);
include('includes/header.php');
//checkprev($_SESSION['userrep'],$_SESSION['prev'],3);
include('includes/connect.php');
//include('functions/function.php');
chkAdminsession();

?>
<div class="container">


	<div style="padding-top:80px;">
	
            <ul class="nav nav-tabs">
                <li class="<?php ?>"><a href="#tab-1" role="tab" data-toggle="tab">Manage Users</a></li>
                <li class="<?php ?>"><a href="#tab-2" role="tab" data-toggle="tab">Manage Timeslot</a></li>
                <li class="<?php ?>"><a href="#tab-3" role="tab" data-toggle="tab">Manage Panels</a></li>
                <li class="<?php ?>"><a href="#tab-4" role="tab" data-toggle="tab">Settings </a></li>
				<li class="<?php ?>"><a href="#tab-6" role="tab" data-toggle="tab">UTME Requirement </a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="tab-1">
                    <p></p>
					
					
                    <div class="card">
                        <div class="card-content">
             <div class="row"><div class="col-lg-6" style="margin-left:20px;">
              <strong ><span class=\"glyphicon glyphicon-info-sign\" id="reply"></span></strong>
        </div></div>
<div class="row">
                <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12" style="padding-left:35px;padding-right:25px;">
                    <div class="panel panel-primary ">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-user"></i> ADD NEW USER</h3>
                        </div>
                        <div class="panel-body">
                         <form role="form" action="settings.php" method="post" id="userform"  enctype="multipart/form-data">
					<div class="form-group input-group"> 
                            <span class="input-group-addon">Staff Name</span>
                            <input type="text" name="staffname" class="form-control" id="staffname"/>
                        </div>
						
						
					<div class="form-group input-group"> 
                            <span class="input-group-addon">Username</span>
                            <input type="email" name="username" class="form-control" id="username"/>
                        </div>
					<div class="form-group input-group"> 
                            <span class="input-group-addon">Password</span>
                            <input type="password" name="pass" class="form-control" id="password"/>
                        </div>
					<div class="form-group input-group">
                            <span class="input-group-addon"> Priviledge level</span>
                            <select name="prev" class="form-control" id="privil" required>
							<option value="">-please select-</option>
							<option value="1">Medical Staff</option>
							<option value="2">Panel Admin</option>
							<option value="3">Super Admin</option>
							</select>
                        </div>
						<div class="form-group input-group" id="dept">
                            <span class="input-group-addon"> Assigned Panel</span>
                            <select name="panel" class="form-control" id="panel" required >
				<option value="" >-please select-</option>
				<option value="1" >panel 1</option>
				<option value="2" >panel 2</option>
				<option value="3" >panel 3</option>
				<option value="4" >panel 4</option>
				   </select>
                        </div>
						
						
                         <input class="btn btn-success" name="submit" type="submit" value="Save"/>

                      

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
					if($usersubmit=mysqli_real_escape_string($con,(trim($_POST['submit'])))){
						
								$usersubmit=mysqli_real_escape_string($con,(trim($_POST['submit'])));
								$staffname=mysqli_real_escape_string($con,(trim($_POST['staffname'])));
								$username=mysqli_real_escape_string($con,(trim($_POST['username'])));
								$pass=mysqli_real_escape_string($con,(trim($_POST['pass'])));
								$prev=mysqli_real_escape_string($con,(trim($_POST['prev'])));
								$panelid=mysqli_real_escape_string($con,(trim($_POST['panel']))); 
								$pswd=password_hash($pass,PASSWORD_BCRYPT);

								$fields=array('pre_id' => '','staff_name' => $staffname,'Username' => $username,'password' => $pswd,'Panel' => $panelid,'Privilege' => $prev);


								$sqlf =Insert2DbTb($con,$fields,'screening_users','');
								
								if($sqlf){

									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-10 hidden-print\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> privilege Submitted Sucessfully</strong>
											  
										</div></div>";

								}else{echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-10\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error Submitting privilege</strong>
										</div></div>";}
					
					
					}else{
						echo "fill user form";
					}
					?>
                </div>
					<div class="col-md-8 col-lg-8 col-sm-6 col-xs-12" style="padding-right:25px;">
								<div class="panel panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title"><i class="fa fa-list"></i>STAFF LIST</h3>
										</div>
									<div class="panel-body" style="overflow-x:scroll;">
										<table class="table table-bordered table-hover"  style="overflow-y:scroll;width:100%">
											<thead>
												  <tr>
												  <th>S/No</th>
													
													<th>Name</th>
													<th>UserName</th>
													<th>Panel </th>
													<th>Priv</th>
													<th colspan=2>Action</th>
												  </tr>
												</thead>
												<tbody>
												<?php
												$counter=1;
												//$rows=Select4rmdbtb($con,'screening_users',"*","");
												$rows=getAllRecord($con,'screening_users',$where=NULL,$order=NULL,$limit=NULL);
												//echo $rows;
												while($record=mysqli_fetch_array($rows)){
												?>		
												<tr>	
												<td><?php echo $counter;?></td>
												<td><?php echo $record['staff_name'];?></td>
												<td><?php echo $record['Username'];?></td>
												<td><?php echo $record['Panel'];?></td>
												<td><?php echo $record['Privilege'];?></td>
												<td><a  class="btn btn-info btn-sm" id="useredit" href="form_handlers/useredit.php?id=<?php echo $record['pre_id'];?>">Edit</a></td><td>  <a href="form_handlers/deleteUser.php?id=<?php echo $record['pre_id'];?>"  class="btn btn-danger btn-sm" >Delete</a></td>
												<?php
												
												
												echo "</tr>";
											$counter++;
						}
?>	
									
												
												</tbody>
										  </table>
									 </div>
								</div>
								<!---------------------------->
								
								
					</div>
</div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane" role="tabpanel" id="tab-2">
                    <p></p>
			<div class="card">
					 <div class="card-content">
         <div class="row"><div class="col-lg-6" style="margin-left:20px;">
              <strong ><span class=\"glyphicon glyphicon-info-sign\" id="reply"></span></strong>
        </div></div>
<div class="row">
                <div class="col-lg-4 col-sm-4 col-xs-4" style="padding-left:35px;padding-right:25px;">
                    <div class="panel panel-primary ">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-user"></i> ADD NEW TIME SLOT</h3>
                        </div>
                        <div class="panel-body">
 <form role="form" action="settings.php#tab-2" method="post" enctype="multipart/form-data">
					<div class="form-group input-group"> 
                            <span class="input-group-addon">Time</span>
                            <select name="time" class="form-control" id="prevlvl" required>
							<option value="">-please select-</option>
							<option value="9AM">9AM</option>
							<option value="12NOON">12 NOON</option>
							</select>
                        </div>
						
						
					<div class="form-group input-group"> 
                            <span class="input-group-addon">Day</span>
                            <select name="day" class="form-control" id="day" required>
							<option value="">-please select-</option>
							<option value="MONDAY">MONDAY</option>
							<option value="TUESDAY">TUESDAY</option>
							<option value="WEDNESDAY">WEDNESDAY</option>
							<option value="THURSDAY">THURSDAY</option>
							<option value="FRIDAY">FRIDAY</option>
							</select>
                        </div>
						<div class="form-group input-group" id="panel">
                            <span class="input-group-addon"> Assigned Panel</span>
                            <select name="panel" class="form-control" id="panel" required >
								<option name="" >-please select-</option>
								<option value="1" >panel 1</option>
								<option value="2" >panel 2</option>
								<option value="3" >panel 3</option>
								<option value="4" >panel 4</option>
				   </select>
                        </div>
					<div class="form-group input-group"> 
                            <span class="input-group-addon">Date</span>
                            <input type="date" name="date" class="form-control" id="date"/>
                        </div>
						<div class="form-group input-group"> 
                            <span class="input-group-addon">Capacity</span>
                            <input type="number" name="capacity" class="form-control" id="capacity"/>
                        </div>
			<div class="form-group input-group" id="stage">
                           <input type="hidden" id="hidden_user_id">
						   
         </div><h5 style="color:blue;">DEPARTMENT LIST</h5>
		 <div style="height:400px;overflow-x:scroll">
		 
		 <table class="table table-bordered table-hover" id="ctble" style="width:auto;overflow-y:scroll">
								<thead>
								  <tr>
									<th>#</th>
									<th>Programme Name</th>
									</tr>
								</thead>
												<tbody id="courses" style="height:20%;overflow-y:scroll;">
											<?php
											/* if(isset($default)){
												die($default);
											} */
											$chkrec4=mysqli_query($con,"SELECT * FROM programme_tb  ORDER BY ProgID ASC");//query student info based on the info you derived
											while($row=mysqli_fetch_array($chkrec4)){
				?>
<tr style="width:auto;"><td><input type="checkbox" value="<?php echo $row['ProgID'];?>" name="depts"></td><td style="width:auto;"><?php echo $row['ProgName'];?></td></tr>
		
<?php		
	}
?>
												</tbody>
											</table>
										</div>
			 <input class="btn btn-success" name="timesubmit" type="submit" value="Save"/>
									<br/>
							</form>
					</div>
			</div>
		
			<?php
					if($timesubmit=mysqli_real_escape_string($con,(trim($_POST['timesubmit'])))){
								$time=mysqli_real_escape_string($con,(trim($_POST['time'])));
								$day=mysqli_real_escape_string($con,(trim($_POST['day'])));
								$date=mysqli_real_escape_string($con,(trim($_POST['date'])));
								$panel=mysqli_real_escape_string($con,(trim($_POST['panel'])));
								$course=mysqli_real_escape_string($con,(trim($_POST['depts'])));
								$capacity=mysqli_real_escape_string($con,(trim($_POST['capacity'])));
								
								if(is_numeric($panel) && is_numeric($course)){
								$fields=array('id' => '','Time' => $time,'Day' => $day,'Date' => $date,'ProgID' => $course,'PanelID' => $panel,'Capacity'=>$capacity);
									}
								$sqlf =Insert2DbTb($con,$fields,'time_slot','');
								
								if($sqlf){

									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-10 hidden-print\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> time slot Submitted Sucessfully</strong>
											  
										</div></div>";

								}else{echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-10\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error Submitting privilege</strong>
										</div></div>";}
					
					
					}else{
						echo "fill user form";
					}
					?>
			;
			
		
        </div>
					<div class="col-lg-8 col-sm-8 col-xs-8" style="padding-right:25px;">
								<div class="panel panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title"><i class="fa fa-list"></i>TIME SLOT</h3>
										</div>
									<div class="panel-body" style="overflow-x:scroll;height:500px">
										<table class="table table-bordered table-hover"  >
											<thead>
												  <tr>
												  <th>S/no</th>
													
													<th>Department</th>
													<th>Day</th>
													<th style="width:auto;">Time</th>
													<th style="width:auto;">Date</th>
													<th>Panel</th>
													<th>Capacity</th>
													<th colspan=2>Action</th>
													</tr>
												</thead>
												
												<tbody>
												<?php
												$counter=1;
												//$rows=Select4rmdbtb($con,'screening_users',"*","");
												$timerows=getAllRecord($con,'time_slot',$where=NULL,$order=NULL,$limit=NULL);
												//echo $rows;
												while($trecord=mysqli_fetch_array($timerows)){
													$dpt=$trecord['ProgID'];
												?>
												<tr>
												<td><?php echo $counter;?></td>
												<td><?php $deptq=getAllRecord($con,'programme_tb',$where="ProgID='$dpt'",$order=NULL,$limit=NULL);
												$arrrecord=mysqli_fetch_array($deptq);
												echo $arrrecord['ProgName'];?></td>
												<td><?php echo $trecord['Day'];?></td>
												<td><?php echo $trecord['Time'];?></td>
												<td><?php echo $trecord['Date'];?></td>
												<td><?php echo $trecord['PanelID'];?></td>
												<td><?php echo $trecord['Capacity'];?></td>
												<td><a  class="btn btn-success btn-sm"  href="edit.php?id=<?php echo $trecord['id'];?>" id="edit"> Edit</a></td><td>  <a href="form_handlers/deletetime.php?id=<?php echo $trecord['id'];?>"  class="btn btn-danger btn-sm" >Delete</a></td>
												<?php
												
												
												echo "</tr>";
											$counter++;
						}
?>	
												</tbody>
										  </table>
									 </div>
								</div>
							</div>
						</div>

                    </div>
                </div>
			</div>
                <div class="tab-pane" role="tabpanel" id="tab-3">
                    <p></p>
		<div class="card">
                    <div class="card-content">
                        <div class="row"><div class="col-lg-6" style="margin-left:20px;">
              <strong ><span class=\"glyphicon glyphicon-info-sign\" id="reply"></span></strong>
        </div></div>
<div class="row">
                <div class="col-lg-4 col-sm-4 col-xs-4" style="padding-left:35px;padding-right:25px;">
                    <div class="panel panel-primary ">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-user"></i> ADD NEW PANEL</h3>
                        </div>
                        <div class="panel-body">
                         <form role="form" action="settings.php#tab-3" method="post" enctype="multipart/form-data">
					<div class="form-group input-group"> 
                            <span class="input-group-addon">PANEL</span>
                            <select name="panel" class="form-control" id="panel" required>
							<option value="">-please select-</option>
							<option value="1">PANEL ONE</option>
							<option value="2">PANEL TWO</option>
							<option value="3">PANEL THREE</option>
							<option value="4">PANEL FOUR</option>
							<option value="5">PANEL FIVE</option>
							<option value="6">PANEL SIX</option>
							</select>
                        </div>
						
						
					<div class="form-group input-group">
                            <span class="input-group-addon"> LOCATION</span>
                            <select name="location" class="form-control" id="location" required>
							<option value="">-please select-</option>
							<option value="FACULTY OF EDUCATION CONFERENCE ROOM">FACULTY OF EDUCATION CONFERENCE ROOM</option>
							<option value="FACULTY OF EDUCATION SEMINAR ROOM">FACULTY OF EDUCATION SEMINAR ROOM</option>
							<option value="GEOLOGY LABORATORY">GEOLOGY LABORATORY</option>
							<option value="FACULTY OF ENGINEERING CONFERENCE ROOM">FACULTY OF ENGINEERING CONFERENCE ROOM</option>
							</select>
                        </div>
						<h5 style="color:blue;">DEPARTMENT LIST</h5>
					<div style="height:400px;overflow-x:scroll">
		 
		 <table class="table table-bordered table-hover" id="ctble" style="width:auto;overflow-y:scroll">
								<thead>
								  <tr>
									<th>#</th>
									<th>Programme Name</th>
									</tr>
								</thead>
						<tbody id="courses" style="height:20%;overflow-y:scroll;">
									<?php
									/* if(isset($default)){
										die($default);
									} */
									$chkrec4=mysqli_query($con,"SELECT * FROM programme_tb  ORDER BY ProgID ASC");//query student info based on the info you derived
									while($row=mysqli_fetch_array($chkrec4)){
		?>
<tr style="width:auto;"><td><input type="checkbox" value="<?php echo $row['ProgID'];?>" name="assigned_course[]"></td><td style="width:auto;"><?php echo $row['ProgName'];?></td></tr>
		
<?php		
	}
?>
						</tbody>
				</table>
		</div>               
		<!-- <div class="form-group input-group" id="stage">
                           <input type="hidden" id="hidden_user_id"> 
         </div> -->
			 <input class="btn btn-success" name="panelsubmit" type="submit" value="Save Panel"/>
<br/>
					</form>
		
			</div>
     </div>	
<?php
					if($_POST && $panelsubmit=mysqli_real_escape_string($con,(trim($_POST['panelsubmit'])))){
						
								$plocation=mysqli_real_escape_string($con,(trim($_POST['location'])));
								$panelName=mysqli_real_escape_string($con,(trim($_POST['panel'])));
								$courses=$_POST['assigned_course'];
								
								
								if(is_array($courses)){
									$assigned_dept=implode(",",$courses);
									//echo $assigned_dept;
									
								$fields=array('PanelID' => '','PanelName' => $panelName,'Dept' => $assigned_dept,'Location' => $plocation);
									}else{echo "no record";}
								$sqlf =Insert2DbTb($con,$fields,'panel_tb','');
								
								if($sqlf){

									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-10 hidden-print\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> panel Submitted Sucessfully</strong>
											  
										</div></div>";

								}else{echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-10\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error Submitting privilege</strong>
										</div></div>";}
					
					
					}else{
						echo "fill user form";
					}
					?>	 
</div>
					<div class="col-lg-8 col-sm-8 col-xs-8" style="padding-right:25px;">
								<div class="panel panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title"><i class="fa fa-list"></i> PANEL LIST</h3>
										</div>
									<div class="panel-body" style="overflow-x:scroll;">
										<table class="table table-bordered table-hover"  style="overflow-y:scroll;width:100%">
											<thead>
												  <tr>
												  <th>S/No</th>
													<th>Panel</th>
													<th>Assigned Departments</th>
													<th>Location</th>
													<th colspan=2>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
												$counter=1;
												//$rows=Select4rmdbtb($con,'screening_users',"*","");
												$panelrows=getAllRecord($con,'panel_tb',$where=NULL,$order=NULL,$limit=NULL);
												//echo $rows;
												while($precord=mysqli_fetch_array($panelrows)){
												
												?>
												<tr>
												<td><?php echo $counter;?></td>
												<td><?php echo $precord['PanelName'];?></td>
												<td><?php
												//echo $precord['Dept'];
													$a=explode(",",$precord['Dept']);
													//var_dump($a);
													foreach($a as $deptname){
														//echo $deptname;
														$Depts_name=Displaylist("programme_tb","ProgName",$deptname,$con);
														echo "<li>".$Depts_name."</li>";
													}
																
												
												
												 
												?>
												
												</td>
												<td><?php echo $precord['Location'];?></td>
												
												<td><a  class="btn btn-success btn-sm"  href="edit.php?id=<?php echo $precord['PanelID'];?>" id="edit"> Edit</a></td><td>  <a href="includes/form_handlers/deletepanel.php?id=<?php echo $precord['PanelID'];?>"  class="btn btn-danger btn-sm" >Delete</a></td>
												<?php
												
												
												echo "</tr>";
											$counter++;
						}
?>	
	
												
												</tbody>
										  </table>
									 </div>
								</div>
								</div>
						</div>
					</div>
                   </div>
              </div>
                <div class="tab-pane" role="tabpanel" id="tab-4">
                    <p></p>
	<div class="card">
                    <div class="card-content">
                        <div class="row"><div class="col-lg-6" style="margin-left:20px;">
              <strong ><span class=\"glyphicon glyphicon-info-sign\" id="reply"></span></strong>
        </div></div>
<div class="row">
                <div class="col-lg-4 col-sm-4 col-xs-4" style="padding-left:35px;padding-right:25px;">
				<?php
				
				$settings=getAllRecord($con,'screening_settings',"","","");
				$set_record=mysqli_fetch_array($settings)
				?>
				
                    <div class="panel panel-primary ">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-user"></i>GENERAL SETTINGS</h3>
                        </div>
                        <div class="panel-body">
                         <form role="form" action="settings.php#tab-4" method="post" enctype="multipart/form-data">
					<div class="form-group input-group"> 
                            <span class="input-group-addon">STATUS</span>
                           <select name="status" class="form-control" id="status" >
							<option value="">-please select-</option>
							<option value="OPENED" <?php if($set_record['status']=="OPENED"){echo "selected";}?>>OPENED</option>
							<option value="CLOSED" <?php if($set_record['status']=="CLOSED"){echo "selected";}?>>CLOSED</option>
							</select>
                        </div>
							<div class="form-group input-group"> 
                            <span class="input-group-addon">SCREENING TYPE</span>
                           <select name="status" class="form-control" id="status" >
							<option value="">-please select-</option>
							<option value="PUTME" <?php if($set_record['Screening_Type']=="PUTME"){echo "selected";}?>>OPENED</option>
							<option value="DE" <?php if($set_record['Screening_Type']=="DE"){echo "selected";}?>>CLOSED</option>
							</select>
                        </div>
						<div class="form-group input-group"> 
                            <span class="input-group-addon">Report By</span>
                           <select name="report_criteria" class="form-control" id="status" >
							<option value="">-please select-</option>
							<option value="1" <?php if($set_record['report_criteria']==1){echo "selected";}?>>BY panel</option>
							<option value="2" <?php if($set_record['report_criteria']==2){echo "selected";}?>>By panel & System</option>
							<option value="3" <?php if($set_record['report_criteria']==3){echo "selected";}?>>By System</option>
							</select>
                        </div>
						
					<div class="form-group input-group"> 
                            <span class="input-group-addon">STYLE</span>
                            <select name="style_class" class="form-control" id="style" >
							<option value="">-please select-</option>
							<option value="default" <?php if($set_record['style_class']=="default"){echo "selected";}?>>DEFAULT</option>
							<option value="primary" <?php if($set_record['style_class']=="primary"){echo "selected";}?>>PRIMARY</option>
							<option value="success" <?php if($set_record['style_class']=="success"){echo "selected";}?>>SUCCESS</option>
							<option value="danger" <?php if($set_record['style_class']=="danger"){echo "selected";}?>>DANGER</option>
							<option value="warning" <?php if($set_record['style_class']=="warning"){echo "selected";}?>>WARNING</option>
							</select>
                       </div>
					   <div class="form-group input-group"> 
                            <span class="input-group-addon">HEADER COLOR</span>
                            <input type="color" name="header_color" value="<?php echo $set_record['header_color'];?>">
                       </div>
					   <div class="form-group input-group"> 
                            <span class="input-group-addon">BG IMAGE</span>
                            <input type="file" name="bgimg" value="<?php echo $set_record['bgimg'];?>">
                       </div>
			 <input class="btn btn-primary" name="settingssubmit" type="submit" value="Save Settings"/>
				<br/>
			</form>
				</div>
             </div>
			 <?php
			 
			 
					if($settingssubmit=mysqli_real_escape_string($con,(trim($_POST['settingssubmit'])))){
						
								$status=mysqli_real_escape_string($con,(trim($_POST['status'])));
								$report_criteria=mysqli_real_escape_string($con,(trim($_POST['report_criteria'])));
								$header_color=mysqli_real_escape_string($con,(trim($_POST['header_color'])));
								$bgimg=mysqli_real_escape_string($con,(trim($_POST['bgimg'])));
								
								$style_class=mysqli_real_escape_string($con,(trim($_POST['style_class'])));
/////////////////////////////////////////////////////////////////////////////////////////////////////////
							  if(strlen($_FILES["bgimg"]["name"])>0){
								
								$target_dir = "assets/img/";
								$pixname="bg".rand(0,10);
								$target_file = $target_dir . basename($_FILES["bgimg"]["name"]);
								$uploadOk = 1;
							   // $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
								$imageFileType = "jpg";
								$imagename = pathinfo($target_file,PATHINFO_FILENAME);
								$userpic = $pixname.".".$imageFileType;
								 //Check if image file is a actual image or fake image
								if(isset($_POST["settingssubmit"])) {
									$check = getimagesize($_FILES["bgimg"]["tmp_name"]);
									if($check !== false) {
									   // echo "<br>File is an image - " . $check["mime"] . ".";
										$uploadOk = 1;
									} else {
										echo "<br>File is not an image.";
										$uploadOk = 0;
									}                                               
								}

							  // Check if file already exists
							  if (file_exists($target_file)) {
								  echo "<br>Sorry, file already exists.";
								  $uploadOk = 0;
							  }
							  // Check file size
							  if ($_FILES["bgimg"]["size"] > 500000) {
								  echo "<br>Sorry, your file is too large.";
								  $uploadOk = 0;
							  }
							  // Allow certain file formats
							  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
							  && $imageFileType != "gif" ) {
								  echo "<br>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
								  $uploadOk = 0;
							  }
							  // Check if $uploadOk is set to 0 by an error
							  if ($uploadOk == 0) {
								  echo "<br>Sorry, your file was not uploaded.";
							  // if everything is ok, try to upload file
							  } else {
								  if (move_uploaded_file($_FILES["bgimg"]["tmp_name"],$target_dir.$userpic)) {
									///////////////////////////////////////passport update
									  $passport_path="assets/img/".$userpic;
									 /*  if($passport_path==""){
										 $passport_path="assets/img/bg.jpg";
									  }
									   */
											} else {$staff_error="Sorry, there was an error uploading your file.";
							   
										}
									}

								}else{
									$passport_path="assets/img/bg.jpg";
									
								}

							//////////////////////////////////		
								$fields=array('id' => 1,'status' => $status,'report_criteria' => $report_criteria,'header_color' => $header_color,'bgimg' => $passport_path,'style_class' => $style_class);
									$sqlupdate=Updatedbtb($con,'screening_settings',$fields,"id=1");
								
								
								if($sqlupdate==true){

									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-10 hidden-print\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> Saved !</strong>
											  
										</div></div>";

								}else{echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-10\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error saving</strong>
										</div></div>";}
					
					
					}else{
						echo "fill user form";
					}
					?>
        
		</div>
					<div class="col-lg-8 col-sm-8 col-xs-8" style="padding-right:25px;">
								<div class="panel panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title"><i class="fa fa-list"></i>STAFF LIST</h3>
										</div>
										<div style="padding:5px 20px 0px 20px;">
										<label style="text-align:centre;padding-left:5px;">MESSAGE TO ADMINS</label>
										<textarea class="form-control" rows="7">
										
										
										</textarea><br/>
										</div>
										<div style="padding-left:20px;padding-bottom:10px;">
									     <input class="btn btn-primary" name="submit" type="submit" value="Send Message"/>
									 </div>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
<!-------------------------------------//////////////////////////////////utme//////////////////////----------------------------------------->

			 <div class="tab-pane" role="tabpanel" id="tab-6">
                    <p></p>
						<div class="card">
							<div class="card-content">
                        <div class="row"><div class="col-lg-6" style="margin-left:20px;">
							<strong ><span class=\"glyphicon glyphicon-info-sign\" id="reply"></span></strong>
							</div></div>
<div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6" style="padding-left:35px;padding-right:25px;">
				<?php
			/* 	
				$settings=getAllRecord($con,'screening_settings',"","","");
				$set_record=mysqli_fetch_array($settings) */
				?>
				
            <div class="panel panel-primary ">
                 <div class="panel-heading">
                       <h3 class="panel-title"><i class="fa fa-"></i>UTME SUBJECT REQUIREMENT</h3>
                        </div>
                   <div class="panel-body">
				   <form action="settings.php" method="POST">
				   <div class="form-group input-group" id="prog">
                            <span class="input-group-addon">Department</span>
                            <select name="utmeprogramme" class="form-control" id="dept" required >
				<option value="" >-please select-</option>
				  <?php
			
					$sel = mysqli_query($con,"SELECT * FROM programme_tb");	
					if($sel){
					while($row=mysqli_fetch_array($sel)){
						$pid=$row['ProgID'];
						$p_name=$row['ProgName'];
						?>
						<option  value='<?php echo $row['ProgID'];?>'> <?php echo $row['ProgName'];?> </option>
						<?php
						}
					
				}else{echo"cant run query";}
			?>
				  </select>
                     </div>
					 <hr><h3>CORE COURSES</h3><p style="color:red">please select the department's core courses (English first)</p>
							<div class="form-group input-group" id="prog">
                   <span class="input-group-addon">English</span>
                   <select name="english" class="form-control" id=""  style="width:255px;">
						<option value="1" >English</option>
								  
				  </select>
                </div>
					 <table>
<?php
$x=1;
$numofsub=3;
for($x=1;$x<=$numofsub;$x++)

{

?> 
	<tr>
		<td>
			<div class="form-group input-group" id="prog">
                   <span class="input-group-addon">Subject</span>
                   <select name="coresubject<?php echo $x;?>" class="form-control" id=""  >
						<option value="" >-please select-</option>
								  <?php
							
									$sel =getAllRecord($con,"olvlsubj_tb","","","");	
									if($sel){
									while($row=mysqli_fetch_array($sel)){
										$sid=$row['SubId'];
										$sub_name=$row['SubName'];
										?>
										<option  value='<?php echo $row['SubId'];?>'> <?php echo $row['SubName'];?> </option>
										<?php
										}
									
								}else{echo"cant run query";}
							?>
				  </select>
                </div>
				</td>
				<td>
			
				</td>
				</tr>
	<?php
}
	?>
		</table>
			
         </div>
     </div>
</div>
<!-------------------------------------//////////////////////////////////utme//////////////////////----------------------------------------->
					<div class="col-lg-6 col-sm-6 col-xs-6" style="padding-right:25px;">
					<div class="row">
					<div class="col-md-12">
								<div class="panel panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title"><i class="fa fa-"></i>(OR) UTME OPTIONAL COURSES</h3>
										</div>
										<div style="padding:20px 20px 0px 20px;">
<table>
								<?php
							/* 	$x=1;
								$numofsub=;
								for($x=1;$x<=$numofsub;$x++)

								{ */

								?> 
<!-----------------------optional subject code block 1------------------------------------------------------>
	<tr>
		<td>
			<div class="form-group input-group" id="prog">
                   <span class="input-group-addon">Subject</span>
                   <select name="optionalsubjecta1" class="form-control" id=""  >
						<option value="" >-please select-</option>
								  <?php
							
									$sel =getAllRecord($con,"olvlsubj_tb","","","");	
									if($sel){
									while($row=mysqli_fetch_array($sel)){
										$sid=$row['SubId'];
										$sub_name=$row['SubName'];
										?>
										<option  value='<?php echo $row['SubId'];?>'> <?php echo $row['SubName'];?> </option>
										<?php
										}
									
								}else{echo"cant run query";}
							?>
				  </select>
                </div>
			</td>
			<td> OR </td>
		<td>
			<div class="form-group input-group" id="prog">
                   <span class="input-group-addon">Subject</span>
                   <select name="optionalsubjecta2" class="form-control" id=""  >
						<option value="" >-please select-</option>
								  <?php
							
									$sel =getAllRecord($con,"olvlsubj_tb","","","");	
									if($sel){
									while($row=mysqli_fetch_array($sel)){
										$sid=$row['SubId'];
										$sub_name=$row['SubName'];
										?>
										<option  value='<?php echo $row['SubId'];?>'> <?php echo $row['SubName'];?> </option>
										<?php
										}
									
								}else{echo"cant run query";}
							?>
				  </select>
                </div>
		</td>
	</tr>
	<!-----------------------optional subject code block 2------------------------------------------------------>
		<tr>
		<td>
			<div class="form-group input-group" id="prog">
                   <span class="input-group-addon">Subject</span>
                   <select name="optionalsubjectb1" class="form-control" id=""  >
						<option value="" >-please select-</option>
								  <?php
							
									$sel =getAllRecord($con,"olvlsubj_tb","","","");	
									if($sel){
									while($row=mysqli_fetch_array($sel)){
										$sid=$row['SubId'];
										$sub_name=$row['SubName'];
										?>
										<option  value='<?php echo $row['SubId'];?>'> <?php echo $row['SubName'];?> </option>
										<?php
										}
									
								}else{echo"cant run query";}
							?>
				  </select>
                </div>
			</td>
			<td> OR </td>
		<td>
			<div class="form-group input-group" id="prog">
                   <span class="input-group-addon">Subject</span>
                   <select name="optionalsubjectb2" class="form-control" id=""  >
						<option value="" >-please select-</option>
								  <?php
							
									$sel =getAllRecord($con,"olvlsubj_tb","","","");	
									if($sel){
									while($row=mysqli_fetch_array($sel)){
										$sid=$row['SubId'];
										$sub_name=$row['SubName'];
										?>
										<option  value='<?php echo $row['SubId'];?>'> <?php echo $row['SubName'];?> </option>
										<?php
										}
									
								}else{echo"cant run query";}
							?>
				  </select>
                </div>
		</td>
	</tr>
<!-----------------------end of optional subject code block 1------------------------------------------------------>	
	<?php
//}
	?>
	
					</table>
					
		</div>
		<hr>
</div>
			<div class="panel panel-primary">
					<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-list"></i>OTHER SUBJECT REQUIREMENT(Do not repeat a core or optional course)</h3>
										</div>
					<div style="height:400px;overflow-x:scroll">
							<table class="table table-bordered table-hover" id="ctble" style="width:500px;overflow-y:scroll">
								<thead>
								  <tr>
									<th>#</th>
									<th>subject Name</th>
									</tr>
								</thead>
									<tbody id="courses" style="height:20%;overflow-y:scroll;">
									<?php
									/* if(isset($default)){
										die($default);
									} */
									$chkrec4=mysqli_query($con,"SELECT * FROM olvlsubj_tb  ORDER BY SubId ASC");//query student info based on the info you derived
									while($rowsubj=mysqli_fetch_array($chkrec4)){
		?>
										<tr style="width:auto;"><td><input type="checkbox" value="<?php echo $rowsubj['SubId'];?>" name="othersubj[]"></td><td style="width:auto;"><?php echo $rowsubj['SubName'];?></td></tr>
		
<?php		
	}
?>
						</tbody>
				</table>
		</div> 
	</div>

										
				<input class="btn btn-primary" name="utmesubmit" type="submit" value="Save Requirement"/>
									</div>
									
								</div>
							</div>
					
			</form>				
								<?php
								//$othersubj="";
								/////////////////////////////////////////utme processor
							if($req_submit=mysqli_real_escape_string($con,(trim($_POST['utmesubmit'])))){
								$othersubj=$_POST['othersubj'];
								$optionalsubjecta1=mysqli_real_escape_string($con,(trim($_POST['optionalsubjecta1'])));
								$optionalsubjecta2=mysqli_real_escape_string($con,(trim($_POST['optionalsubjecta2'])));
								$optionalsubjectb1=mysqli_real_escape_string($con,(trim($_POST['optionalsubjectb1'])));
								$optionalsubjectb2=mysqli_real_escape_string($con,(trim($_POST['optionalsubjectb2'])));
								//print_r($othersubj);
								if((!empty($optionalsubjectb1) && $optionalsubjectb1!="") || (!empty($optionalsubjectb2) && $optionalsubjectb2!="")){
								$optional=$optionalsubjecta1."||".$optionalsubjecta2.":".$optionalsubjectb1."||".$optionalsubjectb2;//construct the optional
								}
								elseif(((!empty($optionalsubjecta1) && $optionalsubjecta1!="") || (!empty($optionalsubjecta2) && $optionalsubjecta2!="")) && ((empty($optionalsubjectb1) && $optionalsubjectb1=="") || (empty($optionalsubjectb2) && $optionalsubjectb2=="")))
								{
									$optional=$optionalsubjecta1."||".$optionalsubjecta2;
								}
								elseif(((empty($optionalsubjecta1) && $optionalsubjecta1=="") && (empty($optionalsubjecta2) && $optionalsubjecta2=="")) && ((empty($optionalsubjectb1) && $optionalsubjectb1=="") || (empty($optionalsubjectb2) && $optionalsubjectb2=="")))
								{ $optional="NULL";
								}
								////////////////////////////////////////////////
								$english=mysqli_real_escape_string($con,(trim($_POST['english'])));
								$coresubject1=mysqli_real_escape_string($con,(trim($_POST['coresubject1'])));
								$coresubject2=mysqli_real_escape_string($con,(trim($_POST['coresubject2'])));
								$coresubject3=mysqli_real_escape_string($con,(trim($_POST['coresubject3'])));
								$utmeprogramme=mysqli_real_escape_string($con,(trim($_POST['utmeprogramme'])));
								//////////////////////////////////////////////////
								if(empty($coresubject1) && empty($coresubject2) && empty($coresubject3)){
									$core=$english;
									
								}
								elseif((empty($coresubject2) && empty($coresubject3)) || ($coresubject2 =="" && $coresubject3 ==""))
								{
									$core=$english.":".$coresubject1;
								}
								elseif(empty($coresubject3))
								{
									$core=$english.":".$coresubject1.":".$coresubject2;
								}
								else
								{
									$core=$english.":".$coresubject1.":".$coresubject2.":".$coresubject3;//construct the core subjects
								}
								//////////////////////////////////////////////////process other subjects to choose from
								if(is_array($othersubj) && !empty($othersubj))
								{
									$othersubjects=implode($othersubj,":");//construct the other subject
								}
								else
								{
									$othersubjects="NULL";//construct the other subject if only one is present
								}
								
							//	$othersubjects=implode($othersubj,"~");//construct the other subject
								
							/////prepare string for inserting into the dba_close

								$utme_require=$core."~".$optional."~".$othersubjects;
								
							echo $utme_require."%".$utmeprogramme;
							/////////////////////prepare array for inserting
							if(isset($utmeprogramme) && isset($utme_require)){
								$fields=array('id' => '','ProgID' => $utmeprogramme,'Subj_comb' => $utme_require);
									}else{echo "no record";}
								$sqlx =Insert2DbTb($con,$fields,'utme_require','');
								
								if($sqlx){

									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-4 hidden-print\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> requirement Submitted Sucessfully</strong>
											  
										</div></div>";

								}else{echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-4\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error Submitting requirement</strong>
										</div></div>";}
					
							
								/* $subject4=mysqli_real_escape_string($con,(trim($_POST['subject4'])));
								$grade4=mysqli_real_escape_string($con,(trim($_POST['grade4'])));
								$subject5=mysqli_real_escape_string($con,(trim($_POST['subject5'])));
								$grade5=mysqli_real_escape_string($con,(trim($_POST['grade5'])));
								$subject6=mysqli_real_escape_string($con,(trim($_POST['subject6'])));
								$grade6=mysqli_real_escape_string($con,(trim($_POST['grade6'])));
								$subject7=mysqli_real_escape_string($con,(trim($_POST['subject7'])));
								$grade7=mysqli_real_escape_string($con,(trim($_POST['grade7'])));
								$subject8=mysqli_real_escape_string($con,(trim($_POST['subject8'])));
								$grade8=mysqli_real_escape_string($con,(trim($_POST['grade8'])));
								$subject9=mysqli_real_escape_string($con,(trim($_POST['subject9'])));
								$grade9=mysqli_real_escape_string($con,(trim($_POST['grade9'])));
								$subject10=mysqli_real_escape_string($con,(trim($_POST['subject10'])));
								$grade10=mysqli_real_escape_string($con,(trim($_POST['grade10'])));
								$subject11=mysqli_real_escape_string($con,(trim($_POST['subject11'])));
								$grade11=mysqli_real_escape_string($con,(trim($_POST['grade11'])));
								$subject12=mysqli_real_escape_string($con,(trim($_POST['subject12'])));
								$grade12=mysqli_real_escape_string($con,(trim($_POST['grade12'])));
								
		$requirement;					
								
							*/}else{echo "FILL IT ";}
								?>
							
							
						</div><!---end of row--->
					</div>
                </div>
            </div>
			
		</div>
    </div>
 </div>
 <script>
/*   $(document).ready(function(){
	$('#useredit').click(function(){
		var userid=$(this).val();
			alert(userid);
		    $.ajax({ 
                type:'POST',
                url:'inludes/form_handlers/useredit.php',
                data:'deptid='+dept,
                success:function(data){
					$('#courses').html(html);
                    //$('#courses').listbox('html');
                }
            });
		
	}) 
	 
 })  */
 </script>
	 <?php include('includes/footer.php');?>