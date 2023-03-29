<?php
$data = array('object'=>@$_GET['object']);
//$result = CallAPI('PUT', $data);

$data = array('object'=>'user', 'id'=>21, 'name'=>'FIO', 'login'=>'loogin', 'pass'=>'parolka');
//$result = CallAPI('POST', $data);

$data = array('object'=>'user');
//$data = array('object'=>'user', 'id'=>21);
//$result = CallAPI('GET', $data);

$data = array('object'=>'user');
//$result = CallAPI('DELETE', $data);


$decoded = json_decode($result);
var_dump($decoded);
//echo $result;
//echo $decoded->message;




function CallAPI($method, $data)
{
    $url = 'http://nodu.esrr.mps/api/api.php';
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    //print_r( json_encode($data) ) ;
    
    switch ($method)
    {
        case "GET":
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            break;
        case "POST":
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE"); 
            break;
    }
    $response = curl_exec($curl);
    $data = $response;

    /* Check for 404 (file not found). */
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    // Check the HTTP Status code
    switch ($httpCode)
    {
        case 200:
            $error_status = "200: Success";
            return ($data);
            break;
        case 400:
            $error_status = "400: Bad Request";
            break;
        case 404:
            $error_status = "404: Not found";
            break;
        case 409:
            $error_status = "409: The request could not be completed";
            break;
        case 500:
            $error_status = "500: servers replied with an error.";
            break;
        case 502:
            $error_status = "502: servers may be down or being upgraded. Try some time later.";
            break;
        case 503:
            $error_status = "503: service unavailable. Try some time later.";
            break;
        default:
            $error_status = "Undocumented error: " . $httpCode . " : " . curl_error($curl);
            break;
    }
    curl_close($curl);
    echo $error_status;
    die;
}

