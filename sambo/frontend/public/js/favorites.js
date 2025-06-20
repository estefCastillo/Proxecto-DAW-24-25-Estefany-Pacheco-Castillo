import ajax from "./ajaxTemplate.js";

const $d = document,
  $favoritos = $d.querySelector(".card_services");

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
  renderFavoritos();
});

//Muestra la lista de favoritos de los usuarios
function renderFavoritos() {
  ajax({
    url: `http://localhost/api/index.php/favorito/usuario/${id_usuario}`,
    method: "GET",
    fExito: (favoritos) => {
      if (favoritos.length == 0) {
        return ($favoritos.innerHTML = `<p>Aún no tienes favoritos guardados.</p>`);
      } else {
        ajax({
          url: "http://localhost/api/index.php/servicio",
          method: "GET",
          fExito: (servicios) => {
            $favoritos.innerHTML = favoritos
              .map((el) => {
                let s = servicios.find((s) => s.id_servicio == el.id_servicio);

                return `
                <article class="service">
                  <figure class="service_img">
                    <img src="${s.imagen}" alt="${s.descripcion}" />
                  </figure>
                  <section class="info">
                    <ul>
                      <li><strong>${s.nombre}</strong></li>
                      <li>${s.precio}€/ ${s.tipo_precio}</li>
                      <li>${s.ubicacion}</li>
                    </ul>
                    <button class="btn-favorite" aria-label="Eliminar de favoritos" data-id="${el.id_favorito}">
                      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                        <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/>
                      </svg>
                    </button>
                  </section>
                </article>
              `;
              })
              .join("");
          },
          fError: () => {
            Swal.fire({
              title: "Error al obtener los servicios",
              icon: "error",
              timer: 1500,
            });
          },
        });
      }
    },
    fError: () => {
      Swal.fire({
        title: "Error al obtener los favoritos",
        icon: "error",
        timer: 1500,
      });
    },
  });
}

//Elimina de favoritos un servicio
$favoritos.addEventListener("click", (ev) => {
  if (ev.target.closest(".btn-favorite").dataset.id) {
    let id_favorito = ev.target.closest(".btn-favorite").dataset.id;
    Swal.fire({
      title: "¿Quieres eliminar este servicio de favoritos?",
      icon: "warning",
      showCancelButton: true,
      cancelButtonColor: "#681717",
      confirmButtonColor: "#3E7255",
      confirmButtonText: "Si",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        ajax({
          url: `http://localhost/api/index.php/favorito/${id_usuario}/${id_favorito}`,
          method: "DELETE",
          fExito: () => {
            Swal.fire({
              title: "¡Eliminado de favoritos!",
              icon: "success",
              timer: 1500,
            });
            renderFavoritos();
          },
          fError: () => {
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
