<?php 
//error_reporting(0);
include('includes/header.php');
include('includes/connect.php');
//include('functions/function.php');
chkAdminsession();
$privilege=$_SESSION['prev'];
$assigned_panel=$_SESSION['panel'];
?>
<script>

</script>
<div class="container">



    <div class="well" style="margin-top:70px;">
        <div class="row" style="padding-left:15px;">
				<div class="alert alert-success col-lg-4 col-md-4" style="height:45px;" >
					  <strong style="padding:0px;line-height:1px;"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['screensuper'];?>!</strong>
					  
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
		
    $stdInfo=GetActiveTime($con,$assigned_panel,$privilege,$JambNo);// get details based on assigned dept and active slot GetActiveTime($conn,$panelid,$prev,$JambNo)
    // echo $JambNo;
   // $tbs = "pstudentinfo_tb_ar";
    //$fields=array('staff_name' => $staffname,'Username' => $username,'password' => $pswd,'Panel' => $panelid,'Privilege' => $prev);
  // $stdInfo = mysqli_fetch_array($stdQ);

    $jambNo = $stdInfo['JambNo'];

    if(isset($jambNo) && $jambNo !=''){

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

    $progQuery = mysqli_fetch_assoc(Select4rmdbtb($con,"programme_tb",$fields = "ProgName",$cond = "ProgID = '".$stdInfo['ProgID']."'"));
    $UTMEdept = $progQuery['ProgName'];
    $UTMEsubjects=$stdInfo['JmbComb'] ;

    $OlevelResult = explode("###",$stdInfo['OlevelRst2']);

    $Olevel1 = explode("||",$OlevelResult[0]);

    if(count($OlevelResult)>1){

    $Olevel2 = explode("||",$OlevelResult[1]);

    }
////////////////////////////////////////////////////////////////////////////////////////////
$OlevelRstDetails  = $stdInfo['OlevelRstDetails'] ;//Etinan Institute, Etinan`~2016`~60093265EA`~3`~1

$olvldetails=explode("###",$OlevelRstDetails);

if(count($olvldetails)>1){
	$details=explode("`~",$olvldetails[0]);// break sitting 1
	$details2=explode("`~",$olvldetails[1]);//break sitting 2
}else{
	$details=explode("`~",$olvldetails[0]);// break sitting 1
}


    ?>



    <div class="row" style="padding-left:10px;padding-right:10px;">
        <div class="col-md-2">
            <div class="card">
                <div class="card-content"><img src=<?php if($passport != ""){echo "../".$passport;}else{ echo "assets/img/pph.jpg";} ?> width="150px" height="70%;" class="img-responsive"></div>
            </div>
        </div>
        <div class="col-md-5">
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
				<h4 id="carddescription"><i class="icon ion-home"></i> CONTACT DETAILS</h4>
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
						<tr>
						<td>
						EMAIL
						</td>
						<td>
						<?php echo $email; ?>
						</td>
						</tr>
					</table>
	
	<button  class="btn btn-primary btn-flat" data-toggle="modal"
	data-target="#myorigin">VIEW CERTIFICATE OF ORIGIN</button>
	
				</div>
            </div>
        </div>
    </div>
	
	<!------------------------------------------------------------------------->
    <div class="row" style="padding-right:10px;padding-left:10px;margin-bottom:100px;">
        <div class="col-md-4" >
            <div class="card" style="height:455px;overflow-y:scroll;">
                <div class="card-content" >
				<h4 id="carddescription"><i class="fa fa-list-o"></i> JAMB DETAILS</h4>
					<table class="table table-bordered table-hover " style="font-family:san-serif;font-weight:bolder;font-size:12px;">
							<tr>
							<td>
							JAMB No:
							</td>
							<td>
								<?php echo $jambNo; ?>
							</td>
							</tr>
							<tr>
							<td>
							JAMB SCORES:
							</td>
							<td>
							<?php echo $jambScore; ?>
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
							if(isset($UTMEsubjects)){
								
								$can_Jmb=explode("~",$UTMEsubjects);
								foreach($can_Jmb as $cand_sub){
									echo"<tr><td>".getSubject($con,$cand_sub)."</td></tr>";
									
									
								}
								
							}else{"no jamb combination was supplied";}
							
							
							?>
						
				</table>
				</td>
			</tr>
		</table>
		<!----------------------Jamb ANALYSIS SECTION------------------->
			<button  class="btn btn-primary btn-flat" data-toggle="modal" data-target="#myjamb">VIEW JAMB RESULT</button>
				
                </div>
				
            </div>
        </div>
		
        <div class="col-md-4" >
            <div class="card" style="height:455px;overflow-x:scroll;">
                <div class="card-image"></div>
                <div class="card-content" >
				<h4 id="carddescription">WAEC DETAILS: <b style="color:red;"><?php echo count($OlevelResult); ?> sittings</b></h4>
				<h5 style="font-family:arial;font-weight:bolder;">No of  Passes On Required Subjects: <?php echo checkAdmissibleStatus($con, $stdInfo['OlevelRst'], $stdInfo['ProgID'],$jambNo); ?></h5>
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
								echo getSubject($con, $subj[0]);
							?>
							</td>
							<td>
							<?php 
								echo getGrade($con, $subj[1]);
							?>
							</td>
						
						</tr>
					<?php
					
					}


					
					?>
						
					</table>

					
						</td>
						</tr>
						
					</table>

                  <button  class="btn btn-primary btn-flat" data-toggle="modal"
						data-target="#mywaec1">VIEW CERTIFICATE</button><hr>
						<?php
					
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
							
						</tr>
						<?php
						}
										
						?>
						
					</table>
						</td>
						</tr>
						
					</table>
				<button  class="btn btn-primary btn-flat" data-toggle="modal"
						data-target="#mywaec2">VIEW CERTIFICATE</button>
