import { ValidationException } from "../../exceptions/ValidationException.js";

export class Validade{

    register(name, email, password, passwordConfirm) {
        const regexEmail = /^[^\s@]+@[^\s@]+\.com$/;

        //Name
        if(!name){
            throw new ValidationException("nome não pode ser vazio.");
        }
        if(name.length < 2 || name.length > 100){
            throw new ValidationException("nome entre 2 e 100 caracteres.");
        }

        //Email
        if(!email){
            throw new ValidationException("E-mail não pode ser vazio.");
        }

        if(email.length > 150){
            throw new ValidationException("E-mail maximo de 150 caracteres.");
        }

        if(!regexEmail.test(email)){
            throw new ValidationException("Email inválido.");
        }
        
        //Password / passwordConfirm
        if(!password){
            throw new ValidationException("A senha não pode ser vazio.");
        }

        if(password.length < 5){
            throw new ValidationException("A senha deve ter pelo menos 5 caracteres.");
        }

        if(password.length > 100){
            throw new ValidationException("Senha no maximo de 100 caracteres.");
        }
        if(password !== passwordConfirm){
            throw new ValidationException("Senhas diferentes.");
        }
    }        
}