import ajax from "./ajaxTemplate.js";

const $d = document,
  $main = $d.querySelector("#s-reserva"),
  url = new URLSearchParams(window.location.search),
  id_servicio = url.get("id");

let id_usuario = localStorage.getItem("usuario")
  ? JSON.parse(localStorage.getItem("usuario")).id
  : null;

$d.addEventListener("DOMContentLoaded", () => {
  const $btnUser = $d.querySelector(".btn-login"),
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
        fError: (error) => {
          console.log(error);
        },
      });
    });
  }

  getServicio();
});

function getServicio() {
  ajax({
    url: `http://localhost/api/index.php/servicio/${id_servicio}`,
    method: "GET",
    fExito: (servicio) => {
      renderServicio(servicio);
    },
    fError: (error) => {
      console.error(error);
    },
  });
}

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
      <input type="date" name="fecha" required />
      <label>Cantidad:</label>
      <input type="number" name="cantidad" min="1" required />
      <button type="submit">Reservar</button>
    </form>
  </section>`;

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
      return
    }
    let fecha = $form.fecha.value;
    let cantidad = $form.cantidad.value;
    let totalPrice = servicio.precio * cantidad;

    ajax({
      url: "http://localhost/api/index.php/reserva",
      method: "POST",
      fExito: (json) => {
        alert(
          `Reserva realizada correctamente.\nTotal: ${totalPrice.toFixed(2)}€`
        );
        $form.reset();
      },
      fError: (error) => {
        console.log(error)
      },
      data: {
        id_usuario: id_usuario,
        id_servicio: servicio.id_servicio,
        fecha,
        cantidad,
        estado: "pendiente",
      },
    });
  });
}
