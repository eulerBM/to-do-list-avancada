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

        $this->pdo->exec($sql);
    }

    public function createTaskTable(): void
    {

        $sql = "CREATE TABLE IF NOT EXISTS task (
            id INT AUTO_INCREMENT PRIMARY KEY,
            idPublic VARCHAR(36) NOT NULL UNIQUE,
            user_creator_id VARCHAR(36)NOT NULL,
            title VARCHAR(200) NOT NULL,
            description TEXT NOT NULL,
            situation TINYINT(1) DEFAULT 0,
            timeout TIMESTAMP NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_creator_id) REFERENCES users(idPublic) ON DELETE CASCADE
        )";

        $this->pdo->exec($sql);
    }
}
