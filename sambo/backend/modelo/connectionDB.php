<?php
class connectionDB{
    public static $pdo;

    public static function get(){
        if(!isset(self::$pdo)){
            try {
                self::$pdo=new PDO('mysql:host=mariadb;dbname=sambo','root','bitnami');
            } catch (\PDOException $th) {
                error_log("Error en la conexión con la base de datos: " . $th->getMessage());
            }
        }
        return self::$pdo;
    }
}