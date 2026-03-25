import "./lib/manejaErrores.js";
import { recibeJson } from "./lib/recibeJson.js";
import { consume } from "./lib/consume.js";
import { muestraError } from "./lib/muestraError.js";

document.addEventListener("DOMContentLoaded", () => {
    const contenedor = document.getElementById("lista-biblioteca");

    async function cargarBiblioteca() {
        try {
            // 1. Obtener la lista de juegos
            const respuesta = await consume(recibeJson("api/srv_biblioteca.php"));
            const juegos = await respuesta.json();
            
            contenedor.innerHTML = "";

            if (juegos.length === 0) {
                contenedor.innerHTML = "<p class='mensaje-vacio'>Tu biblioteca está vacía. ¡Ve a la tienda!</p>";
                return;
            }

            // 2. Pintar cada juego
            juegos.forEach(juego => {
                const card = document.createElement("div");
                card.className = "card-game";
                card.innerHTML = `
                    <img src="${juego.imagen_url}" alt="${juego.titulo_juego}">
                    <div class="card-info">
                        <h4>${juego.titulo_juego}</h4>
                        <button class="btn-steam btn-delete">Eliminar</button>
                    </div>
                `;

                // 3. Configurar el botón de eliminar
                card.querySelector(".btn-delete").addEventListener("click", async () => {
                    if (confirm(`¿Quieres eliminar "${juego.titulo_juego}"?`)) {
                        try {
                            // ENVIAMOS EL ID POR URL (?id=X)
                            const resDel = await fetch(`api/srv_biblioteca.php?id=${juego.id}`, {
                                method: "DELETE"
                            });

                            if (resDel.ok) {
                                // Recargamos la lista visualmente
                                cargarBiblioteca();
                            } else {
                                const error = await resDel.json();
                                muestraError(error);
                            }
                        } catch (e) {
                            console.error("Error al conectar con el servidor", e);
                        }
                    }
                });

                contenedor.appendChild(card);
            });
        } catch (error) {
            console.error("Error al cargar la biblioteca:", error);
        }
    }

    cargarBiblioteca();
});
