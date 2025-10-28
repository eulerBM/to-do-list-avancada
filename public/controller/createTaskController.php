<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../services/taskService.php';
require_once '../response/response.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $taskService = new TaskService();

    $data = json_decode(file_get_contents("php://input"), true);
    
    $title = trim($data["title"]) ?? null;
    $description = trim($data["description"]) ?? null;
    $dateLimit = trim($data["dateLimit"]) ?? null;
    $userCreatorId = $_SESSION['user']['idPublic'] ?? null;

    $taskService->create($title, $description, $dateLimit, $userCreatorId);

} else {

$response = new Response();

$response->error(405, "Método não permitido. Use POST.");

}

?>
