<?php
error_reporting(0);

include('includes/header.php');
include('includes/connect.php');
chkAdminsession();
if(!empty(mysqli_real_escape_string($con,(trim($_POST['generate']))))){
	
$panel=mysqli_real_escape_string($con,(trim($_POST['panel'])));	
$time=mysqli_real_escape_string($con,(trim($_POST['time'])));
$day=mysqli_real_escape_string($con,(trim($_POST['day'])));

$resultset=Select4rmdbtb($con,"time_slot",$fields = "id",$cond = "Time LIKE '$time' AND Day LIKE '$day'");
//$total_num_rows=mysqli_num_rows($resultset);

	//$resultset=getAllRecord($con,"time_slot","Time LIKE '%$time%' AND Day LIKE '%$day%'","","");	
//	$resultset=Select4rmdbtb($con,"time_slot",$fields = "id",$cond = "PanelID = '$panel' AND Time LIKE '%$time%' AND Day LIKE '%$day%'");
//$resultset=getAllRecord($con,"time_slot","PanelID = '$panel' AND Time LIKE '%$time%' AND Day LIKE '%$day%'","","");	
//var_dump($resultset);
}
$counter=1;
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
						<?php echo $total_num_rows;?>	
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
				
				<h4 style="text-align:center;font-weight:bold;font-family:san-serif;">ATTENDANCE LIST OF CANDIDATES FOR <?php echo GetPanel($panel)."-".strtoupper($day)."-".strtoupper($time); ?> SLOT</h4>
				<div class="row">
				<div class="col-md-12 col-lg-12">
				<div class="panel panel-default">
				<div class="panel-heading hidden-print">
				
				<table width="100%">
				<form action="newremark.php" method="post">
						<tr>
						<td style="width:5%;">
						<label> Panel: </label>
						</td>
						<td style="width:50%;">
							
                           <select name="panel" class="form-control" id="panel" >
							<option value="">-please select-</option>
							<option value="0">Medical</option>
							<option value="1">Panel 1</option>
							<option value="2">Panel 2</option>
							<option value="3">Panel 3</option>
							<option value="4">Panel 4</option>
							<option value="5">Panel 5</option>
							
                        </select>
						</td >
						<td><label> Time: </label></td>
						<td style="width:20%;">
							
                           <select name="time" class="form-control" id="time" >
							<option value="">-please select-</option>
							<option value="9AM" >9AM</option>
							<option value="12NOON">12NOON</option>
							 </select>
						</td >
						<td><label> Day: </label></td>
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
							<td style="width:30%;padding-left:20px;">
											
										<input class="btn btn-primary" name="generate" type="submit" value="GENERATE REPORT"/>	
							</td>
							</form>

							<td><button onclick="window.print()" n class="btn btn-danger hidden-print">Print</button></td>
							
						</tr>
						
			</table>
		
		
								
	</div>
	<div class="panel-body" >
				 <table class="table table-bordered table-hover col-lg-12 col-xs-12" >
							<thead>
												<tr>
													<th>S/no</th>
													<th>Name</th>
													<th>Reg No</th>
													<th>Gender</th>
													<th>Phone</th>
													<th>Department</th>
													<th>Remark</th>
													<th>Reason(if not admissible)</th>
													
							</thead>		
												<tbody>	
												<?php
                                        //$all_id.="";	
                                       // $a_id=array();
                                       $a_id=array(); 
								while($details=mysqli_fetch_array($resultset)){
												//	$details=mysqli_fetch_array($resultset);
                            $assigned_id=$details['id'];
                            $a_id[]=$assigned_id;
                           // var_dump($assigned_id);
                            //$getAllId.=$details['id'];
                           	
                    
                        
                                }
                                $n=implode($a_id,",");
                               // echo $n;
                                 foreach($a_id as $g_id):

                            $getstd1=getAllRecord($con,"pstudentinfo_tb_ar","VenueID = '$g_id'","","");
                            $numofstud+=mysqli_num_rows($getstd1);
                            while($d=mysqli_fetch_array($getstd1)){
                                    $rec_id=$d['id'];
                            }
                           // echo $numofstud."nn<br>";
						//	$getstd=getAllRecord($con,"pstudentinfo_tb_ar","VenueID = '$assigned_id'","id","$offset,$rowsperpage");
                            
						
                            endforeach;
                          //  print_r($a_id);
                                //echo $numofstud;
                                $rows_pages = ($numofstud/5);
                           // echo $rows_pages;
                            $rowsperpage = ceil($rows_pages);
                           // echo  $rowsperpage."ll<br/>";
                            $offset = ($panel - 1) * $rowsperpage;
                            //echo  $offset."nn<br/>";
                               // print_r($a_id);
                               $getstd=getAllRecord($con,"pstudentinfo_tb_ar","VenueID IN(".$n.") ","SurName","$offset,$rowsperpage");
                               while($info=mysqli_fetch_array($getstd)){
                                $idy=$info['id'];
                                $SurName=$info['SurName'];
                                $FirstName=$info['FirstName'];
                                $OtherNames=$info['OtherNames'];
                                $JambNo=$info['JambNo'];
                                $Phone=$info['Phone'];
                                $ProgID=$info['ProgID'];
                                $Gender=$info['Gender'];
                              //  $v=$info['VenueID'];
                            ?>
                            <tr>
                    <td><?php echo $counter;?></td>
                   
                    <td><?php echo strtoupper($SurName)." ".$FirstName." ".$OtherNames;?></td>
                    <td><?php echo $JambNo;?></td>
                    <td><?php echo $Gender;?></td>
                    <td><?php echo $Phone;?></td>
                    <td><?php echo $programme=GetProgDetails($ProgID,$con);?></td>
                    <td></td>
                    <td></td>
                    

                <?php
                echo "</tr>";
                $counter++;
                }//end of while	
									?>	
		
												</tbody>
												
												
											  </table>
											  <div class="row">
											  <div class="col-md-6"><p>Panel Chairman Name & Signature.........................................................</p></div>
											  <div class="col-md-6"><p>ICT Staff Name & Signature.....................................................................</p></div>
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