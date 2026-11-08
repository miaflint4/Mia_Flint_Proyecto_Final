
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

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: admin_usuarios.php");
    exit;
}

$consulta = $conexion->prepare(
    "SELECT id, nombre, apellido, dni, email
     FROM usuarios
     WHERE id = ? AND fecha_archivado IS NULL"
);
$consulta->execute([$id]);
$usuario = $consulta->fetch();

if (!$usuario) {
    exit("Usuario no encontrado.");
}

$errores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!hash_equals($_SESSION["token"], $_POST["token"] ?? "")) {
        exit("Solicitud no válida.");
    }

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($nombre === "" || $apellido === "") {
        $errores[] = "El nombre y el apellido son obligatorios.";
    }

    if (!preg_match('/^[0-9]{7,8}$/', $dni)) {
        $errores[] = "Ingresá un DNI válido.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Ingresá un correo válido.";
    }

    if (empty($errores)) {

        $consulta = $conexion->prepare(
            "SELECT id FROM usuarios
             WHERE (dni = ? OR email = ?) AND id <> ?"
        );
        $consulta->execute([$dni, $email, $id]);

        if ($consulta->fetch()) {
            $errores[] = "El DNI o el correo ya pertenecen a otro usuario.";
        } else {

            $consulta = $conexion->prepare(
                "UPDATE usuarios
                 SET nombre = ?, apellido = ?, dni = ?, email = ?
                 WHERE id = ? AND fecha_archivado IS NULL"
            );

            $consulta->execute([
                $nombre,
                $apellido,
                $dni,
                $email,
                $id
            ]);

            header("Location: admin_usuarios.php");
            exit;
        }
    }

    $usuario["nombre"] = $nombre;
    $usuario["apellido"] = $apellido;
    $usuario["dni"] = $dni;
    $usuario["email"] = $email;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Spotify - Editar usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<section>
<div class="card2">

    <h1>Spotify</h1>
    <h2>Editar usuario</h2>

    <?php foreach ($errores as $error) { ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <form action="" method="POST">

        <input type="hidden" name="token"
        value="<?php echo htmlspecialchars($_SESSION["token"]); ?>">

        <label>Nombre</label>
        <input type="text" name="nombre"
        value="<?php echo htmlspecialchars($usuario["nombre"]); ?>" required>

        <label>Apellido</label>
        <input type="text" name="apellido"
        value="<?php echo htmlspecialchars($usuario["apellido"]); ?>" required>

        <label>DNI</label>
        <input type="text" name="dni"
        value="<?php echo htmlspecialchars($usuario["dni"]); ?>" required>

        <label>Email</label>
        <input type="email" name="email"
        value="<?php echo htmlspecialchars($usuario["email"]); ?>" required>

        <button type="submit">Guardar cambios</button>

    </form>

    <p><a href="admin_usuarios.php">Volver a usuarios</a></p>

</div>
</section>

</body>
</html>
