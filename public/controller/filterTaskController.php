<?php
session_start();
require_once '../services/userService.php';
require_once '../response/response.php';
require_once '../services/taskService.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $taskService = new TaskService();

    $page = trim($_GET['page']) ?? null;
    $title = strtolower(trim($_GET['title'])) ?? null;
    $description = strtolower(trim($_GET['description'])) ?? null;
    $situation = trim($_GET['situation']) ?? null;
    $order = strtolower(trim($_GET['order'])) ?? null;
    $dateStart = trim($_GET['dateStart']) ?? null;
    $endDate = trim($_GET['endDate']) ?? null;
    $userCreatorId = $_SESSION['user']['idPublic'] ?? null;

    $taskService->filterTask($page, $title, $description, $situation, $order, $dateStart, $endDate, $userCreatorId);

} else {

$response = new Response();

$response->error(405, "Método não permitido. Use GET.");

}

?>
