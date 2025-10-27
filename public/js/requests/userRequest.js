
export class Request {

    urlLogin = "controller/loginUserController.php";
    urlRegister = "controller/createUserController.php";

    async login(data) {
        try {

            const response = await fetch(this.urlLogin, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            });

            return await response.json();

        } catch (error) {

            throw new Error("Erro ao tentar se conectar com o servidor.")

        }
  
    }

    async register(data) {
        try{
            const response = await fetch(this.urlRegister, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        return await response.json();

        } catch (error){

            throw new Error("Erro ao tentar se conectar com o servidor.")
        }
    }

    
}
