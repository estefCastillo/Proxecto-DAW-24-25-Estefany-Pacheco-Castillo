import ajax from "./ajaxTemplate.js";

const $d = document,
  $registrerForm = $d.querySelector("#registrerForm"),
  $nombre = $d.querySelector("#nombre"),
  $correo = $d.querySelector("#correo"),
  $contrasena = $d.querySelector("#contrasena"),
  $contrasena2 = $d.querySelector("#contrasena2"),
  $e_correo = $d.querySelector("#e_correo"),
  $e_contrasena = $d.querySelector("#e_contrasena"),
  $e_contrasena2 = $d.querySelector("#e_contrasena2"),
  //obtiene la url
  url = new URLSearchParams(window.location.search),
  //obtiene el Id del usuario mediante la url
  id_usuario = url.get("id");

let admin = localStorage.getItem("usuario")
  ? JSON.parse(localStorage.getItem("usuario")).rol == "admin"
  : false;
let regex_email = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
let regex_contrasena = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

function getUsuarioInfo(){
  ajax({
    url:`http://localhost/api/index.php/usuario/${id_usuario}`, 
    method: "GET",
    fExito:json=>{
      $nombre.value=json.nombre
      $correo.value=json.correo
    },
    fError:error=>{
      Swal.fire({
        title: "No se ha podido obtener el usuario",
        icon: "error",
        timer: 1500,
        showConfirmButton: false,
      });
    }
  })
}
$d.addEventListener("DOMContentLoaded",getUsuarioInfo)
//Indica si el correo es válido
$correo.addEventListener("input", () => {
  if (!regex_email.test($correo.value.trim())) {
    $e_correo.classList.remove("valido");
    $e_correo.classList.add("error");
    $e_correo.textContent = "Formato no válido!";
  } else {
    $e_correo.classList.remove("error");
    $e_correo.classList.add("valido");
    $e_correo.textContent = "Formato válido!";
  }
});
//Indica si la contraseña es válida
$contrasena.addEventListener("input", () => {
  if (!regex_contrasena.test($contrasena.value.trim())) {
    $e_contrasena.classList.remove("valido");
    $e_contrasena.classList.add("error");
    $e_contrasena.textContent =
      "Mínimo 8 caracteres, 1 mayúscula, 1 número y 1 carácter especial";
  } else {
    $e_contrasena.classList.remove("error");
    $e_contrasena.classList.add("valido");
    $e_contrasena.textContent = "Contraseña válida!";
  }
});
//Indica si la contraseña coincide con la primera contraseña
$contrasena2.addEventListener("input", () => {
  if ($contrasena.value.trim() != $contrasena2.value.trim()) {
    $e_contrasena2.classList.remove("valido");
    $e_contrasena2.classList.add("error");
    $e_contrasena2.textContent = "Las contraseñas no coinciden";
  } else {
    if ($e_contrasena.classList.contains("valido")) {
      $e_contrasena2.classList.remove("error");
      $e_contrasena2.classList.add("valido");
      $e_contrasena2.textContent = "Las contraseñas coinciden";
    }
  }
});

//Modifica los datos de un usuario
$registrerForm.addEventListener("submit", (ev) => {
  ev.preventDefault();
  let nombre = $nombre.value.trim();
  let correo = $correo.value.trim();
  let contrasena = $contrasena.value.trim();
  let contrasena2 = $contrasena2.value.trim();

  if (!nombre || !correo || !contrasena || !contrasena2) {
    Swal.fire({
      title: "¡Error!",
      text: "Deben cubrirse todos los campos.",
      icon: "error",
      timer: 1500,
      showConfirmButton: false,
    });
    return;
  }

  if (!regex_email.test(correo)) {
    Swal.fire({
      title: "Correo inválido",
      text: "El correo electrónico ha de ser válido.",
      icon: "error",
      timer: 1500,
      showConfirmButton: false,
    });
    return;
  }

  if (!regex_contrasena.test(contrasena)) {
    Swal.fire({
      title: "Contraseña no válida",
      text: "Debe tener 8 caracteres, una mayúscula, un número y un carácter especial.",
      icon: "error",
      timer: 1500,
      showConfirmButton: false,
    });
    return;
  }
  if (contrasena != contrasena2) {
    Swal.fire({
      title: "Las contraseñas no coinciden",
      icon: "error",
      timer: 1500,
    });
    return;
  }

  ajax({
    url: `http://localhost/api/index.php/usuario/${id_usuario}`,
    method: "PUT",
    fExito: () => {
      if ($registrerForm) {
        $registrerForm.reset();
      }
      Swal.fire({
        title: "Usuario actualizado!",
        icon: "success",
        timer: 1500,
        showConfirmButton: false,
      });

      [$e_correo, $e_contrasena, $e_contrasena2].forEach((el) => {
        el.classList.remove("error", "valido");
        el.textContent = "";
      });
      if (admin) {
        window.location.href = "administration.php";
      } else {
        window.location.href = "login.php";
      }
    },

    fError: () => {
      Swal.fire({
        title: "Error al registrar",
        text: "Ya existe un usuario con ese correo.",
        icon: "error",
        timer: 1500,
      });

      if ($registrerForm) {
        $registrerForm.reset();
      }
      [$e_correo, $e_contrasena, $e_contrasena2].forEach((el) => {
        el.classList.remove("error", "valido");
        el.textContent = "";
      });
    },
    data: {
      nombre,
      correo,
      contrasena,
      rol: "usuario",
    },
  });
});
