<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../../config/database.php';
include_once '../../models/user.php';
$database = new Database();
$db = $database->getConnection();
$item = new User($db);
$data = json_decode(file_get_contents("php://input"));
$item->full_name = $data->full_name;
$item->email = $data->email;
$item->password = $data->password;
$item->role = $data->role;
$item->created = date('Y-m-d H:i:s');
if($item->createUser()){
    echo 'User created successfully.';
} else{
    echo 'User could not be created.';
}
?>