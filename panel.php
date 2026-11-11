
<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}

require "conexion.php";

$consulta = $conexion->prepare(
    "SELECT nombre, apellido, dni, email FROM usuarios WHERE id = ?"
);

$consulta->execute([$_SESSION["id"]]);

$usuario = $consulta->fetch();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify - Mi cuenta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<section class="panel-section">

    <div class="card2 panel-card">

        <h1>Spotify</h1>
        <h2>Mi panel personal</h2>

        <div class="datos-usuario">
            <h3>Mis datos</h3>

            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario["nombre"]); ?></p>

            <p><strong>Apellido:</strong> <?php echo htmlspecialchars($usuario["apellido"]); ?></p>

            <p><strong>DNI:</strong> <?php echo htmlspecialchars($usuario["dni"]); ?></p>

            <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario["email"]); ?></p>
        
    <a href="editar_usuario.php?id=<?php echo $_SESSION['id']; ?>">
        Editar mis datos
    </a>
</p>
        </div>

        <div class="panel-enlaces">

            <?php if ($_SESSION["rol"] === "admin") { ?>
                <a href="admin_usuarios.php" class="boton-spotify">
                    Administrar usuarios
                </a>
            <?php } ?>

            <a href="logout.php" class="boton-secundario">
                Cerrar sesión
            </a>

        </div>

    </div>

</section>

</body>
</html>
