<?php

//include headers
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset: UTF-8");
header("Access-Control-Allow-Methods: POST");

//include database.php
include_once("../config/database.php");

//include student.php
include_once("../classes/student.php");

//create object for database
$db = new Database();

$connection = $db->connect();

//create object for student
$student = new Student($connection);

if($_SERVER['REQUEST_METHOD'] === "POST") {

  $data = json_decode(file_get_contents("php://input"));

  if (!empty($data->name) && !empty($data->email) && !empty($data->mobile)) {
    
  //submit data
  $student->name = $data->name;
  $student->email = $data->email;
  $student->mobile = $data->mobile;

  if ($student->create_data()) {

    http_response_code(200);  //200 means ok
    echo json_encode(array(
      "status" => 1,
      "message" => "Student has been created"
    ));
  } else {
    http_response_code(500);  //500 means internal server error
    echo json_encode(array(
      "status" => 0,
      "message" => "Failed to create student"
    ));
  }

} else {
  http_response_code(503);  //503 means service unavailable
  echo json_encode(array(
    "status" => 0,
    "message" => "Access Denied"
  ));
}
  }

?>