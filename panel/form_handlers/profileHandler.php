<?php
error_reporting(0);
include('../../includes/connect.php');
include('../../functions/function.php');
//sleep(10);
$p_reason="";
$panel_rec="";
				 			$cand_id=mysqli_real_escape_string($con,(trim($_POST['c_id']))); 
								$panel_rec=mysqli_real_escape_string($con,(trim($_POST['panel_rec'])));
								$p_reason=mysqli_real_escape_string($con,(trim($_POST['p_reason'])));
								$assigned_panel=mysqli_real_escape_string($con,(trim($_POST['ass_panel'])));
								$programme=mysqli_real_escape_string($con,(trim($_POST['prog_dept'])));
								$moe=mysqli_real_escape_string($con,(trim($_POST['moe'])));
								$deficiency=$_POST['course'];
								//print_r($deficiency);
								$card=mysqli_real_escape_string($con,(trim($_POST['card']))); 

								if($p_reason==2 && empty($deficiency) && (count($deficiency)==0)){
									echo "<script> alertify.alert('YOU MUST SELECT THE DEFICIENT SUBJECT IF THE CANDIDATE HAS AN O-LEVEL DEFICIENCY');</script>";
								exit;
								}
									/*$cand_id=1;
									$panel_rec=1;
									$p_reason="";		
									$card=2;*/
									//echo $cand_id."<br/>".$panel_rec."<br/>".$p_reason."<br/>".$deficiency."<br/>".$card."<br/>";
									$deficient_sub=json_encode($deficiency,true);
									//if(count($deficiency) > 1){$deficient_sub=implode("~",$deficiency);}else{$deficient_sub=$deficiency;}
									
								//echo $deficient_sub;
								if(empty($p_reason) || ($p_reason==""))//IF THE REASON WAS NOT FILLED OR SELECTED
								{
									//$deficient_sub='NULL';
									//	$fields=array('RegNo' => $jambNo,'dept' => $programme,'ScreenedBy' => $assigned_panel,'system_rec' => $adm_status,'system_reason' => $sys_reason);
											
									$fields=array('panel_rec' => $panel_rec,'card' => $card,'dept' => $programme,'ScreenedBy' => $assigned_panel,'panel_reason' => $p_reason,'ModeOfEntry' => $moe);
										//echo "vvvvvvv";				
								}
								else
								{
									//	$fields=array('RegNo' => $jambNo,'dept' => $programme,'ScreenedBy' => $assigned_panel,'system_rec' => $adm_status,'system_reason' => $sys_reason);
							
									//echo "ccccccc";	
									$fields=array('panel_rec' => $panel_rec,'panel_reason' => $p_reason,'dept' => $programme,'ScreenedBy' => $assigned_panel,'card' => $card,'panel_olvl_def' => $deficient_sub,'ModeOfEntry' => $moe);
								}
						
									$sqlupdate=Updatedbtb($con,'recommendation_tb',$fields,"id='$cand_id'");
									if($sqlupdate==true){

									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-10 hidden-print\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> screening sucessful !</strong>
											  
										</div></div>";

								}else{echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-10\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error submitting screening status</strong>
										</div></div>";}
								
								
			?>