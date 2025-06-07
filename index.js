$(document).ready(function () {

    // Validar formulario al enviar
    $("#login_form").on("submit", function (e) {
        const correo = $("#usu_correo").val().trim();
        const pass = $("#usu_pass").val().trim();

        // Validar campos vacíos
        if (correo === "" || pass === "") {
            e.preventDefault();
            Swal.fire({
                icon: "warning",
                title: "Campos vacíos",
                text: "Por favor ingrese su correo y contraseña."
            });
            return;
        }

        // Validar formato de correo
        const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regexCorreo.test(correo)) {
            e.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Correo inválido",
                text: "Por favor ingrese un correo electrónico válido."
            });
            return;
        }

        // Validar longitud mínima de contraseña
        if (pass.length < 4) {
            e.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Contraseña inválida",
                text: "La contraseña debe tener al menos 4 caracteres."
            });
            return;
        }

        // Si todo está correcto, el formulario se envía normalmente
    });

    // Cambiar entre roles
    $("#btnadmin").on("click", function () {
        const rolId = $("#rol_id").val();
        if (rolId == 1) {
            $("#lbltitulo").html("Administrador");
            $(this).html("Ingreso de Supervisor");
            $("#rol_id").val(2);
        } else {
            $("#lbltitulo").html("Ingreso de Supervisor");
            $(this).html("Administrador");
            $("#rol_id").val(1);
        }
    });
});

