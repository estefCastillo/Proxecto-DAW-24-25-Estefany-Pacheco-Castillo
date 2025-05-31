<?php
include_once(__DIR__ . "/../modelo/ReservaModel.php");
include_once("Controller.php");
class ReservaController {

public function getAllByUser($id)
{
 $model=new ReservaModel();
 if(!is_numeric($id)){
    Controller::errorMessage("Los usuarios se identifican con un solo número o id",400);
    die();
 } 
 $reserva=$model->getAllByUser($id);
    echo json_encode($reserva,JSON_PRETTY_PRINT);
}

public function getAllByEmpresa($id_empresa)
{
    $model = new ReservaModel();
    if (!is_numeric($id_empresa)) {
        Controller::errorMessage("Las empresas se identifican con un solo número o id",400);
        die();
    }

    $reservas = $model->getAllByEmpresa($id_empresa);
    if (empty($reservas)) {
        Controller::errorMessage("No se encontraron reservas para la empresa",404);
        die();
    }

    echo json_encode($reservas, JSON_PRETTY_PRINT);
}
public function deletebyUser($id_usuario,$id_reserva)
{
    $model=new ReservaModel();
    if(!is_numeric($id_usuario) || !is_numeric($id_reserva)){
        Controller::errorMessage("Ids incorrectos",400);
        die();
    }

    if($model->deletebyUser($id_usuario, $id_reserva)){
        echo json_encode(["message" => "Reserva eliminada con éxito!"], JSON_PRETTY_PRINT);

    }else{
        Controller::errorMessage("No se ha podido eliminar la reserva",500);
    }
}

public function insert($object)
{
    $model=new ReservaModel();
    $reserva=Reserva::fromjson($object);
    if ($model->insert($reserva)) {
        echo json_encode(["message" => "Reserva añadida con éxito!"], JSON_PRETTY_PRINT);
    }else{
        Controller::errorMessage("No se ha podido añadir la reserva",500);
    }
}
}
