import ajax from "./ajaxTemplate.js";

const $d = document,
  $main = $d.querySelector("#s-reserva"),
  url = new URLSearchParams(window.location.search),
  id_servicio = url.get("id");

//Obtiene el id del usuario
let id_usuario = localStorage.getItem("usuario")
  ? JSON.parse(localStorage.getItem("usuario")).id
  : null;

$d.addEventListener("DOMContentLoaded", () => {
  let $btnUser = $d.querySelector(".btn-login"),
    $vLogin = $d.querySelector("#login"),
    $logout = $d.querySelector("#logout");

  $btnUser.addEventListener("click", () => {
    if ($btnUser && $vLogin) {
      $vLogin.classList.toggle("hidden");
    }
  });

  if ($logout) {
    $logout.addEventListener("click", (ev) => {
      ev.preventDefault();
      ajax({
        url: "http://localhost/api/logout.php",
        method: "POST",
        fExito: () => {
          localStorage.removeItem("usuario");
          window.location.href = "index.php";
        },
        fError: () => {
          Swal.fire({
            title: "No se ha podido cerrar sesión",
            icon: "error",
            timer: 1500,
          });
        },
      });
    });
  }

  getServicio();
});
//Obtiene la información del servicio
function getServicio() {
  ajax({
    url: `http://localhost/api/index.php/servicio/${id_servicio}`,
    method: "GET",
    fExito: (servicio) => {
      renderServicio(servicio);
    },
    fError: () => {
      Swal.fire({
        title: "Error al obtener el servicio",
        icon: "error",
        timer: 1500,
      });
    },
  });
}
//Renderiza el servicio
function renderServicio(servicio) {
  $main.innerHTML = `
  <section class="info-service">
    <h2>${servicio.nombre}</h2>
    <figure>
      <img src="${servicio.imagen}" alt="${servicio.descripcion}">
    </figure>
    <ul>
      <li><strong>Ubicación:</strong> ${servicio.ubicacion}</li>
      <li><strong>Categoría:</strong> ${servicio.categoria}</li>
      <li><strong>Precio:</strong> ${servicio.precio}€ / ${servicio.tipo_precio}</li>
      <li>${servicio.descripcion}</li>
    </ul>
  </section>

  <section class="form-reserva">
    <h3>Reservar este servicio</h3>
    <form id="reservaForm">
      <label>Fecha:</label>
      <input type="date" name="fecha" id="fecha" required />
      <label>Cantidad:</label>
      <input type="number" name="cantidad" min="1" required />
      <button type="submit">Reservar</button>
    </form>
  </section>`;
  //Limita la opción de realizar las reservas al día
  let fecha = $d.querySelector("#fecha");
  let fecha_actual = new Date();
  let anho = fecha_actual.getFullYear();
  let mes = (fecha_actual.getMonth() + 1).toString().padStart(2, "0");
  let dia = fecha_actual.getDate().toString().padStart(2, "0");

  let hoy = `${anho}-${mes}-${dia}`;
  fecha.min = hoy;

  //Realiza la reserva si ya ha iniciado la sesión
  let $form = $d.querySelector("#reservaForm");

  $form.addEventListener("submit", (ev) => {
    ev.preventDefault();
    if (!id_usuario) {
      Swal.fire({
        title: "Necesita estar registrado",
        text: "Será redirigido al login.",
        icon: "warning",
        timer: 1300,
      }).then(() => {
        window.location.href = "login.php";
      });
      return;
    }
    let fecha = $form.fecha.value;
    let cantidad = $form.cantidad.value;
    let totalPrice = servicio.precio * cantidad;
    if (fecha < hoy) {
      Swal.fire({
        title: "Fecha inválida",
        text: "No se pueden hacer reservas en fechas pasadas.",
        icon: "warning",
        timer: 1500,
      });
      return;
    }
    ajax({
      url: "http://localhost/api/index.php/reserva",
      method: "POST",
      fExito: (json) => {
        Swal.fire({
          title: "¡Reserva realizada!",
          html: `Total: <strong>${totalPrice.toFixed(2)}€</strong>`,
          showConfirmButton: false,
          icon: "success",
          timer: 1500,
        });
        $form.reset();
      },
      fError: () => {
        Swal.fire({
          title: "No se ha podido reservar",
          icon: "error",
          timer: 1500,
        });
      },
      data: {
        id_usuario,
        id_servicio: servicio.id_servicio,
        fecha,
        cantidad,
        precio_total: totalPrice,
        estado: "pendiente",
      },
    });
  });
}
