document.addEventListener("DOMContentLoaded", () => {
    const contenedor = document.getElementById("estrenos-imagenes");

    fetch("api/srv_tienda.php")
        .then(res => res.json())
        .then(data => {
            contenedor.innerHTML = "";
            data.slice(0, 4).forEach(juego => {
                const imgCard = document.createElement("div");
                imgCard.className = "img-release-card";
                imgCard.innerHTML = `
                    
                        <img src="${juego.thumbnail}" alt="${juego.title}">
                        <div class="img-overlay">
                            <span>NUEVO</span>
                        </div>
                    </a>
                `;
                contenedor.appendChild(imgCard);
            });
        })
        .catch(err => console.error("Error cargando estrenos"));
});
