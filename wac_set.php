<?php
//$privilege=$_SESSION['prev'];
error_reporting(0);
include('includes/header.php');
include('includes/connect.php');
chkAdminsession();

$waecsubmit=mysqli_real_escape_string($con,(trim($_POST['waecsubmit'])));
if($_POST && !empty($waecsubmit)){
	
	
	
		if(is_numeric($_POST['programme']))
		{
			$programme=mysqli_real_escape_string($con,(trim($_POST['programme'])));
		}
		/***********************************process conditional********************************************/
$core_g=7;//this is C6 and higher grades
$coresubjec11=chkempty(mysqli_real_escape_string($con,(trim($_POST['subject1']))));
$coresubject2=chkempty(mysqli_real_escape_string($con,(trim($_POST['subject2']))));
$coresubject3=chkempty(mysqli_real_escape_string($con,(trim($_POST['subject3']))));
$coresubject4=chkempty(mysqli_real_escape_string($con,(trim($_POST['subject4']))));
$coresubject5=chkempty(mysqli_real_escape_string($con,(trim($_POST['subject5']))));
$coresubject6=chkempty(mysqli_real_escape_string($con,(trim($_POST['subject6']))));

$corestring=$coresubjec11.":".$core_g."~".$coresubject2.":".$core_g."~".$coresubject3.":".$core_g."~".$coresubject4.":".$core_g."~".$coresubject5.":".$core_g."~".$coresubject6.":".$core_g;
$rem= strchr($corestring,"~:");// :7~:7 ~:7~:7
$chk=explode($rem,$corestring);
//print_r($chk);
echo lb();

/***********************************process special cases********************************************/

$spg=8;//this 8 signifies the grade in the olvel table in this case,its a pass grade
$special3="";
$special1=chkempty(mysqli_real_escape_string($con,(trim($_POST['special1']))));
$special2=chkempty(mysqli_real_escape_string($con,(trim($_POST['special2']))));

if($special1!=NULL){//this is to check if that section has been selected




$sp_str=$special1.":".$spg."||".$special2.":".$spg."||".$special3.":".$spg;
echo lb();
//echo $sp_str;
 $sp_rem= strchr($sp_str,"||:");// :7~:7 ~:7~:7
$spchk=explode($sp_rem,$sp_str);
print_r($spchk);
//echo $sp_rem;
//e($spchk);
/* echo lb();
echo $spchk[0]; */ 
}
/***********************************process conditional********************************************/
$cong=7;
$consubjectc1="";//used tocomplete tring for explode towork
$consubjectc2="";//used tocomplete tring for explode towork
$consubjecta1=chkempty(mysqli_real_escape_string($con,(trim($_POST['consubjecta1']))));
$consubjecta2=chkempty(mysqli_real_escape_string($con,(trim($_POST['consubjecta2']))));
$consubjectb1=chkempty(mysqli_real_escape_string($con,(trim($_POST['consubjectb1']))));
$consubjectb2=chkempty(mysqli_real_escape_string($con,(trim($_POST['consubjectb2']))));

if($consubjecta1!=NULL)//this is to check if that section has been selected
{
	$cond_str=$consubjecta1.":".$cong."||".$consubjecta2.":".$cong."~".$consubjectb1.":".$cong."||".$consubjectb2.":".$cong."~".$consubjectc1.":".$cong."||".$consubjectc2.":".$cong;
$cond_rem= strchr($cond_str,"~:");// :7~:7 ~:7~:7
$conchk=explode($cond_rem,$cond_str);
//print_r($chk);
/* echo lb();
echo $conchk[0]; */
}


/***********************************process others********************************************/

$othersg=7;
if(isset($_POST['otherwaecsubj'])){
		if(is_array($_POST['otherwaecsubj'])){
	$otherwaecsubj=chkempty($_POST['otherwaecsubj']);
	if($otherwaecsubj!=NULL)
	{
		foreach($otherwaecsubj as $olvlsub){
			$subj[]=$olvlsub.":".$othersg;
		}
	$olvl=implode("~",$subj);
	/* echo lb();
	echo $olvl;	 */
	}
}
	
}
if(is_array($_POST['otherwaecsubj'])){
	$otherwaecsubj=chkempty($_POST['otherwaecsubj']);
	if($otherwaecsubj!=NULL)
	{
		foreach($otherwaecsubj as $olvlsub){
			$subj[]=$olvlsub.":".$othersg;
		}
	$olvl=implode("~",$subj);
	/* echo lb();
	echo $olvl;	 */
	}
}

/***********************************process final string for insertting into the db********************************************/
if(!isset($olvl)&& !isset($conchk[0]))// if the dept does not have other courses to choose
{
	$finalstr=$chk[0];//string 1
		
}else if(!isset($olvl) && isset($conchk[0]))// if the dept has just core compulsory courses like fac of engineering
{
	$finalstr=$chk[0]."~".$conchk[0];// string 2
	
}else if(!isset($conchk[0]) && isset($olvl))// id dept has no optional courses to choose,but just core and others like philosophy
{
	$finalstr=$chk[0]."~".$olvl;// string 3
	
}else
{
	$finalstr=$chk[0]."~".$conchk[0]."~".$olvl;
}

//echo $finalstr."-".$spchk[0];


$chkexist=Exist($con,"ProgID",$programme,'waec_require');
	if($chkexist[0]== TRUE)
	{
		$record_id=$chkexist[1];
		echo $record_id;
								$fields=array('ProgID' => $programme,'Subj_comb' => $finalstr,'Special_cons' => $spchk[0]);
								$updt=Updatedbtb($con,'waec_require',$fields,"id='$record_id'");
								if($updt)
								{

									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-10 hidden-print\" style=\"margin-left:20px;margin-top:50px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> updated Sucessfully</strong>
											  
										</div></div>";

								}
								else
								{
									echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-10\" style=\"margin-left:20px;margin-top:50px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error updating information</strong>
										</div></div>";
								}
	}
	
	elseif($chkexist[0]==FALSE)
	{
								$fieldsval=array('id' => '','ProgID' => $programme,'Subj_comb' => $finalstr,'Special_cons' => $spchk[0]);
								$sqlres =Insert2DbTb($con,$fieldsval,'waec_require');
								if($sqlres)
								{

									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-10 hidden-print\" style=\"margin-left:20px;margin-top:50px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> Saved Sucessfully</strong>
											  
										</div></div>";

								}
								else
								{echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-10\" style=\"margin-left:20px;margin-top:50px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error Submitting information</strong>
										</div></div>";
								}
	 }	
}	 
 ?>				  
 <div class="tab-pane" role="tabpanel" id="tab-5" style="margin-top:50px;">
                    <p></p>
						<div class="card">
						<form action="wac_set.php" method="POST">
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
                       <h3 class="panel-title"><i class="fa fa-list"></i> WAEC CORE SUBJECTS<br>(enter only core departmental Subject,note all subjects entered here are all with a Credit grade)</h3>
                        </div>
                   <div class="panel-body">
				   
				   <div class="form-group input-group" id="prog">
                            <span class="input-group-addon">Department</span>
                            <select name="programme" class="form-control" id="dept" required >
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
<table>
<?php
$x=1;
$numofsub=6;
for($x=1;$x<=$numofsub;$x++)

