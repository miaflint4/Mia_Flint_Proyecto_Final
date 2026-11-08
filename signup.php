
<?php
require "conexion.php";
$errores = [];

$nombre = '';
$apellido = '';
$dni = '';
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nombre === '') {
        $errores[] = 'El nombre es obligatorio.';
    }

    if ($apellido === '') {
        $errores[] = 'El apellido es obligatorio.';
    }

    if ($dni === '' || !preg_match('/^[0-9]{7,8}$/', $dni)) {
        $errores[] = 'Ingresá un DNI válido.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'Ingresá un correo válido.';
    }

    if (strlen($password) < 8) {
        $errores[] = 'La contraseña debe tener al menos 8 caracteres.';
    }

    if (!isset($_POST['terminos'])) {
        $errores[] = 'Debés aceptar los términos y condiciones.';
    }
    if (empty($errores)) {

    $consulta = $conexion->prepare(
        "SELECT * FROM usuarios WHERE dni = ? OR email = ?"
    );

    $consulta->execute([$dni, $email]);

    if ($consulta->fetch()) {
        $errores[] = 'El DNI o el correo ya están registrados.';
    } else {

        $password_cifrada = password_hash($password, PASSWORD_DEFAULT);

        $consulta = $conexion->prepare(
            "INSERT INTO usuarios (nombre, apellido, dni, email, password)
             VALUES (?, ?, ?, ?, ?)"
        );

        $consulta->execute([
            $nombre,
            $apellido,
            $dni,
            $email,
            $password_cifrada
        ]);

        header("Location: index.php");
        exit;
    }
}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify - Registrarse</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body.signup-page {
    font-family: Arial, Helvetica, sans-serif;
    background: linear-gradient(135deg, #121212, #000000);
    color: white;
    min-height: 100vh;
}

.signup-page section {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px 20px;
}

.signup-page .card2 {
    background-color: #181818;
    width: 100%;
    max-width: 480px;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
}

.signup-page h1 {
    color: #1ed760;
    font-size: 38px;
    text-align: center;
    margin-bottom: 15px;
}

.signup-page h2 {
    color: white;
    font-size: 27px;
    text-align: center;
    margin-bottom: 25px;
}

.signup-page fieldset {
    border: none;
}

.signup-page legend {
    color: #b3b3b3;
    font-size: 14px;
    margin-bottom: 20px;
}

.signup-page fieldset div {
    margin-bottom: 18px;
}

.signup-page label {
    display: block;
    color: white;
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 9px;
}

.signup-page input:not([type="checkbox"]) {
    width: 100%;
    padding: 14px;
    background-color: #242424;
    border: 1px solid #727272;
    border-radius: 5px;
    color: white;
    font-size: 14px;
}

.signup-page input:focus {
    outline: none;
    border: 2px solid #1ed760;
}

.signup-page input::placeholder {
    color: #a7a7a7;
}

.signup-page input[type="checkbox"] {
    accent-color: #1ed760;
    margin-right: 8px;
}

.signup-page fieldset div:has(input[type="checkbox"]) label {
    display: flex;
    align-items: center;
    font-weight: normal;
    font-size: 13px;
    color: #b3b3b3;
}

.signup-page button {
    width: 100%;
    padding: 15px;
    margin-top: 10px;
    border: none;
    border-radius: 30px;
    background-color: #1ed760;
    color: black;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.signup-page button:hover {
    background-color: #3be477;
    transform: scale(1.02);
}

.signup-page a {
    display: block;
    text-align: center;
    margin-top: 22px;
    color: #1ed760;
    text-decoration: none;
    font-size: 14px;
}

.signup-page a:hover {
    color: white;
}

.signup-page p {
    background-color: #3d1919;
    color: #ff7777;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 12px;
    font-size: 14px;
}
</style>
</head>

<body>
<body class="signup-page"> 

    <section>
        <div class="card2">

            <h1>Spotify</h1>
            <h2>Crear cuenta</h2>

            <?php
            foreach ($errores as $error) {
                echo "<p>$error</p>";
            }
            ?>

            <form action="signup.php" method="POST">

                <fieldset>
                    <legend>Completar los datos</legend>

                    <div>
                        <label for="nombre">Nombre *</label>
                        <input type="text" id="nombre" name="nombre"
                        placeholder="Ej: Mauro" required>
                    </div>

                    <div>
                        <label for="apellido">Apellido *</label>
                        <input type="text" id="apellido" name="apellido"
                        placeholder="Ej: Bobyk" required>
                    </div>

                    <div>
                        <label for="dni">DNI *</label>
                        <input type="text" id="dni" name="dni"
                        placeholder="Ej: 50398167" required>
                    </div>

                    <div>
                        <label for="email">Correo electrónico *</label>
                        <input type="email" id="email" name="email"
                        placeholder="Ej: correo@gmail.com" required>
                    </div>

                    <div>
                        <label for="password">Contraseña *</label>
                        <input type="password" id="password" name="password"
                        placeholder="Mínimo de 8 caracteres"
                        minlength="8" required>
                    </div>

                    <div>
                        <label>
                            <input type="checkbox" name="terminos" required>
                            Acepto los términos y condiciones *
                        </label>
                    </div>

                    <button type="submit">Registrarse</button>

                    <a href="index.php">Ya tengo una cuenta</a>

                </fieldset>

            </form>

        </div>
    </section>

</body>
</html>
