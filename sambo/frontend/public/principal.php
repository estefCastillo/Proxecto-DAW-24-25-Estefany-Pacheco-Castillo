<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <metaac
      name="description"
      content="Sambo: la plataforma donde puedes encontrar distintos servicios para tus eventos."
    />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="js/general.js"></script>
    <link rel="stylesheet" href="./css/principal.css" />

    <title>Sambo-Principal</title>
  </head>
  <body>
    <?php include './header.php'; ?>
    <main>
      <form action="#" method="post" id="researchForm">
        <label for="research" class="hidden">Buscador </label>
        <input
          type="text"
          name="research"
          id="research"
          placeholder="Buscador"
        />
        <input type="submit" value="Buscar" />
      </form>

      <section class="btn-categories"></section>
      <section class="card_services">
        
      </section>
    </main>
    <?php include "./footer.php"; ?>
  </body>
</html>
