// biblioteca.js
import "./lib/manejaErrores.js";

document.addEventListener("DOMContentLoaded", () => {
    const contenedor = document.getElementById("lista-biblioteca");
    const userNameDisplay = document.getElementById("user-name");
    const btnLogin = document.getElementById("link-login");
    const btnLogout = document.getElementById("link-logout");

    // --- Función del profesor ---
    async function enviaJsonRecibeJson(url, datos = {}, metodo = "POST") {
        const res = await fetch(url, {
            method: metodo,
            headers: { "Content-Type": "application/json" },
            body: metodo.toUpperCase() !== "GET" ? JSON.stringify(datos) : undefined
        });
        return await res.json();
    }

    // --- Verificar sesión ---
    async function verificarSesion() {
        const user = await enviaJsonRecibeJson("api/srv_session.php", {}, "GET");
        if (user.logeado) {
            if (userNameDisplay) userNameDisplay.innerText = "Hola, " + user.nombre;
            if (btnLogin) btnLogin.style.display = "none";
            if (btnLogout) btnLogout.style.display = "block";
        } else {
            if (btnLogin) btnLogin.style.display = "block";
            if (btnLogout) btnLogout.style.display = "none";
        }
    }
    verificarSesion();

    // --- Cargar biblioteca ---
    async function cargarBiblioteca() {
        const juegos = await enviaJsonRecibeJson("api/srv_biblioteca.php", {}, "GET");
        contenedor.innerHTML = "";
        if (juegos.length === 0) {
            contenedor.innerHTML = "<p>Aún no tienes juegos en tu biblioteca. ¡Ve a la tienda!</p>";
            return;
        }

        juegos.forEach(juego => {
            const card = document.createElement("div");
            card.className = "card-game";
            card.innerHTML = `
                <div class="card-img-container">
                    <img src="${juego.imagen_url}" alt="${juego.titulo_juego}">
                </div>
                <div class="card-info">
                    <h4>${juego.titulo_juego}</h4>
                    <p class="release-date">Agregado el: ${juego.fecha_agregado}</p>
                    <button class="btn-steam btn-delete">Eliminar</button>
                </div>
            `;

            card.querySelector(".btn-delete").addEventListener("click", async () => {
                const resp = await enviaJsonRecibeJson("api/srv_biblioteca.php", { id: juego.id }, "DELETE");
                cargarBiblioteca();
            });

            contenedor.appendChild(card);
        });
    }

    cargarBiblioteca();
});