{

?> 
	<tr>
		<td>
			<div class="form-group input-group" id="prog">
                   <span class="input-group-addon">Subject</span>
                   <select name="subject<?php echo $x;?>" class="form-control" id=""  >
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
	<?php
}
	?>
</table>
					
			
         </div>
     </div>
							<div class="panel panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title"><i class="fa fa-list"></i> SPECIAL EXCEPTIONS(Enter subjects were a pass grade is accepted)</h3>
										</div>
										<div style="padding:5px 20px 0px 20px;">
										
										<table>

	<tr>
		<td>
			<div class="form-group input-group" id="prog">
                   <span class="input-group-addon">Subject</span>
                   <select name="special1" class="form-control" id=""  >
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
			<td>/</td>
			<td>
									<div class="form-group input-group" id="prog">
										   <span class="input-group-addon">Subject</span>
										   <select name="special2" class="form-control" id=""  >
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
	
						
						</table>
					
					</div>
										
				</div>
</div>

					<div class="col-lg-6 col-sm-6 col-xs-6" style="padding-right:25px;">
					<div class="row">
					<div class="col-md-12">
								<div class="panel panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title"><i class="fa fa-list"></i> CONDITIONAL COURSES</h3>
										</div>
										<div style="padding:5px 20px 0px 20px;">
										
										<table>

	<tr>
		<td>
			<div class="form-group input-group" id="prog">
                   <span class="input-group-addon">Subject</span>
                   <select name="consubjecta1" class="form-control" id=""  >
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
                   <select name="consubjecta2" class="form-control" id=""  >
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
	
	<tr>
		<td>
			<div class="form-group input-group" id="prog">
                   <span class="input-group-addon">Subject</span>
                   <select name="consubjectb1" class="form-control" id=""  >
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
                   <select name="consubjectb2" class="form-control" id=""  >
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
						</table>
					
					</div>
										
				</div>
		</div>
									<div class="col-md-12">
									<div class="panel panel-primary">
					<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-list"></i>OTHER SUBJECT REQUIREMENT(Do not repeat a core or optional course)</h3>
										</div>
					<div style="height:355px;overflow-x:scroll">
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
										<tr style="width:auto;"><td><input type="checkbox" value="<?php echo $rowsubj['SubId'];?>" name="otherwaecsubj[]"></td><td style="width:auto;"><?php echo $rowsubj['SubName'];?></td></tr>
		
<?php		
	}
?>
								</tbody>
						</table>
				</div> 
			</div>
		</div>
	</div>
</div>
						<input type="submit" id="waecsubmit" class="btn btn-success" name="waecsubmit" value="SAVE" style="margin-left:10px;width:150px;"/>
					</form>	
						</div><!---end of row--->
						
						
					
					</div>
                </div>
            </div>
 <?php 

 include('includes/footer.php');?>