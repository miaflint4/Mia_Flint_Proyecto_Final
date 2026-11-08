
<?php
session_start();

if (empty($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(32));
}

if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "admin") {
    header("Location: panel.php");
    exit;
}

require "conexion.php";

$consulta = $conexion->query(
    "SELECT id, nombre, apellido, dni, email, rol, tipo_cuenta, fecha_creacion, fecha_archivado
     FROM usuarios
     WHERE fecha_archivado IS NULL
     ORDER BY id ASC"
);

$usuarios = $consulta->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Spotify - Administración</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<section>
    <div class="card2">
        <h1>Spotify</h1>
        <h2>Panel de administración</h2>

        <h3>Usuarios registrados</h3>

        <table border="1" cellpadding="8">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Cuenta</th>
                <th>Estado</th>
                <th>Acciones</th>
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

                    <td>
                        <?php
                        echo $usuario["fecha_archivado"] === null
                            ? "Activo"
                            : "Archivado";
                        ?>
                    </td>

                    <td>
                        <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>">
                            Editar
                        </a>

                        <?php if ($usuario["id"] != $_SESSION["id"]) { ?>

                            <form action="archivar_usuario.php" method="POST">

                                <input type="hidden" name="id"
                                value="<?php echo $usuario['id']; ?>">

                                <input type="hidden" name="token"
                                value="<?php echo htmlspecialchars($_SESSION['token']); ?>">

                                <button type="submit">Archivar</button>

                            </form>

                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <p>
            <a href="usuarios_archivados.php">Ver usuarios archivados</a>
        </p>

        <p><a href="panel.php">Volver al panel</a></p>
        <a href="logout.php">Cerrar sesión</a>

    </div>
</section>

</body>
</html>
