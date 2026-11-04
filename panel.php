
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
    <title>Spotify - Mi cuenta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<section>
    <div class="card2">

        <h1>Spotify</h1>
        <h2>Mi panel personal</h2>

        <h3>Mis datos</h3>

        <p>Nombre: <?php echo htmlspecialchars($usuario["nombre"]); ?></p>
        <p>Apellido: <?php echo htmlspecialchars($usuario["apellido"]); ?></p>
        <p>DNI: <?php echo htmlspecialchars($usuario["dni"]); ?></p>
        <p>Email: <?php echo htmlspecialchars($usuario["email"]); ?></p>

        <?php if ($_SESSION["rol"] === "admin") { ?>
            <p>
                <a href="admin_usuarios.php">Administrar usuarios</a>
            </p>
        <?php } ?>

        <a href="logout.php">Cerrar sesión</a>

    </div>
</section>

</body>
</html>
