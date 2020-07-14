<?php 
//error_reporting(0);
include('../includes/header_user.php');
include('../includes/connect.php');
//include('functions/function.php');
chksessionpanel();
$privilege=$_SESSION['prev'];
$assigned_panel=$_SESSION['panel'];

$settings=Loadsettings($con);
$status=$settings['status'];
$screenType=$settings['Screening_Type'];
$allowAR=$settings['allow_AR'];
if($status=="CLOSED"){
    die("<h2 style='margin-top:100px;padding-left:50px;'>SCREENING CLOSED</h2>");
    
}
?>
<script>
 $(document).ready(function(){
	 
	// $('#jmbanal').html("<img id='loader' src='assets/img/loader.gif' />");
	 
	 //$('#jmbanal').html();
	 
	 $('#reason').hide();
	$('#ctble').hide();
	 
	$('#panel_rec').on('change',function(){
		var prec=$(this).val();
		//alert(prec);
		
		if(prec==0){
			$('#reason').show();		
		}else if((prec==1) ||(prec==-1)){
			$('#reason').hide();
		}
		
		// $('#subj').hide();
	})
	 
$('#p_reason').on('change',function(){
		var reason_value=$(this).val();
		//alert(prec);
		
		if(reason_value==2){
			$('#ctble').show();	
				
		}else{
			$('#ctble').hide();	
		}
		
	})
	
	 $('#panelform').submit(function(e){
		e.preventDefault();
		
		$('#pansubmit').removeClass("fa-save");
		$('#pansubmit').addClass("fa-cog fa-spin");
		
		
		
		 var reason_type = $('#ctble').val();
		 //alert(reason_type);
		 
		var data=$(this).serialize();
		//alert(data);
		/*var panel_reason = $('.p_reason').val();
		var cand_id = $('#c_id').val(); */
		 // alert(panel_rec+panel_reason);
		  
		   $.ajax({ 
                type:'POST',
                url:'form_handlers/profileHandler.php',
                data:data,
                success:function(html){
					
					$('#pansubmit').removeClass("fa-cog fa-spin");
					$('#pansubmit').addClass("fa-save");
					
					$('#stage').html(html);
					//alert(html);
					// $('#pansubmit').html("Submit");
									}
            });  
		
	}) 
///////////////////////////////////////medical processor
/////////////////////////////////////////////////////////////
	
	
	
	
	
	
	
}) 


function val() {
	
	var d=$('#panel_rec').val();
	var e=$('#sys_rec').val();
	
//var d = document.getElementById("panel_rec").value;
//var e = document.getElementById("sys_rec").value;

if((d != "") && (d != e)){
	if(confirm("Do you want to override the system recommendation?")){
		// if the person clicks ok	
		//alert(d);
		
		alertify.confirm("Are you sure you want to override system's Recoomendation?.",
						  function(){
							alertify.success('YES');
						  },
						  function(){
							alertify.error('NO');
							//$('#panel_rec').val()=-1;
						  });
				  
		
		
	//	document.getElementById("panel_rec").selectedIndex = d;
		$('#panel_rec').val()=d;
	

	}else{
		// if the person clicks cancel
		//document.getElementById("panel_rec").selectedIndex = -1;
		$('#panel_rec').val()=-1;
	}
}

}