<?php
						
}
?>
                </div>
            </div>
        </div>
		
        <div class="col-md-4">
            <div class="card" style="height:455px;overflow-y:scroll;">
                <div class="card-content">
				<h4 id="carddescription">CANDIDATE'S SCREENING STATUS</h4>
				<?php
				$screenQ=getAllRecord($con,"recommendation_tb","RegNo='$jambNo'","","");
				$rec_exist=mysqli_num_rows($screenQ);
				if($rec_exist > 0){
					$screened=mysqli_fetch_array($screenQ);
				if($screened[4]!="" || !empty($screened[4])){
					$system=$screened[4];//SYSYTEMREC
					$panel=$screened[6];//PANEL REC
					$medical=$screened[8];// MEDICAL REC
					$final=$screened[10];// FINAL REC
					 }
				
				}
				
				?>
                    
						<table class="table table-bodered table-hover" style="overflow-y:scroll;width:100%;height:200px;">
							
							<tr>
								<td>
								<h5>SYSTEM SCREENING STATUS:</td><td><?php echo GetScreenStatus($system)."--".GetadmStatus($system);?></td>
							</tr>
							<tr>
								<td>
								<h5>PANEL SCREENING STATUS: </td><td><?php echo GetScreenStatus($panel)."--".GetadmStatus($panel);?></td>
							</tr>
							
							<tr>
								<td >
								<h5>MEDICAL SCREENING STATUS: </td><td><?php echo GetScreenStatus($medical)."--".GetadmStatus($medical);?></td>
							</tr>
							<tr>
								<td>
								<h5>FINAL SCREENING STATUS: </td><td><?php echo GetScreenStatus($final)."--".GetadmStatus($final);?></td>
							</tr>
						</table>
				
					<div></div>
                </div>
				
            </div>
        </div>
       </div><!--END OF ROW-->
    
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
		WAEC CERTIFICATE FIRST SITTING
		</h4>
		 </div>
			 <div class="modal-body">
			<img src="../epconfig/UserImages/Waec/<?php echo $jambNo;?>.jpg" width="100%" height="100%">
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
		WAEC CERTIFICATE SECOND SITTING
		</h4>
		 </div>
			 <div class="modal-body">
			<img src="../epconfig/UserImages/Origin/<?php echo $jambNo;?>.jpg" width="100%" height="100%">
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
<img src="../epconfig/UserImages/Origin/<?php echo $jambNo;?>.jpg" width="100%" height="100%">
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
<img src="../epconfig/UserImages/Origin/<?php echo $jambNo;?>.jpg" width="100%" height="100%">
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
  <?php 
 include('includes/footer.php');
 ?> 
 