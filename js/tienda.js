// tienda.js
import "./lib/manejaErrores.js";

document.addEventListener("DOMContentLoaded", () => {
    const contenedor = document.getElementById("contenedor-juegos");
    const userNameDisplay = document.getElementById("user-name");
    const btnLogin = document.getElementById("link-login");
    const btnLogout = document.getElementById("link-logout");

    async function enviaJsonRecibeJson(url, datos = {}, metodo = "POST") {
        const res = await fetch(url, {
            method: metodo,
            headers: { "Content-Type": "application/json" },
            body: metodo.toUpperCase() !== "GET" ? JSON.stringify(datos) : undefined,
            credentials: "same-origin" // Envía cookies de sesión
        });
        return await res.json();
    }

    // --- 1. Verificar sesión ---
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

    // --- 2. Cargar juegos ---
    async function cargarJuegos() {
        const juegos = await enviaJsonRecibeJson("api/srv_tienda.php", {}, "GET");
        contenedor.innerHTML = "";

        juegos.slice(0, 16).forEach(juego => {
            const card = document.createElement("div");
            card.className = "card-game";
            card.innerHTML = `
                <div class="card-img-container">
                    <img src="${juego.thumbnail}" alt="${juego.title}">
                </div>
                <div class="card-info">
                    <h4>${juego.title}</h4>
                    <span class="genre-badge">${juego.genre}</span>
                    <p class="release-date">Lanzamiento: ${juego.release_date}</p>
                    <button class="btn-steam btn-add">Añadir a Biblioteca</button>
                </div>
            `;

            // Botón añadir a biblioteca
            card.querySelector(".btn-add").addEventListener("click", async () => {
                const datos = { titulo_juego: juego.title, imagen_url: juego.thumbnail };
                const respuesta = await enviaJsonRecibeJson("api/srv_biblioteca.php", datos, "POST");
                alert(respuesta.mensaje);
            });

            contenedor.appendChild(card);
        });
    }

    cargarJuegos();
});