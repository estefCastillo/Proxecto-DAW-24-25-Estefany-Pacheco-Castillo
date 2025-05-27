<?php 
session_start();
if (!isset($_SESSION["tipo"]) || isset($_SESSION["tipo"])!="usuario") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">`
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <metaac
      name="description"
      content="Sambo: la plataforma donde puedes encontrar distintos servicios para tus eventos."
    />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="js/favorites.js"></script>
    <link rel="stylesheet" href="./css/principal.css" />

    <title>Sambo-Favoritos</title>
  </head>
  <body>
    <?php include './header.php'; ?>
    <main>
        <h2>Mis favoritos</h2>
    <section class="card_services">
        
      </section>
    </main>
    <?php include './footer.php'; ?>
  </body>
</html>
