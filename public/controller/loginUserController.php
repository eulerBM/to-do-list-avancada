<?php
require_once '../services/userService.php';
require_once '../response/response.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userService = new UserService();

    $data = json_decode(file_get_contents("php://input"), true);
    
    $email = trim($data["email"]) ?? null;
    $password = trim($data["password"]) ?? null;

    $userService->login($email, $password);

} else {

$response = new Response();

$response->error(405, "Método não permitido. Use POST.");

}

?>
