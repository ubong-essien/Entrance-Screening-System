<?php
error_reporting(0);
include('includes/header.php');
include('includes/connect.php');
/* 
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename=example.csv');
header('Pragma: no-cache'); */


$search_criteria="";

if(!empty(mysqli_real_escape_string($con,(trim($_POST['generate']))))){
$search_criteria=mysqli_real_escape_string($con,(trim($_POST['search_criteria'])));	

if(isset($search_criteria)){
	//echo "yeeeeeea";
						$resultset=getAllRecord($con,"temp","verified = 1 AND dateApplied = '$search_criteria'","","");
						
					}
				
}		
	$counter=1;		
 ?>
<script type="text/javascript" src="helpers/csvhelper.js"></script>
<script type="text/javascript">

 $(document).ready(function(){
   
$('#download').click(
function() {//alert("am working");
 exportTableToCSV.apply(this, [$('#report'), 'admissionreport.csv']);
             });
 
}); 
</script>


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
				
				<h4 style="text-align:center;font-weight:bold;font-family:san-serif;">LIST OF CANDIDATES VERIFIED FOR REFUNDS OF PUTME SCREENING FEE</h4>
				<div class="row">
				<div class="col-md-12 col-lg-12">
				<div class="panel panel-default">
				<div class="panel-heading hidden-print">
				
				<table width="100%">
				
						<tr>
						<form action="report.php" method="post">
						<td style="width:10%;">
						<label>Date:</label>
						</td>
						<td style="width:30%;">
							
                          <input type="date" name="search_criteria" class="form-control" value=""/>
						</td>
						
							<td style="width:20%;padding-left:20px;">
											
										<input class="btn btn-primary" name="generate" type="submit" value="GENERATE REPORT"/>	
							</td>
							</form>					
											
							<td style="width:10%;padding-left:150px;">
									<button onclick="window.print()"  class="btn btn-primary hidden-print">Print</button>
								
							
							
							</td>
						<td style="width:10%;">
			
							<a href="#" id="download"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Download</a>
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
													<th>Reg No</th>
													<th>Programme</th>
													<th>Account Name</th>
													<th>Acount Number</th>
													<th>Bank Name</th>
													<th>Sort Code</th>
													<th>Date Applied</th>
													<th>Status</th>
													
													</tr>
												</thead>
												<tbody>
												<?php
												while($details=mysqli_fetch_array($resultset)){
													
													$surnName=$details['surName'];//use this reg o fetch details
													$firstname=$details['firstname'];//use this reg o fetch details
													$othername=$details['othername'];//use this reg o fetch details
													$dept=$details['dept'];//use this reg o fetch details
													$regno=$details['regno'];//use this reg o fetch details
													$phone=$details['phone'];//use this reg o fetch details
													$bankDetails=$details['bankDetails'];//use this reg o fetch details
													$bnkdetails=explode("~",$bankDetails);
													//First Bank~Ubong Essien edet~3025876
													$acctno=$details['acctno'];//use this reg o fetch details
													$date=$details['dateApplied'];//use this reg o fetch details
													
													?>
												<tr>
												<td><?php echo $counter;?></td>
												<td><?php echo strtoupper($firstname)." ".$firstname." ".$othername;?></td>
												<td><?php echo $regno;?></td>
												<td><?php echo $dept;?></td>
												<td><?php echo $bnkdetails[1];?></td>
												<td><?php echo $acctno;?></td>
												<td><?php echo $bnkdetails[0];?></td>
												<td><?php echo $bnkdetails[2];?></td>
												<td><?php echo $date;?></td>
												<td><?php echo "Verified";?></td>
												
												<?php

												echo "</tr>";
												$counter++;
													}//end of while
												
													?>
												</tbody>
											  </table>
											  <div class="row">
												  <div class="col-md-3">
												  <p>__________________________________</p>
												  <p>Director ICT</p>
												  </div>
												  <!--<div class="col-md-3 col-md-offset-9">
												  <p>__________________________________</p>
												  <p></p>
												  </div>-->
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
 <script type="text/javascript">
 
 
 
 </script>
 