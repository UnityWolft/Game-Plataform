// index.js
import "./lib/manejaErrores.js";

document.addEventListener("DOMContentLoaded", () => {
    const contenedor = document.getElementById("estrenos-imagenes");

    // --- Función del profesor ---
    async function enviaJsonRecibeJson(url, datos = {}, metodo = "POST") {
        const res = await fetch(url, {
            method: metodo,
            headers: { "Content-Type": "application/json" },
            body: metodo.toUpperCase() !== "GET" ? JSON.stringify(datos) : undefined
        });
        return await res.json();
    }

    // --- Cargar estrenos ---
    async function cargarEstrenos() {
        const data = await enviaJsonRecibeJson("api/srv_tienda.php", {}, "GET");
        contenedor.innerHTML = "";

        data.slice(0, 4).forEach(juego => {
            const imgCard = document.createElement("div");
            imgCard.className = "img-release-card";
            imgCard.innerHTML = `
                <img src="${juego.thumbnail}" alt="${juego.title}">
                <div class="img-overlay">
                    <span>NUEVO</span>
                </div>
            `;
            contenedor.appendChild(imgCard);
        });
    }

    cargarEstrenos();
});