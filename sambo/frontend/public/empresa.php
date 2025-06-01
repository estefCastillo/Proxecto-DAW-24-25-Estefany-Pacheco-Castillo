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
    <script src="js/session.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="js/empresa.js"></script>
    <link rel="stylesheet" href="./css/admin_eu.css" />
    <title>Sambo-Admin</title>
</head>

<body>
    <?php include './header.php'; ?>
    <main>
        <h2>Bienvenido, <?= $nombre; ?>!</h2>
        <section id="actions">
            <ul>
                <li><a href="./edit_empresa.php">Editar mi información</a></li>
                <li><a href="./form_servicio.php">Añadir servicio</a></li>
                <li><a href="./reservas.php">Mis reservas</a></li>
            </ul>
        </section>
        <section id="mis_servicios">
            <h3>Mis servicios</h3>
            <table id="tablaServicios">
                <thead>
                    <tr>
                        <th>Nombre</th>
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