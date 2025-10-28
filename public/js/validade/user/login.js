import { ValidationException } from "../../exceptions/ValidationException.js";

export class Validade{

    login(email, password) {
        const regexEmail = /^[^\s@]+@[^\s@]+\.com$/;

        if(!email){
            throw new ValidationException("E-mail não pode ser vazio");
        }

        if(email.length > 150){
            throw new ValidationException("E-mail maximo de 150 caracteres");
        }
        if(!regexEmail.test(email)){
            throw new ValidationException("Email inválido.");
        }

        if(!password){
            throw new ValidationException("A senha não pode ser vazia");
        }

        if(password.length < 5){
            throw new ValidationException("A senha deve ter pelo menos 5 caracteres.");
        }

        if(password.length > 100){
            throw new ValidationException("Senha no maximo de 100 caracteres");
        }
    }        
}