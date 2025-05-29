import ajax from "./ajaxTemplate.js";

const $d = document,
  $registrerForm = $d.querySelector("#registrerForm"),
  $nombre = $d.querySelector("#nombre"),
  $correo = $d.querySelector("#correo"),
  $telefono = $d.querySelector("#telefono"),
  $contrasena = $d.querySelector("#contrasena"),
  $contrasena2 = $d.querySelector("#contrasena2"),
  $e_correo = $d.querySelector("#e_correo"),
  $e_contrasena = $d.querySelector("#e_contrasena"),
  $e_contrasena2 = $d.querySelector("#e_contrasena2"),
  $e_tel = $d.querySelector("#e_tel");

let regex_email = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
let regex_contrasena = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

$correo.addEventListener("input", (ev) => {
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

$telefono.addEventListener("input", (ev) => {
  if ($telefono.value.length != 9) {
    $e_tel.classList.remove("valido");
    $e_tel.classList.add("error");
    $e_tel.textContent = "Número no válido, tiene que tener nueve dígitos";
  } else {
    $e_tel.classList.remove("error");
    $e_tel.classList.add("valido");
    $e_tel.textContent = "Número válido!";
  }
});
$contrasena.addEventListener("input", (ev) => {
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

$contrasena2.addEventListener("input", (ev) => {
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

$registrerForm.addEventListener("submit", (ev) => {
  ev.preventDefault();
  let nombre = $nombre.value.trim();
  let correo = $correo.value.trim();
  let contrasena = $contrasena.value.trim();
  let contrasena2 = $contrasena2.value.trim();
  let telefono = $telefono.value.trim();

  if (!nombre || !correo || !contrasena || telefono || !contrasena2) {
    Swal.fire({
      title: "Deben cubrirse todos los campos!",
      icon: "error",
      timer: 1500,
    });
    return;
  }

  if (!regex_email.test(correo)) {
    Swal.fire({
      title: "El correo electrónico ha de ser válido!",
      icon: "error",
      timer: 1500,
    });
    return;
  }

  if (!regex_contrasena.test(contrasena)) {
    Swal.fire({
      title: "Contraseña no válida!",
      text: "Debe tener 8 caracteres, al menos una letra mayúscula, un caracter especial y al menos un número",
      icon: "error",
      timer: 1500,
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
    url: "http://localhost/api/index.php/usuario",
    method: "POST",
    fExito: (json) => {
      if ($registrerForm) {
        $registrerForm.reset();
      }
      alert(json.message);
      [$e_correo, $e_contrasena, $e_contrasena2].forEach((el) => {
        el.classList.remove("error", "valido");
        el.textContent = "";
      });
      window.location.href = "ad_empresas.php";
    },

    fError: (error) => {
      console.log(error);
      alert("Error al insertar el usuario");
      if ($registrerForm) {
        $registrerForm.reset();
      }
      [$e_correo, $e_contrasena, $e_contrasena2].forEach((el) => {
        el.classList.remove("error", "valido");
        el.textContent = "";
      });
    },
    data: {
      nombre: nombre,
      correo: correo,
      telefono: telefono,
      contrasena: contrasena,
    },
  });
});
