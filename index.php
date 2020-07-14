<?php
include('includes/header.php');
include('includes/connect.php');
chkAdminsession();
 ?>
<div class="features-boxed">
        <div class="container">
            <div class="intro"></div>
            <div class="row features" style="margin-top:40px;">
                <div class="col-md-4 col-sm-6 item">
                    <div class="box" >
                        <h3 class="name">No of Screened Candidates</h3><i class="glyphicon glyphicon-filter icon"></i>
						<?php $resultset=getAllRecord($con,"recommendation_tb","","",""); 
							$screened=mysqli_num_rows($resultset);
						?>
                        <h1><strong><?php echo $screened;?></strong> </h1></div>
                </div>
                
                <div class="col-md-4 col-sm-6 item">
                    <div class="box">
                        <h3 class="name">No of Registered Candidates </h3><i class="glyphicon glyphicon-list-alt icon"></i>
						<?php $resultset=getAllRecord($con,"pstudentinfo_tb_ar","RegLevel=6","",""); 
							$registered=mysqli_num_rows($resultset);
						?>
                        <h1><strong><?php echo $registered;?></strong></h1></div>
                </div>
                <div class="col-md-4 col-sm-6 item">
                    <div class="box">
					<h3 class="name">No of Payments</h3><i class="glyphicon glyphicon-credit-card icon"></i>
                        <h1><strong>Heading</strong></h1></div>
                </div>
                <div class="col-md-4 col-sm-6 item">
                    <div class="box">
					<?php $resultset=getAllRecord($con,"recommendation_tb","final_status=1","",""); 
							$admissible=mysqli_num_rows($resultset);
						?>
                        <h3 class="name">No of Admissible </h3><i class="fa fa-graduation-cap icon"></i>
                        <h1><strong><?php echo $admissible;?></strong></h1></div>
                </div>
                <div class="col-md-4 col-sm-6 item">
                    <div class="box">
					<?php $resultset=getAllRecord($con,"recommendation_tb","final_status=0","",""); 
							$notadmissible=mysqli_num_rows($resultset);
						?>
                        <h3 class="name">No of Not-admissible</h3><i class="fa fa-group icon"></i>
                        <h1><strong><?php echo $notadmissible;?></strong></h1></div>
                </div>
				<div class="col-md-4 col-sm-6 item">
                    <div class="box">
                        
					<h3 class="name">No of Unscreened Candidates </h3><i class="glyphicon glyphicon-eye-close icon"></i>
					
                        <h1><strong><?php $unscreened=$registered-$screened;echo $unscreened;?></strong></h1></div>
                </div>
            </div>
        </div>
    </div>
	<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/599310c1dbb01a218b4dc78f/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
	<?php
include('includes/footer.php');

 ?>