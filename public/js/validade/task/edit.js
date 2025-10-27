import { ValidationException } from "../../exceptions/ValidationException.js";
import { formatDate } from "../../utils/formateDate.js";

export default class Validade {

    edit(title, description, situation, dateLimit) {

        if(!title && !description && !situation && !group && !dateLimit){
            throw new ValidationException("Pelo menos um campo deve ser preenchido.");
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

        //Situação
        if(situation && situation > 1){
            throw new ValidationException("A situação deve ter no maximo 1 caractere.");
        }
        // Data limite
        if (!dateLimit) {
            throw new ValidationException("A data limite deve estar presente.");
        }
        if (dateLimit.length > 50) {
            throw new ValidationException("A data limite é muito longa.");
        }
    }

    noChanges(title, title2, description, description2, situation, situation2, group, group2, dateLimit, dateLimit2){
        var groupConverted;

        if(group === "null"){
            groupConverted = null
        }

        if(title === title2 && description === description2 && Number(situation) === situation2 && groupConverted === group2 && formatDate(dateLimit) === formatDate(dateLimit2)){
            throw new ValidationException("Nenhuma alteração feita.");
        }
    }
}