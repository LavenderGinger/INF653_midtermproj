<?php
include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || empty($data->id)) {
    die(json_encode(["id" => "ID is required"]));
}

$category->id = $data->id;

if($category->delete()){
    echo json_encode(array('id' => 'Category Deleted')
    );
} else {
    echo json_encode(array('message' => 'Category Not Deleted')
    );
}