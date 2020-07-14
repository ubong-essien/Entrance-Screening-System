<?php
error_reporting(0);
include('includes/header.php');
include('includes/connect.php');
chkAdminsession();

if(!empty(mysqli_real_escape_string($con,(trim($_POST['generate']))))){
	
$day=mysqli_real_escape_string($con,(trim($_POST['day'])));	
$time=mysqli_real_escape_string($con,(trim($_POST['time'])));	

//=getAllRecord($con,"time_slot","Time LIKE '%$time%' AND Day LIKE '%$day%'","","");
//var_dump($resultset);
	$resultset=Select4rmdbtb($con,"time_slot",$fields = "id",$cond = "Time LIKE '%$time%' AND Day LIKE '%$day%'");

}

 ?>
<script type="text/javascript">
/* $(document).ready(function(){
   
    $('#apprvl').on('change',function(){
		
        var approval = $("#apprvl").val();
		
		var rec_id=$(".id").val();
		alert("record:"+rec_id+":"+approval);
        if(approval){
            $.ajax({ 
                type:'POST',
                url:'approval_handler.php',
                data:'apprv='+approval,
                success:function(html){
                    $('.apprvl').attr(html);
                }
            }); 
        }
    });
	
	
}); */
</script>.
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
<div class="container" style="margin-top:70px;">
	<div class="row">
			<div class="col-lg-12">
				<div style="text-align:center;margin-right:0px">
				<h3 class="panel-title" style="font-size:28px;font-family:san-serif;font-weight:bolder;">AKWA IBOM STATE UNIVERSITY</h3>
				<h3 class="panel-title" style="font-size:18px;font-family:san-serif;font-weight:bolder;">P.M.B. 1167 UYO, AKWA IBOM STATE, NIGERIA</h3>			
				</div>
				<div class="row" style="margin-left:0px;">
							
						<div class="col-lg-4 col-xs-4" style="font-size:16px;font-family:san-serif;font-weight:bolder;">
							<h3 class="panel-title" style="text-align:center;font-family:san-serif;font-weight:bolder;">MAIN CAMPUS:</h3>
							<h3 class="panel-title" style="text-align:center;font-family:san-serif;font-weight:bolder;"> IKOT AKPADEN,MKPAT ENIN L.G.A</h3>
						</div>
						<div class="col-lg-4 col-xs-4">
							<img src="<?php echo home_base_url();?>assets/img/logoban.png" width="80px" height="80px" style="margin-left:100px" /></span>		
							</div>
						<div class="col-lg-4 col-xs-4">
							<h3 class="panel-title" style="text-align:center;font-family:san-serif;font-weight:bolder;">OBIOAKPA CAMPUS:</h3>
							<h3 class="panel-title" style="text-align:center;font-family:san-serif;font-weight:bolder;"> OBIO AKPA,ORUK ANAM L.G.A</h3>
								</div>	
				</div>	
				
				<h4 style="text-align:center;font-weight:bold;font-family:san-serif;">LIST OF CANDIDATES FOR <?php echo strtoupper($day)."-".strtoupper($time); ?> SLOT(MEDICALS)</h4>
				<div class="row">
				<div class="col-md-12 col-lg-12">
				<div class="panel panel-default">
				<div class="panel-heading hidden-print">
				
				<table width="100%">
						<tr>
						<td style="width:5%;">
						<label>Day:</label>
						</td>
						<form action="medical_attendance.php" method="post">
						<td style="width:50%;">
							
                           <select name="day" class="form-control" id="day" >
							<option value="">-please select-</option>
							<option value="MONDAY" >MONDAY</option>
							<option value="TUESDAY">TUESDAY</option>
							<option value="WEDNESDAY">WEDNESDAY</option>
							<option value="THURSDAY">THURSDAY</option>
							<option value="FRIDAY">FRIDAY</option>
							 </select>
						</td >
						<td><label>Time</label> </td>
						<td style="width:20%;">
							
                            <select name="time" class="form-control" id="time" >
							<option value="">-please select-</option>
							<option value="9AM" >9AM</option>
							<option value="12NOON">12NOON</option>
							 </select>
						</td >
							<td style="width:40%;padding-left:20px;">
											
							<input class="btn btn-primary" name="generate" type="submit" value="GENERATE REPORT"/>	
							</td>
							</form>					
											
								<td style="width:5%;padding-left:150px;">
									<button onclick="window.print()"  class="btn btn-primary hidden-print">Print</button>
							
							
							</td>
						</tr>		
			</table>
		
								
	</div>
	<div class="panel-body" >
	
				<table class="table table-bordered table-hover col-lg-12 col-xs-12" >
							<thead>
									<tr>
										<th>S/no</th>
										<th>Candidates Name</th>
										<th>Jamb Number</th>
										<th>Gender</th>
										<th>Phone</th>
										<th>Department</th>
										<th>Signature</th>
										<th>Remark</th>
										
									</tr>
							</thead>	
									<tbody>	
									<?php
								
									//$T_id=array();
				//print_r($assigned_id);
				$counter=1;
				while($details=mysqli_fetch_array($resultset)){
				$assigned_id= $details['id'];
				//$T_id=$details['id']
			//	print_r($T_id);
				//$ass_id =($assigned_id.",");
				
				//echo strrchr($ass_id,",");
				//$ass_id=implode(",",$assigned_id);
				
				//echo $ass_id;
						//explode("",$assigned_id);	
//$assigned_id=6;						
			//	echo $assigned_id;
			
			
									$getstd=getAllRecord($con,"pstudentinfo_tb_ar","VenueID ='$assigned_id'","SurName","");
									
									
									
							while($info=mysqli_fetch_array($getstd)){
												//	$counter=1;	
													$SurName=$info['SurName'];
													$FirstName=$info['FirstName'];
													$OtherNames=$info['OtherNames'];
													$JambNo=$info['JambNo'];
													$Phone=$info['Phone'];
													$ProgID=$info['ProgID'];
													$Gender=$info['Gender'];
													$OlevelRst=$info['OlevelRst'];
													$ssce=explode('###',$OlevelRst);
													$no_of_sittings=count($ssce);
									
									?>
									<tr>
										<td><?php echo $counter;?></td>
										<td><?php echo strtoupper($SurName)." ".$FirstName." ".$OtherNames;?></td>
										<td><?php echo $JambNo; ?></td>
										<td><?php echo $Gender;?></td>
										<td><?php echo $Phone; ?></td>
										<td><?php echo $programme=GetProgDetails($ProgID,$con);?></td>
										
										<td></td><td></td>
										<?php
										echo "</tr>";
									
											$counter++;	
											
								}
								
						}
?>		
									</tbody>
				</table>
									</div>
							</div>
						</div>
					</div><!---end of row-->
		</div>
	</div>
</div>
<?php

include('includes/footer.php');

 ?>