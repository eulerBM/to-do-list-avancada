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

    public function requestTaskRegister($title, $description, $dateLimit, $userCreatorId){

        // Validação titulo
        if(empty($title) || strlen($title) < 5){
            throw new ValidationException("O titulo deve ter no minimo 5 caracteres.");
        }
        if(strlen($title) > 200){
            throw new ValidationException("O titulo deve ter no maximo 200 caracteres.");
        }

        // Validação descrição
        if(empty($description) || strlen($description) < 5){
            throw new ValidationException("A descrição deve ter pelo menos 5 caracteres.");
        }
        if(strlen($description) > 1000){
            throw new ValidationException("A descrição deve ter no maximo 1000 caracteres.");
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

    public function requestTaskEdit($title, $description, $situation, $dateLimit, $idTask, $idPublicUser){

        if(empty($title) && empty($description) && empty($situation) && empty($dateLimit)){

            throw new ValidationException("Por favor altere os campos.");
        }

        // Validação titulo
        if(!empty($title )){
            if(strlen($title) > 200){
                throw new ValidationException("O titulo deve ter no maximo 200 caracteres.");
            }
        }

        // Validação descrição
        if(!empty($description)){
            if(strlen($description) < 5 || strlen($description) > 1000){
                throw new ValidationException("A descrição deve ter entre 5 ou 1000 caracteres.");
            }
        }

        // Validação situação
        if(!empty($situation)){
            if(strlen($situation) > 10){
                throw new ValidationException("A situação deve ter no maximo 10 caracteres.");
            }
        }
        // Validação date limite
        if(!empty($dateLimit) != null){
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

     public function requestTaskFilter($title, $description, $situation, $order, $dateStart, $endDate, $userCreatorId){


        if(empty($title) && empty($description) && !isset($situation) && empty($order) && empty($dateStart) && empty($endDate) ){
            throw new ValidationException("Por favor escolha os filtros.");
        }

        // Validação titulo
        if(!empty($title) && strlen($title) > 200){    
            throw new ValidationException("O titulo deve ter no maximo 200 caracteres.");   
        }

        // Validação descrição
        if(!empty($description) && strlen($description) > 1000){      
            throw new ValidationException("A descrição deve ter no maximo 1000 caracteres.");         
        }

        // Validação situação
        if(!empty($situation) && strlen($situation) > 9){
            throw new ValidationException("A situação deve ter no maximo 9 caractere.");        
        }

        // Validação order
        if(!empty($order) && $order !== "asc" && $order !== "desc"){        
            throw new ValidationException("O ordenar por deve ser asc ou desc.");          
        }
        // Validação date limite
        if(!empty($dateStart) && strlen($dateStart) > 50){
            throw new ValidationException("Data limite muito grande.");
        }

        // Validação date final
        if(!empty($endDate) && strlen($dateStart) > 50){
            throw new ValidationException("Data final muito grande."); 
        }

        // Validação id user criador
        if(empty($userCreatorId)){
            throw new ValidationException("O id do usuario criador deve estar presente.");
        }
        if(strlen($userCreatorId) > 50){
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