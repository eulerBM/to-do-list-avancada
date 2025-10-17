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
}