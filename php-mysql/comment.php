<?php
    class Comment{
        private $conn;
        private $dbTable="comment";

        public $id;
        public $name;
        public $comment;

        public function __construct($db){
            $this->conn=$db;
        }

        public function getComments(){
            $sqlQuery = "SELECT id, name, comment, created_at
               FROM $this->dbTable";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        public function createComment(){
            $sqlQuery = "INSERT INTO
                    $this->dbTable
                    (`name`, `comment`)
                    VALUES
                    ('$this->name','$this->comment' )";
        
            $stmt = $this->conn->prepare($sqlQuery);         
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        public function deleteComment(){
            $sqlQuery = "DELETE FROM $this->dbTable WHERE id = $this->id";
            $stmt = $this->conn->prepare($sqlQuery);         
            if($stmt->execute()){
               return true;
            }
            return false;
        }
    }
?>