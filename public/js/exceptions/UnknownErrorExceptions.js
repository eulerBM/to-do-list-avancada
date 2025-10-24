import { alertExceptions } from "../alerts/alertExceptions.js";

export class UnknownErrorExceptions extends Error {

    constructor(message) {
        super(message);
        this.name = "UnknownErrorExceptions";

        const alertException = new alertExceptions();
        alertException.unknownError(message)

    }
}