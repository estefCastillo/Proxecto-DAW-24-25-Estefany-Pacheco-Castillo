<?php
include_once(__DIR__ . "/../modelo/FavoritoModel.php");
include_once("Controller.php");
class FavoritoController
{
    //Obtiene los favoritos un usuario según su id
    public function getAllByUser($id)
    {
        $model = new FavoritoModel();
        if (!is_numeric($id)) {
            Controller::errorMessage("Los usuarios se identifican con un solo número o id", 400);
            die();
        }
        $favorito = $model->getAllByUser($id[0]);
        echo json_encode($favorito, JSON_PRETTY_PRINT);
    }

    //Elimina un favorito según su id y el id del usuario    
    public function deleteByUser($id_usuario, $id_favorito)
    {
        $model = new FavoritoModel();
        if (!is_numeric($id_usuario) || !is_numeric($id_favorito)) {
            Controller::errorMessage("IDs incorrectos", 400);
            die();
        }

        if ($model->deletebyUser($id_usuario, $id_favorito)) {
            echo json_encode(["message" => "Favorito eliminado con éxito!"], JSON_PRETTY_PRINT);
        } else {
            Controller::errorMessage("No se ha podido eliminar el favorito", 500);
        }
    }

    //Añade un favorito    
    public function insert($object)
    {
        $model = new FavoritoModel();
        $favorito = Favorito::fromjson($object);
        if ($model->insert($favorito)) {
            echo json_encode(["message" => "Favorito añadido con éxito!"], JSON_PRETTY_PRINT);
        } else {
            Controller::errorMessage("No se ha podido añadir el favorito", 500);
        }
    }
}
