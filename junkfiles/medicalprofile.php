<?php include('header.php');?>
<div class="container">



    <div class="well" style="margin-top:70px;">
        <div class="row" style="padding-left:15px;">
				<div class="alert alert-success col-lg-4 col-md-4" style="height:45px;" >
					  <strong style="padding:0px;line-height:1px;"><span class="glyphicon glyphicon-info-sign"></span> Welcome: User</strong>
					  
				</div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="search-container" style="margin-top:0px;margin-bottom:0px;">
                    <input type="text" name="search-bar" placeholder="Search..." class="search-input">
                    <button class="btn btn-default search-btn" type="button"> <i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary btn-lg" type="button">Search </button>
            </div>
        </div>
    </div>
    <div class="row" style="padding-left:10px;padding-right:10px;">
        <div class="col-md-2">
            <div class="card">
                <div class="card-content"><img src="assets/img/vc.png" width="150px" height="70%;" class="img-responsive"></div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-content">
					<h4 id="carddescription"><i class="icon ion-home"></i> BASIC DETAILS</h4>
                    <table class="table table-bordered table-hover " style="font-family:times new;font-weight:bolder;font-size:12px;">
						<tr>
						<td>
						NAME:
						</td>
						<td>
						JOHN DOE EKPO
						</td>
						</tr>
						<tr>
						<td>
						JAMB NUMBER:
						</td>
						<td>
						***********
						</td>
						</tr>
						<tr>
						<td>
						GENDER:
						</td>
						<td>
						M
						</td>
						</tr>
						<tr>
						<td>
						DATE OF BIRTH:
						</td>
						<td>
						12-14-2005
						</td>
						</tr>
						<tr>
						<td>
						AGE:
						</td>
						<td>
						18
						</td>
						</tr>
					</table>
					<button  class="btn btn-primary btn-flat" data-toggle="modal"
						data-target="#mybirth">VIEW BIRTH CERTIFICATE</button>
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
						AKS
						</td>
						</tr>
						<tr>
						<td>
						L.G.A:
						</td>
						<td>
						IBI
						</td>
						</tr>
						<tr>
						<td>
						PHONE:
						</td>
						<td>
						0801234567
						</td>
						</tr>
						<tr>
						<td>
						ADDRESS
						</td>
						<td>
						23 EDET STREET UYO
						</td>
						</tr>
						<tr>
						<td>
						EMAIL
						</td>
						<td>
						YOU@YOU.COM
						</td>
						</tr>
					</table>
					<button  class="btn btn-primary btn-flat" data-toggle="modal"
						data-target="#myorigin">VIEW CERTIFICATE OF ORIGIN</button>
				</div>
            </div>
        </div>
    </div><hr>
    <div class="row" style="padding-right:10px;padding-left:10px;margin-bottom:100px;">
        <div class="col-md-4" >
            <div class="card" style="height:320px;">
                <div class="card-content" >
				<h4 id="carddescription"><i class="icon ion-gear"></i> JAMB DETAILS</h4>
					<table class="table table-bordered table-hover " style="font-family:san-serif;font-weight:bolder;font-size:12px;">
							<tr>
							<td>
							JAMB NUMBER:
							</td>
							<td>
							745449446DC
							</td>
							</tr>
							<tr>
							<td>
							JAMB SCORES:
							</td>
							<td>
							200
							</td>
							</tr>
							<tr>
							<td>
							DEPARTMENT:
							</td>
							<td>
							CHEMISTRY
							</td>
							</tr>
							<tr>
							<td>
							JAMB SUBJECTS:
							</td>
							<td>
							<ul>
							<li>ENGLISH LANGUAGE</li>
							<li>MATHEMATICS</li>
							<li>BIOLOGY</li>
							<li>CHEMISTRY</li>
							</ul>
							</td>
							</tr>
							
						</table>
                   <!--<a href="" class="btn btn-primary">VIEW RESULT</a>-->
                </div>
				
            </div>
        </div>
        <div class="col-md-4" >
            <div class="card" style="height:320px;overflow-x:scroll;">
                <div class="card-image"></div>
                <div class="card-content" >
				<h4 id="carddescription">WAEC DETAILS:<b style="color:red;">(2 sittings)</b></h4>
				<table class="table table-bordered table-hover " style="height:330px;font-family:san-serif;font-weight:bolder;font-size:12px;">
						<tr>
						<td>
						EXAM NUMBER:
						</td>
						<td>
						745449446DC
						</td>
						</tr>
						<tr>
						<td>
						EXAM YEAR:
						</td>
						<td>
						2015/2016
						</td>
						</tr>
						<tr>
						<td>
						EXAM TYPE:
						</td>
						<td>
						MAY JUNE 2017
						</td>
						</tr>
						<tr>
						<td>
						EXAMINATION SCHOOL:
						</td>
						<td>
						COMMUNITY SECONDARY SCHOOL,NNOKWA ANAMBRA STATE
						</td>
						</tr>
						<tr>
						
						<td colspan="2">
						<h5>RESULT BREAKDOWN</h5>
						<table class="table table-bordered table-hover " style="font-family:arial;font-weight:bolder;font-size:12px;overflow-y:scroll;width:100%;height:200px;">
						<tr>
					
							<td>
							ENGLISH LANGUAGE
							</td>
							<td>
							C5
							</td>
						</tr>
						<tr>
					
							<td>
							ENGLISH LANGUAGE
							</td>
							<td>
							C5
							</td>
						</tr>
						<tr>
					
							<td>
							IGBO
							</td>
							<td>
							C5
							</td>
						</tr>
						<tr>
					
							<td>
							HAUSA
							</td>
							<td>
							C5
							</td>
						</tr>
						<tr>
					
							<td>
							ENGLISH
							</td>
							<td>
							C5
							</td>
						</tr>
						<tr>
						
							<td>
							MATHEMATICS
							</td>
							<td>
							C5
							</td>
						</tr>
						<tr>
							<td>
							CHEMISTRY
							</td>
							<td>
							C5
							</td>
						</tr>
					</table>
						</td>
						</tr>
						
					</table>
                  <button  class="btn btn-primary btn-flat" data-toggle="modal"
						data-target="#mywaec1">VIEW CERTIFICATE</button><hr>
				   <h5>SECOND SITTING</h5>
				<table class="table table-bordered table-hover " style="font-family:san-serif;font-weight:bolder;font-size:12px;">
						<tr>
						<td>
						EXAM NUMBER:
						</td>
						<td>
						745449446DC
						</td>
						</tr>
						<tr>
						<td>
						EXAM YEAR:
						</td>
						<td>
						2015/2016
						</td>
						</tr>
						<tr>
						<td>
						EXAM TYPE:
						</td>
						<td>
						MAY JUNE 2017
						</td>
						</tr>
						<tr>
						<td>
						EXAMINATION SCHOOL:
						</td>
						<td>
						COMMUNITY SECONDARY SCHOOL,NNOKWA ANAMBRA STATE
						</td>
						</tr>
						<tr>
						
						<td colspan="2">
						<h5>RESULT BREAKDOWN</h5>
						<table class="table table-bordered table-hover " style="font-family:arial;font-weight:bolder;font-size:12px;overflow-y:scroll;width:100%;height:200px;">
						<tr>
					
							<td>
							ENGLISH LANGUAGE
							</td>
							<td>
							C5
							</td>
						</tr>
						<tr>
					
							<td>
							ENGLISH LANGUAGE
							</td>
							<td>
							C5
							</td>
						</tr>
						<tr>
					
							<td>
							IGBO
							</td>
							<td>
							C5
							</td>
						</tr>
						<tr>
					
							<td>
							HAUSA
							</td>
							<td>
							C5
							</td>
						</tr>
						<tr>
					
							<td>
							ENGLISH
							</td>
							<td>
							C5
							</td>
						</tr>
						<tr>
						
							<td>
							MATHEMATICS
							</td>
							<td>
							C5
							</td>
						</tr>
						<tr>
							<td>
							CHEMISTRY
							</td>
							<td>
							C5
							</td>
						</tr>
					</table>
						</td>
						</tr>
						
					</table>
                <button  class="btn btn-primary btn-flat" data-toggle="modal"
						data-target="#mywaec2">VIEW CERTIFICATE</button>

                </div>
            </div>
        </div>
		<?php
		$privilege=2
		if($privilege==1){
			?>
			<div class="col-md-4">
            <div class="card" style="height:320px;">
                <div class="card-content">
				<h4 id="carddescription">RECOMMENDED STATUS</h4>
                    <p>SYSTEM: <b style="color:green">ADMISSIBLE</b></p>
					<form action="" method="">
						<table class="table table-bodered table-hover">
							<tr>
								<td colspan="2">
								PANEL'S RECOMMENDATION
								</td>
								
							</tr>
							<tr>
								<td>
								<select class="form-control" name="" required>
								<option value="">please Recommend</option>
								<option value="">ADMISSIBLE</option>
								<option value="">NOT-ADMISSIBLE</option>
								</select>
								</td>
								
								
							</tr>
							<tr>
								<td>
									<select class="form-control" name="" required>
									<option value="">-please select-</option>
									<option value="">Wrong UTME Subjects</option>
									<option value="">Deficiency in Subject</option>
									</select>
									</td>
									<td>
								<input type="submit" name="" class="form-control btn btn-success" >
								</td>
							</tr>
						</table>
					</form>
                </div>
            </div>
        </div>
		<?php
					}else{
						
					?>
					
						<div class="col-md-4">
            <div class="card" style="height:320px;">
                <div class="card-content">
				<h4 id="carddescription">RECOMMENDED STATUS</h4>
                    <p>PANEL RECOMMENDATION: <b style="color:green">ADMISSIBLE</b></p>
					<form action="" method="">
						<table class="table table-bodered table-hover">
							<tr>
								<td colspan="2">
								PANEL'S RECOMMENDATION
								</td>
								
							</tr>
							<tr>
								<td>
								<textarea class="form-control" name="" required>
								
								</textarea>
								</td>
								
								
							</tr>
							<tr>
								<td>
									<select class="form-control" name="" required>
									<option value="">-please select-</option>
									<option value="">Wrong UTME Subjects</option>
									<option value="">Deficiency in Subject</option>
									</select>
									</td>
									<td>
								<input type="submit" name="" class="form-control btn btn-success" >
								</td>
							</tr>
						</table>
					</form>
                </div>
            </div>
        </div>
		<?php
						
					}
		
		
		?>
		
        <!--<div class="col-md-4">
            <div class="card" style="height:320px;">
                <div class="card-content">
				<h4 id="carddescription">RECOMMENDED STATUS</h4>
                    <p>SYSTEM: <b style="color:green">ADMISSIBLE</b></p>
					<form action="" method="">
						<table class="table table-bodered table-hover">
							<tr>
								<td colspan="2">
								PANEL'S RECOMMENDATION
								</td>
								
							</tr>
							<tr>
								<td>
								<select class="form-control" name="" required>
								<option value="">please Recommend</option>
								<option value="">ADMISSIBLE</option>
								<option value="">NOT-ADMISSIBLE</option>
								</select>
								</td>
								
								
							</tr>
							<tr>
								<td>
									<select class="form-control" name="" required>
									<option value="">-please select-</option>
									<option value="">Wrong UTME Subjects</option>
									<option value="">Deficiency in Subject</option>
									</select>
									</td>
									<td>
								<input type="submit" name="" class="form-control btn btn-success" >
								</td>
							</tr>
						</table>
					</form>
                </div>
            </div>
        </div>-->
    </div>
</div>	
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
			<img src="assets/img/uploads/waec/1.png" width="100%" height="100%">
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
			<img src="assets/img/uploads/waec/1.png" width="100%" height="100%">
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
<!-----------------------------------MODALFOR FLASHING BIRTH CERTIFICATE------------------------>
<div class="modal fade" id="mybirth" tabindex="-1" role="dialog"
 aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
 <div class="modal-content">
 <div class="modal-header">
 <button type="button" class="close"
 data-dismiss="modal" aria-hidden="true">
 &times;
 </button>
 <h4 class="modal-title" id="myModalLabel">
BIRTH CERTIFICATE
</h4>
 </div>
 <div class="modal-body">
<img src="assets/img/uploads/birth/1.jpg "width="100%" height="100%">
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
<img src="assets/img/uploads/origin/1.jpg" width="100%" height="100%">
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
  
  <?php include('footer.php');?> 