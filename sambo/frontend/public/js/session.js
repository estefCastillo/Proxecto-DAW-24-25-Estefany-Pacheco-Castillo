//Elimina del localStoragge la información del usuario/empresa si la sesión está caducada
function checkSession() {
  fetch("http://localhost/api/session.php")
    .then((res) => res.json())
    .then((json) => {
      if (!json.activa) {
        localStorage.removeItem("usuario");
        localStorage.removeItem("empresa");
        window.location.href = "index.php";
      }
    })
    .catch((error) => console.error(error));
}

setInterval(checkSession, 3600000);
