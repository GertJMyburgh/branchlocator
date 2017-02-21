<?php

    // uncomment to echo json back to calling script
    // header('Content-type: application/json');

    // Include Branch_api class
    require_once("branch_api.php");

    // Get a handle/reference to the Branch API
    $branch_api = new Branch_api();
    







    // Get a list of provinces
    $provinces = $branch_api->getProvinces();
    // Display the list of provinces
    echo "<br />";
    echo "<b>PROVINCES</b><br />";
    foreach ($provinces as $key => $value) {
        echo "ID    = " . preg_replace("/\P{L}+/u", '', $value['province']) . "<br />";
        echo "VALUE = " . $value['province'] . "<br />";
        $data[] = array (
            'id'   => preg_replace("/\P{L}+/u", '', $value['province']),
            'name' => $value['province']
        );
    }
    // uncomment to echo json back to calling script
    // echo json_encode($data);
    






    // Get a list of cities belonging to the selected province
    $myProvince = $provinces[8]['province'];
    $cities = $branch_api->getCities($myProvince);
    // Display the list of cities
    echo "<br />";
    echo "<b>CITIES BELONGING TO " . strtoupper($myProvince) . "</b><br />";
    foreach ($cities as $key => $value) {
        echo "ID    = " . preg_replace("/\P{L}+/u", '', $value['city']) . "<br />";
        echo "VALUE = " . $value['city'] . "<br />";
        $data[] = array (
            'id'   => preg_replace("/\P{L}+/u", '', $value['city']),
            'name' => $value['city']
        );
    }
    // uncomment to echo json back to calling script
    // echo json_encode($data);
        






    // Get the branch, manager, address and google mapurl of the selected city belonging to the selected province
    $myCity = $cities[2]['city'];
    $info = $branch_api->getCityInfo($myProvince, $myCity);
    // Display the info
    echo "<br />";
    echo "<b>INFO BELONGING TO " . strtoupper($myProvince) . " - " . strtoupper($myCity) . "</b><br />";
    foreach ($info as $key => $value) {
        echo "BRANCH  = " . $value['branch'] . "<br />";
        echo "MANAGER = " . $value['manager'] . "<br />";
        echo "ADDRESS = " . $value['address'] . "<br />";
        echo "MAPURL  = " . $value['mapurl'] . "<br />";
    }
    
?>
