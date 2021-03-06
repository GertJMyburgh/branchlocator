<?php ?>

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

        <title>Hollard Branch Locator</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <!-- <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet"> -->

        <!-- Custom styles for this template -->
        <link href="css/funeral-main.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <!--<script src="../../assets/js/ie-emulation-modes-warning.js"></script> -->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
            
        <script type="text/javascript">
            
            // <![CDATA[           
            function Province() {
                $('#province_placeholder').empty();
                $('#province_placeholder').append("<option>Loading......</option>");
                $('#city_placeholder').append("<option value='0'>Select Your City</option>");
                $.ajax({
                    type:"GET",
                    url:"provinces_dropdown.php",
                    contentType:"application/json; charset=utf-8",
                    cache: false,
                    dataType:"json",
                    success: function(data) {
                        $('#province_placeholder').empty();
                        $('#province_placeholder').append("<option value='0'>Select Your Province</option>");
                        $.each(data,function(i,item) {
                            $('#province_placeholder').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                        });
                    },
                    complete: function() {
                    }
                });
            }

            function City(sid) {
                $('#city_placeholder').empty();
                $('#city_placeholder').append("<option>Loading......</option>");
                $.ajax({
                    type:"GET",
                    url:"cities_dropdown.php?sid=" + sid,
                    contentType:"application/json; charset=utf-8",
                    cache: false,
                    dataType:"json",
                    success: function(data) {
                        $('#city_placeholder').empty();
                        $('#city_placeholder').append("<option value='0'>Select Your City</option>");
                        $.each(data,function(i,item) {
                            $('#city_placeholder').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                        });
                    },
                    complete: function() {
                    }
                });
            }

            $(document).ready(function() {
                Province();
                $("#province_placeholder").change(function() {
                    var provinceid = $("#province_placeholder").val();
                    City(provinceid);
                });
            });
            
            function trimWhiteSpacesAll(str) {
                return str.replace(/\s/g, "");
            }

            function trimWhiteSpacesLeftRight(str) {
                str = str.replace(/^\s+/, '');
                for (var i = str.length - 1; i >= 0; i--) {
                    if (/\S/.test(str.charAt(i))) {
                        str = str.substring(0, i + 1);
                        break;
                    }
                }
                return str;
            }

            function getURL() {
                var url;
                url = parent.document.location.href;
                //alert("this is the parent url "+url);
                document.getElementById('urlPathName').value = url;
            }

            function validateForm() {
                var a = document.forms["Form1"]["name"].value;
                var c = document.forms["Form1"]["phoneNumber"].value;
                var d = document.forms["Form1"]["products"].value;       
                
                // Strip any spaces in front or at the back
                a = trimWhiteSpacesLeftRight(a);
                document.forms["Form1"]["name"].value = a;
                c = trimWhiteSpacesAll(c);
                if (isIntegerNumber(c) == false) {
                    c = document.forms["Form1"]["phoneNumber"].value;
                    c = trimWhiteSpacesLeftRight(c);
                }
                document.forms["Form1"]["phoneNumber"].value = c;

                if (a=="My Name" || a=="") {
                    alert("Please enter at least your name.");
                    document.forms["Form1"]["name"].focus();
                    return false;
                }

                if (isAlphaCharacters(a) == false) {
                    alert("Do not use any special characters in the 'Name' field. Only alphabetic characters please.");
                    document.forms["Form1"]["name"].focus();
                    return false;
                }

                if (c.length<10 || isIntegerNumber(c) == false) {
                    alert("Please enter a phone number of at least 10 numeric digits (no other characters) ie 0210000000 or 082000000");
                    document.forms["Form1"]["phoneNumber"].focus();
                    return false;
                }

                if (c.charAt(0) != 0) {
                    alert("The 'Phone Number' may only start with the numeric digit 0 (e.g. 021 or 074 etc.)");
                    document.forms["Form1"]["phoneNumber"].focus();
                    return false;
                }

                if (d=="SelectProduct" || d=="") {
                    alert("Please select a product from the dropdown list.");
                    document.forms["Form1"]["products"].focus();
                    return false;
                }
            }

            function validateFormSearch() {
                var e = document.forms["Form2"]["province_placeholder"].value;       
                var f = document.forms["Form2"]["city_placeholder"].value;       
                
                if (e=="0" || e=="") {
                    alert("Please select a province from the province dropdown list.");
                    document.forms["Form2"]["province_placeholder"].focus();
                    return false;
                }
                
                if (f=="0" || f=="") {
                    alert("Please select a city from the city dropdown list.");
                    document.forms["Form2"]["city_placeholder"].focus();
                    return false;
                }
            }

            function CalcKeyCode(aChar) {
                var character = aChar.substring(0,1);
                var code = aChar.charCodeAt(0);
                return code;
            }

            function checkNumber(val) {
                var strPass   = val.value;
                var strLength = strPass.length;
                var lchar     = val.value.charAt((strLength) - 1);
                var cCode     = CalcKeyCode(lchar);

                /* Check if the keyed in character is a number
                   do you want alphabetic UPPERCASE only ?
                   or lower case only just check their respective
                   codes and replace the 48 and 57
                */

                if (cCode < 48 || cCode > 57 ) {
                    var myNumber = val.value.substring(0, (strLength) - 1);
                    val.value = myNumber;
                }

                return false;
            }

            function checkFieldOnBlur(val) {
                val.value = trimWhiteSpacesLeftRight(val.value);
                if (val.value == "") {
                    switch(val.name) {
                        case 'name':
                            val.value = "My Name";
                            break;
                        case 'phoneNumber':
                            val.value = "My Number";
                            break;
                        default:
                            val.value = "SelectProduct";
                    }
                }

                return val.value;
            }
            
            function checkFieldOnBlurSearch(val) {
                val.value = trimWhiteSpacesLeftRight(val.value);
                if (val.value == "0") {
                    switch(val.name) {
                        case 'province_placeholder':
                            val.value = "0";
                            break;
                        default:
                            val.value = "0";
                    }
                }

                return val.value;
            }

            function cleanFieldOnFocus(val) {
                val.value = trimWhiteSpacesLeftRight(val.value);
                if (val.value == "My Name" || val.value == "My Number" || val.value == "MyNumber" || val.value == "SelectProduct") {
                    val.value = "";
                }

                return val.value;
            }

            function cleanFieldOnFocusSearch(val) {
                val.value = trimWhiteSpacesLeftRight(val.value);
                if (val.value == "Select a Province" || val.value == "Select a City") {
                    val.value = "0";
                }

                return val.value;
            }

            function isInteger(s) {
                var i;
                for (i = 0; i < s.length; i++){
                    // Check that current character is number.
                    var c = s.charAt(i);
                    if (((c < "0") || (c > "9"))) return false;
                }
                // All characters are numbers.

                return true;
            }

            function isIntegerNumber(x) {
                var numbers = /^[-+]?[0-9]+$/;

                if (x.match(numbers)) {
                    return true;
                }
                else {
                    return false;
                }
            }

            function isAlphaCharacters(x) {
                var characters = /^[a-zA-Z ]+$/;

                if (x.match(characters)) {
                    return true;
                }
                else {
                    return false;
                }
            }

            function stripCharsInBag(s, bag) {
                var i;
                var returnString = "";
                // Search through string's characters one by one.
                // If character is not in bag, append to returnString.
                for (i = 0; i < s.length; i++) {
                    var c = s.charAt(i);
                    if (bag.indexOf(c) == -1) returnString += c;
                }

                return returnString;
            }
            
            function firePixelOnTelNrClick() {
				
    		    // alert("PROD - firePixelOnTelNrClick");
	           	// e.preventDefault();
				
                // Google Code for Navigate Conversion Page
                // var google_conversion_id        = 874349905;
                // var google_conversion_language  = "en";
                // var google_conversion_format    = "3";
                // var google_conversion_color     = "ffffff";
                // var google_conversion_label     = "9ePHCPnN8WkQ0Yr2oAM";
                // var google_remarketing_only     = false;

                var image = new Image(1,1); 
                image.src = "//www.googleadservices.com/pagead/conversion/874349905/?label=9ePHCPnN8WkQ0Yr2oAM&amp;guid=ON&amp;script=0";
           
                // alert ("index - BB");
                // window.open("exe_analytics.html?value=search_TEL");
                // alert ("index - CC");
				
		        console.log("PROD AA *************************** firePixelOnTelNrClick");
				
                // $.get("test_analytics.asp", function(data, status) {
                //    alert("Data: " + data + "\nStatus: " + status);
                // });

                // Victor Geldenhuys from Thrive Online has registered these 2 values on Google Console
                // 1. value=search_TEL
                // 2. value=search_URL

                // Ajax form 
                // $.post('tel_analytics.php?value=search_TEL', $(this).serialize())                
                
                $.post('tel_analytics.php', $(this).serialize())                
                    .done( function ( data ) {
                        var json = $.parseJSON(data);
                        console.log("PROD BB *************************** Ajax POST DATA = " + json);
                        // alert("json: " + json);
                        // console.log("Lead: " + json.lead);
                    })                
                    .fail( function () {
                        console.log("PROD CC *************************** Ajax POST FAILED ...");
                    });				
                
                return true;
            }

            // $("#test_call").on("click", firePixelOnTelNrClick_TEST);
            
            // $("#test_call").on("click", firePixelOnTelNrClick);
            
            // $("#test_call").click(function() {
            //  firePixelOnTelNrClick();
            // });
            
            function onTelNrClick2() {
                console.log("PROD AA *************************** onTelNrClick");
                
                $.ajax({
                    type: 'POST',
                    url: 'tel_analytics.php',
                    //contentType:"application/json; charset=utf-8",
                    cache: false,
                    dataType: 'json',
                    success: function(data) {
                        $('.result').html(data);
                        alert('PROD BB *************************** Ajax GET SUCCESS ...');
                    },
                    error: function(xhr, desc, err) {
                        console.log(xhr + "\n" + err + "\n" + desc);
                    }
                });
            }
            
            function onTelNrClick() {
                console.log("PROD AA *************************** Inside function onTelNrClick");
                window.location.replace("exe_analytics.html?value=search_TEL");                
            }

            function handleOutboundLinkClicks(event) {
                console.log("Outbound Link Clicked.................................");
                ga('send', 'event', {
                    eventCategory: 'Outbound Link',
                    eventAction: 'click',
                    eventLabel: event.target.href,
                    transport: 'beacon'
                });
            }            
            
        </script>
        
    </head>

    <body>

        <script>

            //alert ("index.php - Executing Google Analytics");

            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-83544421-1', 'auto');
            ga('send', 'pageview');

        </script>

        <!--TOP MASTHEAD CONTAINING WORD 'Funeral' LINKING TO FUNERAL CALL ME FORM PG-->
        <div class="home-masthead">
            <div class="container">
                <div class="row">        
                    <nav class="home-main">			
                        <a class="home-icon" href="index.php">&nbsp;</a> <a class="funeral-pgr" href="funeral-cover.php">Funeral</a>
                    </nav>
                </div>
            </div>
        </div>

        <!--2ND MASTHEAD CONTAINING HOLLARD LOGO LINKING BACK TO BRANCHES INDEX PG-->
        <div class="logo-masthead">
            <div class="container">
                <div class="">
                    <ul class="nav-main">
                        <li class="nav-main__logo">
                            <a class="logo" href="index.php">&nbsp;</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!--BACKGROUND IMAGE AND FORM-->    
        <div class="container-fluid"id="TOP-BGIMAGE">
        </div>
        <div class="row" style=" background-color:#dcd1e1; padding:0;">

            <div class="container" style="padding:0;">

                <div class="col-lg-6 col-md-6 branch-header branch-title">
                    <h1>Funeral Cover</h1>
                    <h3 class="branch-subheading">Get funeral cover from R10 000 up to R75 000</h3>
                </div>



                <div class="col-sm-6 col-sm-offset-6 col-md-6 branch-sidebar" style="float:none;">
                    <div class="sidebar-module sidebar-module-inset sidebar">
                        <h2 style=" font-size:20px; color:#333;">Call me back for a quote:</h2>
                        <form action="call_me_back.php" enctype="multipart/form-data" name="Form1" onsubmit="return validateForm()" method="POST">
                            <div class="form-group">
                                <!--<input type="text" class="form-control" id="name" value="Name*" />-->
                                <input type="text" class="form-control" name="name" id="name" value="My Name" onblur="checkFieldOnBlur(Form1.name)" onfocus="cleanFieldOnFocus(Form1.name)" />
                            </div>
                            <div class="form-group">                    
                                <!--<input type="text" class="form-control" id="phoneNumber" value="Contact Number*" />-->
                                <input type="text" class="form-control" name="phoneNumber" id="phoneNumber" value="My Number" onblur="checkFieldOnBlur(Form1.phoneNumber)" onfocus="cleanFieldOnFocus(Form1.phoneNumber)" />
                            </div>
                            
                            <input type="hidden" name="products" id="products" value="Funeral" />
                            
                            <div class="form-group">            
                                <input type="submit" class=" sidebar-btn" id="submit" value="CALL ME BACK"/>
                            </div>
                            <!-- Values for 'origin' can be 'FuneralForm' or 'EmbeddedForm'-->
                            <input type="hidden" name="origin" id="origin" value="FuneralForm" />
                        </form>            
                    </div>

                </div>

            </div> 


        </div>




        <!--FUNERAL CONTENT SECTION-->
        <div class="container">




            <div class="row" style="padding-bottom: 15px;">

                <div class="col-sm-12 col-md-6 col-lg-6 branch-main">

                    <p class="funeral-info" style="margin-top: 30px;">Hollard Funeral Plan will help you prepare for tomorrow, 
                        because tomorrow is not promised to us.
                        Planning a funeral for someone you love is hard enough, without the added stress of worrying about how to pay for it.
                        Give your family the support they need when you're no 
                        longer around with quality funeral insurance from Hollard.
                        This funeral plan will give your loved ones a lump sum to cover funeral costs, as well as the extra support they'll need. 
                    </p> 

                    <h3>Benefits of a Hollard funeral plan include:</h3>

                    <ul>
                        <li class="hld-li-tick">Cover from R10 000 to R75 000 depending on your needs an budget.</li>
                        <li class="hld-li-tick">A pay-out within 24 hours to cover funeral expenses. After we received required documentations for a valid claim.</li>
                        <li class="hld-li-tick">Free use of a rental vehicle with full tank and unlimited mileage for 3 days to help with the funeral arrangement.</li>
                        <li class="hld-li-tick">A portion of your premiums back at claim stage, when either you or your partner pass on.</li>
                        <li class="hld-li-tick">R35 000 towards your children university fees, when either you when either you.</li>
                        <li class="hld-li-tick">An Immediate Accidental Death Benefit so you're covered as soon as we get your first premium.</li>
                        <li class="hld-li-tick">You can cover up to 22 family members on one plan.</li>
                    </ul>


                    <!--END OF Left side-->


                </div>

                <!--RIGHT SIDE-->

                <div class="col-sm-6 branch-sidebar">

                    <h3 style="margin-top: 30px;">Optional Extra Benefits:</h3>

                    <ul>
                        <li class="hld-li-tick" style="font-weight:bold;">Extended Family Funeral Rider<br>
                            <span class="sublist-bullet">&bull; Funeral cover for your partner, children, parents and other blood relatives.</span></li>
                        <li class="hld-li-tick" style="font-weight:bold;">Monthly Provider<br>
                            <span class="sublist-bullet">&bull; Cover of up to R20 000 for your family's monthly expenses for a year after you pass away.</span></li>
                        <li class="hld-li-tick" style="font-weight:bold;">Moneyback Benefit<br>
                            <span class="sublist-bullet">&bull; 20% cash back after every five years of paying all your insurance policy premiums.</span></li>
                        <li class="hld-li-tick" style="font-weight:bold;">Memorial Benefit<br>
                            <span class="sublist-bullet">&bull; Cover the cost (either R5 000 or R10 000) of an unveiling ceremony.</span></li>
                        <li class="hld-li-tick" style="font-weight:bold;">Life Cover Benefit<br>
                            <span class="sublist-bullet">&bull; Up to R120 000 lump sum when you or your insured partner passes away.</span></li>
                        <li class="hld-li-tick" style="font-weight:bold;">Personal Accident Benefit<br>
                            <span class="sublist-bullet">&bull; Up to R100 000 cover if you become disabled or die accidentally.</span></li>
                    </ul>
                </div>

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
</body>
</html>
