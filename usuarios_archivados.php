
<?php
session_start();

if (!isset($_SESSION["usuario"]) || ($_SESSION["rol"] ?? "") !== "admin") {
    header("Location: panel.php");
    exit;
}

if (empty($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(32));
}

require "conexion.php";

$consulta = $conexion->query(
    "SELECT id, nombre, apellido, dni, email, rol,
            tipo_cuenta, fecha_archivado
     FROM usuarios
     WHERE fecha_archivado IS NOT NULL
     ORDER BY fecha_archivado DESC"
);

$usuarios = $consulta->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Spotify - Usuarios archivados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<section>
<div class="card2">

    <h1>Spotify</h1>
    <h2>Usuarios archivados</h2>

    <?php if (count($usuarios) === 0) { ?>

        <p>No hay usuarios archivados.</p>

    <?php } else { ?>

        <table border="1" cellpadding="8">

            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Cuenta</th>
                <th>Fecha de archivo</th>
                <th>Acción</th>
            </tr>

            <?php foreach ($usuarios as $usuario) { ?>

                <tr>
                    <td><?php echo $usuario["id"]; ?></td>
                    <td><?php echo htmlspecialchars($usuario["nombre"]); ?></td>
                    <td><?php echo htmlspecialchars($usuario["apellido"]); ?></td>
                    <td><?php echo htmlspecialchars($usuario["dni"]); ?></td>
                    <td><?php echo htmlspecialchars($usuario["email"]); ?></td>
                    <td><?php echo htmlspecialchars($usuario["rol"]); ?></td>
                    <td><?php echo htmlspecialchars($usuario["tipo_cuenta"]); ?></td>
                    <td><?php echo htmlspecialchars($usuario["fecha_archivado"]); ?></td>

                    <td>
                        <form action="reactivar_usuario.php" method="POST">

                            <input type="hidden" name="id"
                            value="<?php echo $usuario["id"]; ?>">

                            <input type="hidden" name="token"
                            value="<?php echo htmlspecialchars($_SESSION["token"]); ?>">

                            <button type="submit">Reactivar</button>

                        </form>
                    </td>
                </tr>

            <?php } ?>

        </table>

    <?php } ?>

    <p><a href="admin_usuarios.php">Volver a usuarios</a></p>
    <a href="logout.php">Cerrar sesión</a>

</div>
</section>

</body>
</html>
