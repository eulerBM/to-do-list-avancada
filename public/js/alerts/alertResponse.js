export default class AlertResponse {
  #type;

  constructor(response) {
    this.status = response.status;
    this.message = response.message;
  }

  loginShow(){

    this.#createAlert(this.message, this.status);

    if (this.status >= 200 && this.status <= 299) {

      setTimeout(() => {

        window.location.href = '/dashboard';
            
      }, 3000);

    }
  }

  registerShow(){

    this.#createAlert(this.message, this.status);

    if (this.status >= 200 && this.status <= 299) {

      setTimeout(() => {

        window.location.href = '/login';
            
      }, 3000);

    }
  }

  normalShow() {
    return this.#createAlert(this.message, this.status);
  }



  #createAlert(message, status) {

    switch (true){

      case status >= 500: this.#type = "danger"; break;

      case status >= 400: this.#type = "warning"; break;

      case status >= 300: this.#type = "info"; break;

      case status >= 200: this.#type = "success"; break;
    }

    const alert = document.createElement("div");
    alert.className = `alert alert-${this.#type}`;
    alert.role = "alert";
    alert.textContent = message;

    document.body.prepend(alert);

    setTimeout(() => alert.remove(), 5000);
  }
}


