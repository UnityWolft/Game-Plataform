// utils.js
export async function enviaJsonRecibeJson(url, datos = {}, metodo = "POST") {
    const res = await fetch(url, {
        method: metodo,
        headers: { "Content-Type": "application/json" },
        body: metodo.toUpperCase() !== "GET" ? JSON.stringify(datos) : null
    });

    if (!res.ok) throw new Error("Error en la petición: " + res.statusText);
    return await res.json();
}