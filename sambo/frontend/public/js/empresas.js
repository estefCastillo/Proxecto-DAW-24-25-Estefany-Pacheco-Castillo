import ajax from "./ajaxTemplate.js";

const $d = document,
  $tbody = $d.querySelector("tbody");

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
        fExito: (json) => {
          localStorage.removeItem("usuario");
          window.location.href = "index.php";
        },
        fError: (error) => {
          Swal.fire({
            title: "No se ha podido cerrar sesión",
            icon: "error",
            timer: 1500,
          });
        },
      });
    });
  }
  getEmpresas();
});

function getEmpresas() {
  ajax({
    url: "http://localhost/api/index.php/empresa",
    method: "GET",
    fExito: (json) => {
      $tbody.innerHTML = json
        .map(
          (el) => `
                <tr>
                  <td>${el.nombre_empresa}</td>
                  <td><a href="mailto:${el.correo}">${el.correo}</a></td>
                  <td>${el.telefono}</td>
                  <td colspan="2">
                    <button class="btn-delete" aria-label="Eliminar empresa" data-id="${el.id_empresa}">
                      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                        <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/>
                      </svg>
                    </button>
                  -
                    <button class="btn-edit" onclick="location.href='edit_empresa.php?id=${el.id_empresa}'" aria-label="Editar empresa">
                      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                    </button>
                  </td>
                </tr>`
        )
        .join("");
    },
    fError: (error) => {
      Swal.fire({
        title: "Error al obtener las empresas",
        icon: "error",
        timer: 1500,
      });
    },
  });
}

$tbody.addEventListener("click", (ev) => {
  ev.preventDefault();
  if (ev.target.closest(".btn-delete")) {
    let id_empresa = ev.target.closest(".btn-delete").dataset.id;
    Swal.fire({
      title: "¿Está seguro de eliminar esta empresa?",
      icon: "warning",
      showCancelButton: true,
      cancelButtonColor: "#681717",
      confirmButtonColor: "#3E7255",
      confirmButtonText: "Eliminar empresa",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        ajax({
          url: `http://localhost/api/index.php/empresa/${id_empresa}`,
          method: "DELETE",
          fExito: (json) => {
            Swal.fire({
              title: "Empresa eliminada con éxito!",
              icon: "success",
              timer: 1500,
            }).then(() => {
              getEmpresas();
            });
          },
          fError: (error) => {
            Swal.fire({
              title: "No se ha podido eliminar",
              icon: "error",
              timer: 1500,
            });
          },
        });
      }
    });
  }
});