</script>
<div class="container">

    <div class="well" style="margin-top:70px;">
        <div class="row" style="padding-left:15px;">
				<div class="alert alert-success col-lg-4 col-md-4" style="height:45px;" >
					  <strong style="padding:0px;line-height:1px;"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['screenpanel'];?>!</strong>
					  
				</div>
				<form action="profile.php" method="post">
            <div class="col-lg-6 col-md-6 col-sm-6">
            
                <div class="search-container" style="margin-top:0px;margin-bottom:0px;">
   					
                    <input type="text" name="search-bar" placeholder="Search..." class="search-input">
                    <button class="btn btn-default search-btn" type="button"> <i class="glyphicon glyphicon-search"></i></button>

                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary btn-lg" type="submit" name="btnSearch">Search </button>
            </div>
             </form>
        </div>
    </div>

    <?php
    if(isset($_POST['search-bar']) && isset($_POST['btnSearch'])){
		
		$JambNo = mysqli_real_escape_string($con,(trim($_POST['search-bar'])));
		
  // $std=GetActiveTime($con,$privilege,$JambNo);// get details based on assigned dept and active slot GetActiveTime($conn,$panelid,$prev,$JambNo)//$assigned_panel
    // echo $JambNo;
   // $tbs = "pstudentinfo_tb_ar";
    //$fields=array('staff_name' => $staffname,'Username' => $username,'password' => $pswd,'Panel' => $panelid,'Privilege' => $prev);
    
    $getAll=getAllRecord($con,"pstudentinfo_tb_ar","JambNo='$JambNo'","","");
 $stdInfo = mysqli_fetch_array($getAll);

    $jambNo = $stdInfo['JambNo'];

    if(isset($jambNo) && $jambNo !=''){

    	//$_SESSION['system_rec'] = '';

   // echo "Jamb number: ".$jambNo;
    $name = $stdInfo['SurName'] . ", ".  $stdInfo['FirstName']. " ".  $stdInfo['OtherNames'];
    $gender = $stdInfo['Gender'];
    $dob= $stdInfo['DOB'];
    //echo "dob ".$dob;
    $age = findAge($dob);
    $passport = $stdInfo['Passport'];

    $stateQuery = mysqli_fetch_assoc(Select4rmdbtb($con,"state_tb",$fields = "StateName",$cond = "StateID = '".$stdInfo['StateId']."'"));
    $state  = $stateQuery['StateName'];
   
    $lgaQuery = mysqli_fetch_assoc(Select4rmdbtb($con,"lga_tb",$fields = "LGAName",$cond = "LGAID = '".$stdInfo['LGA']."'"));
    $lga = $lgaQuery['LGAName'];


    $phone  = $stdInfo['Phone'];;
    $address  = $stdInfo['Addrs'] ;
    $email  = $stdInfo['Email'] ;
	
	$programme=$stdInfo['ProgID'];
    $jambScore = $stdInfo['JambAgg'];

    $deCert = $stdInfo['OtherCert'];
    $modeOfEntry = $stdInfo['ModeOfEntry'];

    $progQuery = mysqli_fetch_assoc(Select4rmdbtb($con,"programme_tb",$fields = "ProgName",$cond = "ProgID = '".$stdInfo['ProgID']."'"));
    $UTMEdept = $progQuery['ProgName'];
	$UTMEsubjects=$stdInfo['JmbComb'] ;
	//$score=$stdInfo['JambAgg'] ;
    $OlevelRstDetails=$stdInfo['OlevelRstDetails'] ;

    $OlevelResult = explode("###",$stdInfo['OlevelRst2']);

    $Olevel1 = explode("||",$OlevelResult[0]);

    if(count($OlevelResult)>1){

    $Olevel2 = explode("||",$OlevelResult[1]);

    }

/////////////////////////////////////////////////////////////////////////////////////////////////////break olevel details up

$OlevelRstDetails  = $stdInfo['OlevelRstDetails'] ;//Etinan Institute, Etinan`~2016`~60093265EA`~3`~1

$olvldetails=explode("###",$OlevelRstDetails);

if(count($olvldetails)>1){
	//echo "ttttt";
	$details=explode("`~",$olvldetails[0]);// break sitting 1
	$details2=explode("`~",$olvldetails[1]);//break sitting 2
}else{
//	echo "vvvvv";
	$details=explode("`~",$olvldetails[0]);// break sitting 1
}

    ?>


<div class="container">
    <div class="row" style="padding-left:10px;padding-right:30px;margin-right:15px;background-color:#efefef;border-radius:4px;">
        <div class="col-md-3" >
            <div class="card" style="height:300px;">
                <div class="card-content"><img src=<?php if($passport != ""){echo "../".$passport;}else{echo "../assets/img/pph.jpg";} ?> width="200px"  class="img-responsive"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="height:300px;">
                <div class="card-content">
					<h4 id="carddescription"><i class="icon ion-home"></i> BASIC DETAILS</h4>
                    <table class="table table-bordered table-hover " style="font-family:times new;font-weight:bolder;font-size:12px;">
						<tr>
						<td>
						NAME:
						</td>
						<td>
						<?php echo $name; ?> 
						</td>
						</tr>
						<tr>
						<td>
						JAMB NUMBER:
						</td>
						<td>
							<?php echo $jambNo; ?> 
						</td>
						</tr>
						<tr>
						<td>
						GENDER:
						</td>
						<td>
						<?php echo $gender; ?> 
						</td>
						</tr>
						<tr>
						<td>
						DATE OF BIRTH:
						</td>
						<td>
						<?php echo $dob; ?> 
						</td>
						</tr>
						<tr>
						<td>
						AGE:
						</td>
						<td>
						<?php echo $age; ?> 
						</td>
						</tr>
					</table>
					
                </div>
            </div>
        </div>
		 <div class="col-md-5">
            <div class="card">
                <div class="card-content">
				<h4 id="carddescription"><i class="fa fa-phone"></i> CONTACT DETAILS</h4>
				<table class="table table-bordered table-hover " style="font-family:san-serif;font-weight:bolder;font-size:12px;">
						
						<tr>
						<td>
						STATE OF ORIGIN:
						</td>
						<td>
						<?php  echo $state; ?>
						</td>
						</tr>
						<tr>
						<td>
						L.G.A:
						</td>
						<td>
						<?php echo $lga; ?>
						</td>
						</tr>
						<tr>
						<td>
						PHONE:
						</td>
						<td>
						<?php echo $phone; ?>
						</td>
						</tr>
						<tr>
						<td>
						ADDRESS
						</td>
						<td>
						<?php echo $address; ?>
						</td>
						</tr>
						<!--<tr>
						<td>
						EMAIL
						</td>
						<td>
						<?php echo $email; ?>
						</td>
						</tr>-->
					</table>
	<?php
	if($privilege==2 || $privilege==3){
					?>
	<button  class="btn btn-primary btn-flat" data-toggle="modal"
	data-target="#myorigin"><li class="fa fa-eye"></li> VIEW CERTIFICATE OF ORIGIN</button>
	<?php
	}
	?>
				</div>
            </div>
        </div>
    </div>
</div>
<br/>
	<!-- --------------------------------------------------------------------- -->
	<div class="container">
    <div class="row" style="height:800px important!;padding-right:10px;padding-left:10px;margin-bottom:100px;margin-right:15px;margin-top:0px;background-color:#efefef;border-radius:3px;">
        <div class="col-md-4" >
            <div class="card" style="height:880px;overflow-y:scroll;">
                <div class="card-content" >
				<h4 id="carddescription"><i class="fa fa-th-large"></i> JAMB DETAILS</h4>
					<table class="table table-bordered table-hover " style="font-family:san-serif;font-weight:bolder;font-size:12px;">
							<tr>
							<td>
							JAMB No:
							</td>
							<td>
								<?php echo $jambNo; ?>
							</td>
							</tr>
							
							<?php
								if($screenType == 'PUTME' && $modeOfEntry == 1){
								if(isset($UTMEsubjects)){
								?>
							<tr>
							<td>
						
							JAMB SCORES:
							</td>
							<td>

								<?php echo $jambScore; $sc=checkjambAgg($con,$jambScore,$programme); if($sc==1){echo "<b style='color: green;'> ✔ (CORRECT AGGREGATE)</b>";}else{echo "<b style='color: red;'> ✘ (AGGREGATE IS BELOW CUTOFF)</b>";}?>
							</td>
							</tr>
							<tr>
							<td>
							DEPARTMENT:
							</td>
							<td>
								<?php echo $UTMEdept; ?>
							</td>
							</tr>
					<tr>
							<td>
							JAMB SUBJECTS:
							</td>
						<td>	
				<table class="table table-bordered table-hover ">
							
							<?php
				
								$can_Jmb=explode("~",$UTMEsubjects);
								foreach($can_Jmb as $cand_sub){
									echo"<tr><td>".getSubject($con,$cand_sub)."</td></tr>";
								}
								
							}else{"no jamb combination was supplied";}
						}elseif($screenType == 'DE' && $modeOfEntry == 2){

							$dedetails = explode('~', $deCert);
							?>
							<tr>
							<td>
							Department Apllied For:
							</td>
							<td>
								<?php echo $UTMEdept; ?>
							</td>
							</tr>
							<tr>
							<td>Name Of Institution:
							</td>
							
							<td>
								<?php echo $dedetails[0]; ?>
							</td>
							</tr>
							<tr>
							<td>
							Department:
							</td>
							<td>
								<?php echo $dedetails[3]; ?>
							</td>
							</tr>
							<tr>
							<td>
							Class Of Pass:
							</td>
							<td>
								<?php 
								$classofpass = mysqli_fetch_assoc(Select4rmdbtb($con,"classofpass_tb",$fields = "ClassName",$cond = "ID = '".$dedetails[2]."'"));
    							$pass = $classofpass['ClassName'];

								echo $pass; ?>

								<table  class="table table-bordered table-hover">
										<td>
								<?php
								if(getDeStatus($con, $dedetails[2])==1){
									?>
							<p style="color: green;">✔</p></td>
							<td>
								<p style="color: green;">Class of Pass: OK</p>
							</td>
							<?php
							}else{
								?>
								<p style="color: red;">✘</p></td>
							<td>
								<p style="color: red;">Class of Pass: NOT OK</p>
							</td>
								<?php
							}
							?>
								</table>
							</td>
						
							</tr>
							<tr>
							<td>
							Year of Graduation:
							</td>
							<td>
								<?php echo $dedetails[1]; ?>
							</td>
							</tr>
							
							<?php
						}		
					?>	
				</table>
				</td>
			</tr>
		</table>
		<!-- -------------------- Jamb ANALYSIS SECTION----------------- -->
				<?php
					if($privilege==2){
						//check screening type
						?>
					<div class="panel panel-primary">
						<div class="panel-heading"><li class="fa fa-bullhorn"></li>Candidate's Subject Analysis</div>
						<div class="panel-body">
						<table class="table table-bordered table-hover " id="jmbanal">
						<?php
						if($screenType == 'PUTME' && $modeOfEntry == 1){
							?>
							
							<tr>
							<td>
							
							<?php
							$utme_req = Getutmerequire($con,$programme);
							$Response_status = checkJamb($con,$UTMEsubjects,$utme_req,$programme,$jambNo );
							//echo "<p class='alert alert-success'>".$Response_status."</p>";
							?>
							</td>
							</tr>
							<?php

							}elseif($screenType == 'DE' && $modeOfEntry == 2){
							//implement diret entry
								$Response_status = getDeStatus($con, $dedetails[2]);
								//echo getDeStatus($con, $dedetails[2]);
							}?>

				</table>
						</div>
					</div>	
						
                 <?php
				 }
				 
			if($privilege==2){
				//check screening type
				if($screenType == 'PUTME' && $modeOfEntry == 1){
					?>
				<button  class="btn btn-primary btn-flat" data-toggle="modal" data-target="#myjamb"><li class="fa fa-eye"></li>VIEW JAMB RESULT</button>
				<?php
				}elseif($screenType == 'DE' && $modeOfEntry == 2){
					//implement diret entry
					?>
					<button  class="btn btn-primary btn-flat" data-toggle="modal" data-target="#myjamb"><li class="fa fa-eye"></li>VIEW CERTIFICATE</button>
					<?php
				}
			}
				?>
                </div>
				
            </div>
        </div>
		
        <div class="col-md-4" >
            <div class="card" style="height:880px;overflow-x:scroll;">
                <div class="card-image"></div>
                <div class="card-content" >
						<div class="">
							<div class="panel-heading">
							<h4 id="carddescription"><li class="fa fa-th-large"></li> WAEC DETAILS </h4>
										
							</div>
							<div class="">
							<?php 
										 if((checkAR($OlevelRstDetails)==true) && empty($stdInfo['OlevelRst2'])){
															$AR_ERROR="Candidate submitted awaiting Result";
															$sys_reason_waec=$AR_ERROR;
											$message="<span class='alert alert-info'><li class='fa fa-bullhorn'></li> ".$AR_ERROR."</span>";

								echo $message;
										 }else{				
										
										?>
											<p style="color:red;"><?php echo count($OlevelResult); ?> sitting(s)</p>
											<h5 style="font-family:arial;font-weight:bolder;">No of  Passes On Required Subjects: <?php echo checkAdmissibleStatus($con, $stdInfo['OlevelRst2'], $programme,$jambNo); ?></h5>
										<table class="table table-bordered table-hover " style="height:330px;font-family:san-serif;font-weight:bolder;font-size:12px;">
												<tr>
												<td>
												EXAM NUMBER:
												</td>
												<td>
												<?php echo $details[2];?>
												</td>
												</tr>
												<tr>
												<td>
												EXAM YEAR:
												</td>

												<td>
												<?php echo $details[1];?>
												</td>
												</tr>
												<tr>
												<td>
												EXAM TYPE:
												</td>
												<td>
												<?php echo Olvlexam($con,$details[3]);?>
												</td>
												</tr>
												<tr>
												<td>
												EXAMINATION SCHOOL:
												</td>
												<td>   
												<?php echo $details[0];?>
												</td>
												</tr>
												<tr>
												
												<td colspan="2">
												<h5>RESULT BREAKDOWN</h5>

											

												<table class="table table-bordered table-hover " style="font-family:arial;font-weight:bold;font-size:12px;overflow-y:scroll;width:100%;height:200px;">

												<?php	

													$countRequire = 0;
													
													for($i =0; $i< count($Olevel1); $i++){

														$subj = explode('=', $Olevel1[$i]);
												?>
												<tr>
													<td>
													<?php 
														echo getSubject($con, $subj[0]);//subject
													?>
													</td>
													<td>
													<?php 
														echo getGrade($con, $subj[1]);//grade
													?>
													</td>
													<?php
												if($privilege==2){							
													?>
													<td>
													<?php 

													if(checkRequirement($con, $subj[0], $subj[1], $stdInfo['ProgID'])==TRUE){

														++$countRequire;
														echo "<p style= 'color: green;'>&#10004;</p>";
													}else{
														echo "<p style= 'color: red;'>&#10008;</p>";
													}
													?>
													</td>
													<?php
													}				
													?>
												</tr>
											<?php
											
											}

											?>
												
											</table>

											
												</td>
												</tr>
												
											</table>

											<?php
											if($privilege==2){
											?>
										  <button  class="btn btn-primary btn-flat" data-toggle="modal"
												data-target="#mywaec1"><li class="fa fa-eye"></li> VIEW CERTIFICATE</button><hr>
												<?php
											}
												if(isset($Olevel2)){
						?>
										   <h5>SECOND SITTING</h5>
										<table class="table table-bordered table-hover " style="font-family:san-serif;font-weight:bolder;font-size:12px;">
												<tr>
												<td>
												EXAM NUMBER:
												</td>
												<td>
												<?php echo $details2[0];?>
												</td>
												</tr>
												<tr>
												<td>
												EXAM YEAR:
												</td>
												<td>
												<?php echo $details2[0];?>
												</td>
												</tr>
												<tr>
												<td>
												EXAM TYPE:
												</td>
												<td>
												<?php echo Olvlexam($con,$details2[3]);?>
												</td>
												</tr>
												<tr>
												<td>
												EXAMINATION SCHOOL:
												</td>
												<td>
												<?php echo $details2[0];?>
												</td>
												</tr>
												<tr>
												
												<td colspan="2">
												<h5>RESULT BREAKDOWN</h5>
												<table class="table table-bordered table-hover " style="font-family:arial;font-weight:bolder;font-size:12px;overflow-y:scroll;width:100%;height:200px;">
												<?php
									
												for($i =0; $i< count($Olevel2); $i++){

													$subj = explode('=', $Olevel2[$i])
												?>
												<tr>
													<td>
													<?php 
														echo getSubject($con, $subj[0]);
													?>
													</td>
													<td>
													<?php 
														echo getGrade($con, $subj[1]);
													?>
													</td>
													<?php
						if($privilege==2){
													
													?>
														<td>
													<?php 

													if(checkRequirement($con, $subj[0], $subj[1], $stdInfo['ProgID'])){

														++$countRequire;
														echo "<p style= 'color: green;'>&#10004;</p>";
													}else{
														echo "<p style= 'color: red;'>&#10008;</p>";
													}
													?>
													</td>
													<?php
													
										}
													?>
												</tr>
												<?php
												}
																
												?>
												
											</table>
												</td>
												</tr>
												
											</table>
											<?php
						if($privilege==2){
											?>
										<button  class="btn btn-primary btn-flat" data-toggle="modal"
												data-target="#mywaec2"><li class="fa fa-eye"></li> VIEW CERTIFICATE</button>
						<?php
										}
						}
				
							}// end of AR CHECK TO DISPLAY MESSAGE INSTEAD OF ERROR MESSAGES
		
						?>
							</div>
							
							
						</div>

                </div>
            </div>
        </div>
		<?php
		if(($privilege==2)){
		
			?>
			<div class="col-md-4"  >
			<div class="card" >
				<div class="card-content">
				<h4 id="carddescription" ><li class="fa fa-th-large"></li>SYSTEM'S SCREENING</h4>
                 
					<?php  
						//	if((checkAdmissibleStatus($con, $stdInfo['OlevelRst2'], $stdInfo['ProgID']) >=5) && ($Response_status!=0))
						//	{	
							//	$adm_status=1;
						//		$sys_reason="";
							//	echo "<b style='color:green'>ADMISSIBLE</b>"; 
						//		}
							//	else
							//	{	$adm_status=0;
						//		$sys_reason="Incorrect UTME Subject Combination";
							//	echo "<b style='color:red'>NOT ADMISSIBLE</b>";
								
							//	}
							
							
						//	$exist=Exist($con,"RegNo",$jambNo,"recommendation_tb");//before inserting be sure it does not exist 
							
						//	if($exist[0]==FALSE){//if it does not exist insert
								
								
							//	$fields=array('RegNo' => $jambNo,'dept' => $programme,'ScreenedBy' => $assigned_panel,'system_rec' => $adm_status,'system_reason' => $sys_reason);
								
							//	$sqlres =Insert2DbTb($con,$fields,'recommendation_tb','');
							//	$listid=mysqli_insert_id($con);
								
							//	}
						//		elseif
						//		($exist[0]==TRUE)
						//		{//if it exist update
							//		$listid=$exist[1];
							//		echo"<br/>candidate already exist";
									
									
									
							//	$fields=array('RegNo' => $jambNo,'ScreenedBy' => $assigned_panel,'dept' => $programme,'system_rec' => $adm_status);
							//		$sqlupdate=Updatedbtb($con,'recommendation_tb',$fields,"id='$listid'");
									
							//	}
							
							///////////////////////////////////////////////////OLEVEL CHECK
							$sys_reason="";
							//check to see the result is not AR
							if((checkAR($OlevelRstDetails)==true) && empty($stdInfo['OlevelRst2'])){
								//this is responsible 4 allowing AR to be admissible
											if($allowAR=='ALLOW'){
												$waec_adm_status=1;
											}else if($allowAR=='DISALLOW'){
												$waec_adm_status=0;
											}
								//end of allow AR TO BE ADMISSIBLE
								
						
								 

							}else{

										if(checkAdmissibleStatus($con, $stdInfo['OlevelRst2'], $programme,$jambNo) >=5)
									{	$waec_adm_status=1;
										echo "<b style='color:green;display:block;border-radius:2px;background-color:#efefef;'><li class='fa fa-check'></li> CANDIDATE'S O' LEVEL IS OK </b>"; 
										}
										else
										{$waec_adm_status=0;
										$sys_reason_waec="-Deficiency In O-level Subject-";
										echo "<b style='color:red;display:block;border-radius:2px;background-color:#efefef;'> <li class='fa fa-remove'></li> ERROR! IN O'LEVEL SUBJECTS</b><br/>";
										
										}
							}
							
								//////////////////////////////////////////UTME CHECK
							if($Response_status!=0)
							{	$utme_adm_status=1;
								echo "<b style='color:green;display:block;border-radius:2px;background-color:#efefef;font-family:verdana'><li class='fa fa-check'></li> CANDIDATE'S UTME COMBINATION IS OK </b>"; 
								
								}
								else
								{//when the response status is 0,then check to see if the mode of entry is de or putme todisplay correct error message
									$utme_adm_status=0;
									if($modeOfEntry==2){
											$sys_reason_utme="<i><br/>Pass Grade Not Accepted!</i>";
										
									}else{
											$sys_reason_utme="Incorrect UTME Subject Combination";
										
									}
									
								
								//echo "<b style='color:red'>NOT ADMISSIBLE</b>";
								
								}

								//check if the jambscore requirements
							//	echo $jambScore."--".$programme;
								$score_check=checkjambAgg($con,$jambScore,$programme);
							//	echo $score_check;
									if($score_check==0){
										$sys_score_status=0;
										$sys_reason_score="Jamb Aggregate is below cutoff mark";
										$sys_reason.=$sys_reason_score;
										echo "<b style='color:red'>NOT-ADMISSIBLE</b>"; 
									}else{
										$sys_score_status=1;
									}

								/////////////check if both conditions are ok***********************/////
								if(($waec_adm_status==1) && ($utme_adm_status==0))
								{
									$sys_reason.=$sys_reason_utme;
									echo "<li><b style='color:red;display:block;border-radius:2px;background-color:#efefef;font-family:verdana'><li class='fa fa-remove'></li> ERROR IN UTME SUBJECTS(".$sys_reason_utme.")</b></li>";
									//echo "<b style='color:red'>(".$sys_reason_utme.")</b>";
									$adm_status=0;
									//$final_status=0;
									?><input type='hidden' id= "sys_rec" value = <?php echo $adm_status; ?> /><?php
								}
								else if(($waec_adm_status==0) && ($utme_adm_status==1))
								{							$sys_reason.=$sys_reason_waec;
							
															 if((checkAR($OlevelRstDetails)==true) && empty($stdInfo['OlevelRst2'])){
															$AR_ERROR="(Candidate submitted awaiting result)";
															
															$sys_reason_waec.=$AR_ERROR;
															$sys_reason.=$AR_ERROR;
															echo "<b style='color:red'>NOT-ADMISSIBLE</b>"; 
															}else{
																
														
															} 
									
									echo "<li><b style='color:red'>".$sys_reason_waec."</b></li>";
									$adm_status=0;
									//$final_status=0
									?><input type='hidden' id= "sys_rec" value = <?php echo $adm_status; ?> /><?php
								}
								else if(($waec_adm_status==0) && ($utme_adm_status==0))
								{	//$sys_reason=$sys_reason_waec;	
														
										if((checkAR($OlevelRstDetails)==true) && empty($stdInfo['OlevelRst2'])){
											$AR_ERROR="(Candidate submitted awaiting result)";
											$sys_reason.=$AR_ERROR;
											$sys_reason_waec.=$AR_ERROR;
											echo "<b style='color:red'>NOT-ADMISSIBLE</b>"; 
											}else{
												
										
											} 
							

									//$sys_reason=$sys_reason_waec."-&-".$sys_reason_utme;
									$adm_status=0;
									?>
									<input type='hidden' id= "sys_rec" value = <?php echo $adm_status; ?> />
									<?php
								}
								else if(($waec_adm_status==1) && ($utme_adm_status==1))
								{	
											//check for the scorestatus before diplaying admission status or even setting admstatus
											if($sys_score_status==1){
												$adm_status=1;
												//$sys_reason="";
											//$final_status=1
											echo "<b style='color:green'>ADMISSIBLE</b>"; 
											}else{
												$adm_status=0;
												echo "<b style='color:red;display:block;border-radius:2px;background-color:#efefef;font-family:verdana'><li class='fa fa-remove'></li>".$sys_reason_score."</b>";
											}
											
									?>
									<input type='hidden' id= 'sys_rec' value = <?php echo $adm_status; ?> /><?php
								}
							//////////////////////////////////////////////////////////////////////////
							$exist=Exist($con,"RegNo",$jambNo,"recommendation_tb");//before inserting be sure it does not exist 
							
							if($exist[0]==FALSE){//if it does not exist insert
								
								
								$fields=array('RegNo' => $jambNo,'dept' => $programme,'system_rec' => $adm_status,'system_reason' => $sys_reason);

								?>

								

								<?php 
								
								$sqlres =Insert2DbTb($con,$fields,'recommendation_tb','');
								$listid=mysqli_insert_id($con);
								
								}elseif($exist[0]==TRUE){//if it exist update
									$listid=$exist[1];
									//echo"<br/>candidate already exist";
									
									
									
									$fields=array('RegNo' => $jambNo,'system_rec' => $adm_status,'system_reason' => $sys_reason);
									$sqlupdate=Updatedbtb($con,'recommendation_tb',$fields,"RegNo='$jambNo'");
									
								}
		}
							
							
							//////////////////////////////////////////////////////////////////////////////////////////////////
					?>
				</div>
			</div>
            <div class="card">
                <div class="card-content" style="height:660px" >
			<div class="">
				<div class="panel panel-primary">
				<div class="panel-heading"><li class="fa fa-bullhorn"></li>
								PANEL'S RECOMMENDATION
							</div>
				<div class="panel-body" style="width:;height:550px;overflow-y:scroll;">
				
				<form id="panelform">
						<table class="table table-responsive" style="padding:0px;">
							
							<tr>
								<td>
								<strong>Recommendation:</strong>
								</td>
								<td>
								<select class="form-control" name="panel_rec" id="panel_rec" onchange="val()" style="width:100px;" required>
								<option value="-1">please select</option>
								<option value="1">ADMISSIBLE</option>
								<option value="0">NOT-ADMISSIBLE</option>
								</select>
								</td>
							</tr>
							<tr id="reason">
								<td><strong>Reason:</strong></td>
								
								<td >
								<select class='form-control ' id="p_reason" name='p_reason' style="width:100px;" >
								<option value="">-please select-</option>
								<?php
								
										$sel = mysqli_query($con,"SELECT * FROM screening_reason");	
										if($sel){
										while($row=mysqli_fetch_array($sel)){
											$pid=$row['id'];
											$reason_name=$row['Reason'];
											?>
											<option  value='<?php echo $pid;?>'> <?php echo $reason_name;?> </option>
											<?php
											}
										
									}
									else
									{echo"cant run query";
									}
								?>
								</select>
								</td>
							</tr>
							<tr>
							<td colspan="2" >
							<div id="ctble" style="width:;height:150px;overflow-y:scroll;">
							<table class="table table-bordered table-hover"  >
								<thead>
								  <tr>
									<th>#</th>
									<th>Subjects</th>
									</tr>
								</thead>
								<tbody id="courses" style="height:20%;overflow-y:scroll;">
									<?php
									/* if(isset($default)){
										die($default);
									} */
									$chkrec4=mysqli_query($con,"SELECT * FROM olvlsubj_tb");//query student info based on the info you derived
									while($row=mysqli_fetch_array($chkrec4)){
										?>
								<tr style="width:auto;"><td><input id="subj" type="checkbox"  value="<?php echo $row['SubId'];?>" name="course[]"></td><td style="width:auto;"><?php echo $row['SubName'];?></td></tr>
										
								<?php		
									}
								?>
							</tbody>
						
						</table>
						</div>
							</td>
							</tr>
								<tr>
								<td colspan="2">
								<p><strong>No of Result Checker(s):<b style="color:red"><?php echo count($OlevelResult); ?></b></p>
								</td>
								</tr>
							<tr>
								<td>
								<p><strong>No of Result Checker cards submitted</strong></p>
								</td>
								<td>
								<input type="number" name="card" value="" required style="width:100px;" />
								</td>
							</tr>
							<input type="hidden" name="c_id" value="<?php echo $listid;?>" id="c_id">
							<input type="hidden" name="ass_panel" value="<?php echo $assigned_panel;?>" id="">
							<input type="hidden" name="prog_dept" value="<?php echo $programme;?>" id="">
							<input type="hidden" name="moe" value="<?php echo $modeOfEntry;?>" id="">
							
							
							<tr>
								<td colspan="2">
								<button  name="panelsubmit"  class="form-control btn btn-success" >Submit <li id="pansubmit" class="fa fa-save"></li></button>
								</td>
							</tr>
						</table>
					</form>
					<div id="stage"></div>
				</div>
				</div>
					
					
					</div>
                </div> <!-- end of card content -->
            </div>
			<?php
					/* 			if(isset($_POST['panelsubmit'])){
								$panelsubmit=mysqli_real_escape_string($con,(trim($_POST['panelsubmit'])));
								$panel_rec=mysqli_real_escape_string($con,(trim($_POST['panel_rec'])));
								$p_reason=mysqli_real_escape_string($con,(trim($_POST['p_reason'])));
								if(empty($p_reason) || $p_reason=="")
								{
									$fields=array('panel_rec' => $panel_rec);
								}
								else
								{
									$fields=array('panel_rec' => $panel_rec,'panel_reason' => $p_reason);
								}
						
									$sqlupdate=Updatedbtb($con,'recommendation_tb',$fields,"id='$listid'");
									if($sqlupdate==true){

									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-10 hidden-print\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> screening sucessful !</strong>
											  
										</div></div>";

								}else{echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-10\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error submitting screening status</strong>
										</div></div>";}
								}
				 */				
			?>
        </div>
		
		
       </div><!--END OF ROW-->
	   </div><!-- end of container -->
<?php 
					
		}// END OF IF REG NO NOT FOUND
	else{
	?>
	<div class="well" style="background: white; border: 0px;">
        <div class="row" style="padding-left:15px;">
				<div class="alert alert-danger col-lg-12 col-md-12" style="height:45px; border: 0px;" >
					  <strong style="padding:0px;line-height:1px;"><span class="glyphicon glyphicon-info-sign"></span> Candidate  NOT FOUND</strong>
					  
				</div>
			
        </div>
    </div>
    <?php
	}
	
	
	}elseif(!isset($_POST['search-bar']) and !isset($_POST['btnSearch'])){

}

