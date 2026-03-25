import "./lib/manejaErrores.js";
import { recibeJson } from "./lib/recibeJson.js";
import { consume } from "./lib/consume.js";

document.addEventListener("DOMContentLoaded", async () => {
    const contenedor = document.getElementById("estrenos-imagenes");

    try {
        const respuesta = await consume(recibeJson("api/srv_tienda.php"));
        const data = await respuesta.json();
        contenedor.innerHTML = "";

        data.slice(0, 4).forEach(juego => {
            const div = document.createElement("div");
            div.className = "img-release-card";
            div.innerHTML = `<img src="${juego.thumbnail}" alt="${juego.title}">`;
            contenedor.appendChild(div);
        });
    } catch (error) {
        console.error("Error en index", error);
    }
});