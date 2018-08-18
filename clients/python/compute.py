#!/bin/env python

import requests
import pprint


base_url = 'http://manifold.metamatic.us/v1/compute/'
api_key = 'dummy-api-key'
data_file = '../models/40mmcube.stl'


def post():
	files = {'datafile': open(data_file, 'rb')}
	data = {'api_key': api_key}
	r = requests.post(url=base_url, data=data, files=files)
	task_id = r.json()['task_id']
	print("Created Job with task_id: %s" % task_id)
	return task_id


def get(task_id):
	params = {'task_id': task_id}
	r = requests.get(url=base_url, params=params)
	print(r.url)
	print("Waiting for computation to finish ...")
	while True:
		if len(r.content) > 0:
			print(r.content)
			break
		print("Waiting ...")
		print(r.url)
		r = requests.get(url=base_url, params=params)
	return r.json()


if __name__=='__main__':
	import sys
	api_key = sys.argv[1]
	data_file = sys.argv[2]
	task_id = post()
	results = get(task_id)
	pprint.pprint(results)

