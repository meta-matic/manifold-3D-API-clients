<?php
// 1. Make POST request
// ----------------------------------------------------------------------------
$target_url = "http://manifold.metamatic.us/v1/compute/";
$api_key = "dummy-api-key";

$file_name_with_full_path = realpath("/tmp/40mmcube.stl");
echo "File: " . $file_name_with_full_path;
echo "\n";

$post = array("api_key" => $api_key,"datafile"=>new CURLFile($file_name_with_full_path));
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$target_url);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
$result=curl_exec ($ch);
curl_close ($ch);

// Decode JSON response
$json = json_decode($result, true);
$task_id = $json["task_id"];
if (is_null($task_id)){
	echo "ERROR: no task_id was returned!\n";
	return;
}
echo "Task ID: " . $task_id;
echo "\n";


// 2. Poll for a valid response
// ----------------------------------------------------------------------------
$data = "";
while ($data == ""){
	//Make GET request
	$ch = curl_init($target_url . "?task_id=" . $task_id);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$data = curl_exec($ch);
	curl_close($ch);
	// Wait
	sleep(2);
	echo(".");
}
echo "\n";


// 3. Render JSON response
// ----------------------------------------------------------------------------
$json = json_decode($data, true);
echo "Result: ";
echo "\n";
echo json_encode($json, JSON_PRETTY_PRINT);
echo "\n";

// JSON parsing example - output the volume
echo "\n";
echo "Volume: " . $json["volume"]["value"] . " " . $json["volume"]["UOM"];
echo "\n";

?>