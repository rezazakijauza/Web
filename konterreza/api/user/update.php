<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");
include_once '../../config/database.php';
include_once '../../models/user.php';
$database = new Database();
$db = $database->getConnection();
$item = new user($db);
$data = json_decode(file_get_contents("php://input"));
$item->id = $data->id;
// user values
$item->full_name = $data->full_name;
$item->email = $data->email;
$item->password = $data->password;
$item->role = $data->role;
$item->created = date('Y-m-d H:i:s');
if($item->updateuser()){
    echo json_encode("user data updated.");
} else{
    echo json_encode("Data could not be updated");
}
?>
