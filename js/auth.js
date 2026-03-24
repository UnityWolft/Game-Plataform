// auth.js
import "./lib/manejaErrores.js"; // <-- asegurarse de que la librería esté cargada

document.addEventListener("DOMContentLoaded", () => {

    const formLogin = document.getElementById('formLogin');
    const formRegistro = document.getElementById('formRegistro');
    const userNameDisplay = document.getElementById("user-name");
    const btnLogin = document.getElementById("link-login");
    const btnRegistro = document.getElementById("link-registro");
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
            if (btnRegistro) btnRegistro.style.display = "none";
            if (btnLogout) btnLogout.style.display = "block";
        } else {
            if (userNameDisplay) userNameDisplay.innerText = "";
            if (btnLogin) btnLogin.style.display = "block";
            if (btnRegistro) btnRegistro.style.display = "block";
            if (btnLogout) btnLogout.style.display = "none";
        }
    }
    verificarSesion();

    // --- Login ---
    if (formLogin) {
        formLogin.addEventListener('submit', async (e) => {
            e.preventDefault();
            const errorBox = document.getElementById('mensajeError');
            const datos = {
                correo: document.getElementById('correo').value,
                password: document.getElementById('password').value
            };
            const respuesta = await enviaJsonRecibeJson("api/srv_login.php", datos);
            if (respuesta.status === "ok") window.location.href = "tienda.html";
            else if (errorBox) errorBox.innerText = respuesta.mensaje;
        });
    }

    // --- Registro ---
    if (formRegistro) {
        formRegistro.addEventListener('submit', async (e) => {
            e.preventDefault();
            const datos = {
                nombre: document.getElementById('nombre').value,
                correo: document.getElementById('correo').value,
                password: document.getElementById('password').value
            };
            const respuesta = await enviaJsonRecibeJson("api/srv_registro.php", datos);
            if (respuesta.status === "ok") {
                window.location.href = "login.html";
            }
        });
    }

    // --- Logout ---
    if (btnLogout) {
        btnLogout.addEventListener("click", async () => {
            await fetch("api/srv_logout.php");
            window.location.href = "index.html";
        });
    }

});