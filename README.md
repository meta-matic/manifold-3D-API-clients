### NEW! Includes a free WordPress Plugin client implmentation!

# manifold-3D-API-clients
Clients for the Manifold 3D API web-service. Calculates the following values for a 3D model:
* Volume
* Bounding box
* Surface area
* Facet count
* Build time estimate  
Manifold web-service also renders 3D models to images.  


#### Example implementations for these languages:  
* JS / HTML
* PHP
* Python
* cURL


#### Intended usage:  
1. Obtain an api_key  
2. Submit yout 3D model via HTTP POST  
3. A task_id is returned  
4. Submit the task_id via HTTP GET  
5. Calculation results are returned as a JSON object  

#### Example using cURL:  

1. POST the computation job:  

  data_file=your-model-file-path  
  api_key=your-api-key  
  base_url=http://manifold.metamatic.us/v1/compute/  

  curl -X POST \  
    -F "api_key=$api_key" \  
    -F "datafile=@$data_file" --url $base_url  
  echo  

2. GET the computation results:  

  task_id=your-task-id  
  base_url=http://manifold.metamatic.us/v1/compute/  
  
  curl -X GET --url "$base_url?task_id=$task_id"  

3. Example response:
  ```{
    "facet_count": {
      "UOM": "#",
      "value": 796
    },
    "bbox": {
      "UOM": "mm",
      "value": {
        "height": 9.0,
        "length": 82.85900115966797,
        "width": 62.0
      }
    },
    "image": {
      "value": "/media/manifold/render/d265d6f9-5e02-4ae5-853b-46e8ab20ebc8.png"
    },
    "error": null,
    "time": {
      "UOM": "s",
      "value": {
        "min": 168.7331635010258,
        "max": 506.1994905030774
      }
    },
    "area": {
      "UOM": "mm2",
      "value": 4679.713492961474
    },
    "volume": {
      "UOM": "mm3",
      "value": 4049.5959240246193
    }
  }```
