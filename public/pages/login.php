<?php include 'includes/header.php'; ?>

<link rel="stylesheet" href="../css/login.css">

<div class="container">

    <form id="userForm">

        <div class="mb-3 text-center col-6 mx-auto">

          <label for="exampleFormControlInput1" class="form-label">Email</label>
          <input name="email" class="form-control form-control-sm" id="exampleFormControlInput1" placeholder="Exemplo@email.com" require>

        </div>
        
        <div class="mb-3 text-center col-6 mx-auto">

          <label for="inputPassword1" class="form-label">Senha</label>
          <input type="password" name="password" id="inputPassword1" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" placeholder="Digite sua senha" require>

        </div>

        <div class="mb-3 text-center col-6 mx-auto">

          <button type="submit" class="btn btn-danger">Entrar</button>

        </div>
        
    </form>

</div>

<script type="module"> 

    import { showAlert } from "./js/alerts.js";
    import { redirectAfterSuccess } from "./js/script.js";

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("userForm");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    console.log("Enviando dados:", data);

    try {
        
      const response = await fetch("controller/loginUserController.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      });

      const result = await response.json();

      console.log("Resposta do servidor:", result);

      if(result.status >= 200){

        showAlert(result.status, result.message)

        redirectAfterSuccess(result)
        
      }

    } catch (error) {

      console.error("Erro ao enviar:", error);
      alert("Erro ao enviar os dados");

    }

  });

});

</script>

<?php include 'includes/footer.php'; ?>