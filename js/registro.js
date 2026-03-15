document.getElementById("formRegistro").addEventListener("submit",function(e){
    e.preventDefault()

    let nombre=document.getElementById("nombre").value
    let correo=document.getElementById("correo").value
    let password=document.getElementById("password").value

    if(nombre=="" || correo=="" || password==""){
        alert("Todos los campos son obligatorios")
        return
    }

    fetch("api/apiRegistro.php",{
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify({nombre,correo,password})
    })
    .then(res=>res.json())
    .then(data=>alert(data.mensaje))
})