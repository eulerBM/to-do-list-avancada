<?php
require_once '../database/database.php';
require_once '../response/response.php';

class userRepository {

    private $pdo;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    public function userSave($name, $email, $password){

        try{

            $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

            $stmt = $this->pdo->prepare("
                INSERT INTO users (idPublic, name, email, password) 
                VALUES (UUID(), :name, :email, :password)
            ");

            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword
            ]);

            return true;

        } catch (PDOException $e){

            if($e->getCode() === '23000'){

                throw new Exception("E-mail já cadastrado.");

            }
            
            return false;
            
        }
    }

    public function findByUser($email){

        $stmt = $this->pdo->prepare("
                SELECT id, idPublic, name, email, password, created_at FROM users WHERE email = :email LIMIT 1
            ");

            $stmt->execute([
                ':email' => $email,
            ]);

            return $stmt->fetch(PDO::FETCH_ASSOC);

    }
}
