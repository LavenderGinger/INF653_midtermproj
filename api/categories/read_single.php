<?php
include_once '../../config/Database.php';
include_once '../../models/Category.php';

  $database = new Database();
  $db = $database->connect();
  $category = new Category($db);

  $category->id = isset($_GET['id']) ? $_GET['id'] : die();

  $author->read_single();
  
  $author_arr = array (
      'id' => $category->id,
      'author' => $category->category
  );
  
  print_r(json_encode($category_arr));