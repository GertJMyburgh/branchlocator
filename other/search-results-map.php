<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="images/favicon.ico">

        <title>Hollard Branch Locator - Search Results Map</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/main.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!--<script>
            function initialize() {
                alert("Draw GOOGLE MAP");
                var mapProp = {
                    center: new google.maps.LatLng(37, -122),
                    zoom: 5,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>-->
        
        <script>
            function initMap() {
                var myLatLng1 = {lat: -33.9201300, lng: 18.4236889};
                var myLatLng2 = {lat: -33.8802317, lng: 18.6317117};

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 8,
                    url: "https:\/\/www.google.co.za\/maps\/place\/Riebeek+St,+Cape+Town,+8001\/@-33.9188745,18.419483,17z\/data=!4m5!3m4!1s0x1dcc67612cc820b1:0x3f7ed43b0658592b!8m2!3d-33.9188393!4d18.4216209";
//                    center: myLatLng1
                });
                
//                var marker1 = new google.maps.Marker({
//                  position: myLatLng1,
//                  map: map,
//                  title: 'Hollard Branch 01'
//                });
//
//                var marker2 = new google.maps.Marker({
//                  position: myLatLng2,
//                  map: map,
//                  title: 'Hollard Branch 02'
//                });
            }
            
        </script>
        
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALKLHmQpaY_wNrRsbZEPMHiDmGN5IlNnQ&callback=initMap" async defer></script>

    </head>

    <body>

        <!--TOP MASTHEAD CONTAINING HOME ICON LINKING BACK TO BRANCHES INDEX PG-->
        <div class="home-masthead">
            <div class="container">
                <div class="row">
                    <nav class="home-main">
                        <a class="home-icon" href="#">&nbsp;</a>
                    </nav>
                </div>
            </div>
        </div>

        <!--2ND MASTHEAD CONTAINING HOLLARD LOGO LINKING BACK TO BRANCHES INDEX PG-->
        <div class="logo-masthead">
            <div class="container">
                <div class="row">
                    <ul class="nav-main">
                        <li class="nav-main__logo">
                            <a class="logo" href="/">&nbsp;</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>    


        <div class="container">

            <!--MAIN CONTENT SECTION ON LEFT INCLUDING MAP AND BRANCH DEETS-->
            <div class="col-lg-10 branch-header branch-title">
                <h1>Hollard Branch Locator</h1>
                <h3 class="branch-subheading">Find your nearest Hollard branch:</h3>
            </div>

            <div class="row">

                <div class="col-sm-8 col-md-8 branch-main">

                    <!--GOOGLE MAP-->                
                    <div class="col-sm-12 branch-main">

                        <!-- <div id="googleMap" class="col-sm-12 col-md-12 map-sizer"></div> -->
                        <div id="map" class="col-sm-12 col-md-12 map-sizer"></div>

                        
                        <!--BRANCH DETAILS PERTAINING TO MAP-->
                        <div class="search-results">
                            <h4 class="search-results-branchname">George</h4>
                            <dl class="search-results-list">
                                <dt>Address:</dt>
                                <dd>Unit 9, Canal Edge III, Carl Cronje Drive, Tyger Waterfront, 7530</dd>
                                <dt>Branch Manager: </dt>
                                <dd>Heinrich Westenraad</dd>                
                            </dl>
                        </div>                 
                    </div>

                    <!--BRANCHES SEARCH REDEFINE BUTTON - TO TAKE USER BACK TO THE SEARCH PAGE-->
                    <form action="index.php" method="" class="form-inline">
                        <div class="col-lg-12 form-group branch-form">            
                            <input type="submit" class="btn map-form-btn" id="submit" value="REDEFINE SEARCH"/>                       
                        </div>
                    </form>  

                </div>

                <!--RIGHT SIDEBAR INCLUDING CALL-BACK FORM-->

                <div class="col-sm-4 branch-sidebar">
                    <div class="sidebar-module sidebar-module-inset sidebar">
                        <h2>Rather call me back please</h2>
                        
                        <form action="call_me_back.php" method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" value="Name*" />
                            </div>
                            <div class="form-group">                    
                                <input type="text" class="form-control" name="phoneNumber" id="phoneNumber" value="Contact Number*" />    
                            </div>
                            <div class="form-group">                    
                                <select class="form-control input-group sidebar-form sidebar-caret" name="products" id="products">
                                    <option value="SelectProduct" selected="" class="sidebar-select">Select a product</option>
                                    <option value="Funeral" class="sidebar-options">Funeral</option>
                                    <option value="Legal" class="sidebar-options">Legal</option>
                                    <option value="Life" class="sidebar-options">Life</option>
                                </select>
                            </div>                
                            <div class="form-group">            
                                <input type="submit" class=" sidebar-btn" id="submit" value="CALL ME BACK"/>                       
                            </div>
                        </form>            
                    </div>

                    <!--HOLLARD CALL DIRECT NUMBER-->
                    <div class="sidebar-module">
                        <h3 class="universal-number">Or call us: 0800 601 016</h3>
                    </div>

                </div><!-- /.branch-sidebar -->

            </div><!-- /.row -->

        </div><!-- /.container -->

        <!--FOOTER-->
        <footer class="branch-footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 col-sm-push-8 branch-footer-social">
                        <ul class="nav-social">
                            <li class="nav-social--facebook">
                                <a href="https://www.facebook.com/HollardInsurance" target="_blank"><i class="icon--facebook">&nbsp;</i></a></li>
                            <li class="nav-social--linkedin">
                                <a href="http://www.linkedin.com/company/12696?trk=cws-btn-overview-0-0" target="_blank"><i class="icon--linkedin">&nbsp;</i></a></li>
                            <li class="nav-social--twitter">
                                <a href="https://twitter.com/hollard" target="_blank"><i class="icon--twitter">&nbsp;</i></a></li>                    
                            <li class="nav-social--googleplus">
                                <a href="https://plus.google.com/u/0/+HollardInsurance" target="_blank"><i class="icon--googleplus">&nbsp;</i></a></li>                    
                            <li class="nav-social--instagram">
                                <a href="http://instagram.com/hollardgram?ref=badge" target="_blank"><i class="icon--instagram">&nbsp;</i></a></li>                    
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <p>The Hollard Insurance Company Ltd (Reg No. 1952/003004/06) is an authorised Financial Services Provider, and a member of the South African Insurance Association (SAIA).<br>
                        Hollard Life Assurance Company (Reg. No. 1993/001405/06) is an authorised Financial Services Provider and a member of the Association for Savings and Investment South Africa (ASISA).<br> 
                        Hollard Investment Managers (Reg. No. 1997/001696/07) is an authorised Financial Services Provider, operates as an investment manager and is a member of the Association for Savings and Investment South Africa (ASISA).<br>
                        <br>
                        Hollard is committed to high ethical standards of business. Hollard subscribes to the Ombudsman for Short-Term Insurance and the Ombudsman for Long-Term Insurance, and is subject to the jurisdiction of the FAIS Ombud. <br>
                        <br>
                        Hollard has developed and publicises its own Financial Crime Risk Management Policy as well as policies in support of the aims of the 
                        Anti Money-Laundering Act and the Corrupt Activities Act.
                    </p>
                    <p>
                        &copy; Copyright 2016 Hollard 
                    </p>
                </div>
            </div>
        </footer>


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

        <!-- <script src="http://maps.googleapis.com/maps/api/js"></script> -->
    </body>
</html>
