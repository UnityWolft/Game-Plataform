// js/lib/manejaErrores.js
import { muestraError } from "./muestraError.js";

/**
 * Intercepta Response.prototype.json para capturar errores de parseo
 * y asegurar que se reporten correctamente en navegadores Chromium.
 */
{
  const originalJson = Response.prototype.json;

  Response.prototype.json = function () {
    // Llamamos al método original usando el contexto (this) de la respuesta
    return originalJson.apply(this, arguments)
      .catch((/* @type {any} */ error) => {
        // Corrige un error de Chrome que evita el manejo correcto de errores.
        throw new Error(error);
      });
  };
}

// Captura errores globales
window.onerror = function (_message, _url, _line, _column, errorObject) {
  muestraError(errorObject);
  return true;
};

// Captura promesas rechazadas no manejadas
window.addEventListener('unhandledrejection', event => {
  muestraError(event.reason);
  event.preventDefault();
});