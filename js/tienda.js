import "./lib/manejaErrores.js";
import { enviaJsonRecibeJson } from "./lib/enviaJsonRecibeJson.js";
import { recibeJson } from "./lib/recibeJson.js";
import { consume } from "./lib/consume.js";

document.addEventListener("DOMContentLoaded", () => {
    const contenedor = document.getElementById("contenedor-juegos");

    async function cargarJuegos() {
        try {
            const respuesta = await consume(recibeJson("api/srv_tienda.php"));
            const juegos = await respuesta.json();
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
                        <button class="btn-steam btn-add">Añadir a Biblioteca</button>
                    </div>
                `;

                card.querySelector(".btn-add").addEventListener("click", async () => {
                    const datos = { titulo_juego: juego.title, imagen_url: juego.thumbnail };
                    const resPost = await consume(enviaJsonRecibeJson("api/srv_biblioteca.php", datos));
                    const final = await resPost.json();
                    alert(final.mensaje);
                });

                contenedor.appendChild(card);
            });
        } catch (error) {
            console.error("Error cargando tienda", error);
        }
    }

    cargarJuegos();
});