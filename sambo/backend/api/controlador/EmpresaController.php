<?php
include_once(__DIR__ . "/../modelo/EmpresaModel.php");
include_once("Controller.php");
class EmpresaController extends Controller
{

    public function get($id)
    {
        $model = new EmpresaModel();
        if (!is_numeric($id)) {
            Controller::errorMessage("Las empresas se identifican con un solo número o id", 400);
            die();
        }
        $empresa = $model->get($id[0]);
        if ($empresa == null) {
            Controller::errorMessage("No existe ninguna empresa con ese id", 404);
            die();
        }
        echo json_encode($empresa, JSON_PRETTY_PRINT);
    }

    public function getAll()
    {
        $model = new EmpresaModel();
        $empresas = $model->getAll();
        echo json_encode($empresas, JSON_PRETTY_PRINT);
    }

    public function delete($id)
    {
        $model = new EmpresaModel();
        if (!is_numeric($id)) {
            Controller::errorMessage("Las empresas se identifican con un solo id", 400);
            die();
        }

        if ($model->delete($id)) {
            echo json_encode(["message" => "Empresa eliminada con éxito!"], JSON_PRETTY_PRINT);
        } else {
            Controller::errorMessage("No se ha podido eliminar la empresa", 500);
        }
    }

    public function update($id, $object)
    {
        $model = new EmpresaModel();
        if (!is_numeric($id)) {
            Controller::errorMessage("Las empresas se identifican con un solo id", 400);
            die();
        }

        $empresa = Empresa::fromjson($object);
        if (empty(trim($empresa->getNombre_empresa())) || empty(trim($empresa->getCorreo())) || empty(trim($empresa->getContrasena())) || empty(trim($empresa->getTelefono())) || empty(trim($empresa->getDireccion()))) {
            Controller::errorMessage("Todos los campos son obligatorios", 400);
            die();
        }

        $contrasena = password_hash($empresa->getContrasena(), PASSWORD_DEFAULT);
        $empresa->setContrasena($contrasena);
        if ($model->update($empresa, $id)) {
            echo json_encode(["message" => "Empresa modificado con éxito!"], JSON_PRETTY_PRINT);
        } else {
            Controller::errorMessage("No se ha podido modificar la empresa", 500);
        }
    }

    public function insert($object)
    {
        $model = new EmpresaModel();
        $empresa = Empresa::fromjson($object);

        if (empty(trim($empresa->getNombre_empresa())) || empty(trim($empresa->getCorreo())) || empty(trim($empresa->getContrasena())) || empty(trim($empresa->getTelefono())) || empty(trim($empresa->getDireccion()))) {
            Controller::errorMessage("Todos los campos son obligatorios", 400);
            die();
        }


        if ($model->findbyEmail($empresa->getCorreo()) != null) {
            Controller::errorMessage("Ya existe una empresa con ese correo", 409);
            die();
        }

        $contrasena = password_hash($empresa->getContrasena(), PASSWORD_DEFAULT);
        $empresa->setContrasena($contrasena);

        if ($model->insert($empresa)) {
            http_response_code(201);
            echo json_encode(["message" => "Empresa añadida con éxito!"], JSON_PRETTY_PRINT);
        } else {
            Controller::errorMessage("No se ha podido añadir la empresa", 500);
        }
    }
}
