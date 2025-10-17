<?php
require_once __DIR__ . '../../database/database.php';


class Migration {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function createUsersTable(): void {
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
            echo "Tabela 'users' criada com sucesso!<br>";

        } catch (PDOException $e) {

            echo "Erro ao criar tabela: " . $e->getMessage();

        }
    }
}
