<?php 

//error_reporting(0);

include('../includes/header_user.php');

include('../includes/connect.php');

//include('functions/function.php');

//chksessionpanel();

//$privilege=$_SESSION['prev'];

//$assigned_panel=$_SESSION['panel'];
pstudentinfo_tb_ar
?>



<div class="container">



    <?php

	
pstudentinfo_tb_ar
// echo $JambNo;

   // $tbs = "pstudentinfo_tb";

    //$fields=array('staff_name' => $staffname,'Username' => $username,'password' => $pswd,'Panel' => $panelid,'Privilege' => $prev);

  // $stdInfo = mysqli_fetch_array($stdQ);

  

  

 $pr=getAllRecord($con,"programme_tb","","","");

 while($r=mysqli_fetch_array($pr)){

	 $dept=$r['ProgID'];

	 



 // $dept=;

  $gender="M";

	$stdQ=getAllRecord($con,"nonpstudentinfo_tb","ProgID = '$dept' AND RegLevel=6","","");//$getscreened=getAllRecord($con,"recommendation_tb","RegNo LIKE '$regNo' AND final_status=1","","");

		while($stdInfo = mysqli_fetch_array($stdQ)){

		$jambNo=$stdInfo['JambNo'];

		

			  $OlevelResult = explode("###",$stdInfo['OlevelRst2']);

		



    $Olevel1 = explode("||",$OlevelResult[0]);



    if(count($OlevelResult)>1){



    $Olevel2 = explode("||",$OlevelResult[1]);



    }



/////////////////////////////////////////////////////////////////////////////////////////////////////break olevel details up

		$olvlRstDet=$stdInfo['OlevelRstDetails'];

		$UTMEsubjects=$stdInfo['JmbComb'];

		

		$utme_req=Getutmerequire($con,$dept);

		

		$Response_status=checkJamb($con,$UTMEsubjects,$utme_req,$dept,$jambNo);

		echo "<p>".$Response_status."</p>";

		?>

		

                    <p>SYSTEM:</p> 

					<?php  

					echo checkAdmissibleStatus($con, $stdInfo['OlevelRst2'],$dept,$jambNo);

					

					

					

							if(checkAdmissibleStatus($con, $stdInfo['OlevelRst2'], $dept,$jambNo) >=5)

							{	$waec_adm_status=1;

								echo "<b style='color:green'>CANDIDATE IS </b>"; 

								}

								else

								{$waec_adm_status=0;

								$sys_reason_waec="Deficiency In Olevel Subject";

								echo "<b style='color:red'>NOT ADMISSIBLE</b>";

								

								}

								//////////////////////////////////////////

							if($Response_status!=0)

							{	$utme_adm_status=1;

									echo "<b style='color:green'>ADMISSIBLE</b>"; 

								}

								else

								{$utme_adm_status=0;

								$sys_reason_utme="Incorrect UTME Subject Combination";

								echo "<b style='color:red'>NOT ADMISSIBLE</b>";

								

								}

								/////////////check if both conditions are ok***********************/////

								if(($waec_adm_status==1) && ($utme_adm_status==0))

								{

									$sys_reason=$sys_reason_utme;

									echo "<b style='color:red'>NOT ADMISSIBLE</b>";

									echo "<b style='color:red'>".$sys_reason_utme."</b>";

									$adm_status=0;

									//$final_status=0;

								}

								else if(($waec_adm_status==0) && ($utme_adm_status==1))

								{							$sys_reason=$sys_reason_waec;		

															/* if(checkAR($olvlRstDet)==true){

															$AR_ERROR="Candidate submitted awaiting result and Presented no Result";

															$sys_reason=$AR_ERROR;

									

															}else{

																

														

															} */

									

									echo "<b style='color:red'>".$sys_reason_waec."</b>";

									$adm_status=0;

									//$final_status=0

								}

								else if(($waec_adm_status==0) && ($utme_adm_status==0))

								{	$sys_reason=$sys_reason_waec;	

														/* 	if(checkAR($olvlRstDet)==true){

															$AR_ERROR="Candidate submitted awaiting result and Presented no Result";

															$sys_reason=$AR_ERROR;

									

															}else{

																

															

															} */

							

									$sys_reason=$sys_reason_waec."-&-".$sys_reason_utme;

									$adm_status=0;

								}

								else if(($waec_adm_status==1) && ($utme_adm_status==1))

								{

									$adm_status=1;

									$sys_reason="";

									//$final_status=1

									echo "<b style='color:green'>ADMISSIBLE</b>"; 

								}

							//////////////////////////////////////////////////////////////////////////

							$exist=Exist($con,"RegNo",$jambNo,"recommendation_tb");//before inserting be sure it does not exist 

							

							if($exist[0]==FALSE){//if it does not exist insert

								

								

								$fields=array('RegNo' => $jambNo,'dept' => $programme,'system_rec' => $adm_status,'system_reason' => $sys_reason);

								

								$sqlres =Insert2DbTb($con,$fields,'recommendation_tb','');

								$listid=mysqli_insert_id($con);

								

								}

								elseif

								($exist[0]==TRUE)

								{//if it exist update

									$listid=$exist[1];

									//echo"<br/>candidate already exist";

									

									

									

									$fields=array('RegNo' => $jambNo,'system_rec' => $adm_status,'system_reason' => $sys_reason);

									$sqlupdate=Updatedbtb($con,'recommendation_tb',$fields,"RegNo='$jambNo'");

									

								}

		}

 }//end of while

					?>

					

		





<!----------------------------------/ENDS HERE------------------------------------------------------>



  <script src="../assets/js/jquery.min.js"></script>

    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>

	  <script src="../assets/js/Sidebar-Menu.js"></script>

	  

</body>



</html>