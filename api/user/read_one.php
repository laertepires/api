<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$user = new User($db);
 
// set ID property of user to be edited
$user->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of user to be edited
$user->readOne();
 
// create array
$user_arr = array(
	"id" =>  $user->id,
    "first_name" =>  $user->first_name,
    "last_name" => $user->last_name,
    "email" => $user->email,
    "cpf" => $user->cpf,
    "phone" => $user->phone,
    "date_of_birth" => $user->date_of_birth,
    "status" => $user->status
 
);
 
// make it json format
print_r(json_encode($user_arr));
?>