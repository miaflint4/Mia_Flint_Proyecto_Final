
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
    <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body.login-page {
    font-family: Arial, Helvetica, sans-serif;
    background: linear-gradient(135deg, #121212, #000000);
    color: white;
    min-height: 100vh;
}

.login-page section {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.login-page .card2 {
    background-color: #181818;
    width: 100%;
    max-width: 430px;
    padding: 45px 40px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 8px 30px rgba(0,0,0,0.5);
}

.login-page h1 {
    color: #1ed760;
    font-size: 38px;
    margin-bottom: 25px;
}

.login-page h2 {
    color: white;
    font-size: 27px;
    margin-bottom: 30px;
}

.login-page p {
    background-color: #3d1919;
    color: #ff7777;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 20px;
}

.login-page fieldset {
    border: none;
}

.login-page legend {
    color: #b3b3b3;
    margin-bottom: 20px;
    font-size: 14px;
}

.login-page fieldset div {
    text-align: left;
    margin-bottom: 20px;
}

.login-page label {
    display: block;
    color: white;
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 9px;
}

.login-page input {
    width: 100%;
    padding: 14px;
    background-color: #242424;
    border: 1px solid #727272;
    border-radius: 5px;
    color: white;
    font-size: 14px;
}

.login-page input:focus {
    border: 2px solid #1ed760;
    outline: none;
}

.login-page input::placeholder {
    color: #a7a7a7;
}

.login-page button {
    width: 100%;
    padding: 15px;
    margin-top: 12px;
    border: none;
    border-radius: 30px;
    background-color: #1ed760;
    color: black;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.login-page button:hover {
    background-color: #3be477;
    transform: scale(1.03);
}

.login-page a {
    text-decoration: none;
}

.login-page a button {
    background-color: transparent;
    border: 1px solid #727272;
    color: white;
}

.login-page a button:hover {
    border-color: white;
    background-color: #282828;
}
</style>
</head>

<body class="login-page">
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

