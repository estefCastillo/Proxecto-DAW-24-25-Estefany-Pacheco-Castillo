<?php
session_start();
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "empresa") {
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta
    name="description"
    content="Sambo: la plataforma donde puedes encontrar distintos servicios para tus eventos." />
  <link rel="stylesheet" href="./css/login.css" />
  <script src="js/session.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="module" src="./js/edit_servicio.js"></script>
  <title>Sambo-Editar</title>
</head>

<body>
  <header>
    <h1>Sambo</h1>
    <a href="principal.php"><img src="./img/v1.png" alt="Logo de sambo" /></a>
  </header>
  <main id="register">
    <h2>Servicio</h2>
    <form id="servicioForm">
      <label for="nombre">Nombre del servicio:</label>
      <input type="text" id="nombre" name="nombre" required />

      <label for="descripcion">Descripción:</label>
      <textarea id="descripcion" name="descripcion" rows="3"></textarea>

      <label for="precio">Precio:</label>
      <input type="number" id="precio" name="precio" step="0.01" />

      <label for="tipo_precio">Tipo de precio:</label>
      <input type="text" id="tipo_precio" name="tipo_precio" placeholder="hora, evento, etc." />

      <label for="imagen">Ruta de la imagen:</label>
      <input type="text" id="imagen" name="imagen" placeholder="img/ejemplo.jpg" />

      <label for="categoria">Categoría:</label>
      <input type="text" id="categoria" name="categoria" required />

      <label for="ubicacion">Ubicación:</label>
      <input type="text" id="ubicacion" name="ubicacion" />
      <input type="submit" value="Guardar" />
    </form>
  </main>
  <footer>
    <p>Sambo &copy; Todos los derechos reservados</p>
  </footer>
</body>

</html>