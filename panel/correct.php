<?php

include('../includes/header_user.php');

include('../includes/connect.php');



$pr=getAllRecord($con,"cx","","","");

 while($r=mysqli_fetch_arrapstudentinfo_tb_ar

	 $jamb=$r['jmb'];

	 $state=$r['state'];
pstudentinfo_tb_ar
	 $lga=$r['lga'];

//echo  $jamb."--".$state."--".$lga;

	 $stdQ=getAllRecord($con,"pstudentinfo_tb","JambNo LIKE '$jamb'","","");//$getscreened=getAllRecord($con,"recommendation_tb","RegNo LIKE '$regNo' AND final_status=1","","");

		$stdInfo = mysqli_fetch_array($stdQ);

		$jambNo=$stdInfo['JambNo'];

	 echo $jambNo;

	 $fields=array('StateId' => $state,'LGA' => $lga);

		$sqlupdate=Updatedbtb($con,'pstudentinfo_tb',$fields,"JambNo='$jambNo'");

				

	 if($sqlupdate){echo "<br/><br/><br/><br/><br/><br/><br/>UPDATED";}else{echo "<br/><br/><br/><br/><br/><br/>ERROR";}

		

	 

	 

 }

?>