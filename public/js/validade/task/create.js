import { ValidationException } from "../../exceptions/ValidationException.js";

export default class Validade {

    create(title, description, dateLimit) {

        if(!title && !description && !dateLimit){
            throw new ValidationException("título, descrição e data limite devem ser preenchida.");
        }

        // Título
        if (!title || title.length < 5) {
            throw new ValidationException("O título deve ter no mínimo 5 caracteres.");
        }
        if (title.length > 200) {
            throw new ValidationException("O título deve ter no máximo 200 caracteres.");
        }

        // Descrição
        if (!description || description.length < 5) {
            throw new ValidationException("A descrição deve ter no mínimo 5 caracteres.");
        }
        if (description.length > 1000) {
            throw new ValidationException("A descrição deve ter no máximo 1000 caracteres.");
        }
        // Data limite
        if (!dateLimit) {
            throw new ValidationException("A data limite deve estar presente.");
        }
        if (dateLimit.length > 50) {
            throw new ValidationException("A data limite é muito longa.");
        }
    }
}