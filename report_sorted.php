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



if($dept==-1){
    //echo "<br/><br/><br/><br/><br/>XXXXXXXXXXXXXXXXXXXXXXXXX".$search_criteria."--".$modeofentry;
    $resultset=mysqli_query($con,"SELECT pstudentinfo_tb.FirstName, pstudentinfo_tb.SurName, pstudentinfo_tb.OtherNames,pstudentinfo_tb.JambNo,pstudentinfo_tb.Gender,pstudentinfo_tb.LGA,pstudentinfo_tb.DOB,pstudentinfo_tb.StateId,pstudentinfo_tb.Phone, pstudentinfo_tb.JambAgg,pstudentinfo_tb.JmbComb,pstudentinfo_tb.OtherCert,pstudentinfo_tb.ProgID,recommendation_tb.ModeOfEntry,recommendation_tb.system_reason,recommendation_tb.panel_reason,recommendation_tb.panel_rec,recommendation_tb.medical_rec,recommendation_tb.panel_olvl_def,recommendation_tb.dept,recommendation_tb.final_status 
    FROM recommendation_tb 
    INNER JOIN pstudentinfo_tb 
    on recommendation_tb.RegNo = pstudentinfo_tb.JambNo WHERE recommendation_tb.final_status = {$search_criteria} AND recommendation_tb.ModeOfEntry={$modeofentry} ORDER BY dept ASC,JambAgg DESC");
    
   // var_dump($resultset);
	
}
else if($dept!=-1){

    //echo "<br/><br/><br/><br/><br/>YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY".$search_criteria."--".$modeofentry;
    $resultset=mysqli_query($con,"SELECT pstudentinfo_tb.FirstName, pstudentinfo_tb.SurName, pstudentinfo_tb.OtherNames,pstudentinfo_tb.JambNo,pstudentinfo_tb.Gender,pstudentinfo_tb.LGA,pstudentinfo_tb.DOB,pstudentinfo_tb.StateId,pstudentinfo_tb.Phone,pstudentinfo_tb.JambAgg,pstudentinfo_tb.JmbComb,pstudentinfo_tb.OtherCert,pstudentinfo_tb.ProgID,recommendation_tb.ModeOfEntry,recommendation_tb.system_reason,recommendation_tb.panel_reason,recommendation_tb.panel_rec,recommendation_tb.medical_rec,recommendation_tb.panel_olvl_def,recommendation_tb.dept,recommendation_tb.final_status 
    FROM recommendation_tb 
    INNER JOIN pstudentinfo_tb 
    on recommendation_tb.RegNo = pstudentinfo_tb.JambNo WHERE recommendation_tb.final_status = {$search_criteria} AND recommendation_tb.dept={$dept} AND recommendation_tb.ModeOfEntry={$modeofentry} ORDER BY dept ASC,JambAgg DESC");
    
   // var_dump($resultset);
	
	
}



		
					
					}

				
				
			
 ?>
<script type="text/javascript" src="helpers/csvhelper.js"></script>
<script type="text/javascript">

 $(document).ready(function(){
   
    $('#download').click(
    function() {
        alert("am working");
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
<div class="wrapper" style="margin-top:70px;margin-left:0px;">
	
				<h4 style="text-align:center;font-weight:bold;font-family:san-serif;">LIST OF <?php if($search_criteria==1){echo"ADMISSIBLE";}elseif($search_criteria==0){echo "NOT-ADMISSIBLE";}else{echo "SCREENED";} if($modeofentry==2){echo " DIRECT-ENTRY";}else{echo " PUTME";}?> CANDIDATES</h4>
				        
				<div class="row">
				<div class="col-md-12 col-lg-12">
				<div class="panel panel-default">
				<div class="panel-heading hidden-print">
				
				<table width="100%">
				
						<tr>
						<form action="report_sorted.php" method="post">
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
				  2120700824
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
	</div>
	</div>
	</div>
	<div class="row" style="margin-left:0px;">
	<div class="col-md-12 col-lg-12" >
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
													<?php if($modeofentry==1){echo "<th>UTME SUBJECT</th>";}?>
													<?php if($modeofentry==2){echo"<th>Institution</th>";}else{echo "<th>Jamb Aggregate</th>";}?>
													
													<?php if($modeofentry==2){echo"<th>Course Of Study</th>";}?>
													<?php if($modeofentry==2){echo"<th>Class of Pass</th>";}?>
													<?php if($search_criteria==0){echo"<th>Reason</th>";}?>
												
													</tr>
												</thead>
												<tbody>
												<?php
												//var_dump($resultset);
												//echo $dept."/".$search_criteria."/".$modeofentry;
												//print_r($details);
												while($details=mysqli_fetch_array($resultset)){
                                                    //echo $details['RegNo'];
                                                    $jmb_sub=array();
													$def_subjects="";
													$RegNo=$details['RegNo'];//use this reg o fetch details
													$panel_reason=$details['panel_reason'];
													$system_reason=$details['system_reason'];
													$medical_reason=$details['medical_reason'];
													$medical_rec=$details['medical_rec'];
													//var_dump($medical_reason);
													$panel_deficiency=$details['panel_olvl_def'];
													$dpt=$details['dept'];
													//if paneldeficiency is empty
													if(!empty($panel_deficiency)){
																$defff=json_decode($panel_deficiency);// array carrying the subject selected by panel
																
															foreach($defff as $rea){
																$reas_sub=getSubject($con, $rea);
																$sub[]=$reas_sub;
																$def_subjects=implode($sub,",");///if(!empty($utme_sys_rea)){echo 
															}
														}
													
													
													//panel_reason
												
													$StateId=$details['StateId'];
													$LGA=$details['LGA'];
													$SurName=$details['SurName'];
													$FirstName=$details['FirstName'];
													$OtherNames=$details['OtherNames'];
													$Gender=$details['Gender'];
													$JambAgg=$details['JambAgg'];
													$ProgID=$details['ProgID'];
													$phone=$details['Phone'];
													$ModeOfEntry=$details['ModeOfEntry'];
                                                    $JmbComb=$details['JmbComb'];
                                                    
													$OtherCert=$details['OtherCert'];
													$JambNo=$details['JambNo'];
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
														$def_sub=implode($sub,"-|-");///if(!empty($utme_sys_rea)){echo 
													}
													
			/******************this is to get deficient subject for candidate missing a particulay subject but was selelcted by the panel************************************/
			
			                                            if((empty($sy_reason) || ($sy_reason=="")) && !empty($panel_deficiency)){
			                                                
			                                                $missing_def=$def_subjects;
			                                            }else{
			                                                $missing_def="";
			                                            }
													
						/*******************************************************************************************************************************************/
													
												/*******************merge the arrays from sysytem and panel to get the unique*********************/
												$subj_def=array();
											      $d_subj = array_merge($defff,$reasn);
													$all_d_subj=array_unique($d_subj);
													
														foreach($all_d_subj as $all_d){
														$de_sub=getSubject($con, $all_d);
														$subj_def[]=$de_sub;
														$deffic_sub=implode($subj_def,"|");///if(!empty($utme_sys_rea)){echo 
													}
													/******************************************/
													
													
													//implode();
													//$jmbsub=array();
													$jamb=explode("~",$JmbComb);
													foreach($jamb as $jmb){
														$jmb_sub[]=getSubjectAbbr($con, $jmb);
														//$jmbsub[]=$jmb_sub;
														//$j_sub=implode($jmbsub,"<br/>");///if(!empty($utme_sys_rea)){echo 
													}
													
													
												?>
												<tr>
												<td><?php echo $counter;?></td>
												<td><?php echo $JambNo;?></td>
												<td><?php echo strtoupper($SurName)." ".$FirstName." ".$OtherNames;?></td>
												<td><?php echo $Gender;?></td>
												
												<td><?php echo GetStateAbbr($StateId,$con);?></td>
												<td><?php echo GetLGA($LGA,$con);?></td>
											<!--	<td><?php //echo GetProgDetails($ProgID,$con);?></td>-->
												<td><?php echo GetProgDetails($dpt,$con);?></td>
                                                <?php if($ModeOfEntry==1){echo "<td>". implode("|",$jmb_sub)."</td>";} ?>
                                                <!--<td><?php //echo $JmbComb;?></td>-->
												<!--<td><span style="font-family:verdana;font-size:12px;"><?php //echo $jmbsub[0]." | ".$jmbsub[1]." | ".$jmbsub[2]." | ".$jmbsub[3];?></span></td>-->
												<td><?php if($ModeOfEntry==2){$de_details=explode("~",$OtherCert); echo $de_details[0];}else{echo $JambAgg;} ?></td>
												<?php if($ModeOfEntry==2){echo "<td>".$de_details[3]."</td>";}?>
												<?php if($ModeOfEntry==2){echo "<td>".GetDEFullgrade($con,$de_details[2])."</td>";}?>
												<?php
												if($search_criteria==0){
													
												?>
												<td><b>Panel's Decision: </b><?php 
												if($panel_reason==2 && $def_subjects!=""){echo GetReason($con,$panel_reason)."<br/><span style='font-family:arial;'><b>O-level Deficiency(s): ".$def_sub."</span>-".$missing_def;}else{echo "<span>".GetReason($con,$panel_reason)."(".$system_reason.") , </span>";}//$def_subjects----(</b><b style='font-family:monospace'>system:".$def_sub."</b>)---$def_sub."--".$def_subjects."--"
												?>
												<!--<li><?php// if(!empty($utme_sys_rea)){echo "<b>UTME Deficiency: </b>".$utme_sys_rea;}else{echo $system_reason;}?></li>-->
												
												<?php if(!empty($medical_reason)){echo "<span>".$medical_reason."</span>";}else if($medical_rec==-1){echo "<span style='font-family:verdana;'> NOT SCREENED AT MEDICALS</span>";}?>
												</td>
												
												<?php
													}
												?>
												
											
												
												<?php

												echo "</tr>";
												$counter++;
													}//end of while
												
													?>
												</tbody>
											  </table>
									</div>
							</div>
						</div><!---end of row-->
		

<?php
include('includes/footer.php');

 ?>