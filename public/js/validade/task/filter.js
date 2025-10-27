import { ValidationException } from "../../exceptions/ValidationException.js";

export default class Validade {

    filter(title, description, situation, order, dateStart, endDate) {

        if(!title && !description && !situation && !order && !dateStart && !endDate){
            throw new ValidationException("Pelo menos um campo deve ser preenchido.");
        }

        if (title && title.length > 200) {
            throw new ValidationException("O título deve ter no máximo 200 caracteres.");
        }

        if (description && description.length > 1000) {
            throw new ValidationException("A descrição deve ter no máximo 1000 caracteres.");
        }

        if(situation && situation > 1){
            throw new ValidationException("A situação deve ter no maximo 1 caractere.");
        }

        if(order && order.length > 4){
            throw new ValidationException("O ordenar por deve ser asc ou desc.");
        }
       
        if (dateStart &&dateStart.length > 50) {
            throw new ValidationException("A data limite é muito longa.");
        }

        if (endDate && endDate.length > 50) {
            throw new ValidationException("A data limite é muito longa.");
        }
    }
}