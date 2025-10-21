<?php

class response{

    public function userCreate($status, $message){

        $data = [
            "status" => $status,
            "message" => $message
        ];

        header("Content-Type: application/json");

        echo json_encode($data);
        exit;
    }

    public function userLogin($status, $idPublic, $name, $email){

        $data = [
            "status" => $status,
            "message" => "Login feito com sucesso",
            "user" => [
                "idPublic" => $idPublic,
                "name" => $name,
                "email" => $email
            ]
            
        ];

        header("Content-Type: application/json");

        echo json_encode($data);
        exit;

    }

    public function getAllTasks($status, $tasks){

        $data = [

            "status" => $status,
            "tasks" => $tasks
            
        ];

        header("Content-Type: application/json");

        echo json_encode($data);
        exit;

    }

    public function taskCreate($status, $message){

        $data = [
            "status" => $status,
            "message" => $message
        ];

        header("Content-Type: application/json");

        echo json_encode($data);
        exit;
    }

    public function taskDelete($status, $message){

        $data = [
            "status" => $status,
            "message" => $message
        ];

        header("Content-Type: application/json");

        echo json_encode($data);
        exit;
    }

    public function error($status, $message){

        $data = [
            "status" => $status,
            "message" => $message
        ];

        header("Content-Type: application/json");

        echo json_encode($data);
        exit;

    }
}