<?php
include_once(__DIR__ . "/../modelo/ReservaModel.php");
include_once("Controller.php");
class ReservaController {

public function getAllByUser($id)
{
 $model=new ReservaModel();
 if(!is_numeric($id)){
    Controller::notFoundMessage("Los usuarios se identifican con un solo número o id");
    die();
 } 
 $reserva=$model->getAllByUser($id[0]);
 if ($reserva==null) {
    Controller::notFoundMessage("No existe ninguna reserva con ese id");
    die();
}  
    echo json_encode($reserva,JSON_PRETTY_PRINT);
}

public function getAllByClient($id_cliente)
{
    $model = new ReservaModel();
    if (!is_numeric($id_cliente)) {
        Controller::notFoundMessage("Los clientes se identifican con un solo número o id");
        die();
    }

    $reservas = $model->getAllByClient($id_cliente);
    if (empty($reservas)) {
        Controller::notFoundMessage("No se encontraron reservas para el cliente");
        die();
    }

    echo json_encode($reservas, JSON_PRETTY_PRINT);
}
public function delete($id_usuario,$id_reserva)
{
    $model=new ReservaModel();
    if(!is_numeric($id_usuario) || !is_numeric($id_reserva)){
        Controller::notFoundMessage("Ids incorrectos");
        die();
    }

    if($model->deleteByUser($id_usuario, $id_reserva)){
        echo json_encode(["message" => "Reserva eliminada con éxito!"], JSON_PRETTY_PRINT);

    }else{
        Controller::notFoundMessage("No se ha podido eliminar la reserva");
    }
}

public function update($id_usuario,$id_reserva, $object)
{
    $model=new ReservaModel();
    if(!is_numeric($id_usuario) || !is_numeric($id_reserva)){
        Controller::notFoundMessage("IDs incorrectos");
        die();
    }

    $reserva=Reserva::fromjson($object);
    if ($model->update($reserva,$id_usuario,$id_reserva)) {
        echo json_encode(["message" => "Reserva modificada con éxito!"], JSON_PRETTY_PRINT);
    }else{
        Controller::notFoundMessage("No se ha podido modificar al reserva");
    }

}

public function insert($object)
{
    $model=new ReservaModel();
    $reserva=Reserva::fromjson($object);
    if ($model->insert($reserva)) {
        echo json_encode(["message" => "Reserva añadida con éxito!"], JSON_PRETTY_PRINT);
    }else{
        Controller::notFoundMessage("No se ha podido añadir la reserva");
    }
}
}
