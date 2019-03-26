<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/category.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$category = new Category($db);


$category->id = $_POST['id'];
$category->name = $_POST['name'];
$category->description = $_POST['description'];

// update the product
if(
	!empty($_POST['id']) &&
	!empty($_POST['name']) &&
	!empty($_POST['description']) 
){

	if($category->update()){


    // set response code - 200 ok
		http_response_code(200);

    // tell the user
		echo json_encode(array("message" => "Category was updated."));
	}

// if unable to update the Category, tell the user
	else {

    // set response code - 503 service unavailable
		http_response_code(503);

    // tell the user
		echo json_encode(array("message" => "Unable to update Category."));
	}
//missing field
} else {
	http_response_code(501);

    // tell the user
	echo json_encode(array("message" => "Unable to update Category. missing field."));
}

?>