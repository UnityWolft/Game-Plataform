document.getElementById("formLogin").addEventListener("submit",function(e){

e.preventDefault()

let correo=document.getElementById("correo").value
let password=document.getElementById("password").value

fetch("api/apiLogin.php",{

method:"POST",

headers:{
"Content-Type":"application/json"
},

body:JSON.stringify({
correo:correo,
password:password
})

})

.then(res=>res.json())
.then(data=>{

if(data.status=="ok"){
location.href="index.php"
}else{
alert(data.mensaje)
}

})

})