<?php
session_start();
require_once '../services/taskService.php';
require_once '../response/response.php';

if ($_SERVER["REQUEST_METHOD"] === "PATCH") {
    $taskService = new TaskService();

    $data = json_decode(file_get_contents("php://input"), true);
    
    $titulo = trim($data["titulo"]) ?? null;
    $descricao = trim($data["descricao"]) ?? null;
    $situation = trim($data["situation"]) ?? null;
    $grupo = trim($data["grupo"]) ?? null;
    $dateLimit = trim($data["dateLimit"]) ?? null;
    $idTask = trim($data["idTask"]) ?? null;
    $idPublicUser = $_SESSION['user']['idPublic'] ?? null;

    error_log("Erro ao editar: " . json_encode([
    'titulo' => $titulo,
    'descricao' => $descricao,
    'situation' => $situation,
    'grupo' => $grupo,
    'idTask' => $idTask
]));
    
    $taskService->edit($titulo, $descricao, $situation, $grupo, $dateLimit, $idTask, $idPublicUser);

} else {

$response = new Response();

$response->error(405, "Método não permitido. Use PATCH.");

}

?>
