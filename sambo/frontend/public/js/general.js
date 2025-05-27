import ajax from "./ajaxTemplate.js";

const $d = document,
  $btnCategories = $d.querySelector(".btn-categories"),
  $servicios = $d.querySelector(".card_services"),
  $researchForm = $d.querySelector("#researchForm"),
  $research = $d.querySelector("#research");

let allServices = [];
let id_usuario = localStorage.getItem("usuario")
  ? JSON.parse(localStorage.getItem("usuario")).id
  : null;

$d.addEventListener("DOMContentLoaded", (ev) => {
  const $btnUser = $d.querySelector(".btn-login"),
    $vLogin = $d.querySelector("#login"),
    $logout = $d.querySelector("#logout");

  $btnUser.addEventListener("click", (ev) => {
    if ($btnUser && $vLogin) {
      $vLogin.classList.toggle("hidden")
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
          console.log(error);
        },
      });
    });
  }

  renderCategories();
  fetchServicios();
});

// Se mostrarán los botones de filtrado por categoría
function renderCategories() {
  ajax({
    url: "http://localhost/api/index.php/servicio/categorias",
    method: "GET",
    fExito: (json) => {
      $btnCategories.innerHTML = `
      <button type="button" data-name="todos">Todos</button>
  ${json
    .map(
      (el) =>
        `<button type="button" data-name="${el.toLowerCase()}">${el}</button>`
    )
    .join("")}
`;
    },
    fError: (error) => {
      console.log(error);
    },
  });
}

$btnCategories.addEventListener("click", (ev) => {
  ev.preventDefault();
  if (ev.target.tagName == "BUTTON") {
    let categoria = ev.target.dataset.name.toLowerCase();
    renderServicios(categoria);
  }
});

function fetchServicios() {
  ajax({
    url: "http://localhost/api/index.php/servicio",
    method: "GET",
    fExito: (json) => {
      allServices = json;
      filtrarServicios("todos");
    },
    fError: console.log,
  });
}

function filtrarServicios(categoria) {
  const servicios =
    categoria === "todos"
      ? allServices
      : allServices.filter((el) => el.categoria.toLowerCase() === categoria);
  showServicios(servicios);
}


function showServicios(servicios) {
  if (!servicios.length) {
     return  $servicios.innerHTML =
      "<p>No se ha encontrado ningún servicio con ese nombre</p>";
   
  }

  $servicios.innerHTML = servicios
    .map(
      (el) => `
    <article class="service">
      <a href="service.php?id=${el.id_servicio}">
        <figure class="service_img">
          <img src="${el.imagen}" alt="${el.descripcion}" />
        </figure>
      </a>
      <section class="info">
        <ul>
          <li><strong>${el.nombre}</strong></li>
          <li>${el.precio}€/ ${el.tipo_precio}</li>
          <li>${el.ubicacion}</li>
        </ul>
        <button class="btn-favorite" aria-label="Añadir a favoritos" data-id="${el.id_servicio}">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#3E7255">
            <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/>
          </svg>
        </button>
      </section>
    </article>`
    )
    .join("");
}

function handleSearch() {
  const buscado = $research.value.toLowerCase().trim();
  const filtrado = allServices.filter((el) =>
    el.nombre.toLowerCase().includes(buscado)
  );
  showServicios(buscado ? filtrado : allServices);
}

$research.addEventListener("input", handleSearch);
$researchForm.addEventListener("submit", (ev) => {
  ev.preventDefault();
  handleSearch();
});

$servicios.addEventListener("click", (ev) => {
  if (ev.target.closest(".btn-favorite").dataset.id) {
    let id_servicio = ev.target.closest(".btn-favorite").dataset.id;
    if (!id_usuario) {
      window.location.href = "login.php";
      return;
    }

    ajax({
      url: "http://localhost/api/index.php/favorito",
      method: "POST",
      fExito: (json) => {
        alert(json.message);
      },
      fError: (error) => {
        console.log(error);
      },
      data: { id_usuario, id_servicio },
    });
  }
});
