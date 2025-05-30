import ajax from "./ajaxTemplate.js";

const $d = document,
  $registrerForm = $d.querySelector("#registrerForm"),
  $nombre = $d.querySelector("#nombre_empresa"),
  $correo = $d.querySelector("#correo"),
  $direccion = $d.querySelector("#direccion"),
  $telefono = $d.querySelector("#telefono"),
  $contrasena = $d.querySelector("#contrasena"),
  $contrasena2 = $d.querySelector("#contrasena2"),
  $e_correo = $d.querySelector("#e_correo"),
  $e_contrasena = $d.querySelector("#e_contrasena"),
  $e_contrasena2 = $d.querySelector("#e_contrasena2"),
  $e_tel = $d.querySelector("#e_tel"),
  url = new URLSearchParams(window.location.search)

let id_empresa = "";

if (url.get("id")) {
  id_empresa = url.get("id");
} else {
  id_empresa = JSON.parse(localStorage.getItem("empresa")).id;
}

console.log(id_empresa);

let admin = localStorage.getItem("usuario")
  ? JSON.parse(localStorage.getItem("usuario")).rol == "admin"
  : false;

let regex_tel = /^[0-9]{9}$/;
let regex_email = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
let regex_contrasena = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

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

$telefono.addEventListener("input", () => {
  if (!regex_tel.test($telefono.value.trim())) {
    $e_tel.classList.remove("valido");
    $e_tel.classList.add("error");
    $e_tel.textContent = "Número no válido, tiene que tener nueve dígitos";
  } else {
    $e_tel.classList.remove("error");
    $e_tel.classList.add("valido");
    $e_tel.textContent = "Número válido!";
  }
});

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

$registrerForm.addEventListener("submit", (ev) => {
  ev.preventDefault();
  let nombre = $nombre.value.trim();
  let correo = $correo.value.trim();
  let contrasena = $contrasena.value.trim();
  let contrasena2 = $contrasena2.value.trim();
  let telefono = $telefono.value.trim();
  let direccion = $direccion.value.trim();

  if (
    !nombre ||
    !correo ||
    !contrasena ||
    !telefono ||
    !direccion ||
    !contrasena2
  ) {
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
      showConfirmButton: false,
    });
    return;
  }

  ajax({
    url: `http://localhost/api/index.php/empresa/${id_empresa}`,
    method: "PUT",
    fExito: (json) => {
      if ($registrerForm) {
        $registrerForm.reset();
      }
      Swal.fire({
        title: "Empresa modificada con éxito!",
        icon: "success",
        timer: 1500,
        showConfirmButton: false,
      }).then(() => {
        if (admin) {
        window.location.href = "ad_empresas.php";
      } else {
              ajax({
                url: "http://localhost/api/logout.php",
                method: "POST",
                fExito: (json) => {
                  localStorage.removeItem("empresa");
                  window.location.href = "login.php";
                },
                fError: (error) => {
                  Swal.fire({
                    title: "No se ha podido cerrar sesión",
                    icon: "error",
                    timer: 1500,
                  });
                },
              });
      }
      });

      [$e_correo, $e_contrasena, $e_contrasena2].forEach((el) => {
        el.classList.remove("error", "valido");
        el.textContent = "";
      });
    },
    fError: (error) => {
      Swal.fire({
        title: "Error al modificar la empresa",
        text: "El correo electrónico ya existe",
        icon: "error",
        timer: 1500,
        showConfirmButton: false,
      });

      if ($registrerForm) {
        $registrerForm.reset();
      }

      [$e_correo, $e_tel, $e_contrasena, $e_contrasena2].forEach((el) => {
        el.classList.remove("error", "valido");
        el.textContent = "";
      });
    },
    data: {
      nombre_empresa: nombre,
      correo: correo,
      direccion: direccion,
      telefono: telefono,
      contrasena: contrasena,
    },
  });
});
