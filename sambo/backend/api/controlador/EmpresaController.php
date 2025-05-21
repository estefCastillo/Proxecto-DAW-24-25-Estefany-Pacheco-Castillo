<?php
include_once(__DIR__ . "/../modelo/EmpresaModel.php");
include_once("Controller.php");
class EmpresaController extends Controller{

public function get($id)
{
 $model=new EmpresaModel();
 if(!is_numeric($id)){
    Controller::notFoundMessage("Las empresas se identifican con un solo número o id");
    die();
 } 
 $empresa=$model->get($id[0]);
 if ($empresa==null) {
    Controller::notFoundMessage("No existe ninguna empresa con ese id");
    die();
}  
    echo json_encode($empresa,JSON_PRETTY_PRINT);
}

public function getAll()
{
 $model=new EmpresaModel();
 $empresas=$model->getAll();
 echo json_encode($empresas,JSON_PRETTY_PRINT);   
}

public function delete($id)
{
    $model=new EmpresaModel();
    if(!is_numeric($id)){
        Controller::notFoundMessage("Las empresas se identifican con un solo id");
        die();
    }

    if($model->delete($id)){
        echo json_encode(["message" => "Empresa eliminada con éxito!"], JSON_PRETTY_PRINT);

    }else{
        Controller::notFoundMessage("No se ha podido eliminar la empresa");
    }
}

public function update($id, $object)
{
    $model=new EmpresaModel();
    if(!is_numeric($id)){
        Controller::notFoundMessage("Las empresas se identifican con un solo id");
        die();
    }

    $empresa=Empresa::fromjson($object);
    if ($model->update($empresa,$id)) {
        echo json_encode(["message" => "Empresa modificado con éxito!"], JSON_PRETTY_PRINT);
    }else{
        Controller::notFoundMessage("No se ha podido modificar la empresa");
    }

}

public function insert($object)
{
    $model=new EmpresaModel();
    $empresa=Empresa::fromjson($object);
    if ($model->insert($empresa)) {
        echo json_encode(["message" => "Empresa añadida con éxito!"], JSON_PRETTY_PRINT);
    }else{
        Controller::notFoundMessage("No se ha podido añadir la empresa");
    }
}
}
