<?php include 'includes/header.php'; ?>

<link rel="stylesheet" href="../css/login.css">
<link rel="stylesheet" href="../css/alert.css">


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

    <div id="alert-message"></div>

  </form>

</div>


<script type="module">

  import {
    Validade
  } from "../js/validade/user/login.js";
  import {
    ValidationException
  } from '../js/exceptions/ValidationException.js';
  import alertExceptions from '../js/alerts/alertExceptions.js';
  import {
    Request
  } from '../js/requests/userRequest.js';
  import AlertResponse from '../js/alerts/alertResponse.js';

  $(function() {
    $("#userForm").submit(async function(e) {
      e.preventDefault();

      const formData = $(this).serializeArray();
      const data = {};
      formData.forEach(item => data[item.name] = item.value);

      try {

        const validade = new Validade();
        validade.login(data.email, data.password);

        const request = new Request();
        const response = await request.login(data);

        const alertResponse = new AlertResponse(response);
        alertResponse.loginShow();

      } catch (error) {

        if (error instanceof ValidationException) {
          return;
        }

        const alertException = new alertExceptions();

        alertException.unknownError(error.message)

      }
    });
  });
</script>

<?php include 'includes/footer.php'; ?>