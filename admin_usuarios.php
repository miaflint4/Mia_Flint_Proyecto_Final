<?php
session_start();

if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "admin") {
    header("Location: panel.php");
    exit;
}

require "conexion.php";

$consulta = $conexion->query(
    "SELECT id, nombre, apellido, dni, email, rol, tipo_cuenta, fecha_creacion, fecha_archivado
     FROM usuarios
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
            </tr>

            <?php foreach ($usuarios as $usuario) { ?>
                <tr>
                    <td><?php echo $usuario["id"]; ?></td>
                    <td><?php echo htmlspecialchars($usuario["nombre"]); ?></td>
                    <td><?php echo htmlspecialchars($usuario["apellido"]); ?></td>
                    <td><?php echo htmlspecialchars($usuario["dni"]); ?></td>
                    <td><?php echo htmlspecialchars($usuario["email"]); ?></td>
                    <td><?php echo $usuario["rol"]; ?></td>
                    <td><?php echo $usuario["tipo_cuenta"]; ?></td>
                    <td>
                        <?php
                        echo $usuario["fecha_archivado"] === null
                            ? "Activo"
                            : "Archivado";
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <p><a href="panel.php">Volver al panel</a></p>
        <a href="logout.php">Cerrar sesión</a>
        
    </div>
</section>

</body>
</html>
