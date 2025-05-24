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
$endpoint=$uri[3];

/**
 * Obtenemos el controlador
 */
try {
    $controlador=Controller::getController($endpoint);
} catch (\Throwable $th) {
    Controller::errorMessage("Se ha producido un error obteniendo el endpoint: " . $th->getMessage(),500);
    die();
}
 /**
  * Obtención del id o de los ids
  */
if (count($uri)>=5) {
    try {
        $id = getIds($uri);
        if (count($id) == 1) {
            $id = $id[0];
        }
    } catch (Throwable $th) {
        Controller::errorMessage("Error al obtener los ids",500);
        die();
    }
}

switch ($method) {
    case 'GET':
        if(isset($id) && is_numeric($id)){
            if ($endpoint=="reserva" || $endpoint=="favorito") {
                if (in_array("usuario", $uri)) {
                    $controlador->getAllByUser($id);
                } else {
                    $controlador->getAllByEmpresa($id);

                }
            }else{
                $controlador->get($id);
            }
        }else{
            if ($endpoint=="reserva" || $endpoint=="favorito") {
                Controller::errorMessage("Se debe indicar el id del usuario",400);
            }else if($endpoint=="servicio" && in_array("categorias",$uri)){
                $controlador->getCategories();
            } else{
                $controlador->getAll();
            }
        }
        break;
    case 'DELETE':
        if (isset($id)) {
            if ($endpoint=="reserva" || $endpoint=="favorito") {
                if (strlen($id)==2) {
                    $controlador->deleteByUser($id[0],$id[1]);
                }else{
                    Controller::errorMessage("Se ha de indicar dos ids correctos",400);
                    die();
                }
            }else{
                $controlador->delete($id[0]);
            }
        }else{
            Controller::errorMessage("Se ha de indicar un id correcto",400);
        }
        break;
    case 'PUT':
        if (isset($id)) {
            $json = file_get_contents("php://input");
            if ($endpoint == "reserva") {
                if (strlen($id) == 2) {
                    $controlador->update($id[0], $id[1], $json);
                } else {
                    Controller::errorMessage("Se ha de indicar dos ids correctos",400);
                    die();
                }
            }elseif ($endpoint == "favorito") {
                Controller::errorMessage("No se puede hacer cambios en los favoritos",500);
                die();
            }else {
                $controlador->update($id, $json);
            }
        } else {
            Controller::errorMessage("Se ha de indicar un id correcto",400);
        }
        break;
    case 'POST':
        $json=file_get_contents("php://input");
        $controlador->insert($json);
        break;    
    default:
        Controller::errorMessage("Método HTTP no encontrado",404);
        break;
}

