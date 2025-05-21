import ajax from "./ajaxTemplate.js";

const $d=document,
$loginForm=$d.querySelector("#loginForm"),
$correo=$d.querySelector("#correo").value.trim(),
$contrasena=$d.querySelector("#contrasena").value.trim()

$loginForm.addEventListener("submit",ev=>{
    ev.preventDefault();
    
    let correo=$correo.value
    let contrasena=$contrasena.value

    if (!correo.trim() || !contrasena.trim()) {
        alert("Deben cubrirse todos los campos");
        return;
    }
    
    ajax({
        url:"http://localhost/api/login.php",
        method:"POST",
        fExito:json=>{
            localStorage.setItem("tipo", json.tipo);
            localStorage.setItem("nombre", json.nombre);
            localStorage.setItem("correo", json.correo);
            localStorage.setItem("id", json.id);

              if (json.tipo=="usuario") {
                window.location.href = "principal.html";
              } else if(json.tipo=="empresa") {
                window.location.href = "empresa.html";
              }
        },
        fError:error=>{
            console.log(error);
            alert("Correo o contraseña incorrectos")
            $loginForm.reset();
        },
        data:{
            correo:correo,
            contrasena:contrasena
        }
        
    })

})