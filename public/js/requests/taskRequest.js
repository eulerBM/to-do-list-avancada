export default class Request {

    urlGetTaskWithPagination = "controller/getTaskController.php";
    urlCreateTask = "controller/createTaskController.php";
    urlDeleteTask = "controller/deleteTaskController.php";
    urlEditTask = "controller/editTaskController.php";
    urlFilterTask = "controller/filterTaskController.php";


    async getTasksWithPagination(page = 1){

         try {

            const response = await fetch(this.urlGetTaskWithPagination + `?page=${page}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                },
                credentials: "include"
            });

            return await response.json();

        } catch (error) {

            throw new Error("Erro ao tentar se conectar com o servidor.");

        }
    }

    async create(data) {
        try {

            const response = await fetch(this.urlCreateTask, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            });

            return await response.json();

        } catch (error) {

            throw new Error("Erro ao tentar se conectar com o servidor.");

        }

    }

    async edit(data) {
        try {

            const response = await fetch(this.urlEditTask, {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data),
                credentials: "include"
            });

            return await response.json();

        } catch (error) {

            throw new Error("Erro ao tentar se conectar com o servidor.");

        }
    }

    async filter(data, page = 1) {

        try {

            const queryParams = new URLSearchParams({
                page,
                ...data
            }).toString();

            const response = await fetch(this.urlFilterTask + `?${queryParams}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                },
                credentials: "include"
            });

            return await response.json();

        } catch (error) {

            throw new Error("Erro ao tentar se conectar com o servidor.");

        }

    }

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

            throw new Error("Erro ao tentar se conectar com o servidor.");

        }
    }
}
