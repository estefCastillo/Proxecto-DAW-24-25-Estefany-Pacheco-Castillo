<?php 
session_start();
if (!isset($_SESSION["tipo"]) || isset($_SESSION["tipo"])!="usuario") {
    header("Location: index.php");
    exit();
}

$nombre=$_SESSION["nombre"];
$correo=$_SESSION["correo"];
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <metaac
      name="description"
      content="Sambo: la plataforma donde puedes encontrar distintos servicios para tus eventos."
    />
    <script type="module" src="js/reservas.js"></script>
    <link rel="stylesheet" href="./css/principal.css" />

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
        
        </section>
    </main>
    <footer-component></footer-component>
  </body>
</html>