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
    $company_id = $_GET['company_id'];

    $customer_query = "SELECT company_name, company_address, company_phone, company_pic_name, company_pic_contact FROM customer WHERE company_id = '$company_id'";
    $customer_result = mysqli_query($connect, $customer_query);

    $customer_array = array();
    while($customer_row = mysqli_fetch_array($customer_result)){
        array_push(
            $customer_array,
            array(
                'company_name' => $customer_row['company_name'],
                'company_address' => $customer_row['company_address'],
                'company_phone' => $customer_row['company_phone'],
                'company_pic_name' => $customer_row['company_pic_name'],
                'company_pic_contact' => $customer_row['company_pic_contact']
            )
        );
    }

    if($customer_array){
        echo json_encode(
            array(
                'StatusCode' => 200,
                'Status' => 'Success',
                'Data' => $customer_array
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