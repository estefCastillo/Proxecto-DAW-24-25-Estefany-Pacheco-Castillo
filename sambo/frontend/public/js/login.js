import ajax from "./ajaxTemplate.js";

const $d=document,
$loginForm=$d.querySelector("#loginForm"),
$correo=$d.querySelector("#correo"),
$contrasena=$d.querySelector("#contrasena")

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
            localStorage.setItem("usuario", JSON.stringify(json));
              if (json.tipo=="usuario") {
                window.location.href = "principal.php";
              } else if(json.tipo=="empresa") {
                window.location.href = "empresa.php";
              } else if(json.tipo == "admin"){
                window.location.href = "administration.php";

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