import ajax from "./ajaxTemplate.js";

const $d = document,
  $loginForm = $d.querySelector("#loginForm"),
  $correo = $d.querySelector("#correo"),
  $contrasena = $d.querySelector("#contrasena");

//Inicia sesión y redirige al usuario
$loginForm.addEventListener("submit", (ev) => {
  ev.preventDefault();
  let correo = $correo.value;
  let contrasena = $contrasena.value;

  if (!correo.trim() || !contrasena.trim()) {
    Swal.fire({
      title: "Deben cubrirse todos los campos",
      icon: "warning",
      timer: 1500,
    });
    return;
  }

  ajax({
    url: "http://localhost/api/login.php",
    method: "POST",
    fExito: (json) => {
      if (json.rol == "usuario") {
        localStorage.setItem("usuario", JSON.stringify(json));
        window.location.href = "principal.php";
      } else if (json.rol == "empresa") {
        localStorage.setItem("empresa", JSON.stringify(json));
        window.location.href = "empresa.php";
      } else if (json.rol == "admin") {
        localStorage.setItem("usuario", JSON.stringify(json));
        window.location.href = "administration.php";
      }
    },
    fError: () => {
      Swal.fire({
        title: "No se ha podido iniciar sesión",
        icon: "error",
        timer: 1500,
      });
      $loginForm.reset();
    },
    data: {
      correo,
      contrasena,
    },
  });
});
