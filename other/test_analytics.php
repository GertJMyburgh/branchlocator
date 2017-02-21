<?php

$base_url = $_SERVER['HTTP_HOST'];
$url = 'http://'.$base_url.'/Hollard_BranchLocator/exe_analytics.html';

//echo $url;
//echo  json_encode($url);

//$testpage = file_get_contents($url);
//echo $testpage;


$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_USERAGENT, 'Opera/9.23 (Windows NT 5.1; U; en)' );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

##Below two option will enable the HTTPS option .
#curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, TRUE );
#curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
$testpage = curl_exec( $ch );
curl_close($ch);


echo json_encode($testpage);

?>