<?php
error_reporting(0);
include('includes/header.php');
include('includes/connect.php');
chkAdminsession();
$privilege=$_SESSION['prev'];
if(!empty(mysqli_real_escape_string($con,(trim($_POST['generate']))))){
	
$examstype=mysqli_real_escape_string($con,(trim($_POST['examstype'])));	
$examsset=mysqli_real_escape_string($con,(trim($_POST['examsset'])));	
$examsset="";
$resultset;
					if($examstype==2)
					{	$search_criteria="%`~2`%";
						$resultset=getAllRecord($con,"pstudentinfo_tb_ar","OlevelRstDetails LIKE '$search_criteria'","","");
					}
					elseif($examstype==3)
					{	$search_criteria="%`~3`%";
						$resultset=getAllRecord($con,"pstudentinfo_tb_ar","OlevelRstDetails LIKE '$search_criteria'","","");
					}
					elseif($examstype==4)
					{
						$search_criteria="%`~4`%";
						$resultset=getAllRecord($con,"pstudentinfo_tb_ar","OlevelRstDetails LIKE '$search_criteria'","","");
					}

				
			}
 ?>
<script type="text/javascript" src="helpers/csvhelper.js"></script>
<script type="text/javascript">

 $(document).ready(function(){
   
$('#download').click(
function() {//alert("am working");
 exportTableToCSV.apply(this, [$('#report'), 'verification.csv']);
             });
 
}); 
</script>
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

				<h4 style="text-align:center;font-weight:bold;font-family:san-serif;">LIST OF CANDIDATES 
				<?php

				if(isset($examstype)){
					switch($examstype){
								case 1:
									echo "(Awaiting Result)";
								break;
								case 2:
									echo "(WAEC)";
								break;
								case 3:
									echo "(NECO)";
								break;
								case 4:
									echo "(NABTEB)";
								break;
								case 5:
									echo "(OTHERS)";
								break;

								}
					}?></h4>
				<div class="row">
				<div class="col-md-12 col-lg-12">
				<div class="panel panel-default">
				<div class="panel-heading hidden-print">
				<form action="resultverification.php" method="post">
				<table width="100%">
						<tr>
						<td style="width:5%;">
						<label>Type:</label>
						</td>
						<td style="width:50%;">
							
                           <select name="examstype" class="form-control" id="examstype" >
							<option value="">-please select-</option>
							<option value="2" >WAEC</option>
							<option value="3">NECO</option>
							<option value="4">NABTEB</option>
							<option value="5">OTHERS</option>
							
                        </select>
						</td >
						<td><label>Set:</label> </td>
						<td style="width:20%;">
							
                           <select name="examsset" class="form-control" id="examsset" >
							<option value="">-please select-</option>
							<option value="1" >MAY/JUNE</option>
							<option value="2">NOV/DEC</option>
						</select>
						</td >
							<td style="width:40%;padding-left:20px;">
											
							<input class="btn btn-primary" name="generate" type="submit" value="GENERATE REPORT"/>	
							</td>
							</form>					
											
								<td style="width:5%;padding-left:150px;">
									<button onclick="window.print()"  class="btn btn-primary hidden-print">Print</button>
							
							
							</td>
							<td>
			
							<a href="#" id="download">Download</a>
							</td>
						</tr>		
			</table>
		
								
	</div>
	<div class="panel-body" >
				<table class="table table-bordered table-hover col-lg-12 col-xs-12" id="report">
				<thead>
						<tr>
							<th>S/no</th>
							<th>Name</th>
							<th>Examination School</th>
							<th>Exams year</th>
							<th>Examination Number</th>
							<th>Exams Type</th>
							
							<th>No Of sittings</th>
						</tr>
				</thead>	
						<tbody>	
						<?php
						//$olvldet=array();
						$counter=1;
						while($details=mysqli_fetch_array($resultset)){
							$SurName=$details['SurName'];
							$FirstName=$details['FirstName'];
							$OtherNames=$details['OtherNames'];
							
							$OlevelRstDetails=$details['OlevelRstDetails'];
							$ssce=explode('###',$OlevelRstDetails);
							//print_r($ssce);
							$first=explode("`~",$ssce[0]);
							if(in_array($examstype,$first)){
							$school1 = $first[0];
							$yearSitting1 = $first[1];
							$examNo1 = $first[2];
							$examType1 = $first[3];
							//echo $examType1;
							 if($examType1 == $examstype){?>
						<tr>
							<td><?php echo $counter;?></td>
							<td><?php echo strtoupper($SurName." ".$FirstName." ".$OtherNames);?></td>
							
							<td><?php echo strtoupper($school1); ?></td>
							<td><?php echo $yearSitting1; ?> </td>
							<td><?php echo $examNo1; ?> </td>
							<td><?php switch($examType1){
								case 1:
									echo "Awaiting Result";
								break;
								case 2:
									echo "WAEC";
								break;
								case 3:
									echo "NECO";
								break;
								case 4:
									echo "NABTEB";
								break;
								case 5:
									echo "OTHERS";
								break;

								} ?> </td>
						<?php
								
							
				echo"<td>".count($ssce)."</td>";

				echo "</tr>";
					}
				}
						else if(!empty($ssce[1]) ){
							$second=explode("`~",$ssce[1]);

							if(in_array($examstype,$second)){
							$school2 = $second[0];
							$yearSitting2 = $second[1];
							$examNo2 = $second[2];
							$examType2 = $second[3];
							//echo $examType2;
							 if($examType2 == $examstype){?>
						<tr>
							<td><?php echo $counter;?></td>
							<td><?php echo strtoupper($SurName." ".$FirstName." ".$OtherNames);?></td>
							
							<td><?php echo strtoupper($school2); ?></td>
							<td><?php echo $yearSitting2; ?> </td>
							<td><?php echo $examNo2; ?> </td>
							<td><?php switch($examType2){
								case 1:
									echo "Awaiting Result";
								break;
								case 2:
									echo "WAEC";
								break;
								case 3:
									echo "NECO";
								break;
								case 4:
									echo "NABTEB";
								break;
								case 5:
									echo "OTHERS";
								break;

								} ?> </td>
						<?php
						echo"<td>".count($ssce)."</td>";
						echo "</tr>";
					}
				}
			}
		$counter++;
		}//end of while	
							
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