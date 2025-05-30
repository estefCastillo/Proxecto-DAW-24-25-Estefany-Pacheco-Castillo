<?php
include_once(__DIR__ . "/../modelo/UsuarioModel.php");
include_once("Controller.php");

class UsuarioController extends Controller
{
    public function get($id)
    {
        $model = new UsuarioModel();
        if (!is_numeric($id)) {
            Controller::errorMessage("Los usuarios se identifican con un solo número o id", 400);
            die();
        }

        $usuario = $model->get($id);
        if ($usuario == null) {
            Controller::errorMessage("No existe ningún usuario con ese id", 404);
            die();
        }
        echo json_encode($usuario, JSON_PRETTY_PRINT);
    }

    public function getAll()
    {
        $model = new UsuarioModel();
        $usuarios = $model->getAll();
        echo json_encode($usuarios, JSON_PRETTY_PRINT);
    }

    public function delete($id)
    {
        $model = new UsuarioModel();
        if (!is_numeric($id)) {
            Controller::errorMessage("Los usuarios se identifican con un solo id", 400);
            die();
        }

        if ($model->delete($id)) {
            echo json_encode(["message" => "Usuario eliminado con éxito!"], JSON_PRETTY_PRINT);
        } else {
            Controller::errorMessage("No se ha podido eliminar al usuario", 500);
        }
    }

    public function update($id, $object)
    {
        $model = new UsuarioModel();
        if (!is_numeric($id)) {
            Controller::errorMessage("Los usuarios se identifican con un solo id", 400);
            die();
        }

        $usuario = Usuario::fromjson($object);
        if (empty($usuario->getNombre()) || empty($usuario->getCorreo()) || empty($usuario->getContrasena())) {
            Controller::errorMessage("Todos los campos son obligatorios", 400);
            die();
        }
        $contrasena = password_hash($usuario->getContrasena(), PASSWORD_DEFAULT);
        $usuario->setContrasena($contrasena);
        if ($model->update($usuario, $id)) {
            echo json_encode(["message" => "Usuario modificado con éxito!"], JSON_PRETTY_PRINT);
        } else {
            Controller::errorMessage("No se ha podido modificar al usuario", 500);
        }
    }

    public function insert($object)
    {
        $model = new UsuarioModel();
        $usuario = Usuario::fromjson($object);

        if (empty($usuario->getNombre()) || empty($usuario->getCorreo()) || empty($usuario->getContrasena())) {
            Controller::errorMessage("Todos los campos son obligatorios", 400);
            die();
        }

        if ($model->findbyEmail($usuario->getCorreo()) != null) {
            Controller::errorMessage("Ya existe un usuario con ese correo", 409);
            die();
        }

        $contrasena = password_hash($usuario->getContrasena(), PASSWORD_DEFAULT);
        $usuario->setContrasena($contrasena);

        if ($model->insert($usuario)) {
            http_response_code(201);
            echo json_encode(["message" => "Usuario añadido con éxito!"], JSON_PRETTY_PRINT);
        } else {
            Controller::errorMessage("No se ha podido añadir al usuario", 500);
        }
    }
}
