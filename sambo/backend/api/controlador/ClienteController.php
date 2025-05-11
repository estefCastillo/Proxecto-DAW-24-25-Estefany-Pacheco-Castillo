<?php
include_once(__DIR__ . "/../modelo/ClienteModel.php");
include_once("Controller.php");
class ClienteController extends Controller{

public function get($id)
{
 $model=new ClienteModel();
 if(!is_numeric($id)){
    Controller::notFoundMessage("Los clientes se identifican con un solo número o id");
    die();
 } 
 $cliente=$model->get($id[0]);
 if ($cliente==null) {
    Controller::notFoundMessage("No existe ningún cliente con ese id");
    die();
}  
    echo json_encode($cliente,JSON_PRETTY_PRINT);
}

public function getAll()
{
 $model=new ClienteModel();
 $clientes=$model->getAll();
 echo json_encode($clientes,JSON_PRETTY_PRINT);   
}

public function delete($id)
{
    $model=new ClienteModel();
    if(!is_numeric($id)){
        Controller::notFoundMessage("Los clientes se identifican con un solo id");
        die();
    }

    if($model->delete($id)){
        echo json_encode(["message" => "Cliente eliminado con éxito!"], JSON_PRETTY_PRINT);

    }else{
        Controller::notFoundMessage("No se ha podido eliminar al cliente");
    }
}

public function update($id, $object)
{
    $model=new ClienteModel();
    if(!is_numeric($id)){
        Controller::notFoundMessage("Los clientes se identifican con un solo id");
        die();
    }

    $cliente=Cliente::fromjson($object);
    if ($model->update($cliente,$id)) {
        echo json_encode(["message" => "Cliente modificado con éxito!"], JSON_PRETTY_PRINT);
    }else{
        Controller::notFoundMessage("No se ha podido modificar al cliente");
    }

}

public function insert($object)
{
    $model=new ClienteModel();
    $cliente=Cliente::fromjson($object);
    if ($model->insert($cliente)) {
        echo json_encode(["message" => "Cliente añadido con éxito!"], JSON_PRETTY_PRINT);
    }else{
        Controller::notFoundMessage("No se ha podido añadir al cliente");
    }
}
}
