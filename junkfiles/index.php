<?php include('header.php');?>
<body>
    <nav class="navbar navbar-default navbar-fixed-top navigation-clean">
        <div class="container">
            <div class="navbar-header"><a class="navbar-brand navbar-link" href="#">AKWA IBOM STATE UNIVERSITY</a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active" role="presentation"><a href="#">Home </a></li>
                    <li role="presentation"><a href="#">Reports</a></li>
                    <li role="presentation"><a href="#">Settings </a></li>
                    <li role="presentation"><a href="#">Logout</a></li>
                    <li class="dropdown"><a class="dropdown-toggle hidden" data-toggle="dropdown" aria-expanded="false" href="#">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation"><a href="#">First Item</a></li>
                            <li role="presentation"><a href="#">Second Item</a></li>
                            <li role="presentation"><a href="#">Third Item</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="well" style="margin-top:70px;">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-10">
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
                <div class="card-content"><img></div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-content">
                    <p class="text-center">Cards for display in portfolio style material design by Google. </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="padding-right:10px;padding-left:10px;">
        <div class="col-md-4">
            <div class="card">
                <div class="card-image"><img class="img-responsive" src="assets/img/materialdesign_devices.png"><span class="card-title">Material Cards</span></div>
                <div class="card-content">
                    <p>Cards for display in portfolio style material design by Google. </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-image"><img class="img-responsive" src="assets/img/materialdesign_devices.png"><span class="card-title">Material Cards</span></div>
                <div class="card-content">
                    <p>Cards for display in portfolio style material design by Google. </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-image"><img class="img-responsive" src="assets/img/materialdesign_devices.png"><span class="card-title">Material Cards</span></div>
                <div class="card-content">
                    <p>Cards for display in portfolio style material design by Google. </p>
                </div>
            </div>
        </div>
    </div>
   <?php include('footer.php');?>