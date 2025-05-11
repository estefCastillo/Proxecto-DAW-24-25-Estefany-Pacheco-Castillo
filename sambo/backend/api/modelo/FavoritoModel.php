<?php
include_once("Model.php");

class Favorito extends ModelObject{
    public ?int $id_favorito;
    public int $id_usuario;
    public int $id_servicio;

    public function __construct($id_usuario,$id_servicio,$id_favorito=null) {
        $this->id_favorito = $id_favorito;
        $this->id_usuario=$id_usuario;
        $this->id_servicio=$id_servicio;
    }

    public static function fromjson($json)
    {
        $data=json_decode($json);
        return new Favorito($data->id_usuario,$data->id_servicio,$data->id_favorito??null);
    }

    public function toJson()
    {
        return json_encode($this,JSON_PRETTY_PRINT);
    }


    /**
     * Get the value of id_favorito
     */ 
    public function getId_favorito()
    {
        return $this->id_favorito;
    }

    /**
     * Set the value of id_favorito
     *
     * @return  self
     */ 
    public function setId_favorito($id_favorito)
    {
        $this->id_favorito = $id_favorito;

        return $this;
    }

    /**
     * Get the value of id_usuario
     */ 
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     * Set the value of id_usuario
     *
     * @return  self
     */ 
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    /**
     * Get the value of id_servicio
     */ 
    public function getId_servicio()
    {
        return $this->id_servicio;
    }

    /**
     * Set the value of id_servicio
     *
     * @return  self
     */ 
    public function setId_servicio($id_servicio)
    {
        $this->id_servicio = $id_servicio;

        return $this;
    }
}
class FavoritoModel extends Model{

    public function getAllbyUser($id_usuario){
        $sql="SELECT * FROM  favorito WHERE id_usuario=:id_usuario";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id_usuario',$id_usuario,PDO::PARAM_INT);
        $favoritos=[];

        try {
            $stmt->execute();
            if ($s=$stmt->fetch()) {
                $favorito=new Favorito($s["id_usuario"],$s["id_servicio"],$s["id_favorito"]);
                $favoritos[] = $favorito;
            }
        } catch (PDOException $e) {
            error_log("Error en FavoritoModel->getAllbyUser(id_usuario): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $favoritos;
    }
    public function insert($favorito){
        $sql="INSERT INTO favorito (id_usuario,id_servicio) VALUES (:id_usuario,:id_servicio)";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id_usuario',$favorito->getId_usuario(),PDO::PARAM_INT);
        $stmt->bindValue(':id_servicio',$favorito->getId_servicio(),PDO::PARAM_INT);
        $resultado=false;

        try {
            $resultado=$stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en FavoritoModel->insert($favorito): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }
    public function deletebyUser($id_usuario,$id_favorito){
        $sql="DELETE FROM  favorito WHERE id_usuario=:id_usuario AND id_favorito=:id_favorito";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id_usuario',$id_usuario,PDO::PARAM_INT);
        $stmt->bindValue(':id_favorito',$id_favorito,PDO::PARAM_INT);
        $resultado=false;

        try {
            $resultado=$stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en FavoritoModel->delete($id_usuario,$id_favorito): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }
}
