<?php
error_reporting(0);
include('includes/header.php');
include('includes/connect.php');
/* 
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename=example.csv');
header('Pragma: no-cache'); */
chkAdminsession();
$settings=Loadsettings($con);
$status=$settings['status'];
$screenType=$settings['Screening_Type'];
//checkprev($_SESSION['user'],$_SESSION['prev'],'2');//check for priviledge */
$counter=1;
//echo $settings['report_criteria'];
$search_criteria="";

if(!empty(mysqli_real_escape_string($con,(trim($_POST['generate']))))){
$search_criteria=mysqli_real_escape_string($con,(trim($_POST['search_criteria'])));	
$dept=mysqli_real_escape_string($con,(trim($_POST['dept'])));	
$modeofentry=mysqli_real_escape_string($con,(trim($_POST['modeofentry'])));



if(($modeofentry==1)){
					if(($dept!=-1) && ($search_criteria==1))
					{
						$resultset=getAllRecord($con,"recommendation_tb","final_status = '$search_criteria' AND dept = '$dept' AND ModeOfEntry = 1","","");
					//	echo "<br/><br/><br/><br/><br/><br/><br/>XX";
					}
					elseif(($dept!=-1) && ($search_criteria==0))
					{
						$resultset=getAllRecord($con,"recommendation_tb","final_status = '$search_criteria' AND dept = '$dept' AND ModeOfEntry=1","","");
				//	echo "<br/><br/><br/><br/><br/><br/><br/>YY";
					}
					elseif(($dept==-1) && ($search_criteria==0))
					{
						$resultset=getAllRecord($con,"recommendation_tb","final_status = '$search_criteria' AND ModeOfEntry=1","","");
				//	echo "<br/><br/><br/><br/><br/><br/><br/>ZZ";
					}
					elseif(($dept==-1) && ($search_criteria==1))
					{
						$resultset=getAllRecord($con,"recommendation_tb","final_status = '$search_criteria' AND ModeOfEntry=1","","");
				//	echo "<br/><br/><br/><br/><br/><br/><br/>CC";
					}
	
	
	
}
elseif($modeofentry==2){
	
				if(($dept!=-1) && ($search_criteria==1))
					{
						$resultset=getAllRecord($con,"recommendation_tb","final_status = '$search_criteria' AND dept = '$dept' AND ModeOfEntry = 2","","");
					//	echo "<br/><br/><br/><br/><br/><br/><br/>AA";
					}
					elseif(($dept!=-1) && ($search_criteria==0))
					{
						$resultset=getAllRecord($con,"recommendation_tb","final_status = '$search_criteria' AND dept = '$dept' AND ModeOfEntry=2","","");
				//	echo "<br/><br/><br/><br/><br/><br/><br/>BB";
					}
					elseif(($dept==-1) && ($search_criteria==0))
					{
						$resultset=getAllRecord($con,"recommendation_tb","final_status = '$search_criteria' AND ModeOfEntry=2","","");
				//	echo "<br/><br/><br/><br/><br/><br/><br/>DD";
					}
					elseif(($dept==-1) && ($search_criteria==1))
					{
						$resultset=getAllRecord($con,"recommendation_tb","final_status = '$search_criteria' AND ModeOfEntry=2","","");
				//	echo "<br/><br/><br/><br/><br/><br/><br/>SS";
					}
	
	
	
}


/*if(is_numeric($search_criteria)){//QUERY TO GET ADMISSIBLE AND NOT ADMISSIBLE BASED ON MODE OF ENTRY AND DEPT



					if(($dept!=-1) && ($search_criteria==1) && ($modeofentry==1))
					{
						$resultset=getAllRecord($con,"recommendation_tb","final_status = '$search_criteria' AND dept = '$dept' AND ModeOfEntry = '$modeofentry'","","");
						echo "<br/><br/><br/><br/><br/><br/><br/>XX";
					}
					elseif(($dept!=-1) && ($search_criteria==1) && ($modeofentry==2))
					{
						$resultset=getAllRecord($con,"recommendation_tb","ModeOfEntry=2 AND dept = '$dept'","","");
					echo "<br/><br/><br/><br/><br/><br/><br/>YY";
					}elseif(($dept!=-1) && ($search_criteria==0) && ($modeofentry==1)){
						
							$resultset=getAllRecord($con,"recommendation_tb","final_status='$search_criteria' AND ModeOfEntry='$modeofentry' AND dept = '$dept'","dept","");
					echo "<br/><br/><br/><br/><br/><br/><br/>AA";
					}elseif(($dept!=-1) && ($search_criteria==0) && ($modeofentry==2)){
						
							$resultset=getAllRecord($con,"recommendation_tb","final_status='$search_criteria' AND ModeOfEntry=2 AND dept = '$dept'","dept","");
					echo "<br/><br/><br/><br/><br/><br/><br/>BB";
					}elseif(($dept==-1) && ($search_criteria==0) && ($modeofentry==2)){
						
						
							$resultset=getAllRecord($con,"recommendation_tb","final_status='$search_criteria' AND ModeOfEntry=2","dept","");
					echo "<br/><br/><br/><br/><br/><br/><br/>CC";
					}elseif(($dept==-1) && ($search_criteria==1) && ($modeofentry==1)){
						
							$resultset=getAllRecord($con,"recommendation_tb","final_status='$search_criteria' AND ModeOfEntry='$modeofentry'","dept","");
					echo "<br/><br/><br/><br/><br/><br/><br/>DD";
					}elseif(($dept==-1) && ($search_criteria==1) && ($modeofentry==2)){
						
							$resultset=getAllRecord($con,"recommendation_tb","final_status=1 AND ModeOfEntry=2","dept","");
					echo "<br/><br/><br/><br/><br/><br/><br/>DD";
					}
}*/
		/**************************************queries with dept********************************************/
		
		
		
					
					}

				
				
			
 ?>
