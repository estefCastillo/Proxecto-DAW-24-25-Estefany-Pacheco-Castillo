<?php
include_once(__DIR__ . "/../modelo/ServicioModel.php");
include_once("Controller.php");
class ServicioController extends Controller
{

    //Obtiene un servicio según su id    
    public function get($id)
    {
        $model = new ServicioModel();
        if (!is_numeric($id)) {
            Controller::errorMessage("Los servicios se identifican con un solo número o id", 400);
            die();
        }
        $servicio = $model->get($id);
        if ($servicio == null) {
            Controller::errorMessage("No existe ningún servicio con ese id", 404);
            die();
        }
        echo json_encode($servicio, JSON_PRETTY_PRINT);
    }

    //Obtiene todos los servicio
    public function getAll()
    {
        $model = new ServicioModel();
        $servicios = $model->getAll();
        echo json_encode($servicios, JSON_PRETTY_PRINT);
    }

    //Obtiene todas las categorías existentes
    public function getCategories()
    {
        $model = new ServicioModel();
        $categorias = $model->getCategories();
        echo json_encode($categorias, JSON_PRETTY_PRINT);
    }
    //Elimina un servicio según su id
    public function delete($id)
    {
        $model = new ServicioModel();
        if (!is_numeric($id)) {
            Controller::errorMessage("Los servicios se identifican con un solo id", 400);
            die();
        }

        if ($model->delete($id)) {
            echo json_encode(["message" => "Servicio eliminado con éxito!"], JSON_PRETTY_PRINT);
        } else {
            Controller::errorMessage("No se ha podido eliminar al servicio", 500);
        }
    }

    // Modifica los datos de un servicio según su id
    public function update($id, $object)
    {
        $model = new ServicioModel();
        if (!is_numeric($id)) {
            Controller::errorMessage("Los servicios se identifican con un solo id", 400);
            die();
        }

        $servicio = Servicio::fromjson($object);
        if ($model->update($servicio, $id)) {
            echo json_encode(["message" => "Servicio modificado con éxito!"], JSON_PRETTY_PRINT);
        } else {
            Controller::errorMessage("No se ha podido modificar al servicio", 500);
        }
    }

    //Añade un servicio
    public function insert($object)
    {
        $model = new ServicioModel();
        $servicio = Servicio::fromjson($object);
        if ($model->insert($servicio)) {
            echo json_encode(["message" => "Servicio añadido con éxito!"], JSON_PRETTY_PRINT);
        } else {
            Controller::errorMessage("No se ha podido añadir al servicio");
        }
    }
}
