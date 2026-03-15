fetch('/api/productos')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            data.data.forEach(producto => {
                document.getElementById("productos").innerHTML += 
                    `<div class="producto">
                        <h3>${producto.nombre}</h3>
                        <p>Precio: $${producto.precio}</p>
                    </div>`;
            });
        } else {
            alert("No se pudieron cargar los productos.");
        }
    })
    .catch(error => console.log('Error al cargar los productos: ', error));
