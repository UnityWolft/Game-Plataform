document.addEventListener("DOMContentLoaded", () => {
    const formLogin = document.getElementById('formLogin');
    const formRegistro = document.getElementById('formRegistro');
    const userNameDisplay = document.getElementById("user-name");
    const btnLogin = document.getElementById("link-login");
    const btnRegistro = document.getElementById("link-registro");
    const btnLogout = document.getElementById("link-logout");

    fetch("api/srv_session.php")
        .then(res => res.json())
        .then(user => {
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
        })
        .catch(err => console.error("Error verificando sesión"));
    if (formLogin) {
        formLogin.addEventListener('submit', async (e) => {
            e.preventDefault();
            const errorBox = document.getElementById('mensajeError');
            
            const datos = {
                correo: document.getElementById('correo').value,
                password: document.getElementById('password').value
            };

            try {
                const res = await fetch('api/srv_login.php', {
                    method: 'POST',
                    body: JSON.stringify(datos),
                    headers: { 'Content-Type': 'application/json' }
                });

                const respuesta = await res.json();

                if (res.ok) {
                    window.location.href = 'tienda.html';
                } else {
                    if (errorBox) {
                        errorBox.innerText = respuesta.mensaje;
                        errorBox.style.display = 'block';
                    } else {
                        alert(respuesta.mensaje);
                    }
                }
            } catch (err) {
                alert("Error de conexión con el servidor");
            }
        });
    }

    // --- 4. LÓGICA DE REGISTRO (Módulo 10 y 12) ---
    if (formRegistro) {
        formRegistro.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const datos = {
                nombre: document.getElementById('nombre').value,
                correo: document.getElementById('correo').value,
                password: document.getElementById('password').value
            };

            try {
                const res = await fetch('api/srv_registro.php', {
                    method: 'POST',
                    body: JSON.stringify(datos),
                    headers: { 'Content-Type': 'application/json' }
                });

                const respuesta = await res.json();

                if (res.ok) {
                    alert("¡Registro exitoso! Por favor, inicia sesión.");
                    window.location.href = 'login.html'; // Redirigir al login
                } else {
                    alert("Error: " + respuesta.mensaje);
                }
            } catch (err) {
                alert("No se pudo completar el registro.");
            }
        });
    }
});
