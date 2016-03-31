#!/bin/bash

api_key=dummy-api-key
base_url=http://manifold.metamatic.us/v1/compute/

curl -X POST \
 -F "api_key=$api_key" \
 -F "datafile=@$1" --url $base_url
echo

