<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Sambo: la plataforma donde puedes encontrar distintos servicios para tus eventos."
    />
    <link rel="stylesheet" href="./css/login.css" />
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script  type="module" src="./js/form_empresas.js"></script>
    <title>Sambo-Registro</title>
  </head>
  <body>
    <header>
      <h1>Sambo</h1>
      <a href="index.php"><img src="./img/v1.png" alt="Logo de sambo" /></a>
    </header>
    <main id="register">
      <h2>Registro</h2>
      <form id="registrerForm">
        <label for="nombre_empresa">Nombre:</label>
        <input type="text" name="nombre_empresa" id="nombre_empresa" placeholder="Sambo" required>

        <label for="correo">Correo electrónico:</label>
        <input type="email" id="correo" name="correo" placeholder="sambo@info.com" required/>
        <span class="error" id="e_correo"></span>

        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" placeholder="658733573" max="9" required/>
        <span class="error" id="e_tel"></span>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required/>
        <span class="error" id="e_contrasena"></span>

        <label for="contrasena2">Repita la contraseña:</label>
        <input type="password" id="contrasena2" name="contrasena2" required/>
        <span class="error" id="e_contrasena2"></span>
        <input type="submit" value="Registrarse"/>
      </form>
    </main>
    <footer>
        <p>Sambo &copy; Todos los derechos reservados</p>
    </footer>
  </body>
</html>
