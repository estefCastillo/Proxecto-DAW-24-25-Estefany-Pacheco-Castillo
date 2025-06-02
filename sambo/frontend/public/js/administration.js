import ajax from "./ajaxTemplate.js";

const $d = document,
  $cards = $d.querySelector(".card_administrar");

$d.addEventListener("DOMContentLoaded", (ev) => {
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
});
//Redirige al usuario administrador
$cards.addEventListener("click", (ev) => {
  ev.preventDefault();
  if (ev.target.closest("button").classList.contains("admin-empresas")) {
    window.location.href = "ad_empresas.php";
  } else if (ev.target.closest("button").classList.contains("admin-usuarios")) {
    window.location.href = "ad_usuarios.php";
  }
});
