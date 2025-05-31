import ajax from "./ajaxTemplate.js";

const $d = document,
  $servicioForm = $d.querySelector("#servicioForm"),
  $nombre = $d.querySelector("#nombre"),
  $descripcion = $d.querySelector("#descripcion"),
  $precio = $d.querySelector("#precio"),
  $tipo_precio = $d.querySelector("#tipo_precio"),
  $imagen = $d.querySelector("#imagen"),
  $categoria = $d.querySelector("#categoria"),
  $ubicacion = $d.querySelector("#ubicacion");

let id_empresa = localStorage.getItem("empresa")
  ? JSON.parse(localStorage.getItem("empresa")).id
  : null;

$servicioForm.addEventListener("submit", (ev) => {
  ev.preventDefault();
  let nombre = $nombre.value.trim();
  let descripcion = $descripcion.value.trim();
  let precio = $precio.value.trim();
  let tipo_precio = $tipo_precio.value.trim();
  let imagen = $imagen.value.trim();
  let categoria = $categoria.value.trim();
  let ubicacion = $ubicacion.value.trim();

  if (
    !nombre ||
    !descripcion ||
    !precio ||
    !imagen ||
    !categoria ||
    !tipo_precio ||
    !ubicacion
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

  ajax({
    url: "http://localhost/api/index.php/servicio",
    method: "POST",
    fExito: (json) => {
        Swal.fire({
        title: "Servicio añadido!",
        icon: "success",
        timer: 1500,
        showConfirmButton: false,
      });
      $servicioForm.reset();
    },
    fError: (error) => {
      Swal.fire({
        title: "Error al añadir el servicio",
        icon: "error",
        timer: 1500,
        showConfirmButton: false,
      });
    },
    data: {
      nombre,
      descripcion,
      precio,
      tipo_precio,
      imagen,
      categoria,
      ubicacion,
      id_empresa,
    },
  });
});
