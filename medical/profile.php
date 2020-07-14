<?php 
//updated 2-7-19
//error_reporting(0);
include('../includes/header_user.php');
include('../includes/connect.php');
//include('functions/function.php');
chksessionmed();
$privilege=$_SESSION['prev'];
$assigned_panel=$_SESSION['panel'];
?>
<script>
 $(document).ready(function(){
	    
///////////////////////////////////////medical processor
 $('#medreason').hide();
	 
	$('#med_recom').on('change',function(){
		var medrec=$(this).val();
		//alert(medrec);
		
		if(medrec==0){
			$('#medreason').show();		
		} else if(medrec==1){
			 $('#medreason').hide();
		}
	 })
	 
		  
	  $('#medform').submit(function(e){
		 e.preventDefault();
		 $('#pansubmit').removeClass("fa-save");
		$('#pansubmit').addClass("fa-cog fa-spin");
		var meddata=$(this).serialize();
		/* var panel_rec = $('#panel_rec').val();
		var panel_reason = $('.p_reason').val();
		var cand_id = $('#c_id').val(); */
		 // alert(panel_rec+panel_reason);
		  
		    $.ajax({ 
                type:'POST',
                url:'form_handlers/medical_handler.php',
                data:meddata,
                success:function(text){
					$('#pansubmit').removeClass("fa-cog fa-spin");
					$('#pansubmit').addClass("fa-save");
					$('#medstage').html(text);
									}
            });  
		
	}) 
	/////////////////////////////////////////////////////////////
}) 

</script>
<div class="container">



    <div class="well" style="margin-top:70px;">
        <div class="row" style="padding-left:15px;">
				<div class="alert alert-success col-lg-4 col-md-4" style="height:45px;" >
					  <strong style="padding:0px;line-height:1px;"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['screenmed'];?>!</strong>
					  
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
    $VenueID  = $stdInfo['VenueID'] ;
	
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
/////////////////////////////////////////////////////////////////////////////////////////////////////break olevel details up

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
                <div class="card-content"><img src=<?php if($passport != ""){echo "../".$passport;}else{ echo "../assets/img/pph.jpg";} ?>  width="150px" height="70%;" class="img-responsive"></div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card" style="height:270px;">
                <div class="card-content">
					<h4 id="carddescription"><i class="icon ion-home"></i> BASIC DETAILS</h4>
                    <table class="table table-bordered table-hover " style="font-family:arial narrow;font-weight:bolder;font-size:12px;">
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
				<table class="table table-bordered table-hover " style="font-family:arial narrow;font-weight:bolder;font-size:12px;">
						
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
				</div>
            </div>
        </div>
    </div>
	
	<!------------------------------------------------------------------------>
    <div class="row" style="padding-right:10px;padding-left:10px;margin-bottom:100px;">
        <div class="col-md-4" >
            <div class="card" style="height:455px;overflow-y:scroll;">
                <div class="card-content" >
				<h4 id="carddescription"><i class="icon ion-gear"></i> JAMB DETAILS</h4>
					<table class="table table-bordered table-hover " style="font-family:arial narrow;font-weight:bolder;font-size:12px;">
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
		<!----------------------Jamb ANALYSIS SECTION------------------>
                </div>
				
            </div>
        </div>
		
        <div class="col-md-4" >
            <div class="card" style="height:455px;overflow-x:scroll;">
                <div class="card-image"></div>
                <div class="card-content" >
				<h4 id="carddescription">WAEC DETAILS: <b style="color:red;"><?php echo count($OlevelResult); ?> sittings</b></h4>
				<h5 style="font-family:arial;font-weight:bolder;">No of  Passes On Required Subjects: <?php echo checkAdmissibleStatus($con, $stdInfo['OlevelRst2'], $programme,$jambNo); ?></h5>
				<table class="table table-bordered table-hover " style="height:330px;font-family:arial narrow;font-weight:bolder;font-size:12px;">
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

					

						<table class="table table-bordered table-hover " style="font-family:arial narrow;font-weight:bold;font-size:12px;overflow-y:scroll;width:100%;height:200px;">

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

					<?php
					
						if(isset($Olevel2)){
?>
				   <h5>SECOND SITTING</h5>
				<table class="table table-bordered table-hover " style="font-family:arial narrow;font-weight:bolder;font-size:12px;">
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
						<table class="table table-bordered table-hover " style="font-family:arial narrow;font-weight:bolder;font-size:12px;overflow-y:scroll;width:100%;height:200px;">
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
					
<?php
						
}
?>
                </div>
            </div>
        </div>
		
		<div class="col-md-4">
            <div class="card" style="height:455px;">
                <div class="card-content" style="font-family:arial narrow">
				<h4 id="carddescription">RECOMMENDED STATUS</h4>
				<?php
				$screened=Exist($con,"RegNo",$jambNo,"recommendation_tb");
				?>
                    <p>PANEL SCREENING STATUS: <b style="color:green"><?php if($screened[0]==TRUE){echo "<h4 style='color:green;font-family:times new roman'>SCREENED</h4>";}else{echo "<h4 style='color:red'>NOT SCREENED</h4>";}?></b></p>
					<form id="medform">
						<table class="table table-bodered table-hover" >
							<tr>
								<td colspan="2">
								MEDICAL PERSONNEL RECOMMENDATION
								</td>
								
							</tr>
							<tr>
								<td>
								<select class="form-control" name="med_recom" id="med_recom" required>
								<option value="">-please select-</option>
								<option value="1">NORMAL</option>
								<option value="0">NOT-NORMAL</option>
								</select>
								</td>
							</tr>
							<tr id="medreason">
								<td>
								<p style="color:red">Please state reasons</p>
									<textarea class="form-control" name="med_reason" >
									
									</textarea>
								</td>
							</tr>
							<input type="hidden" name="cand_id" value="<?php echo $screened[1];?>" />
							<input type="hidden" name="regno" value="<?php echo $jambNo;?>" />
							<input type="hidden" name="score" value="<?php echo $jambScore;?>" />
							<input type="hidden" name="cand_phone" value="<?php echo $phone;?>" />
							<input type="hidden" name="dept" value="<?php echo $programme;?>" />
							<input type="hidden" name="cand_name" value="<?php echo $name;?>" />
							<input type="hidden" name="cand_email" value="<?php echo $email;?>" />
							<input type="hidden" name="VenueID" value="<?php echo $VenueID;?>" />
							
							<tr>
								<td colspan="2">
								<button name="med_submit" class="form-control btn btn-success" >Submit <li id="pansubmit" class="fa fa-save"></button>
								</td>
							
							</tr>
						</table>
						<p style="color:red;">NOTE:Please the Medical section of the screening is very important.please state reasons clearly</p>
							
					</form>
					<div id="medstage"></div>
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
	  <script src="../assets/js/Sidebar-Menu.js"></script>
	  
</body>

</html>