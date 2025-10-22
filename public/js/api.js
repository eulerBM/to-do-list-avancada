import { showAlert } from "./alerts.js";

export async function  fetchCreateTask(data) {

    try {

        const response = await fetch("controller/createTaskController.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        console.log("Resposta do servidor:", result);

        if (result.status > 200){

            showAlert(result.status, result.message)

        }

    } catch (error) {

        console.error("Erro ao enviar:", error);
        alert("Erro ao enviar os dados");

    }
};

export async function fetchAllTask(page) {

    try {

        const response = await fetch(`controller/getTaskController.php?page=${page}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            },
            credentials: "include"
        });

        const result = await response.json();

        console.log("Resposta do servidor:", result);

        if (result.status >= 200){

            showAlert(result.status, "Tarefas encontradas")

        }

        if(!localStorage.getItem("totalPages")){
            localStorage.setItem("totalPages", result.totalPages)
        }
        
        return result;

    } catch (error) {

        console.error("Erro ao enviar:", error);
        alert("Erro ao enviar os dados");

    }
};

export async function fetchEditTask() {

    try {

        const response = await fetch("controller/editTaskController.php", {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json"
            },
            credentials: "include"
        });

        const result = await response.json();

        console.log("Resposta do servidor:", result);

        if (result.status >= 200){

            showAlert(result.status, "Editação da tarefa feita com sucesso.")

        }

        return result;

    } catch (error) {

        console.error("Erro ao enviar:", error);
        alert("Erro ao enviar os dados");

    }
};

export async function fetchDeleteTask(idTask) {

    try {

        const response = await fetch("controller/deleteTaskController.php", {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ idTask }),
            credentials: "include"
        });

        const result = await response.json();

        console.log("Resposta do servidor:", result);

        if (result.status >= 200){

            showAlert(result.status, result.message)

        }

        return result;

    } catch (error) {

        console.error("Erro ao enviar:", error);
        alert("Erro ao enviar os dados");

    }
};