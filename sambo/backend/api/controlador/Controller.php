<?php
include("UsuarioController.php");
include("ClienteController.php");


abstract class Controller{
    public abstract function get($id);
    public abstract function getAll();
    public abstract function delete($id);
    public abstract function update($id, $object);
    public abstract function insert($object);

    public static function notFoundMessage($message){
        error_log($message);
        header("HTTP/1.1 404 Not Found");
        echo json_encode($message, JSON_PRETTY_PRINT);
    }

    public static function getController($controllerName){
        $controller=null;
        switch ($controllerName) {
            case 'usuario':
                $controller=new UsuarioController();
                break;
            case 'cliente':
                $controller=new ClienteController();
                break;
            default:
                echo "Error obteniendo el controlador";
                break;
        }
        return $controller;
    }
}

