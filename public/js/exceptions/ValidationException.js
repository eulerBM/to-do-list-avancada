import  alertExceptions from "../alerts/alertExceptions.js";


export class ValidationException extends Error {

    constructor(message) {
        super(message);
        this.name = "ValidationException";

        const alertException = new alertExceptions();
        alertException.validation(message)
     
    }
}