const formularioLogin =
    document.getElementById(
        "formLogin"
    );

const mensajeLogin =
    document.getElementById(
        "mensajeLogin"
    );


formularioLogin.addEventListener(
    "submit",
    async function (evento) {

        evento.preventDefault();

        const correo =
            document
                .getElementById(
                    "correoLogin"
                )
                .value
                .trim();

        const contrasena =
            document
                .getElementById(
                    "contrasenaLogin"
                )
                .value;


        try {

            const respuesta =
                await fetch(
                    "../backend/usuarios/login.php",
                    {
                        method: "POST",

                        headers: {
                            "Content-Type":
                                "application/json"
                        },

                        body:
                            JSON.stringify({
                                correo:
                                    correo,

                                contrasena:
                                    contrasena
                            })
                    }
                );


            const datos =
                await respuesta.json();


            if (
                !respuesta.ok ||
                !datos.exito
            ) {

                throw new Error(
                    datos.mensaje ||
                    "No se pudo iniciar sesión."
                );
            }


            mensajeLogin.textContent =
                datos.mensaje;

            mensajeLogin.className =
                "exito";


            setTimeout(
                function () {

                    window.location.href =
                        "index.php";

                },
                500
            );


        } catch (error) {

            mensajeLogin.textContent =
                error.message;

            mensajeLogin.className =
                "error";

            console.error(
                error
            );
        }
    }
);