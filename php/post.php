<?php

$target_url = 'http://manifold.metamatic.us/v1/compute/';

$api_key = 'dummy-api-key';

$file_name_with_full_path = realpath('../models/40mmcube.stl');

$post = array('api_key' => $api_key,'datafile'=>'@'.$file_name_with_full_path);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$target_url);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$result=curl_exec ($ch);
curl_close ($ch);

echo $result;
echo "\n";

?>
