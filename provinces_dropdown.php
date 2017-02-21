<?php

    header('Content-type: application/json');
    
    // Include Branch_api class
    require_once("branch_api.php");

    // Get a handle/reference to the Branch API
    $branch_api = new Branch_api();
    
    // Get a list of provinces
    $provinces = $branch_api->getProvinces();
    
    // Display the list of provinces
    foreach ($provinces as $key => $value) {
        $data[] = array (
            //'id'   => preg_replace("/\P{L}+/u", '', $value['province']),
            'id'   => $value['province'],
            'name' => $value['province']
        );
    }

    echo json_encode($data);
    
?>
