<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}
include_once '../../config/Database.php';
include_once '../../models/Category.php';

  $database = new Database();
  $db = $database->connect();
  $category = new Category($db);

  $result = $category->read();
  $num = $result->rowCount();
  
  if($num>0){
      $categories_arr = array();
      $categories_arr['data']=array();
  
      while($row=$result->fetch(PDO::FETCH_ASSOC)){
          print_r($row);
          extract($row);
          $author_item = array(
              'id'=>$id,
              'category'=>$category
          );
          array_push($categories_arr['data'], $category_item);
      }
      echo json_encode($categories_arr);
  } 
  else {
      echo json_encode(array('message' => 'No Categories Found')
      );
  }