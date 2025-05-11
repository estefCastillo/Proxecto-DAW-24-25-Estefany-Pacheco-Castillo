<?php
include_once(__DIR__ . "/../modelo/FavoritoModel.php");
include_once("Controller.php");
class FavoritoController
{
    public function getAllByUser($id)
    {
        $model = new FavoritoModel();
        if (!is_numeric($id)) {
            Controller::notFoundMessage("Los usuarios se identifican con un solo número o id");
            die();
        }
        $favorito = $model->getAllByUser($id[0]);
        if ($favorito == null) {
            Controller::notFoundMessage("No existe ningún usuario con favoritos con ese id");
            die();
        }
        echo json_encode($favorito, JSON_PRETTY_PRINT);
    }
    public function deleteByUser($id_usuario, $id_favorito)
    {
        $model = new FavoritoModel();
        if (!is_numeric($id_usuario) || !is_numeric($id_favorito)) {
            Controller::notFoundMessage("IDs incorrectos");
            die();
        }

        if ($model->deletebyUser($id_usuario, $id_favorito)) {
            echo json_encode(["message" => "Favorito eliminado con éxito!"], JSON_PRETTY_PRINT);
        } else {
            Controller::notFoundMessage("No se ha podido eliminar el favorito");
        }
    }
    public function insert($object)
    {
        $model = new FavoritoModel();
        $favorito = Favorito::fromjson($object);
        if ($model->insert($favorito)) {
            echo json_encode(["message" => "Favorito añadido con éxito!"], JSON_PRETTY_PRINT);
        } else {
            Controller::notFoundMessage("No se ha podido añadir el favorito");
        }
    }
}
