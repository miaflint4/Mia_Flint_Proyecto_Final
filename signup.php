
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
    <link rel="stylesheet" href="styles.css">
</head>

<body>

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
