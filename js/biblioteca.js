document.addEventListener("DOMContentLoaded", () => {
    const contenedor = document.getElementById("lista-biblioteca");

    // Módulo 11: Renderizado dinámico desde el servicio de base de datos
    fetch("api/srv_biblioteca.php")
        .then(res => {
            if (res.status === 401) {
                alert("Debes iniciar sesión primero");
                window.location.href = "login.html";
                return;
            }
            return res.json();
        })
        .then(data => {
            contenedor.innerHTML = ""; // Limpiar cargando

            if (data.length === 0) {
                contenedor.innerHTML = "<p>Aún no tienes juegos en tu biblioteca. ¡Ve a la tienda!</p>";
                return;
            }

            data.forEach(juego => {
                const card = document.createElement("div");
                card.className = "card-game";
                card.innerHTML = `
                    <div class="card-img-container">
                        <img src="${juego.imagen_url}" alt="${juego.nombre_juego}" style="width:100%">
                    </div>
                    <div class="card-info">
                        <h4>${juego.nombre_juego}</h4>
                        <p class="release-date">Agregado el: ${juego.fecha_agregado}</p>
                        <button class="btn-steam" style="background:#a41c1c;">Eliminar (Próximamente)</button>
                    </div>
                `;
                contenedor.appendChild(card);
            });
        })
        .catch(err => {
            contenedor.innerHTML = "<p>Error al cargar la biblioteca.</p>";
        });
});
document.addEventListener("DOMContentLoaded", () => {
    // Verificar sesión al cargar la página
    fetch("api/srv_session.php")
        .then(res => res.json())
        .then(user => {
            const userNameDisplay = document.getElementById("user-name");
            const btnLogin = document.getElementById("link-login");
            const btnLogout = document.getElementById("link-logout");

            if (user.logeado) {
                if (userNameDisplay) userNameDisplay.innerText = "Hola, " + user.nombre;
                if (btnLogin) btnLogin.style.display = "none";    // Esconder Login
                if (btnLogout) btnLogout.style.display = "block"; // Mostrar Salir
            } else {
                if (btnLogout) btnLogout.style.display = "none";
            }
        });
});