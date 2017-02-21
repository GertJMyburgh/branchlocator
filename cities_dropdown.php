<?php

    header('Content-type: application/json');
    
    // Include Branch_api class
    require_once("branch_api.php");

    // Get a handle/reference to the Branch API
    $branch_api = new Branch_api();
    
    // Get a list of cities belonging to the selected province
    $myProvince = $_GET["sid"];
    $cities = $branch_api->getCities($myProvince);

    // Display the list of cities
    foreach ($cities as $key => $value) {
        $data[] = array (
            //'id'   => preg_replace("/\P{L}+/u", '', $value['city']),
            'id'   => $value['city'],
            'sid'  => $value['province'],
            'name' => $value['city']
        );
    }

    echo json_encode($data);
    
?>
