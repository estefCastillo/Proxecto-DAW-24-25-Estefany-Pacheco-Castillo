const $d=document,
$loginForm=$d.querySelector("#loginForm"),
$correo=$d.querySelector("#correo"),
$contrasena=$d.querySelector("#contrasena")

function ajax(options) {
    const {url,method,fExito,fError,data}=options

    fetch(url,{
        method:method||"GET",
        headers:{
            "Content-type":"application/json; charset=utf-8"
        },
        body:JSON.stringify(data)
    })
    .then(resp=>resp.ok?resp.json():Promise.reject(resp))
    .then(json=>fExito(json))
    .catch(error=>fError(error))
}

$loginForm.addEventListener("submit",ev=>{
    ev.preventDefault();
    console.log("submititi");
    
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
        },
        data:{
            correo:correo,
            contrasena:contrasena
        }
        
    })

})