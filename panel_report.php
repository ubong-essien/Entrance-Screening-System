<?php

error_reporting(0);

include('includes/header.php');
include('includes/connect.php');
chkAdminsession();

if(!empty(mysqli_real_escape_string($con,(trim($_POST['generate']))))){
	
$panel=mysqli_real_escape_string($con,(trim($_POST['panel'])));	
$time=mysqli_real_escape_string($con,(trim($_POST['time'])));	
$day=mysqli_real_escape_string($con,(trim($_POST['day'])));	

	$resultset=Select4rmdbtb($con,"time_slot",$fields = "id",$cond = "Time LIKE '%$time%' AND Day LIKE '%$day%' AND PanelID='$panel'");
//	var_dump($resultset);
		
	
//	$rowcount=mysqli_num_rows($resultset);

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
<div class="container" style="margin-top:50px;">
	<div class="row">
				<div class="row">
						<div class="col-lg-12 col-xs-12 col-lg-offset-4 col-lg-offset-4 col-xs-offset-4" style="">
							<img src="<?php echo home_base_url();?>assets/img/logoban.png" width="80px" height="80px" style="margin-left:100px" /></span>		
						</div>
				</div>
			<div class="col-lg-12">
				<div style="text-align:center;margin-right:0px">
				<h3 class="panel-title" style="font-size:32px;font-family:san-serif;font-weight:bolder;">AKWA IBOM STATE UNIVERSITY</h3>
				<h3 class="panel-title" style="font-size:20px;font-family:san-serif;font-weight:bolder;">P.M.B. 1167 UYO, AKWA IBOM STATE, NIGERIA</h3>			
				</div>
				<div class="row" style="margin-left:0px;">
							
						<div class="col-lg-4 col-xs-4" style="font-size:16px;font-family:san-serif;font-weight:bolder;">
							<h3 class="panel-title" style="text-align:center;font-family:san-serif;font-weight:bolder;font-size:19px;">MAIN CAMPUS:</h3>
							<h3 class="panel-title" style="text-align:center;font-family:san-serif;font-weight:bolder;font-size:19px;"> IKOT AKPADEN,MKPAT ENIN L.G.A</h3>
						</div>
						<div class="col-lg-4 col-xs-4" style="font-size:16px;font-family:san-serif;font-weight:bolder;">
						</div>
						<div class="col-lg-4 col-xs-4">
							<h3 class="panel-title" style="text-align:center;font-family:san-serif;font-weight:bolder;font-size:19px;">OBIOAKPA CAMPUS:</h3>
							<h3 class="panel-title" style="text-align:center;font-family:san-serif;font-weight:bolder;font-size:19px;"> OBIO AKPA,ORUK ANAM L.G.A</h3>
								</div>	
				</div>
<hr>				
				<br><br>
				<h4 style="text-align:center;font-weight:bold;font-family:san-serif;font-size:18px;">SCREENING SUMMARY FOR PANEL <?php echo " ".$panel."-".$day."-".$time?></h4>
				<div class="row">
				<div class="col-md-12 col-lg-12">
				<div class="panel panel-default">
				<div class="panel-heading hidden-print">
				
				<table width="100%">
						<tr>
						<td style="width:5%;">
						<label>Panel:-</label>
						</td>
						<form action="panel_report.php" method="post">
						<td style="width:50%;">
							
                           <select name="panel" class="form-control" id="panel" >
							<option value="">-please select-</option>
							<option value="1">Panel 1</option>
							<option value="2">Panel 2</option>
							<option value="3">Panel 3</option>
							<option value="4">Panel 4</option>
							
                        </select>
						</td >
						<td style="width:5%;">
						<label> Day:-</label>
						</td>
						<td style="width:30%;">
							
                           <select name="day" class="form-control" id="day" >
							<option value="">-please select-</option>
							<option value="MONDAY" >MONDAY</option>
							<option value="TUESDAY">TUESDAY</option>
							<option value="WEDNESDAY">WEDNESDAY</option>
							<option value="THURSDAY">THURSDAY</option>
							<option value="FRIDAY">FRIDAY</option>
							 </select>
						</td >
						<td><label>Slot:-</label> </td>
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
	<?php while($rows=mysqli_fetch_array($resultset)){
		$assigned_id=$rows['id'];
		
		$getstd=getAllRecord($con,"pstudentinfo_tb_ar","VenueID ='$assigned_id'","","");
		$record=mysqli_fetch_array($getstd);
		$numrows=mysqli_num_rows($getstd);// number of candidate assigned
		//print_r($rows['id']);
		
		$regNo=$record['JambNo'];
		//var_dump($regNo);
		$getscreened1=getAllRecord($con,"recommendation_tb","RegNo LIKE '$regNo'","","");//$getscreened=getAllRecord($con,"recommendation_tb","RegNo LIKE '$regNo' AND final_status=1","","");
		$sc_record=mysqli_num_rows($getscreened1);
		/********************************************************************************************/
		$getscreened2=getAllRecord($con,"recommendation_tb","RegNo LIKE '$regNo' AND panel_rec=1","","");//$getscreened=getAllRecord($con,"recommendation_tb","RegNo LIKE '$regNo' AND final_status=1","","");
		$no=mysqli_num_rows($getscreened2);
		/********************************************************************************************/
		$getscreened3=getAllRecord($con,"recommendation_tb","RegNo LIKE '$regNo' AND panel_rec=0","","");//$getscreened=getAllRecord($con,"recommendation_tb","RegNo LIKE '$regNo' AND final_status=1","","");
		$notadm=mysqli_num_rows($getscreened3);
		/********************************************************************************************/
		
		/********************************************************************************************/
	}
	$getscreened4=getAllRecord($con,"recommendation_tb","RegNo LIKE '$regNo' AND ScreenedBy = '$panel' AND card != 0","","");//$getscreened=getAllRecord($con,"recommendation_tb","RegNo LIKE '$regNo' AND final_status=1","","");
		$crd=array();
		while($cardno=mysqli_fetch_array($getscreened4)){
		$crd=(int)$cardno['card'];
		//var_dump($crd);
		}
		$cardtotal=array_sum($crd);
		//echo $cardtotal;
		//var_dump($crd);
	?>

				<table class="table table-bordered table-hover col-lg-12 col-xs-12" style="font-family:monospace;font-size:16px;">
								
									<tbody>
									
									<tr>
									<td colspan="2" style="text-align:center;font-family:monospace;font-size:20px;"><h4>SCREENING BREAKDOWN FOR PANEL <?php echo $panel;?></h4></td>
									</tr>
									<tr>
									<td>Number of Admissible Candidates</td>
									<td><?php echo $no;?></td>
									</tr>
									<tr>
									<td>Number of Assigned Candidates</td>
									<td><?php echo $numrows;?></td>
									</tr>
									<tr>
									<td>Number of Not Admissible Candidates</td>
									<td><?php echo $notadm;?></td>
									</tr>
									<tr>
									<td>Number Of Screened Candidates</td>
									<td><?php echo $sc_record;?></td>
									</tr>
									<tr>
									<td>Number of Absent Candidate</td>
									<td><?php echo ($numrows-$sc_record);?></td>
									</tr>
									<tr>
									<td>Number of Result Checkers</td>
									<td><?php echo $cardtotal;?></td>
									</tr>
									</tbody>
				</table>
				<div class="col-md-12 col-xs-12 ">
				<p style="font-family:monospace;font-size:14px;">Comment:...............................................................................................................................<br/><br/>
				.......................................................................................................................................</p><br/><br/>
				
				<p style="font-family:monospace;">Name..................................................Signature.........................Date..............................</p>
				
				<p style="font-family:monospace;font-weight:bold;line-height:0px;padding-left:100px;">Panel Chairman</p>
				</div>
				
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