<?php
    include("dbinfo.php");
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Hollard Branch Locator</title>
        <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALKLHmQpaY_wNrRsbZEPMHiDmGN5IlNnQ" type="text/javascript"></script> -->
        
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
            //]]>
        </script>
        
    </head>

    <body>
        <form action="show_city_info.php" method="POST">
            <span>Provinces</span>
            <select name="province_placeholder" id="province_placeholder"></select>
            <span>Cities</span>
            <select name="city_placeholder" id="city_placeholder"></select>
            <input type="submit" id="submit" value="GET INFO"/>                       
        </form>
    </body>

</html>
