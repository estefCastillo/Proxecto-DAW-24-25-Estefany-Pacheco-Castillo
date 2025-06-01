import ajax from "./ajaxTemplate.js";

const $d = document,
  $tbody = $d.querySelector("tbody");

let id_empresa = localStorage.getItem("empresa")
  ? JSON.parse(localStorage.getItem("empresa")).id
  : null;

$d.addEventListener("DOMContentLoaded", (ev) => {
  let $btnUser = $d.querySelector(".btn-login"),
    $vLogin = $d.querySelector("#login"),
    $logout = $d.querySelector("#logout");

  $btnUser.addEventListener("click", (ev) => {
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
          localStorage.removeItem("empresa");
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
  getReservas();
});
//Renderiza las reservas de una empresa en concreto
function getReservas() {
  ajax({
    url: `http://localhost/api/index.php/reserva/${id_empresa}`,
    method: "GET",
    fExito: (reservas) => {
      if (reservas.length == 0) {
        $tbody.innerHTML = `
          <tr>
            <td colspan="5">Aún no tiene reservas</td>
          </tr>`;
        return;
      }

      ajax({
        url: "http://localhost/api/index.php/usuario",
        method: "GET",
        fExito: (usuarios) => {
          $tbody.innerHTML = reservas
            .map((el) => {
              let correo = usuarios.find(
                (u) => u.id_usuario == el.id_usuario
              ).correo;
              let estado = "";
              if (el.estado.toLowerCase() == "pendiente") {
                estado = "pendiente";
              } else if (el.estado.toLowerCase() == "realizada") {
                estado = "realizada";
              }
              return `
                <tr>
                  <td>${el.fecha}</td>
                  <td>${el.cantidad}</td>
                  <td>${el.precio_total}</td>
                  <td class="${estado}">${el.estado.toUpperCase()}</td>
                  <td><a href="mailto:${correo}">${correo}</a></td>
                </tr>`;
            })
            .join("");
        },
        fError: () => {
          Swal.fire({
            title: "Error al obtener usuarios",
            icon: "error",
            timer: 1500,
          });
        },
      });
    },
    fError: () => {
      Swal.fire({
        title: "Error al obtener las reservas",
        icon: "error",
        timer: 1500,
      });
    },
  });
}
