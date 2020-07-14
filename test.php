<?php
include('includes/connect.php');
include('functions/function.php');
include('functions/screener.php');


//include('includes/header.php');
$dept=28;





	//pick all not admissible from recommendation tb
	/* $getAllnonadm=getAllRecord($con,"recommendation_tb","dept='$dept' AND ModeOfEntry=1  AND final_status=0","","");
	while($rw= mysqli_fetch_assoc($getAllnonadm)){
	$JambNo=$rw['RegNo'];
	$id=$rw['id']; */

//$getAllnonadm=getAllRecord($con,"pstudentinfo_tb_ar","ModeOfEntry=1 AND OlevelRst2 !='' AND OlevelRst !=''","","");
//$getAllnonadm=getAllRecord($con,"recommendation_tb","RegNo='$REG'","","");
$getAllnonadm=getAllRecord($con,"pstudentinfo_tb","ModeOfEntry=1 AND OlevelRst2 !='' AND OlevelRst !=''","","");
//$getAllnonadm=getAllRecord($conn,"pstudentinfo_tb_ar_ar","dept='$dept' AND ModeOfEntry=1 AND OlevelRst2 !='' AND OlevelRst !=''","","");
//$noooo= mysqli_num_rows($getAllnonadm);
//echo $noooo;
	while($cand_details= mysqli_fetch_assoc($getAllnonadm)){
	$JambNo=$cand_details['JambNo'];


	$id=getscreenbYREG($con,$JambNo);

$cand_details=candet($con,$JambNo);
//var_dump($cand_details);
$score= $cand_details['Score'];
$moe= $cand_details['modeOfEntry'];
$utmesubj= $cand_details['UTMEsubjects'];
$olvel= $cand_details['olevel'];
$canddept= $cand_details['canddept'];
// check jamb things
$utme_status=checkcandjamb($con,$score,$utmesubj,$canddept,$JambNo);

$utmestatuscode=$utme_status[0];
$utmereason=$utme_status[1];
//echo $JambNo."-------".$score."---------------".$canddept."-------".$utmereason."------".$utmestatuscode;

//check waec
$waec_status=check_waec($con,$olvel,$canddept,$JambNo,$allowAR);
$waecstatuscode=$waec_status[0];
$waecreason=$waec_status[1];
//echo $waecreason."****".$waecstatuscode;
//echo lb();
////echo $JambNo."-------".$score."---------------".$canddept."-------".$waecreason."------".$waecstatuscode;


//computeStatus($sys_reason_waec,$utmesys_reason,$waec_adm_status,$utmestatus_code);
$computed_status=computeStatus($waecreason,$utmereason,$waecstatuscode,$utmestatuscode);
if(is_array($computed_status)){
	$reason_to_db=$computed_status['system_reason'];
	$status_to_db=$computed_status['system_status'];
	$generatedcode=$computed_status['code'];

echo $generatedcode;
}

echo lb();
echo $JambNo."-------".$score."---------------".$canddept."-------".$status_to_db."------".$reason_to_db;

//
$imp=implementstatus($con,$JambNo,$id,$status_to_db,$reason_to_db,$generatedcode);

echo $imp; 

		}


	

?>