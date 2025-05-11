<?php
include("UsuarioController.php");
include("ClienteController.php");
include("ServicioController.php");
include("FavoritoController.php");
include("ReservaController.php");


abstract class Controller
{
    public abstract function get($id);
    public abstract function getAll();
    public abstract function delete($id);
    public abstract function update($id, $object);
    public abstract function insert($object);

    public static function notFoundMessage($message)
    {
        error_log($message);
        header("HTTP/1.1 404 Not Found");
        echo json_encode($message, JSON_PRETTY_PRINT);
    }

    public static function getController($controllerName)
    {
        $controller = null;
        switch ($controllerName) {
            case 'usuario':
                $controller = new UsuarioController();
                break;
            case 'cliente':
                $controller = new ClienteController();
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
