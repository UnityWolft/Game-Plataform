document.getElementById('registroFormulario').addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username.length < 3) {
        alert("El nombre de usuario debe tener al menos 3 caracteres.");
        return;
    }

    if (password.length < 6) {
        alert("La contraseña debe tener al menos 6 caracteres.");
        return;
    }

    const datosUsuario = { username, password };

    fetch('/api/usuarios', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datosUsuario)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Usuario registrado exitosamente");
        } else {
            alert("Error al registrar el usuario");
        }
    })
    .catch(error => alert("Hubo un error al registrar el usuario"));
});
