<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../services/taskService.php';
require_once '../response/response.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $taskService = new TaskService();

    $page = $_GET['page'] ?? 1;
    $userCreatorId = $_SESSION['user']['idPublic'] ?? null;
    
    $taskService->getTasks($userCreatorId, $page);

} else {

$response = new Response();

$response->error(405, "Método não permitido. Use GET.");

}

?>
