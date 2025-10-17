<?php include 'includes/header.php'; ?>


<div class="container">

    <form id="userForm">

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" require>
        </div>

        <label for="inputPassword1" class="form-label">Password</label>
        <input name="password" id="inputPassword1" class="form-control" aria-describedby="passwordHelpBlock" require>

        <div class="mb-3">

            <button type="submit" class="btn btn-success">Entrar</button>

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