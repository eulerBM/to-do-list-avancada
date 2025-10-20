<?php
require_once __DIR__ . '../../database/database.php';


class Migration
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createUsersTable(): void
    {

        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            idPublic VARCHAR(36) NOT NULL UNIQUE,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(150) UNIQUE NOT NULL,
            password VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        try {

            $this->pdo->exec($sql);

            echo "<script>console.log('Tabela \"users\" criada com sucesso!');</script>";
        } catch (PDOException $e) {

            echo "Erro ao criar tabela: " . $e->getMessage();
        }
    }

    public function createTaskTable(): void
    {

        $sql = "CREATE TABLE IF NOT EXISTS task (
            id INT AUTO_INCREMENT PRIMARY KEY,
            idPublic VARCHAR(36) NOT NULL UNIQUE,
            user_creator_id VARCHAR(36) NOT NULL,
            title VARCHAR(200) NOT NULL,
            description TEXT NOT NULL,
            situation TINYINT(1) DEFAULT 0,
            timeout TIMESTAMP NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_creator_id) REFERENCES users(idPublic) ON DELETE CASCADE,
            INDEX idx_user_creator_id(user_creator_id)
        )";

        try {

            $this->pdo->exec($sql);

            echo "<script>console.log('Tabela \"task\" criada com sucesso!');</script>";

        } catch (PDOException $e) {

            echo "Erro ao criar tabela task: " . $e->getMessage();
        }
    }

    public function createTaskUsersTable(): void
    {

        $sql = "CREATE TABLE IF NOT EXISTS task_users (
            task_id INT NOT NULL,
            user_id INT NOT NULL,
            PRIMARY KEY (task_id, user_id),
            FOREIGN KEY (task_id) REFERENCES task(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )";

        try {

            $this->pdo->exec($sql);

            echo "<script>console.log('Tabela \"task_users\" criada com sucesso!');</script>";
        } catch (PDOException $e) {

            echo "Erro ao criar tabela task_users: " . $e->getMessage();
        }

    }
}
