<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta
    name="description"
    content="Sambo: la plataforma donde puedes encontrar distintos servicios para tus eventos." />
  <script src="js/session.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="./css/login.css" />
  <script type="module" src="js/login.js"></script>
  <title>Sambo-Iniciar sesión</title>
</head>

<body>
  <header>
    <h1>Sambo</h1>
    <a href="index.php"><img src="./img/v1.png" alt="Logo de sambo" /></a>
  </header>
  <main id="register">
    <p> ¿No tienes cuenta? <a href="./register.php">Regístrate</a></p>
    <h2>Iniciar sesión</h2>

    <form id="loginForm">
      <label for="correo">Correo electrónico:</label>
      <input type="email" id="correo" name="correo" required />
      <label for="contrasena">Contraseña:</label>
      <input type="password" id="contrasena" name="contrasena" required />
      <input type="submit" value="Iniciar sesión" />
    </form>
  </main>
  <footer>
    <p>Sambo &copy; Todos los derechos reservados</p>
  </footer>
</body>

</html>