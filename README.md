# manifold-3D-API-clients
Clients for the Manifold 3D API web service.

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

  api_key=<your-api-key>  
  base_url=http://manifold.metamatic.us/v1/compute/  

  curl -X POST \  
    -F "api_key=$api_key" \  
    -F "datafile=@$1" --url $base_url  
  echo  
