
<?php
session_start();

if (!isset($_SESSION["usuario"]) || ($_SESSION["rol"] ?? "") !== "admin") {
    header("Location: panel.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: usuarios_archivados.php");
    exit;
}

if (!isset($_SESSION["token"]) ||
    !hash_equals($_SESSION["token"], $_POST["token"] ?? "")) {
    exit("Solicitud no válida.");
}

require "conexion.php";

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: usuarios_archivados.php");
    exit;
}

$consulta = $conexion->prepare(
    "UPDATE usuarios
     SET fecha_archivado = NULL
     WHERE id = ? AND fecha_archivado IS NOT NULL"
);

$consulta->execute([$id]);

header("Location: usuarios_archivados.php");
exit;
?>
