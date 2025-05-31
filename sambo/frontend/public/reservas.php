<?php
session_start();
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "empresa") {
    header("Location: index.php");
    exit();
}
$nombre = $_SESSION["nombre"];
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
    <script type="module" src="js/reservas.js"></script>
    <link rel="stylesheet" href="./css/admin_eu.css" />

    <title>Sambo-Admin</title>
</head>

<body>
    <?php include './header.php'; ?>
    <main>
        <h2>Reservas de <?= $nombre; ?>!</h2>
        <section id="mis_reservas">
            <h3>Mis servicios</h3>
            <table id="tablaReservas">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                        <th>Estado</th>
                        <th>Contacto</th>
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