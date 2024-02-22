<?php
//Header access is required
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

//Display error message
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//Connection access
require_once('../connection/connection.php');

//Checking call API method
if($_SERVER['REQUEST_METHOD'] === 'GET'){

    $lastPO_query = "SELECT PONumber FROM purchaseOrder ORDER BY PONumber DESC LIMIT 1;";
    $lastPO_result = mysqli_query($connect, $lastPO_query);

    $lastPO_array = array();
    while($lastPO_row = mysqli_fetch_array($lastPO_result)){
        array_push(
            $lastPO_array,
            array(
                'PONumber' => $lastPO_row['PONumber']
            )
        );
    }

    if($lastPO_array){
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $lastPO_array
            )
        );
    } else {
        http_response_code(400);
        echo json_encode(
            array(
                'StatusCode' => 400,
                'Status' => 'Error Bad Request, Result not found !'
            )
        );
    }

} else {
    http_response_code(404);
    echo json_encode(
        array(
            "StatusCode" => 404,
            'Status' => 'Error',
            "message" => "Error: Invalid method. Only POST requests are allowed."
        )
    );
}

?>