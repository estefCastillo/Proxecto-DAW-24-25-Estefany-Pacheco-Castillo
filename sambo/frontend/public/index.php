<?php
session_start();
if (isset($_SESSION["rol"]) && $_SESSION["rol"] == "empresa") {
    header("Location: empresa.php");
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
  <script src="js/session.js"></script>
  <script type="module" src="js/general.js"></script>
  <link rel="stylesheet" href="./css/general.css" />
  <title>Sambo-Servicios para eventos</title>
</head>

<body>
  <?php include './header.php'; ?>
  <main>
    <section class="portada">
      <h2>Organiza tu evento perfecto</h2>
      <h2>Todo lo que necesitas, en un solo lugar</h2>
    </section>

    <article id="nosotros">
      <span></span>
      <section>
        <h3>Nosotros</h3>
        <p>Creemos que cada evento merece ser <span class="sambo">único y especial.</span></p>
        <p>Por ello, nace Sambo, una plataforma pensada para conectar a organizadores y particulares con los mejores servicios locales de Galicia.</p>
        <p>Nuestro objetivo es hacer que planificar un evento sea más fácil, más rápido y, sobre todo, reducir el estrés de planificación. Queremos dar visibilidad a negocios y talentos que muchas veces pasan desapercibidos, apostando por lo auténtico, lo cercano y lo de calidad.</p>
        <details>
          <summary>Ver más información</summary>
          <article id="more_info">
            <h3>¿Por qué Sambo?</h3>
            <p>
              Este proyecto podría haberse llamado de mil formas distintas que reflejasen su propósito, pero decidí que su nombre fuese especial: <span class="sambo">Sambo</span>.
            </p>
            <p>Sambo fue mi pequeño pero gran compañero durante casi diez años. Llegó a mi vida como un regalo del cielo, llenando cada rincón, no solo de mi casa, sino tmabién de mi vida. Tuve la maravillosa oportunidad de crecer con él y compartir una etapa de mi vida a su lado. Su alegría y su cariño incondicional me acompañaron día y noche. Estuvo conmigo en los buenos momentos y también en los difíciles. Su alma no conocía maldad, solo lealtad. Me enseñó más de lo que jamás imaginé que me pudiera enseñar: sobre todo, el valor del amor y la resiliencia hasta su último día.</p>
            <p>Hace casi dos años, me tocó organizar un evento muy especial: la boda de mi hermano mayor. Recuerdo bien el estrés de planificar, buscar y pensar en cada detalle de la ceremonia. En todo ese proceso, Sambo estuvo a mi lado en cada paso. Sin decir una palabra, me brindaba apoyo y tranquilidad.</p>
            <p>Un 15 de marzo, Sambo tuvo que partir. Dejó un gran vacío, pero también un gran ejemplo a seguir. No quiero que su recuerdo se disipe con el tiempo. Por eso, cuando nació la idea de esta plataforma, no dudé en ponerle su nombre. Es una forma de recordarle y agradecerle todo lo que me dio, no solo durante la organización de la boda que da vida a este proyecto, sino durante toda su vida. Siempre acompañándome con amor, paciencia y una lealtad que nunca olvidaré.</p>
            <figure>
              <img src="./img/sambo.jpg" alt="Sambo">
            </figure>
          </article>
        </details>
      </section>
    </article>
    <section id="beneficios">
      <ul>
        <li>1 web</li>
        <li>2 minutos</li>
        <li>3 veces más fácil</li>
        <li>y múltiples opciones.</li>
      </ul>
    </section>

    <article id="comenzar">
      <h4>Crea recuerdos con Sambo:</h4>
      <a href="./principal.php">Comenzar</a>
      <section class="scroll_services">
        <section class="card_service">
          <p>Catering</p>
          <figure class="card_service_img">
            <img src="./img/catering_example.jpg" alt="Catering">
          </figure>
        </section>
        <section class="card_service">
          <p>Stands</p>
          <figure class="card_service_img">
            <img src="./img/stands.jpg" alt="Stands">
          </figure>
        </section>

        <section class="card_service">
          <p>Música en vivo</p>
          <figure class="card_service_img">
            <img src="./img/musica_vivo.jpg" alt="Música en vivo">
          </figure>
        </section>

        <section class="card_service">
          <p>Recuerdos</p>
          <figure class="card_service_img">
            <img src="./img/recuerdos.jpg" alt="Recuerdos">
          </figure>
        </section>

        <section class="card_service">
          <p>Mobiliario</p>
          <figure class="card_service_img">
            <img src="./img/mobiliario.jpg" alt="Mobiliario">
          </figure>
        </section>

        <section class="card_service">
          <p>Local</p>
          <figure class="card_service_img">
            <img src="./img/local.jpg" alt="Local">
          </figure>
        </section>

        <section class="card_service">
          <p>Invitaciones</p>
          <figure class="card_service_img">
            <img src="./img/invitaciones.jpg" alt="Invitaciones">
          </figure>
        </section>

        <section class="card_service">
          <p>Arreglos florales</p>
          <figure class="card_service_img">
            <img src="./img/arreglos_florales.jpg" alt="Arreglos florales">
          </figure>
        </section>

      </section>
    </article>

  </main>
  <?php include "./footer.php"; ?>

</body>

</html>