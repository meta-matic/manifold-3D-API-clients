<?php
$target_url = 'http://manifold.metamatic.us/v1/compute/';
$api_key = 'dummy-api-key';

$file_name_with_full_path = realpath('/tmp/40mmcube.stl');
echo $file_name_with_full_path;
echo "\n";

$post = array('api_key' => $api_key,'datafile'=>new CURLFile($file_name_with_full_path));
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$target_url);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
$result=curl_exec ($ch);
curl_close ($ch);

echo $result;
echo "\n";

?>
