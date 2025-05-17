
// Importar los componentes 
import "./header.js";
import "./footer.js";

// Definición de las constantes
const $d = document

$d.addEventListener("DOMContentLoaded",ev=>{
    customElements.whenDefined("header-component").then(()=>{
        const $btnUser = $d.querySelector(".btn-login"),
        $vLogin = $d.querySelector("#login");
        // Se añade un evento para mostrar/ocultar la ventana de acceso, a través de la clase hidden
        $btnUser.addEventListener("click", (ev) => {
        $vLogin.classList.contains("hidden")?$vLogin.classList.remove("hidden"): $vLogin.classList.add("hidden");
          });
    })
})

 
