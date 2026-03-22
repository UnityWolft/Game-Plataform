document.addEventListener("DOMContentLoaded", () => {
    const contenedor = document.getElementById("contenedor-juegos");

    fetch("api/srv_tienda.php")
        .then(res => {
            if(!res.ok) throw new Error("Error al conectar con la API");
            return res.json();
        })
        .then(data => {
            contenedor.innerHTML = "";
            
            data.slice(0, 16).forEach(juego => {
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
                        <button class="btn-steam btn-add" onclick="agregarABiblioteca('${juego.title}', '${juego.thumbnail}')">
                            Añadir a Biblioteca
                        </button>
                    </div>
                `;
                contenedor.appendChild(card);
            });
        })
        .catch(err => {
            contenedor.innerHTML = `<div class="error-msg">No se pudo cargar el catálogo: ${err.message}</div>`;
        });
});

// Módulo 10: Procesar acción de añadir (envía JSON al servidor)
function agregarABiblioteca(nombre, imagen) {
    fetch("api/srv_biblioteca.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ nombre, imagen })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.mensaje);
    })
    .catch(err => alert("Error al guardar el juego"));
}
document.addEventListener("DOMContentLoaded", () => {
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
