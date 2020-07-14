<div class="row"><div class="col-lg-6" style="margin-left:20px;">
              <strong ><span class=\"glyphicon glyphicon-info-sign\" id="reply"></span></strong>
        </div></div>
<div class="row">
                <div class="col-lg-4 col-sm-4 col-xs-4" style="padding-left:35px;padding-right:25px;">
                    <div class="panel panel-success ">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-user"></i> ADD NEW USER</h3>
                        </div>
                        <div class="panel-body">
                         <form role="form" action="user.php" method="post" enctype="multipart/form-data">
					<div class="form-group input-group"> 
                            <span class="input-group-addon">Staff Name</span>
                            <input type="text" name="staffname" class="form-control" id="staffname"/>
                        </div>
						
						
					<div class="form-group input-group"> 
                            <span class="input-group-addon">Username</span>
                            <input type="email" name="username" class="form-control" id="username"/>
                        </div>
					<div class="form-group input-group"> 
                            <span class="input-group-addon">Password</span>
                            <input type="password" name="pass" class="form-control" id="password"/>
                        </div>
					<div class="form-group input-group">
                            <span class="input-group-addon"> Priviledge level</span>
                            <select name="prev" class="form-control" id="prevlvl" required>
							<option value="">-please select-</option>
							<option value="1">Head of dept</option>
									<option value="2">Senate</option>
							</select>
                        </div>
						<div class="form-group input-group" id="dept">
                            <span class="input-group-addon"> Assigned Department</span>
                            <select name="dept" class="form-control" id="dept" required >
				<option name="" >-please select-</option>
				  <?php
			
					$sel = mysqli_query($con,"SELECT * FROM programme_tb");	
					if($sel){
					while($row=mysqli_fetch_array($sel)){
						$pid=$row['ProgID'];
						$p_name=$row['ProgName'];
						?>
						<option  value='<?php echo $row['ProgID'];?>'> <?php echo $row['ProgName'];?> </option>
						<?php
						}
					
				}else{echo"cant run query";}
			?>
				  </select>
                        </div>
						<div class="form-group input-group">
                            <span class="input-group-addon"> Phone Number</span>
                            <input class="form-control" placeholder="Enter phone" name="phone" id="phone">
                        </div>
                       
						 <div class="form-group input-group" id="stage">
                           <input type="hidden" id="hidden_user_id"> 
                        </div>
						
                         <input class="btn btn-primary" name="submit" type="submit" value="Submit Application"/>

                       

                    </form>
					<br/>
					<table class="table table-bordered table-hover">
					 <thead>
      <tr>
        <th>Priviledge Type</th>
		<th>Priviledge id</th>
      </tr>
    </thead><tbody>
				
					<tr><td>Head of Dept</td><td>1</td></tr>
					<tr><td>Academic Affairs</td><td>2</td></tr>
					</tbody>
					</table>
						</div>
                    </div>
                </div>
				<div class="col-lg-8 col-sm-8 col-xs-8" style="padding-right:25px;">
				<div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-list"></i>STAFF LIST</h3>
                        </div>
                        <div class="panel-body" style="overflow-x:scroll;">
                             

					
<table class="table table-bordered table-hover"  style="overflow-y:scroll;width:100%">
	
    <thead>
      <tr>
	  <th>S/no</th>
        
		<th>Name</th>
		<th>UserName</th>
		<th>Programme</th>
		<th>Phone Number</th>
        <th>Priv</th>
		<th colspan=2>Action</th>
      </tr>
    </thead>
    <tbody>';

<?php

$sel_prev=Getuser($con);
$counter=1;
		while($row=mysqli_fetch_array($sel_prev)){
			$dept=$row['ProgID'];
			//$pay_RegNo=$row['st'];
			//$payses=$row['Ses'];
			///////////////while your are fetching the regno from payment,get the details from studentinfo
			
			
			////////////////////////////////////////////////////////////////////////////////////////////
			$seldept = mysqli_query($con,"SELECT * FROM programme_tb WHERE ProgID = '$dept'");//decode programme id
			$rowdept=mysqli_fetch_array($seldept);




?>		
		<tr>	
        <td><?php echo $counter;?></td>
<td><?php echo $row['staff_name'];?></td>
		<td><?php echo $row['Username'];?></td>
		<td><?php $programme=GetProgDetails($dept,$con);if($programme['ProgName']==""){echo "ADMIN USER";}else{echo $programme['ProgName'];}?></td>
		<td><?php echo $row['phone'];?></td>
		<td><?php echo $row['Privilege'];?></td>
        <td><a  class="btn btn-success btn-sm"  href="edit.php?id=<?php echo $row['pre_id'];?>" id="edit"> Edit</a></td><td>  <a href="ajax/deleteUser.php?id=<?php echo $row['pre_id'];?>"  class="btn btn-danger btn-sm" >Delete</a></td>
		
<?php

		echo "</tr>";
	$counter++;
					}
						
?>	
      
<script type="text/javascript" >
/* $(document).ready(function(){
   
    $('#delete').on('click',function(){
        var del_id = $(this).val();
		alert(del_id);
        if(del_id){
            $.ajax({ 
                type:'POST',
                url:'ajax/deleteUser.php',
				data:'id='+del_id,
                success:function(html){
                    $('#reply').html(html);
					
                }
            }); 
        }else{
            $('#reply').html('error deleting record')
        }
    });
});
 */
</script>		
     
     
    </tbody>
  </table>
                        </div>
                    </div>
                </div>
</div>

                    
<!-- Modal content for update starts here starts here-->
