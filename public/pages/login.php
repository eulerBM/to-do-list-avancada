<?php include 'includes/header.php'; ?>

<link rel="stylesheet" href="../css/login.css">
<link rel="stylesheet" href="../css/alert.css">


<div class="container">

  <form id="userForm">

    <div class="mb-3 text-center col-6 mx-auto">

      <label for="exampleFormControlInput1" class="form-label">Email</label>
      <div class="input-group input-group-sm">
        <input name="email" class="form-control form-control-sm" id="exampleFormControlInput1" placeholder="Exemplo@email.com" require>
      </div>

    </div>

    <div class="mb-3 text-center col-6 mx-auto">
      <label for="inputPassword1" class="form-label">Senha</label>

      <div class="input-group input-group-sm">
        <input
          type="password"
          name="password"
          id="password"
          class="form-control form-control-sm"
          placeholder="Digite sua senha"
          required>
        <button
          class="btn btn-outline-secondary"
          type="button"
          id="togglePassword">
          <i class="bi bi-eye"></i>
        </button>
      </div>
    </div>

    <div class="mb-3 text-center col-6 mx-auto">

      <button id="buttonEnter" type="submit" class="btn btn-danger">Entrar</button>

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

  const togglePassword = document.getElementById('togglePassword');
  const password = document.getElementById('password');
  const icon = togglePassword.querySelector('i');

  togglePassword.addEventListener('click', () => {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    icon.classList.toggle('bi-eye');
    icon.classList.toggle('bi-eye-slash');
  });

</script>

<?php include 'includes/footer.php'; ?>