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
require_once('../../connection/connection.php');

//Checking call API method
if($_SERVER['REQUEST_METHOD'] === 'GET'){

    $user_query = "SELECT A1.refferal_id, A1.company, A1.limit_user, A2.first_name, A2.last_name, A2.username, A3.permission_access, A4.company_name FROM refferal A1 JOIN user A2 ON A1.refferal_id = A2.unique_id JOIN permission A3 ON A2.permission_id = A3.permission_id JOIN company A4 ON A1.company = A4.company_id WHERE A1.refferal_id = 'FGr9km';";
    $user_result = mysqli_query($connect, $user_query);

    $user_array = array();
    while($user_row = mysqli_fetch_array($user_result)){
        array_push(
            $user_array,
            array(
                'refferal_id' => $user_row['refferal_id'],
                'company' => $user_row['company'],
                'limit_user' => $user_row['limit_user'],
                'first_name' => $user_row['first_name'],
                'last_name' => $user_row['last_name'],
                'username' => $user_row['username'],
                'company_name' => $user_row['company_name'],
                'permission_access'=> $user_row['permission_access']
            )
        );
    }

    if($user_array){
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $user_array
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
            "message" => "Error: Invalid method. Only GET requests are allowed."
        )
    );
}

?>