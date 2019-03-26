<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate category object
include_once '../objects/category.php';
 
$database = new Database();
$db = $database->getConnection();
 
$category = new Category($db);
 

// make sure data is not empty
if(
    !empty($_POST['name']) &&
    !empty($_POST['description'])
){
 

    // set user property values
    $category->name = $_POST['name'];
    $category->description = $_POST['description'];
    $category->created = date('Y-m-d H:i:s');
 
    // create the category
    if($category->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        //echo json_encode(array("message" => "category was created."));
        $user_arr=array(
        "status" => true,
        "message" => "Category was created."
    );
    }
 
    // if unable to create the category, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        $user_arr=array(
        "status" => false,
        "message" => "Unable to create Category."
    );
        //echo json_encode(array("message" => "Unable to create category."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    $user_arr=array(
        "status" => true,
        "message" => "Unable to create Category. Data is incomplete."
    );
   // echo json_encode(array("message" => "Unable to create category. Data is incomplete."));
}
echo json_encode($user_arr, JSON_PRETTY_PRINT);
?>