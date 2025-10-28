<?php include 'includes/header.php'; ?>

<link rel="stylesheet" href="../css/register.css">

<div class="container">

  <form id="userForm">

    <div class="mb-3 text-center col-6 mx-auto">
      <label for="exampleFormControlInput1" class="form-label">Nome</label>
      <input type="text" name="name" class="form-control form-control-sm" id="exampleFormControlInput1" placeholder="Digite seu nome completo" require>
    </div>

    <div class="mb-3 text-center col-6 mx-auto">
      <label for="exampleFormControlInput1" class="form-label">Email</label>
      <input type="email" name="email" class="form-control form-control-sm" id="exampleFormControlInput1" placeholder="Exemplo@email.com" require>
    </div>

    <div class="mb-3 text-center col-6 mx-auto">
      <label for="inputPassword1" class="form-label form-control-sm">Senha</label>
      <div class="input-group input-group-sm">
        <input type="password" name="password" id="inputPassword1" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" placeholder="Digite sua senha" require>
        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
          <i class="bi bi-eye"></i>
      </div>
    </div>

    <div class="mb-3 text-center col-6 mx-auto">
      <label for="inputPassword2" class="form-label form-control-sm">Confirmar senha</label>
      <input type="password" name="confirmPassword" id="inputPassword2" class="form-control form-control-sm" aria-describedby="passwordHelpBlock" placeholder="Confirme sua senha" require>
    </div>

    <div class="mb-3 text-center col-6 mx-auto">

      <button type="submit" id="buttonRegister" class="btn btn-danger">Cadastrar</button>

    </div>

  </form>

</div>

<script type="module">
  import {
    Validade
  } from "../js/validade/user/register.js";
  import {
    ValidationException
  } from '../js/exceptions/ValidationException.js';
  import {
    Request
  } from '../js/requests/userRequest.js';
  import AlertResponse from '../js/alerts/alertResponse.js';
  import alertExceptions from '../js/alerts/alertExceptions.js';

  $(document).ready(function() {
    $("#userForm").submit(async function(e) {
      e.preventDefault();

      const formData = $(this).serializeArray();
      const data = {};
      formData.forEach(item => data[item.name] = item.value);

      try {
        const validade = new Validade();
        validade.register(data.name, data.email, data.password, data.confirmPassword);

        const request = new Request();
        const response = await request.register(data);

        const alertResponse = new AlertResponse(response);
        alertResponse.registerShow();

      } catch (error) {
        if (error instanceof ValidationException) {

          return;

        }

        const alertException = new alertExceptions();

        alertException.unknownError(error.message)

      }
    });
  });

  const togglePassword = document.getElementById('togglePassword');
  const password = document.getElementById('inputPassword1');
  const icon = togglePassword.querySelector('i');

  togglePassword.addEventListener('click', () => {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    icon.classList.toggle('bi-eye');
    icon.classList.toggle('bi-eye-slash');
  });
</script>

<?php include 'includes/footer.php'; ?>