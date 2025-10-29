<h1 align="center">Estrutura do banco de dados e relacionamentos</h1>

<h3>Estrutura usuario</h3>

```bash
"CREATE TABLE IF NOT EXISTS users (
id INT AUTO_INCREMENT PRIMARY KEY,
idPublic VARCHAR(36) NOT NULL UNIQUE,
name VARCHAR(100) NOT NULL,
email VARCHAR(150) UNIQUE NOT NULL,
password VARCHAR(100) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)"
```

<h3>Estrutura Tarefa</h3>

```bash
"CREATE TABLE IF NOT EXISTS task (
id INT AUTO_INCREMENT PRIMARY KEY,
idPublic VARCHAR(36) NOT NULL UNIQUE,
user_creator_id VARCHAR(36)NOT NULL,
title VARCHAR(200) NOT NULL,
description TEXT NOT NULL,
situation TINYINT(1) DEFAULT 0,
timeout TIMESTAMP NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (user_creator_id) REFERENCES users(idPublic) ON DELETE CASCADE)"
```
<h1 align="center">Descrição das principais funções, classes e scripts PHP</h1>

<ul>
    <li><b>Setup.php → init()</b> – conecta com o banco e roda as migrations.</li>
    <li><b>routes.php → handleRoutes()</b> – intercepta as requisições e analisa qual é a rota que o usuario quer acessar.</li>
    <li><b>response.php → response</b> – padroniza a resposta do back-end.</li>
    <li><b>/utils → Validade</b> – valida os dados antes de processar no back-end.</li>
    <li><b>/services → taskService.php & userService</b> – Logica de negocio.</li>
    <li><b>/repository → taskRepository.php & userRepository</b> – onde ficam as operações do SQL.</li>
    <li><b>/js/render → render()</b> – renderiza os modais do dashboard</li>
    <li><b>/js/requests → userRequest & taskRequest</b> – fazem as req pros controller</li>
    <li><b>/controller/ALL → **Controller.php</b> – recebem as req e mandam pro service</li>
</ul>

<h1 align="center">Funcionamento das requisições AJAX</h1>

<ul>
    <li><b>js/render → render()</b> – renderiza os modais do dashboard e manda os dados pro controller sem ataulizar a pagina.</li>
</ul>

<h4 align="center">Exemplo de uso pra DELETAR tarefa</h4>

```bash
render(title, idTask) {

        this.htmlDeleteTask(title, idTask);

        const $modalElement = $("#modalDeleteTask");
        const modal = new bootstrap.Modal($modalElement[0]);
        modal.show();

       
        $(document).off("submit", "#formDeletTask").on("submit", "#formDeletTask", async function (e) {
            e.preventDefault();

            const request = new Request();
            const validade = new Validade();
            const renderTasks = new RenderTasks();

            try {

                const idTask = $(this).data("id");

                validade.delete(idTask)

                const response = await request.delete(idTask)

                modal.hide();
                $modalElement.remove();

                const alert = new AlertResponse(response);
                alert.normalShow()
        
                renderTasks.renderTasksWithPagination();

            } catch (error) {

                if (error instanceof ValidationException) {
                    return;
                }
                console.error("Erro ao deletar tarefa:", error);
            }
        });

    }
```

<h4 align="center">Exemplo de uso pra enviar tarefa</h4>

```bash
async delete(idTask) {

        try {

            const response = await fetch(this.urlDeleteTask, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ idTask }),
                credentials: "include"
            });

            return await response.json();;

        } catch (error) {

            throw new Error(this.messageDefault);

        }
    }
```
<h1 align="center">Decisões técnicas adotadas</h1>

<ul>
    <li><b>Separar bem as funcionalidades</b></li>
    <li><b>utilizar ao maximo POO</b></li>
    <li><b>utilizar docker</b></li>
    <li><b>utilizar exceptions junto com alerts</b></li>
</ul>

<h1 align="center">Passos para configuração local (ex: conexão MySQL, diretórios etc.).</h1>

Acesse `database/database.php` → para configuração da conexão do MySQL.
<br>
Acesse `migration/migration.php` → para ter acesso as tabelas do banco (se adicionar mais tabela chame no `setup.php`).
<br>
acesse `routes.php` → para ter acesso a rota do sistema.
<br>
acesse `js/render` → para ter acesso as renderições das modais.
<br>
acesse `js/requests` → para ter acesso as requições que são feitas pro controller.




