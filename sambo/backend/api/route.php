<?php
include_once("controlador/Controller.php");

/**
 * Función para obtener los ids
 */
function getIds(array $uri):array{
    $ids = [];
    for($i=count($uri)-1;$i>=0;$i--){
        if(is_numeric($uri[$i])){
            $ids[] = $uri[$i];
        }
    }
    return array_reverse($ids);
}



/**
 * Obtenemos la uri, el método y el endpoint
 */
$method=$_SERVER["REQUEST_METHOD"];
$uri=$_SERVER["REQUEST_URI"];
$uri=explode("/",$uri);
$id=null;
$endpoint=$uri[4];

/**
 * Obtenemos el controlador
 */
try {
    $controlador=Controller::getController($endpoint);
} catch (\Throwable $th) {
    Controller::notFoundMessage("Se ha producido un error obteniendo el endpoint: " . $th->getMessage());
    die();
}
 /**
  * Obtención del id o de los ids
  */
if (count($uri)>=6) {
    try {
        $id = getIds($uri);
        if (count($id) == 1) {
            $id = $id[0];
        }
    } catch (Throwable $th) {
        Controller::notFoundMessage("Error al obtener los ids");
        die();
    }
}

switch ($method) {
    case 'GET':
        if(isset($id)){
            $controlador->get($id);
        }else{
            $controlador->getAll();
        }
        break;
    case 'DELETE':
        if (isset($id)) {
            $controlador->delete($id);
        }else{
            Controller::notFoundMessage("Se ha de indicar un id correcto");
        }
        break;
    case 'PUT':
        if (isset($id)) {
            $json=file_get_contents("php://input");
            $controlador->update($id,$json);
        }else{
            Controller::notFoundMessage("Se ha de indicar un id correcto");
        }
        break;
    case 'POST':
        $json=file_get_contents("php://input");
        $controlador->insert($json);
        break;    
    default:
        Controller::notFoundMessage("Método HTTP no encontrado");
        break;
}

