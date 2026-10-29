<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG IN</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
     
        <section>
      <div class="card2">
          <h1>Log in</h1>
        <fieldset>
<legend>Completar los datos</legend>
<div>
<label for="username">Username *</label>
<input type="text" id="username" name="username" placeholder="Ej: Maurobobyk" required>
</div>
<div>
<label for="username">Nombre y Apellido *</label>
<input type="text" id="nya" name="nya" placeholder="Ej: Mauro bobyk" required>
</div>
    
<div>
<label for="email">email *</label>
<input type="text" id="email" name="email" placeholder="Ej: Maurobobyk@gmail.com" required>
</div>


    <div>
<label for="password">Password *</label>
<input type="password" id="password" name="password" placeholder="Minimo de 8 caracteres" minlength="8" required>
</div>

<div>
<label>
<input type="checkbox" name="terminos" required>
Acepto los <a href="#">términos y condiciones</a> *
</label>
</div>


<div>
<button type="submit"><a href="index.php">Log in</a></button>
<button type="submit">Submit </button>
</div>
</form>
</div>
</div>
</fieldset>
          
        </div>
      </div>
</section>
</div>
</body>

<?php
$$errores = [];
$nombreyapellido= '';
$email = '';
$password = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$nombreyapellido = trim($_POST['nombreyapellido'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
if ($nombre === '') {
$errores[] = 'El nombre y apellido es obligatorio.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
$errores[] = 'Ingresá un correo válido.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
$errores[] = 'Ingresá un correo válido.';
}
}