<?php

header('Content-Type: application/json'); // GERT MYBURGH added this line

$base_url = $_SERVER['HTTP_HOST'];
$url = 'http://'.$base_url.'/exe_analytics.html?value=search_URL'; // GERT MYBURGH removed /Hollard_BranchLocator part

// Victor Geldenhuys from Thrive Online has registered these 2 values on Google Console
// 1. value=search_TEL
// 2. value=search_URL
        
// echo $url;
// echo json_encode($url);

// $testpage = file_get_contents($url);
// echo $testpage;

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_USERAGENT, 'Opera/9.23 (Windows NT 5.1; U; en)' );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

// Below two option will enable the HTTPS option . // GERT MYBURGH replaced ## with //
// curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, TRUE ); // GERT MYBURGH replaced # with //
// curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 ); // GERT MYBURGH replaced # with //
$testpage = curl_exec( $ch );
curl_close($ch);

echo json_encode($testpage);

?>
