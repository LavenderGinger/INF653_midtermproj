<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  $method = $_SERVER ['REQUEST_METHOD'];

  if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
  }

  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';

  $database = new Database();
  $db = $database->connect();
  $quote = new Quote($db);

  $id = isset($_GET['id']) ? $_GET['id'] : null;
  $author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
  $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
  
  $result = $quote->read();
  $num = $result->rowCount();
  
  if($num>0){
      $quotes_arr = array();
      $quotes_arr['data']=array();

      while($row=$result->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          $id = $row['id'];
        $quote = $row['quote'];
        $author = $row['author'] ?? null;
        $category = $row['category'] ?? null;

          $quote_item = array(
              'id'=>$id,
              'quote'=>$quote,
              'author'=>$author,
              'category'=>$category
          );
          array_push($quotes_arr['data'], $quote_item);
      }
      echo json_encode($quotes_arr);
  }
  else {
      echo json_encode(array('message' => 'No Quotes Found'));
  }