<?php
session_start();
if (!isset($_SESSION["tipo"]) || isset($_SESSION["tipo"]) != "usuario") {
  header("Location: index.php");
  exit();
}

$nombre = $_SESSION["nombre"];
$correo = $_SESSION["correo"];
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <metaac
    name="description"
    content="Sambo: la plataforma donde puedes encontrar distintos servicios para tus eventos." />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="module" src="js/profile_r.js"></script>
  <link rel="stylesheet" href="./css/reservas.css" />

  <title>Sambo-Perfil</title>
</head>

<body>
  <?php include './header.php'; ?>
  <main>
    <section id="datos">
      <h2>¡Hola, <?= $nombre; ?> !</h2>
    </section>

    <section id="reservas">
      <h3>Mis reservas: </h3>
      <table id="tablaReservas">
        <thead>
          <tr>
            <th>Servicio</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>&euro;</th>
            <th>Acciones</th>

          </tr>

        </thead>
        <tbody>
        </tbody>
      </table>
    </section>
  </main>
  <?php include './footer.php'; ?>
</body>

</html>