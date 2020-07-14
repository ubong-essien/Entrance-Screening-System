<?php
include('../includes/connect.php');
include('../functions/function.php');

								$cand_id=mysqli_real_escape_string($con,(trim($_POST['cand_id'])));
							 	$med_recom=mysqli_real_escape_string($con,(trim($_POST['med_recom']))); 
								$med_reason=mysqli_real_escape_string($con,(trim($_POST['med_reason'])));
								
								 
									/*$cand_id=1;
									$panel_rec=1;
									$p_reason="";		
									$card=2;*/
								if(empty($med_reason) || $med_reason=="")
								{
									$fields=array('medical_rec' => $med_recom,'medical_reason' => "");
								}
								else
								{
									$fields=array('medical_rec' => $med_recom,'medical_reason' => $med_reason);
								}
									//echo $cand_id;
									$sqlupdate=Updatedbtb($con,'recommendation_tb',$fields,"id='$cand_id'");
									
								if($sqlupdate==true){
												$finaladmstatus=SetFinal($con,$cand_id);
												if($finaladmstatus==true){$admit="completed";}else{$admit="not";}
									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-10 hidden-print\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> screening".$admit." sucessful !</strong></div></div>";

								}else{echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-10\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error submitting screening status</strong></div></div>";}
								
								
			?>