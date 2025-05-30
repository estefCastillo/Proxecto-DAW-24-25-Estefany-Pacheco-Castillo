export default function ajax(options) {
  const { url, method, fExito, fError, data } = options;

  fetch(url, {
    method: method || "GET",
    headers: {
      "Content-type": "application/json; charset=utf-8",
    },
    credentials: "include",
    body: JSON.stringify(data),
  })
    .then((resp) => {
      if (resp.ok) {
        return resp.json();
      } else {
        if (resp.status == 401) {
          localStorage.removeItem("usuario");
          localStorage.removeItem("empresa");
          window.location.href = "login.php";
        }
        return Promise.reject(resp);
      }
    })
    .then((json) => fExito(json))
    .catch((error) => fError(error));
}