?>

<!-----------------------------------MODALFOR FLASHING WAEC FIRST------------------------>
<div class="modal fade" id="mywaec1" tabindex="-1" role="dialog"
 aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
	 <div class="modal-content">
		 <div class="modal-header">
			 <button type="button" class="close"
			 data-dismiss="modal" aria-hidden="true">
			 &times;
			 </button>
				<h4 class="modal-title" id="myModalLabel">
		WAEC CERTIFICATE FOR <?php echo $jambNo;?> FIRST SITTING
		</h4>
		 </div>
			 <div class="modal-body">
			<img src="../../epconfig/UserImages/Waec/<?php echo $jambNo;?>.jpg" width="100%" height="100%">
			 </div>
		<div class="modal-footer">
			 <button type="button" class="btn btn-default"
			 data-dismiss="modal">Close
			 </button>
			</div>
	 </div><!-- /.modal-content -->
</div><!-- /.modal -->
</div>
<!----------------------------------/ENDS HERE------------------------------------------------------>
<!-----------------------------------MODALFOR FLASHING WAEC SECOND------------------------>
<div class="modal fade" id="mywaec2" tabindex="-1" role="dialog"
 aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
	 <div class="modal-content">
		 <div class="modal-header">
			 <button type="button" class="close"
			 data-dismiss="modal" aria-hidden="true">
			 &times;
			 </button>
				<h4 class="modal-title" id="myModalLabel">
		WAEC CERTIFICATE FOR <?php echo $jambNo;?> SECOND SITTING
		</h4>
		 </div>
			 <div class="modal-body">
			<img src="../../epconfig/UserImages/Waec/<?php echo $jambNo."_1";?>.jpg" width="100%" height="100%">
			 </div>
		<div class="modal-footer">
			 <button type="button" class="btn btn-default"
			 data-dismiss="modal">Close
			 </button>
			</div>
	 </div><!-- /.modal-content -->
