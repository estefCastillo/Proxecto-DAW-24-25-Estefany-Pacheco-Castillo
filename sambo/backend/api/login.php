<?php
session_set_cookie_params(60);
session_start();
include_once("modelo/EmpresaModel.php");
include_once("modelo/UsuarioModel.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

$json = file_get_contents("php://input",true);
$data= json_decode($json,true);
$correo = trim($data["correo"]);
$contrasena = trim($data["contrasena"]);

if (!isset($correo) || !isset($contrasena)) {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["error" => "Ambos campos son obligatorios"],JSON_PRETTY_PRINT);
    exit();
}

$usuarioModel=new UsuarioModel();
$usuario=$usuarioModel->findbyEmail($correo);

$empresaModel=new EmpresaModel();
$empresa=$empresaModel->findbyEmail($correo);

if ($usuario!=null) {
    if (password_verify($contrasena,$usuario->getContrasena())) {
        $rol=$usuario->getRol();
        $_SESSION["rol"]=$rol;
        $_SESSION["id_usuario"]=$usuario->getId_usuario();
        $_SESSION["nombre"]=$usuario->getNombre();
        $_SESSION["correo"]=$usuario->getCorreo();

        echo json_encode([
            "rol" => $rol,
            "id" => $usuario->getId_usuario(),
            "nombre" => $usuario->getNombre(),
            "correo" => $usuario->getCorreo()
        ], JSON_PRETTY_PRINT);
        exit();
    }else{
        header("HTTP/1.1 401 Unauthorized");
        echo json_encode(["error" => "Contraseña incorrecta"],JSON_PRETTY_PRINT);
        exit();
    }

}

if ($empresa!=null) {
    if (password_verify($contrasena,$empresa->getContrasena())) {
        $_SESSION["rol"] = "empresa";
        $_SESSION["id_empresa"] = $empresa->getId_empresa();
        $_SESSION["nombre"] = $empresa->getNombre_empresa();

        echo json_encode([
            "rol" => "empresa",
            "id" => $empresa->getId_empresa(),
            "nombre" => $empresa->getNombre_empresa(),
            "correo" => $empresa->getCorreo()
        ], JSON_PRETTY_PRINT);
        exit();
    }else{
        header("HTTP/1.1 401 Unauthorized");
        echo json_encode(["error" => "Contraseña incorrcta"],JSON_PRETTY_PRINT);
        exit();
    }
}

header("HTTP/1.1 404 Not Found");
echo json_encode(["error" => "Correo incorrecto"], JSON_PRETTY_PRINT);
exit();