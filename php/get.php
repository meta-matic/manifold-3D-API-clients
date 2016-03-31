<?php

$target_url = 'http://manifold.metamatic.us/v1/compute/';

$task_id = 'dummy-task-id';

$ch = curl_init($target_url . '?task_id=' . $task_id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
curl_close($ch);

echo $data;

?>
