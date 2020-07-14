<?php
include('../includes/connect.php');
include('../functions/function.php');
//sleep(10);
							 	$cand_id=mysqli_real_escape_string($con,(trim($_POST['c_id']))); 
								$panel_rec=mysqli_real_escape_string($con,(trim($_POST['panel_rec'])));
								$p_reason=mysqli_real_escape_string($con,(trim($_POST['p_reason'])));
								$deficiency=$_POST['course'];
								//print_r($deficiency);
								
								
								$card=mysqli_real_escape_string($con,(trim($_POST['card']))); 
									/*$cand_id=1;
									$panel_rec=1;
									$p_reason="";		
									$card=2;*/
									echo $cand_id."<br/>".$panel_rec."<br/>".$p_reason."<br/>".$deficiency."<br/>".$card."<br/>";
									
									if(count($deficiency) > 1){$deficient_sub=implode("~",$deficiency);}else{$deficient_sub=$deficiency;}
									
								echo $deficient_sub;
								if(empty($p_reason) || ($p_reason==""))//IF THE REASON WAS NOT FILLED OR SELECTED
								{
									//$deficient_sub='NULL';				
									$fields=array('panel_rec' => $panel_rec,'card' => $card,'panel_reason' => $p_reason);
										echo "vvvvvvv";				
								}
								else
								{
									echo "ccccccc";	
									$fields=array('panel_rec' => $panel_rec,'panel_reason' => $p_reason,'card' => $card,'panel_olvl_def' => $deficient_sub);
								}
						
									$sqlupdate=Updatedbtb($con,'recommendation_tb',$fields,"id='$cand_id'");
									if($sqlupdate==true){

									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-10 hidden-print\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> screening sucessful !</strong>
											  
										</div></div>".$fields;

								}else{echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-10\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error submitting screening status</strong>
										</div></div>";}
								
								
			?>