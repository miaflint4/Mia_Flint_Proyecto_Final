
<?php
session_start();
require "conexion.php";

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    header("Location: index.php?error=1");
    exit;
}

$consulta = $conexion->prepare(
    "SELECT * FROM usuarios WHERE email = ? AND fecha_archivado IS NULL"
);

$consulta->execute([$email]);

$usuario = $consulta->fetch();


if ($usuario && password_verify($password, $usuario['password'])) {

    $_SESSION["usuario"] = $usuario["email"];
    $_SESSION["id"] = $usuario["id"];
    $_SESSION["rol"] = $usuario["rol"];
    $_SESSION["nombre"] = $usuario["nombre"];

    header("Location: panel.php");
    exit;
}

header("Location: index.php?error=1");
exit;
