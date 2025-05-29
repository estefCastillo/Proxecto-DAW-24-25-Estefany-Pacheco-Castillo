import ajax from "./ajaxTemplate.js";

const $d = document,
  $tbody = $d.querySelector("tbody");

let id_usuario = localStorage.getItem("usuario")
  ? JSON.parse(localStorage.getItem("usuario")).id
  : null;

$d.addEventListener("DOMContentLoaded", (ev) => {
  const $btnUser = $d.querySelector(".btn-login"),
    $vLogin = $d.querySelector("#login"),
    $logout = $d.querySelector("#logout");

  $btnUser.addEventListener("click", () => {
    if ($vLogin) {
      $vLogin.classList.toggle("hidden");
    }
  });

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

  getReservas();
});

function getReservas() {
  ajax({
    url: `http://localhost/api/index.php/reserva/usuario/${id_usuario}`,
    method: "GET",
    fExito: (json) => {
      if (json.length == 0) {
        return $tbody.innerHTML = `
        <tr>
          <td colspan="6">No se han encontrado reservas a su nombre.</td>
        </tr>`;
        
      }

      ajax({
        url: "http://localhost/api/index.php/servicio",
        method: "GET",
        fExito: (servicios) => {
          $tbody.innerHTML = json
            .map((el) => {
              let s = servicios.find(
                (servicio) => servicio.id_servicio == el.id_servicio
              );
              return `
                <tr>
                  <td>${s.nombre}</td>
                  <td>${el.fecha}</td>
                  <td>${el.estado}</td>
                  <td>${(s.precio * el.cantidad).toFixed(2)}</td>
                  <td>
                    <button class="btn-cancel" aria-label="Cancelar reserva" data-id="${
                      el.id_reserva
                    }">
                      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                        <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/>
                      </svg>
                    </button>
                  </td>
                </tr>`;
            })
            .join("");

          // Cancelar reserva
          setTimeout(() => {
            $d.querySelectorAll(".btn-cancel").forEach((btn) => {
              btn.addEventListener("click", () => {
                const id = btn.dataset.id;

                Swal.fire({
                  title: "¿Está seguro de cancelar su reserva?",
                  icon: "warning",
                  showCancelButton: true,
                  cancelButtonColor: "#681717",
                  confirmButtonColor: "#3E7255",
                  confirmButtonText: "Cancelar reserva",
                  cancelButtonText: "No",
                }).then((result) => {
                  if (result.isConfirmed) {
                    ajax({
                      url: `http://localhost/api/index.php/reserva/${id_usuario}/${id}`,
                      method: "DELETE",
                      fExito: () => {
                        Swal.fire({
                          title: "¡Cancelada!",
                          text: "Su reserva ha sido cancelada.",
                          icon: "success",
                          timer: 1500
                        }).then(()=>{getReservas()})
                        
                      },
                      fError: (error) => {
                        console.error(error);
                      },
                    });
                  }
                });
              });
            });
          }, 100);
        },
        fError: (error) => {
          console.log(error);
        },
      });
    },
    fError: (error) => {
      console.log(error);
    },
  });
}
