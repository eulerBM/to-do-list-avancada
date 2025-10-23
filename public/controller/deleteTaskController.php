<?php
session_start();
require_once '../services/taskService.php';
require_once '../response/response.php';

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $taskService = new TaskService();

    $data = json_decode(file_get_contents("php://input"), true);
    
    $idTask = trim($data["idTask"]) ?? null;
    $userIdPublic = $_SESSION['user']['idPublic'] ?? null;

    $taskService->delete($idTask, $userIdPublic);

} else {

$response = new Response();

$response->error(405, "Método não permitido. Use DELETE.");

}

?>
