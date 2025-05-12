<?php
include_once("Model.php");

class Reserva extends ModelObject{
    public ?int $id_reserva;
    public int $id_usuario;
    public int $id_servicio;
    public string $fecha;
    public string $estado;


    public function __construct($id_usuario,$id_servicio,$fecha,$estado,$id_reserva=null) {
        $this->id_reserva = $id_reserva;
        $this->id_usuario=$id_usuario;
        $this->id_servicio=$id_servicio;
        $this->fecha=$fecha;
        $this->estado=$estado;
    }

    public static function fromjson($json)
    {
        $data=json_decode($json);
        return new Reserva($data->id_usuario,$data->id_servicio,$data->fecha,$data->estado,$data->id_reserva??null);
    }

    public function toJson()
    {
        return json_encode($this,JSON_PRETTY_PRINT);
    }



    /**
     * Get the value of id_reserva
     */ 
    public function getId_reserva()
    {
        return $this->id_reserva;
    }

    /**
     * Set the value of id_reserva
     *
     * @return  self
     */ 
    public function setId_reserva($id_reserva)
    {
        $this->id_reserva = $id_reserva;

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

    /**
     * Get the value of fecha
     */ 
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */ 
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of estado
     */ 
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set the value of estado
     *
     * @return  self
     */ 
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }
}
class ReservaModel extends Model{
    public function getAllbyUser($id_usuario){
        $sql = "SELECT * FROM reserva WHERE id_usuario = :id_usuario";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $reservas = [];

        try {
            $stmt->execute();
            $resultado=$stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $s) {
                $reserva=new Reserva($s["id_usuario"],$s["id_servicio"],$s["fecha"],$s["estado"],$s["id_reserva"]);
                $reservas[]=$reserva;
            }
        } catch (PDOException $e) {
            error_log("Error en ReservaModel->getAllByUser($id_usuario): " . $e->getMessage());
        } finally {
            $stmt=null;
            $pdo=null;
        }
        return $reservas;
    }
    public function getAllByClient($id_cliente){
        $sql = "SELECT r.id_reserva,r.id_usuario,r.id_servicio,r.fecha,r.estado
                FROM reserva r
                JOIN servicio s ON r.id_servicio = s.id_servicio
                WHERE s.id_cliente = :id_cliente";
        
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $reservas = [];
        try {
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($resultado as $r) {
                $reserva = new Reserva($r["id_usuario"], $r["id_servicio"], $r["fecha"], $r["estado"], $r["id_reserva"]);
                $reservas[] = $reserva;
            }
        } catch (PDOException $e) {
            error_log("Error en ReservaModel->getAllByClient($id_cliente): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $reservas;
    }
    public function insert($reserva){
        $sql="INSERT INTO reserva (id_usuario,id_servicio,fecha,estado) VALUES (:id_usuario,:id_servicio,:fecha,:estado)";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id_usuario',$reserva->getId_usuario(),PDO::PARAM_INT);
        $stmt->bindValue(':id_servicio',$reserva->getId_servicio(),PDO::PARAM_INT);
        $stmt->bindValue(':fecha',$reserva->getFecha(),PDO::PARAM_STR);
        $stmt->bindValue(':estado',$reserva->getEstado(),PDO::PARAM_STR);
        $resultado=false;

        try {
            $resultado=$stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en ReservaModel->insert($reserva): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }
    public function update($reserva,$id_usuario,$id_reserva){
        $sql="UPDATE reserva SET 
        id_servicio=:id_servicio,
        fecha=:fecha,
        estado=:estado
        WHERE id_usuario=:id_usuario AND id_reserva=:id_reserva";

        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id_servicio',$reserva->getId_servicio(),PDO::PARAM_INT);
        $stmt->bindValue(':fecha',$reserva->getFecha(),PDO::PARAM_STR);
        $stmt->bindValue(':estado',$reserva->getEstado(),PDO::PARAM_STR);
        $stmt->bindValue(':id_usuario',$id_usuario,PDO::PARAM_INT);
        $stmt->bindValue(':id_reserva',$id_reserva,PDO::PARAM_INT);
        $resultado=false;

        try {
            $stmt->execute();
            $resultado=$stmt->rowCount() == 1;
        } catch (PDOException $e) {
            error_log("Error en ReservaModel->update($reserva,$id_reserva): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }
    public function deletebyUser($id_usuario,$id_reserva){
        $sql="DELETE FROM  reserva WHERE id_usuario = :id_usuario AND id_reserva=:id_reserva";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindValue(':id_reserva',$id_reserva,PDO::PARAM_INT);
        $resultado=false;

        try {
            $resultado=$stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en ReservaModel->deleteByUser($id_usuario,$id_reserva): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }
}
