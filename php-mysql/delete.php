<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json;");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once 'database.php';
    include_once 'comment.php';

    $database = new DB();
    $db = $database->getConnection();

    $item = new Comment($db);
    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
      
    if($item->deleteComment()){
        echo json_encode("Comment deleted.");
    } else{
        echo json_encode("Not deleted.");
    }
?>