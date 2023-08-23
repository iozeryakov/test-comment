<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
    header("Content-Type: application/json;");
    
    include_once 'database.php';
    include_once 'comment.php';

    $database = new DB();
    $db = $database->getConnection();

    $comments = new Comment($db);

    $stmt = $comments->getComments();
    $itemCount = $stmt->rowCount();

    if($itemCount > 0){
        $commentArr = array();
        while ($row = $stmt->fetch()){
            extract($row);
            $e = array(
                "id" => $id,
                "name" => $name,
                "comment" => $comment,
                "created_at" => $created_at
            );
            array_push($commentArr, $e);
        }
        echo json_encode($commentArr);
    }
?>