<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json;");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once 'database.php';
    include_once 'comment.php';

    $database = new DB();
    $db = $database->getConnection();

    $item = new Comment($db);
    $data = json_decode(file_get_contents("php://input"));
    $item->name=$data->name;
    $item->comment= $data->comment;
      
    if($item->createComment()){
        echo json_encode("Comment created.");
    } else{
        echo json_encode("Not create.");
    }
?>