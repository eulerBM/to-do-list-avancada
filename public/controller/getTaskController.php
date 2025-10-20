<?php
session_start();
require_once '../services/taskService.php';
require_once '../response/response.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $taskService = new TaskService();

    $userCreatorId = $_SESSION['user']['idPublic'] ?? null;
    
    $taskService->getTasks($userCreatorId);

} else {

$response = new Response();

$response->error(405, "Método não permitido. Use POST.");

}

?>
