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
<button type="submit"><a href="index.html">Submit</a></button>
<button type="signup"><a href="signup.php">Sign up</a></button>
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
$errores = [];
$username = '';
$password = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username = trim($_POST['nombre'] ?? '');
$password = trim($_POST['apellido'] ?? '');
if ($username === '') {
$errores[] = 'El nombre es obligatorio.';
}
if ($password === '') {
$errores[] = 'El apellido es obligatorio.';
}
}