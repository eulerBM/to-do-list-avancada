<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json");
require_once __DIR__ . '/../response/response.php';
require_once __DIR__ . '../../repository/userRepository.php';
require_once __DIR__ . '../../utils/validade.php';

class userService{

    private $response;
    private $userRepository;
    private $validade;

    public function __construct(){
        
        $this->response = new Response();
        $this->userRepository = new UserRepository();
        $this->validade = new Validade();

    }

    public function create($name, $email, $password, $confirmPassword){

        try{

            $this->validade->requestRegister($name, $email, $password, $confirmPassword);

            $userSave= $this->userRepository->userSave($name, $email, $password, $confirmPassword);

            if(!$userSave){

                $this->response->error(400, "Erro ao salvar o usuario no banco.");

            }

            $this->response->userCreate(201, "Usuario criado, faça login.");

        } catch (ValidationException $e){

            $this->response->error($e->getStatus(), $e->getMessage());

        } catch (Exception $e){

            if($e->getMessage() === "E-mail já cadastrado."){

                $this->response->error(409, $e->getMessage());
                exit;

            }

            $this->response->error(500, "Erro interno: " . $e->getMessage());
            
        }
    }

    public function login($email, $password){

        try{

            $this->validade->requestLogin($email, $password);

            $user = $this->userRepository->findByUser($email);

            if(!$user){

                $this->response->error(401, "Email ou senha invalidos");
            }

            $verifyPassword = password_verify($password, $user["password"]);

            if(!$verifyPassword){

                $this->response->error(401, "Email ou senha invalidos");

            }

            $_SESSION['user'] = [
                'id' => $user['id'],
                'idPublic' => $user['idPublic'],
                'name' => $user['name'],
                'email' => $user['email']
            ];

            $this->response->userLogin(200, $user['idPublic'], $user['name'], $user['email']);


        } catch (ValidationException $e){

            $this->response->error($e->getStatus(), $e->getMessage());

        } catch (Exception $e){

            $this->response->error(500, "Erro interno: " . $e->getMessage());
            
        }
    }
}