</div><!-- /.modal -->
</div>
<!----------------------------------/ENDS HERE------------------------------------------------------>
<!--------------------------jamb starts here--------------------------------------->
<div class="modal fade" id="myjamb" tabindex="-1" role="dialog"
 aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
 <div class="modal-content">
 <div class="modal-header">
 <button type="button" class="close"
 data-dismiss="modal" aria-hidden="true">
 &times;
 </button>
 <h4 class="modal-title" id="myModalLabel">
JAMB RESULT
</h4>
 </div>
 <div class="modal-body">
<img src="../../epconfig/UserImages/JambResult/<?php echo $jambNo;?>.jpg "width="100%" height="100%">
 </div>
 <div class="modal-footer">
 <button type="button" class="btn btn-default"
 data-dismiss="modal">Close
 </button>
 </div>
 </div><!-- /.modal-content -->
</div><!-- /.modal -->
</div>

  <!-----------------------------------MODALFOR FLASHING ORIGIN------------------------>
<div class="modal fade" id="myorigin" tabindex="-1" role="dialog"
 aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
 <div class="modal-content">
 <div class="modal-header">
 <button type="button" class="close"
 data-dismiss="modal" aria-hidden="true">
 &times;
 </button>
 <h4 class="modal-title" id="myModalLabel">
CERTIFICATE OF ORIGIN
</h4>
 </div>
 <div class="modal-body">
<img src="../../epconfig/UserImages/Origin/<?php echo $jambNo;?>.jpg" width="100%" height="100%">
 </div>
 <div class="modal-footer">
 <button type="button" class="btn btn-default"
 data-dismiss="modal">Close
 </button>
 </div>
 </div><!-- /.modal-content -->
</div><!-- /.modal -->
</div>

<!----------------------------------/ENDS HERE------------------------------------------------------>
 </div> 
  <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
	   <!--<script src="../assets/js/Sidebar-Menu.js"></script>
	 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->
	   <script src="<?php echo home_base_url();?>assets/js/alertify.min.js"></script>
	  <script>
	/*  $(document).ready(function(){  
					 
					  $('#panel_rec').on('change',function(){
						   var prec=$('#panel_rec').val();
							var sysrec=$('#sys_rec').val();
						  
						  
			if(sysrec!=prec){		  
					  
						alertify.confirm("Are you sure you want to override system's Recoomendation?.",
						  function(){
							alertify.success('YES');
						  },
						  function(){
							alertify.error('NO');
						  });
				  
			}
	 });  
}); */  
	  </script>
</body>

</html>