<?php
session_start();
require_once '../services/taskService.php';
require_once '../response/response.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $taskService = new TaskService();

    $data = json_decode(file_get_contents("php://input"), true);
    
    $titulo = trim($data["titulo"]) ?? null;
    $descricao = trim($data["descricao"]) ?? null;
    $dateLimit = trim($data["dateLimit"]) ?? null;
    $userCreatorId = $_SESSION['user']['idPublic'] ?? null;

    $taskService->create($titulo, $descricao, $dateLimit, $userCreatorId);

} else {

$response = new Response();

$response->error(405, "Método não permitido. Use POST.");

}

?>