<script type="text/javascript" src="helpers/csvhelper.js"></script>
<script type="text/javascript">

 $(document).ready(function(){
   
$('#download').click(
function() {//alert("am working");
 exportTableToCSV.apply(this, [$('#report'), 'admissionreport.csv']);
             });
 
}); 
</script>


<!--<div class="row hidden-print">
                <div class="col-lg-12" style="margin-right:0px;margin-left:200px;padding-left:0px;width:auto;">
                    <div class="panel panel-primary" style="width:auto;">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>Department's Analysis</h3>
                        </div>
                        <div class="panel-body">

                            <table class="table table-bordered table-hover" style="width:auto;">
								<thead>
								  <tr>
									<th>S/no</th>
									<th>level</th>
									<th>male</th>
									<th>female</th>
									<th>Total</th>
									
								</thead>
									<tbody>
									<tr>
									<td>1</td>
									<td><?php //echo $level;?></td>
									<td><?php //echo $lvlm;?></td>
									<td><?php //echo $lvlf;?></td>
									<td><?php //echo $yr1;?></td>
									</tr>

									</tbody>
							</table>
                        </div>
                    </div>
                </div>
            </div><!--end of analysis div-->
<div class="container" style="margin-top:70px;">
	<div class="row">
			<div class="col-lg-12">
				<div style="text-align:center;margin-right:0px">
				<h3 class="panel-title" style="font-size:28px;font-family:san-serif;font-weight:bolder;">AKWA IBOM STATE UNIVERSITY</h3>
				<h3 class="panel-title" style="font-size:18px;font-family:san-serif;font-weight:bolder;">P.M.B. 1167 UYO, AKWA IBOM STATE, NIGERIA</h3>			
				</div>
				<div class="row" style="margin-left:0px;">
							
						<div class="col-lg-4 col-xs-4" style="font-size:16px;font-family:san-serif;font-weight:bolder;">
							<h3 class="panel-title" style="text-align:center;font-family:san-serif;font-weight:bolder;">MAIN CAMPUS:</h3>
							<h3 class="panel-title" style="text-align:center;font-family:san-serif;font-weight:bolder;"> IKOT AKPADEN,MKPAT ENIN L.G.A</h3>
						</div>
						<div class="col-lg-4 col-xs-4">
							<img src="<?php echo home_base_url();?>assets/img/logoban.png" width="80px" height="80px" style="margin-left:100px" /></span>		
							</div>
						<div class="col-lg-4 col-xs-4">
							<h3 class="panel-title" style="text-align:center;font-family:san-serif;font-weight:bolder;">OBIOAKPA CAMPUS:</h3>
							<h3 class="panel-title" style="text-align:center;font-family:san-serif;font-weight:bolder;"> OBIO AKPA,ORUK ANAM L.G.A</h3>
								</div>	
				</div>	
				
				<h4 style="text-align:center;font-weight:bold;font-family:san-serif;">LIST OF <?php if($search_criteria==1){echo"ADMISSIBLE";}elseif($search_criteria==0){echo "NOT-ADMISSIBLE";}else{echo "SCREENED";} if($modeofentry==2){echo " DIRECT-ENTRY";}else{echo "PUTME";}?> CANDIDATES</h4>
				<div class="row">
				<div class="col-md-12 col-lg-12">
				<div class="panel panel-default">
				<div class="panel-heading hidden-print">
				
				<table width="100%">
				
						<tr>
						<form action="report.php" method="post">
						<td style="width:5%;">
						<label>Criteria:</label>
						</td>
						<td style="width:18%;">
							
                           <select name="search_criteria" class="form-control" id="repcrit" >
							<option value="">-please select-</option>
							<option value="1" >ADMISSIBLE</option>
							<option value="0">NOT ADMISSIBLE</option>
							<option value="2">SCREENED</option>
							
                        </select>
						</td >
						<td style="width:12%;">
						<label>Entry Mode:</label>
						</td>
						<td style="width:25%;">
							
                           <select name="modeofentry" class="form-control" id="repcrit" >
							<option value="">-please select-</option>
							<option value="1" >UTME</option>
							<option value="2">DE</option>
							<!--<option value="-1">BOTH</option>-->
							
                        </select>
						</td >
						
						<td style="width:5%;">
						<label>Department:</label>
						</td>
						<td style="width:30%;">
							
                <select name="dept" class="form-control" id="dept" required >
				<option value="" >-please select-</option>
				<option value="-1" >ALL Department</option>
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
					
				}
				else
				{echo"cant run query";
				}
			?>
				  </select>
						</td >
							<td style="width:20%;padding-left:20px;">
											
										<input class="btn btn-primary" name="generate" type="submit" value="GENERATE REPORT"/>	
							</td>
							</form>					
											
							<td style="width:5%;padding-left:150px;">
									<button onclick="window.print()"  class="btn btn-primary hidden-print">Print</button>
								
							
							
							</td>
						<td style="width:7%;">
			
							<a href="#" id="download"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Download</a>
							</td>
						</tr>	
						
			</table>
			
	</div>
	<div class="panel-body" >
				 <table class="table table-bordered table-hover col-lg-12 col-xs-12" id="report">
							<thead>
												<tr>
													<th>S/no</th>
													<th>Reg No</th>
													<th>Name</th>
													<th>Gender</th>
													<th>State</th>
													<th>LGA</th>
													<th>Programme</th>
													<th>UTME SUBJECT</th>
													<?php if($modeofentry==2){echo"<th>Certificate Type/Grade</th>";}else{echo "<th>Jamb Aggregate</th>";}?>
													<?php if($search_criteria==0){echo"<th>Reason</th>";}?>
													<th>Mode of Entry</th>
													</tr>
												</thead>
												<tbody>
												<?php
												//var_dump($resultset);
												echo $dept."/".$search_criteria."/".$modeofentry;
												//print_r($details);
												while($details=mysqli_fetch_array($resultset)){
													//echo $details['RegNo'];
													$def_subjects="";
													$RegNo=$details['RegNo'];//use this reg o fetch details
													$panel_reason=$details['panel_reason'];
													$system_reason=$details['system_reason'];
													$medical_reason=$details['medical_reason'];
													$panel_deficiency=$details['panel_olvl_def'];
													//if paneldeficiency is empty
													if(!empty($panel_deficiency)){
																$defff=json_decode($panel_deficiency);
															foreach($defff as $rea){
																$reas_sub=getSubject($con, $rea);
																$sub[]=$reas_sub;
																$def_subjects=implode($sub,",");///if(!empty($utme_sys_rea)){echo 
															}
														}
													
													
													//panel_reason
												$rec_set=Getcand_details($RegNo,$con);
												$records=mysqli_fetch_array($rec_set);
													$StateId=$records['StateId'];
													$LGA=$records['LGA'];
													$SurName=$records['SurName'];
													$FirstName=$records['FirstName'];
													$OtherNames=$records['OtherNames'];
													$Gender=$records['Gender'];
													$JambAgg=$records['JambAgg'];
													$ProgID=$records['ProgID'];
													$phone=$records['Phone'];
													$ModeOfEntry=$records['ModeOfEntry'];
													$JmbComb=$records['JmbComb'];
													$OtherCert=$records['OtherCert'];
													$JambNo=$records['JambNo'];
													///////////////decode ids-----------------AKWA IBOM STATE POLYTECHNIC IKOT-OSURUA~2015~8~MARKETING
													GetLGA($LGA,$con);
													GetState($StateId,$con);
													GetProgDetails($ProgID,$con);
													$sub=array();
													//////////////get the deficiency details
													$q_reason=getAllRecord($con,"deficency","RegNo='$JambNo'","","");
													$s_reason=mysqli_fetch_array($q_reason);
													$sy_reason=$s_reason['Olvl_Deficiency'];
													
													$utme_sys_rea=$s_reason['Utme_Deficiency'];
													
													$reasn=explode("~",$sy_reason);
													foreach($reasn as $rea){
														$reas_sub=getSubject($con, $rea);
														$sub[]=$reas_sub;
														$def_sub=implode($sub,"<br/>");///if(!empty($utme_sys_rea)){echo 
													}
													//implode();
													$jmbsub=array();
													$jamb=explode("~",$JmbComb);
													foreach($jamb as $jmb){
														$jmb_sub=getSubjectAbbr($con, $jmb);
														$jmbsub[]=$jmb_sub;
														//$j_sub=implode($jmbsub,"<br/>");///if(!empty($utme_sys_rea)){echo 
													}
													
													
												?>
												<tr>
												<td><?php echo $counter;?></td>
												<td><?php echo $RegNo;?></td>
												<td><?php echo strtoupper($SurName)." ".$FirstName." ".$OtherNames;?></td>
												<td><?php echo $Gender;?></td>
												
												<td><?php echo GetStateAbbr($StateId,$con);?></td>
												<td><?php echo GetLGA($LGA,$con);?></td>
												<td><?php echo GetProgDetails($ProgID,$con);?></td>
												<td><span style="font-family:verdana;font-size:12px;"><?php echo $jmbsub[0]." | ".$jmbsub[1]." | ".$jmbsub[2]." | ".$jmbsub[3];?></span></td>
												<td><?php if($ModeOfEntry==2){$de_details=explode("~",$OtherCert); echo $de_details[0]."-".GetDEgrade($con,$de_details[2]);}else{echo $JambAgg;} ?></td>
												
												<?php
												if($search_criteria==0){
													
												?>
												<td><ul><li><b>Panel's Decision: </b><?php 
												if($panel_reason==2 && $def_subjects!=""){echo GetReason($con,$panel_reason)."<br/><li><b>O-level Deficiency(s): </b>".$def_subjects."</li>";}else{echo "<li>".GetReason($con,$panel_reason).$sy_reason."<br/></li>";}
												?>
												<!--<li><?php// if(!empty($utme_sys_rea)){echo "<b>UTME Deficiency: </b>".$utme_sys_rea;}else{echo $system_reason;}?></li>-->
												
												<?php if(!empty($medical_reason)){echo "<li>".$medical_reason."</li>";}elseif($medical_reason==-1){echo "<li>NOT SCREENED AT MEDICALS</li>";}?>
												</ul></td>
												
												<?php
													}
												?>
												
												<td><?php if($ModeOfEntry==2){echo "DE";}else{echo "UTME";}?></td>
												
												<?php

												echo "</tr>";
												$counter++;
													}//end of while
												
													?>
												</tbody>
											  </table>
									</div>
							</div>
						</div>
					</div><!---end of row-->
		</div>
	</div>
</div>
<?php
include('includes/footer.php');

 ?>