<?php
include_once(__DIR__ . "/../modelo/UsuarioModel.php");
include_once("Controller.php");
class UsuarioController extends Controller{

public function get($id)
{
 $model=new UsuarioModel();
 if(!is_numeric($id)){
    Controller::notFoundMessage("Los usuarios se identifican con un solo número o id");
    die();
 } 
 $usuario=$model->get($id[0]);
 if ($usuario==null) {
    Controller::notFoundMessage("No existe ningún usuario con ese id");
    die();
}  
    echo json_encode($usuario,JSON_PRETTY_PRINT);
}

public function getAll()
{
 $model=new UsuarioModel();
 $usuarios=$model->getAll();
 echo json_encode($usuarios,JSON_PRETTY_PRINT);   
}

public function delete($id)
{
    $model=new UsuarioModel();
    if(!is_numeric($id)){
        Controller::notFoundMessage("Los usuarios se identifican con un solo id");
        die();
    }

    if($model->delete($id)){
        echo json_encode(["message" => "Usuario eliminado con éxito!"], JSON_PRETTY_PRINT);

    }else{
        Controller::notFoundMessage("No se ha podido eliminar al usuario");
    }
}

public function update($id, $object)
{
    $model=new UsuarioModel();
    if(!is_numeric($id)){
        Controller::notFoundMessage("Los usuarios se identifican con un solo id");
        die();
    }

    $usuario=Usuario::fromjson($object);
    if ($model->update($usuario,$id)) {
        echo json_encode(["message" => "Usuario modificado con éxito!"], JSON_PRETTY_PRINT);
    }else{
        Controller::notFoundMessage("No se ha podido modificar al usuario");
    }

}

public function insert($object)
{
    $model=new UsuarioModel();
    $usuario=Usuario::fromjson($object);
    if ($model->insert($usuario)) {
        echo json_encode(["message" => "Usuario añadido con éxito!"], JSON_PRETTY_PRINT);
    }else{
        Controller::notFoundMessage("No se ha podido añadir al usuario");
    }
}
}
