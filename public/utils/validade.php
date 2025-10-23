<?php
require_once '../exceptions/ValidationException.php';

class validade{

    public function requestRegister($name, $email, $password, $confirmPassword){
        
        // Validação name
        if(empty($name) || strlen($name) < 2){
            throw new ValidationException("O nome deve ter pelo menos 2 caracteres.");
        }
        if(strlen($name) > 100){
            throw new ValidationException("O nome deve ter no maximo 100 caracteres.");
        }

        // Validação email
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new ValidationException("Email inválido.");
        }
        if(strlen($email) > 150){
            throw new ValidationException("O email deve ter no maximo 150 caracteres.");
        }

        // Validação password & confirmPassword
        if(empty($password) || strlen($password) < 5){
            throw new ValidationException("A senha deve ter pelo menos 5 caracteres.");
        }
        if(strlen($password) > 100 || strlen($confirmPassword) > 100){
            throw new ValidationException("A senha deve ter no maximo 100 caracteres.");
        }
        if($password !== $confirmPassword){
            throw new ValidationException("As senhas digitadas são diferentes.");
        }
    }

    public function requestLogin($email, $password){

        // Validação email
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new ValidationException("Email inválido.");
        }
        if(strlen($email) > 150){
            throw new ValidationException("O email deve ter no maximo 150 caracteres.");
        }

        // Validação password
        if(empty($password) || strlen($password) < 5){
            throw new ValidationException("A senha deve ter pelo menos 5 caracteres.");
        }
        if(strlen($password) > 100){
            throw new ValidationException("A senha deve ter no maximo 100 caracteres.");
        }
    }

    public function requestTaskRegister($titulo, $descricao, $grupo, $dateLimit, $userCreatorId){

        // Validação titulo
        if(empty($titulo)){
            throw new ValidationException("titulo inválido.");
        }
        if(strlen($titulo) > 200){
            throw new ValidationException("O titulo deve ter no maximo 200 caracteres.");
        }

        // Validação descrição
        if(empty($descricao) || strlen($descricao) < 5){
            throw new ValidationException("A descrição deve ter pelo menos 5 caracteres.");
        }
        if(strlen($descricao) > 1000){
            throw new ValidationException("A senha deve ter no maximo 1000 caracteres.");
        }

        // Validação de grupo
        if(strlen($grupo) > 1000){
            throw new ValidationException("O grupo deve ter no maximo 1000 caracteres.");
        }

        // Validação date limite
        if(empty($dateLimit)){
            throw new ValidationException("A data limite deve estar presente.");
        }
        if(strlen($dateLimit) > 50){
            throw new ValidationException("Data limite muito grande.");
        }

        // Validação id user criador
        if(empty($userCreatorId)){
            throw new ValidationException("O id do usuario criador deve estar presente.");
        }
        if(strlen($userCreatorId) > 50){
            throw new ValidationException("ID do usuario criador muito grande.");
        }
    }

    public function requestTaskEdit($titulo, $descricao, $situation, $grupo, $dateLimit, $idTask, $idPublicUser){

        if(empty($titulo) && empty($descricao) && empty($situation) && empty($dateLimit)){

            throw new ValidationException("Por favor altere os campos.");
        }

        // Validação titulo
        if($titulo != null){
            if(strlen($titulo) > 200){
                throw new ValidationException("O titulo deve ter no maximo 200 caracteres.");
            }
        }

        // Validação descrição
        if($descricao != null){
            if(strlen($descricao) < 5 || strlen($descricao) > 1000){
                throw new ValidationException("A descrição deve ter entre 5 ou 1000 caracteres.");
            }
        }

        // Validação situação
        if($situation != null){
            if(strlen($situation) > 10){
                throw new ValidationException("A situação deve ter no maximo 10 caracteres.");
            }
        }

        // Validação de grupo
        if($grupo != null){
            if(strlen($grupo) > 1000){
                throw new ValidationException("O grupo deve ter no maximo 1000 caracteres.");
            }
        }

        // Validação date limite
        if($dateLimit != null){
            if(strlen($dateLimit) > 50){
                throw new ValidationException("Data limite muito grande.");
            }
        }

        // Validação ID da task
        if(empty($idTask) || strlen($idTask) > 50){
            throw new ValidationException("ID da task inválido.");
        }

        // Validação id user criador
        if(empty($idPublicUser)){
            throw new ValidationException("O id do usuario criador deve estar presente.");
        }
        if(strlen($idPublicUser) > 50){
            throw new ValidationException("ID do usuario criador muito grande.");
        }


    }

    public function requestTaskDelete($idTask, $userCreatorId){

        // Validação ID da task
        if(empty($idTask) || strlen($idTask) > 50){
            throw new ValidationException("ID da task inválido.");
        }
        
        // Validação id user criador
        if(empty($userCreatorId) || strlen($userCreatorId) > 50){
            throw new ValidationException("ID do user criador inválido.");
        }
    }
}