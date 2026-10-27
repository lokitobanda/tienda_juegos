// 1. Mensaje de bienvenida
if (window.location.pathname.endsWith("inicio.html")) {
    alert("¡Bienvenido a SkyGames!");
}


// 3. Fecha y hora
const fechaHora = document.getElementById("fechaHora");

if (fechaHora) {

    function actualizarFechaHora() {
        const ahora = new Date();

        fechaHora.textContent = ahora.toLocaleString();
    }

    actualizarFechaHora();

    setInterval(actualizarFechaHora, 1000);
}


//  Galería de imágenes
const imagenGaleria = document.getElementById("imagenGaleria");
const siguiente = document.getElementById("siguiente");
const anterior = document.getElementById("anterior");

if (imagenGaleria && siguiente && anterior) {

    const imagenes = [
        "imagenes/novedad1.jfif",
        "imagenes/novedad2.jfif",
        "imagenes/novedad3.jfif",
        "imagenes/novedad4.jfif"
    ];

    let posicion = 0;

    siguiente.addEventListener("click", function() {

        posicion++;

        if (posicion >= imagenes.length) {
            posicion = 0;
        }

        imagenGaleria.src = imagenes[posicion];

    });

    anterior.addEventListener("click", function() {

        posicion--;

        if (posicion < 0) {
            posicion = imagenes.length - 1;
        }

        imagenGaleria.src = imagenes[posicion];

    });
}





//  Validación del formulario

const formulario = document.getElementById("formulario");

if (formulario) {

    formulario.addEventListener("submit", function(event) {

        event.preventDefault();

        const nombre = document.getElementById("nombre").value.trim();
        const correo = document.getElementById("correo").value.trim();
        const mensaje = document.getElementById("mensaje").value.trim();

        const errorNombre = document.getElementById("errorNombre");
        const errorCorreo = document.getElementById("errorCorreo");
        const errorMensaje = document.getElementById("errorMensaje");

        errorNombre.textContent = "";
        errorCorreo.textContent = "";
        errorMensaje.textContent = "";

        let formularioValido = true;

        // Validar nombre
        if (nombre === "") {
            errorNombre.textContent = "Por favor, ingresa tu nombre.";
            formularioValido = false;
        }
         const formatoNombre = /^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s]+$/;

         if (nombre === "") {
          errorNombre.textContent = "Por favor, ingresa tu nombre.";
          formularioValido = false;
            } 
        else if (!formatoNombre.test(nombre)) {
           errorNombre.textContent = "El nombre solo puede contener letras.";
         formularioValido = false;
       }











        // Validar correo
        const formatoCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (correo === "") {
            errorCorreo.textContent = "Por favor, ingresa tu correo.";
            formularioValido = false;
        } 
        else if (!formatoCorreo.test(correo)) {
            errorCorreo.textContent = "Ingresa un correo electrónico válido.";
            formularioValido = false;
        }

        // Validar mensaje
        if (mensaje === "") {
            errorMensaje.textContent = "Por favor, escribe tu consulta.";
            formularioValido = false;
        }

        if (formularioValido) {
            alert("¡Consulta enviada correctamente!");
        }

    });

}



//  Menú interactivo

const botonInfo = document.getElementById("botonInfo");
const informacion = document.getElementById("informacion");

if (botonInfo && informacion) {

    botonInfo.addEventListener("click", function() {

        informacion.classList.toggle("oculto");

        if (informacion.classList.contains("oculto")) {
            botonInfo.textContent = "Mostrar información";
        } else {
            botonInfo.textContent = "Ocultar información";
        }

    });

}








//  Resumen del formulario

const mostrarResumen = document.getElementById("mostrarResumen");
const resumen = document.getElementById("resumen");

if (mostrarResumen && resumen) {

    mostrarResumen.addEventListener("click", function() {

        const nombre = document.getElementById("nombre").value;
        const correo = document.getElementById("correo").value;
        const producto = document.getElementById("producto").value;
        const mensaje = document.getElementById("mensaje").value;

        resumen.innerHTML = `
            <h2>Resumen de tu consulta</h2>

            <p><strong>Nombre:</strong> ${nombre}</p>

            <p><strong>Correo:</strong> ${correo}</p>

            <p><strong>Producto:</strong> ${producto}</p>

            <p><strong>Consulta:</strong> ${mensaje}</p>
        `;

    });

}




//  Modo oscuro

const modoOscuro = document.getElementById("modoOscuro");

// Comprobar si anteriormente estaba activado
if (localStorage.getItem("modoOscuro") === "activado") {
    document.body.classList.add("modo-oscuro");
}

if (modoOscuro) {

    // Cambiar el botón según el estado actual
    if (document.body.classList.contains("modo-oscuro")) {
        modoOscuro.textContent = "☀️ Modo claro";
    }

    modoOscuro.addEventListener("click", function() {

        document.body.classList.toggle("modo-oscuro");

        if (document.body.classList.contains("modo-oscuro")) {

            modoOscuro.textContent = "☀️ Modo claro";

            localStorage.setItem("modoOscuro", "activado");

        } else {

            modoOscuro.textContent = "🌙 Activar modo oscuro";

            localStorage.setItem("modoOscuro", "desactivado");

        }

    });
}