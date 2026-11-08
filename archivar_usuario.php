
<?php
session_start();

if (!isset($_SESSION["usuario"]) || ($_SESSION["rol"] ?? "") !== "admin") {
    header("Location: panel.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: admin_usuarios.php");
    exit;
}

if (!isset($_SESSION["token"]) ||
    !hash_equals($_SESSION["token"], $_POST["token"] ?? "")) {
    exit("Solicitud no válida.");
}

require "conexion.php";

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: admin_usuarios.php");
    exit;
}

// Evitar que el administrador archive su propia cuenta.
if ($id == $_SESSION["id"]) {
    exit("No podés archivar tu propia cuenta.");
}

$consulta = $conexion->prepare(
    "UPDATE usuarios
     SET fecha_archivado = NOW()
     WHERE id = ? AND fecha_archivado IS NULL"
);

$consulta->execute([$id]);

header("Location: admin_usuarios.php");
exit;
?>
