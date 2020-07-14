
    <nav class="navbar navbar-default navbar-fixed-top navigation-clean" >
        <div class="container" >
            <div class="navbar-header"><a class="navbar-brand navbar-link" href="#">AKWA IBOM STATE UNIVERSITY</a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
			<!-------------------------super admin------------------------->
		
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav navbar-right" style="color:orange;">
                    <li class="active" role="presentation"><a href="screening-portal">Home </a></li>
                    <li role="presentation"><a href="candidate-profile">Screening</a></li>
                    <li role="presentation"><a href="system-setting">Settings </a></li>
					<li role="presentation"><a href="waec_settings">Waec Settings </a></li>
					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="">Generate Report <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
							<li role="presentation"><a href="Admission-list">Admission Report</a></li>
							<li role="presentation"><a href="panel_report.php">Panel Summary Sheet</a></li>
                            
                            <!--<li role="presentation"><a href="#">Third Item</a></li>-->
                        </ul>
                    </li>
                    <li role="presentation"><a href="<?php echo home_base_url();?>logout.php">Logout</a></li>
                    
                </ul>
            </div>
			
        </div>
    </nav>