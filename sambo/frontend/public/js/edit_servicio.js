import ajax from "./ajaxTemplate.js";

const $d = document,
  $servicioForm = $d.querySelector("#servicioForm"),
  $nombre = $d.querySelector("#nombre"),
  $descripcion = $d.querySelector("#descripcion"),
  $precio = $d.querySelector("#precio"),
  $tipo_precio = $d.querySelector("#tipo_precio"),
  $imagen = $d.querySelector("#imagen"),
  $categoria = $d.querySelector("#categoria"),
  $ubicacion = $d.querySelector("#ubicacion"),
  //obtiene la url
  url = new URLSearchParams(window.location.search),
  //obtiene el Id del servicio mediante la url
  id_servicio = url.get("id");

let id_empresa = localStorage.getItem("empresa")
  ? JSON.parse(localStorage.getItem("empresa")).id
  : null;

//Edita un servicio
$servicioForm.addEventListener("submit", (ev) => {
  ev.preventDefault();
  let nombre = $nombre.value.trim();
  let descripcion = $descripcion.value.trim();
  let precio = parseFloat($precio.value.trim());
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
    url: `http://localhost/api/index.php/servicio/${id_servicio}`,
    method: "PUT",
    fExito: () => {
      Swal.fire({
        title: "Servicio modificado!",
        icon: "success",
        timer: 1500,
        showConfirmButton: false,
      });
      $servicioForm.reset();
      window.location.href = "empresa.php";
    },
    fError: () => {
      Swal.fire({
        title: "Error al editar el servicio",
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
