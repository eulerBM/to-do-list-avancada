<?php
require_once '../services/userService.php';
require_once '../response/response.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userService = new UserService();

    $data = json_decode(file_get_contents("php://input"), true);
    
    $idTask = trim($data["idTask"]) ?? null;
   
    $userService->create($name, $email, $password, $confirmPassword);

} else {

$response = new Response();

$response->error(405, "Método não permitido. Use POST.");

}

?>
