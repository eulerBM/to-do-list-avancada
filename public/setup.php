<?php
require_once './database/database.php';
require_once './migration/migration.php';


class Setup {
    public function init() {
        $pdo = Database::getConnection();
        $migration = new Migration($pdo);
        $migration->createUsersTable();
        $migration->createTaskTable();
        $migration->createTaskUsersTable();
        
    }
}
