import "./lib/manejaErrores.js";
import { enviaJsonRecibeJson } from "./lib/enviaJsonRecibeJson.js";
import { recibeJson } from "./lib/recibeJson.js";
import { consume } from "./lib/consume.js";
import { muestraObjeto } from "./lib/muestraObjeto.js";

document.addEventListener("DOMContentLoaded", () => {
    const formLogin = document.getElementById('formLogin');
    const formRegistro = document.getElementById('formRegistro');
    const btnLogin = document.getElementById("link-login");
    const btnRegistro = document.getElementById("link-registro");
    const btnLogout = document.getElementById("link-logout");

    // --- Verificar sesión ---
    async function verificarSesion() {
        try {
            const respuesta = await consume(recibeJson("api/srv_session.php"));
            const user = await respuesta.json();

            if (user.logeado) {
                // muestraObjeto busca el ID "nombre" o "user-name" en el HTML
                muestraObjeto(document, { "user-name": "Hola, " + user.nombre });
                
                if (btnLogin) btnLogin.style.display = "none";
                if (btnRegistro) btnRegistro.style.display = "none";
                if (btnLogout) btnLogout.style.display = "block";
            } else {
                if (btnLogin) btnLogin.style.display = "block";
                if (btnLogout) btnLogout.style.display = "none";
            }
        } catch (error) {
            console.error("Error al verificar sesión", error);
        }
    }
    verificarSesion();

    // --- Login ---
    if (formLogin) {
        formLogin.addEventListener('submit', async (e) => {
            e.preventDefault();
            const datos = {
                correo: document.getElementById('correo').value,
                password: document.getElementById('password').value
            };

            const respuesta = await consume(enviaJsonRecibeJson("api/srv_login.php", datos));
            const resultado = await respuesta.json();

            if (resultado.status === "ok") {
                window.location.href = "tienda.html";
            }
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

            const respuesta = await consume(enviaJsonRecibeJson("api/srv_registro.php", datos));
            const resultado = await respuesta.json();

            if (resultado.status === "ok") {
                window.location.href = "login.html";
            }
        });
    }
});