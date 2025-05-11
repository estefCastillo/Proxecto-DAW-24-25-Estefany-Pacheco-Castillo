<?php
include_once(__DIR__ . "/../modelo/ServicioModel.php");
include_once("Controller.php");
class ServicioController extends Controller{

public function get($id)
{
 $model=new ServicioModel();
 if(!is_numeric($id)){
    Controller::notFoundMessage("Los servicios se identifican con un solo número o id");
    die();
 } 
 $servicio=$model->get($id[0]);
 if ($servicio==null) {
    Controller::notFoundMessage("No existe ningún servicio con ese id");
    die();
}  
    echo json_encode($servicio,JSON_PRETTY_PRINT);
}

public function getAll()
{
 $model=new ServicioModel();
 $servicios=$model->getAll();
 echo json_encode($servicios,JSON_PRETTY_PRINT);   
}

public function delete($id)
{
    $model=new ServicioModel();
    if(!is_numeric($id)){
        Controller::notFoundMessage("Los servicios se identifican con un solo id");
        die();
    }

    if($model->delete($id)){
        echo json_encode(["message" => "Servicio eliminado con éxito!"], JSON_PRETTY_PRINT);

    }else{
        Controller::notFoundMessage("No se ha podido eliminar al servicio");
    }
}

public function update($id, $object)
{
    $model=new ServicioModel();
    if(!is_numeric($id)){
        Controller::notFoundMessage("Los servicios se identifican con un solo id");
        die();
    }

    $servicio=Servicio::fromjson($object);
    if ($model->update($servicio,$id)) {
        echo json_encode(["message" => "Servicio modificado con éxito!"], JSON_PRETTY_PRINT);
    }else{
        Controller::notFoundMessage("No se ha podido modificar al servicio");
    }

}

public function insert($object)
{
    $model=new ServicioModel();
    $servicio=Servicio::fromjson($object);
    if ($model->insert($servicio)) {
        echo json_encode(["message" => "Servicio añadido con éxito!"], JSON_PRETTY_PRINT);
    }else{
        Controller::notFoundMessage("No se ha podido añadir al servicio");
    }
}
}
