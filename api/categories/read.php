<?php
include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();
$category = new Category($db);

if (isset($_GET['id'])) {
    $category->id = $_GET['id'];
    $category->read_single($category->id);

    if ($category->name !== null) {
        echo json_encode([
            'id' => $category->id,
            'category' => $category->name,
        ]);
    }
    else {
        echo json_encode(['message' => 'Category Not Found']);
    }
} else {
    $result = $category->read();
    if ($result->rowCount() > 0) {
        $categories_arr = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            array_push($categories_arr, [
                'id' => $id,
                'category' => $name,
            ]);
        }
        echo json_encode($categories_arr);
    }
    else {
        echo json_encode([]);
    }
}