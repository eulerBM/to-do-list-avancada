import { ValidationException } from "../../exceptions/ValidationException.js";

export default class Validade {

    delete(idTask) {

       if(!idTask || idTask.length > 50){
            throw new ValidationException("ID da task inválido.");
       }
    }
}