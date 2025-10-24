export default class alertExceptions {

  validation(message){

    return this.#createAlert(message);

  }

  request(){
    return this.#createAlert(message);
  }

  unknownError(message){

    return this.#createAlert(message, "danger", 5);

  }

  


  #createAlert(messageExceptions, type = "warning", time = 4) {

    const alert = document.createElement("div");
    alert.className = `alert alert-${type}`;
    alert.role = "alert";
    alert.textContent = messageExceptions;

    document.body.prepend(alert);

    setTimeout(() => alert.remove(), time * 1000);

  }
}




