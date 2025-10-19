<?php
require_once '../database/database.php';
require_once '../response/response.php';

class taskRepository {

    private $pdo;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    public function taskSave($titulo, $descricao, $grupo, $dateLimit, $userCreatorId){

        try{

            $stmt = $this->pdo->prepare("
                INSERT INTO task (idPublic, user_creator_id, title, description, timeout) 
                VALUES (UUID(), :user_creator_id, :title, :description, :timeout)
            ");

            $stmt->execute([
                ':user_creator_id' => $userCreatorId,
                ':title' => $titulo,
                ':description' => $descricao,
                ':timeout' => $dateLimit
            ]);

            return true;

        } catch (PDOException $e){
            
            return false;
            
        }
    }

}
