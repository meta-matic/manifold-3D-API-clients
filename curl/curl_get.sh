#!/bin/bash

task_id=dummy-task-id
base_url=http://manifold.metamatic.us/v1/compute/

curl -X GET --url "$base_url?task_id=$task_id"
echo

