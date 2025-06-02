<?php
include("UsuarioController.php");
include("EmpresaController.php");
include("ServicioController.php");
include("FavoritoController.php");
include("ReservaController.php");

//Clase abstracta de la cual extienden todos los controladores
abstract class Controller
{
    public abstract function get($id);
    public abstract function getAll();
    public abstract function delete($id);
    public abstract function update($id, $object);
    public abstract function insert($object);

    //Muestra el error y devuelve una petición http    
    public static function errorMessage($message, $code = 400)
    {
        error_log($message);
        http_response_code($code);
        echo json_encode($message, JSON_PRETTY_PRINT);
    }

    //Obtiene el controlador 
    public static function getController($controllerName)
    {
        $controller = null;
        switch ($controllerName) {
            case 'usuario':
                $controller = new UsuarioController();
                break;
            case 'empresa':
                $controller = new EmpresaController();
                break;
            case 'servicio':
                $controller = new ServicioController();
                break;
            case 'favorito':
                $controller = new FavoritoController();
                break;
            case 'reserva':
                $controller = new ReservaController();
                break;
            default:
                echo "Error obteniendo el controlador";
                break;
        }
        return $controller;
    }
}
