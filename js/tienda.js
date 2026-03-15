fetch("/api/apiJuegos.php")

.then(res => res.json())

.then(data => {

let contenedor = document.getElementById("juegos")

data.slice(0,12).forEach(juego => {

contenedor.innerHTML += `

<div class="col-md-3 mb-4">

<div class="card bg-dark text-light">

<img src="${juego.thumbnail}" class="card-img-top">

<div class="card-body">

<h5>${juego.title}</h5>

<p>${juego.genre}</p>

<a href="${juego.game_url}" target="_blank" class="btn btn-primary">
Ver Juego
</a>

<br><br>

<button class="btn btn-success"
onclick="agregarBiblioteca('${juego.title}','${juego.thumbnail}')">
Agregar a biblioteca
</button>

</div>

</div>

</div>

`

})

})
function agregarBiblioteca(nombre,imagen){

fetch("/api/apiAgregarBiblioteca.php",{

method:"POST",

headers:{
"Content-Type":"application/json"
},

body:JSON.stringify({
nombre:nombre,
imagen:imagen
})

})

.then(res => res.json())

.then(data => {

alert(data.mensaje)

})

}