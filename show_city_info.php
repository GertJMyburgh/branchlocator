<?php

    // Include Branch_api class
    require_once("branch_api.php");

    // Get a handle/reference to the Branch API
    $branch_api = new Branch_api();
    
    // Get the branch, manager, address and google mapurl of the selected city belonging to the selected province
    $myProvince     = $_POST['province_placeholder'];
    $myCity         = $_POST['city_placeholder'];
    $displayBranch  = "";
    $displayManager = "";
    $displayAddress = "";
    $displayMapURL  = "";
            
    $info = $branch_api->getCityInfo($myProvince, $myCity);

    // Display the info
    echo "<br />";
    echo "<b>INFO BELONGING TO " . strtoupper($myProvince) . " - " . strtoupper($myCity) . "</b><br />";
    foreach ($info as $key => $value) {
        echo "BRANCH  = " . $value['branch'] . "<br />";
        $displayBranch = $value['branch'];
        echo "MANAGER = " . $value['manager'] . "<br />";
        $displayManager = $value['manager'];
        echo "ADDRESS = " . $value['address'] . "<br />";
        $displayAddress = $value['address'];
        echo "MAPURL  = " . $value['mapurl'] . "<br />";
        $displayMapURL = $value['mapurl'];
    }
    
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Hollard Branch Locator - Search Results</title>
    </head>

    <body>
        <div>
            <h1>Hollard Branch Locator</h1>
            <h3>Find your nearest Hollard branch:</h3>
        </div>

        <div>
            <form action="newIndex.php" method="">
                <div>
                    <input type="submit" id="submit" value="REDEFINE SEARCH"/>                       
                </div>
            </form>  

            <div>
                <h3>Branch Locator Results:</h3>
                <div>
                    <h4><?php print $displayBranch;?></h4>
                    <dl>
                        <dt>Address:</dt>
                        <dd><?php print $displayAddress;?></dd>
                        <dt>Branch Manager: </dt>
                        <dd><?php print $displayManager;?></dd>                
                    </dl>
                    <p><a href="<?php print $displayMapURL;?>">open with google maps</a></p>
                </div>
            </div>
        </div>
    </body>
</html>
