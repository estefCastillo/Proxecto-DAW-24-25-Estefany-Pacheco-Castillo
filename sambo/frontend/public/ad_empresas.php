<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <metaac
        name="description"
        content="Sambo: la plataforma donde puedes encontrar distintos servicios para tus eventos." />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="module" src="js/empresas.js"></script>
    <link rel="stylesheet" href="./css/admin_eu.css" />

    <title>Sambo-Admin</title>
</head>

<body>
    <?php include './header.php'; ?>
    <main>
        <section id="empresas">
            <h2>Empresas</h2>
            <a href="./form_empresas.php">+ Nueva</a>
            <table id="tablaEmpresas">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Telefono</th>
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