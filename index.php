
<?php
session_start();

if (isset($_SESSION["usuario"])) {
    header("Location: panel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify - Iniciar sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <section>
        <div class="card2">

            <h1>Spotify</h1>
            <h2>Iniciar sesión</h2>

            <?php if (isset($_GET["error"])) { ?>
                <p>Usuario o contraseña incorrectos.</p>
            <?php } ?>

            <form action="login.php" method="POST">

                <fieldset>
                    <legend>Completar los datos</legend>

                    <div>
                        <label for="usuario">Usuario *</label>
                        <input type="email" id="email" name="email"
                        placeholder="Ingresá tu email" required>
                    </div>

                    <div>
                        <label for="clave">Contraseña *</label>
                        <input type="password" id="clave" name="password"
                        placeholder="Ingresá tu contraseña" required>
                    </div>

                    <button type="submit">Iniciar sesión</button>

                    <a href="signup.php">
                        <button type="button">Registrarse</button>
                    </a>

                </fieldset>

            </form>

        </div>
    </section>
</body>
</html>

