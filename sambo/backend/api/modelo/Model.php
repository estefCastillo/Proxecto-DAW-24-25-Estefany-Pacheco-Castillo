<?php
class Model{
        public static $pdo;
    
        public static function getConnection(){
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

abstract class ModelObject{
    abstract static public function fromjson($json);
    abstract public function toJson();
}