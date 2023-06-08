<?php
if (isset($_SESSION['logged'])){
    header("Location: ../index.php");
    die;
}

class RegisterRepository {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function register($username, $hash_password, $email) {
        $query = "INSERT INTO user (user_name, password, email) VALUES (:username, :hash_password, :email)";

        $statement = $this->db->getConnection()->prepare($query);
        $statement->bindParam(':username', $username);
        $statement->bindParam(':hash_password', $hash_password);
        $statement->bindParam(':email', $email);
        $statement->execute();
        
        return true;
    }
}