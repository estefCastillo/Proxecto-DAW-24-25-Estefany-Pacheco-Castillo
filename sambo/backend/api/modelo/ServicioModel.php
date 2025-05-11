<?php
include_once("Model.php");

class Servicio extends ModelObject{
    public ?int $id_servicio;
    public string $nombre;
    public string $descripcion;
    public float $precio;
    public string $categoria;
    public string $ubicacion;
    public int $id_cliente;


    public function __construct($nombre,$descripcion,$precio,$categoria,$ubicacion,$id_cliente,$id_servicio=null) {
        $this->id_servicio = $id_servicio;
        $this->nombre=$nombre;
        $this->descripcion=$descripcion;
        $this->precio=$precio;
        $this->categoria=$categoria;
        $this->ubicacion=$ubicacion;
        $this->id_cliente=$id_cliente;
    }

    public static function fromjson($json)
    {
        $data=json_decode($json);
        return new Servicio($data->nombre,$data->descripcion,$data->precio,$data->categoria,$data->ubicacion,$data->id_cliente,$data->id_servicio??null);
    }

    public function toJson()
    {
        return json_encode($this,JSON_PRETTY_PRINT);
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
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of precio
     */ 
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */ 
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of categoria
     */ 
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set the value of categoria
     *
     * @return  self
     */ 
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get the value of ubicacion
     */ 
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set the value of ubicacion
     *
     * @return  self
     */ 
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get the value of id_cliente
     */ 
    public function getId_cliente()
    {
        return $this->id_cliente;
    }

    /**
     * Set the value of id_cliente
     *
     * @return  self
     */ 
    public function setId_cliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;

        return $this;
    }
}

class ServicioModel extends Model{
    public function getAll(){
        $sql="SELECT * FROM servicio";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $servicios = [];

        try {
            $stmt->execute();
            $resultado=$stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $r) {
                $servicio=new Servicio($r["nombre"],$r["descripcion"],$r["precio"],$r["categoria"],$r["ubicacion"],$r["id_cliente"],$r["id_servicio"]);
                $servicios[]=$servicio;
            }
        } catch (PDOException $e) {
            error_log("Error en ServicioModel->getAll(): " . $e->getMessage());
        } finally {
            $stmt=null;
            $pdo=null;
        }
        return $servicios;
    }
    public function get($id_servicio){
        $sql="SELECT * FROM  servicio WHERE id_servicio=:id_servicio";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id_servicio',$id_servicio,PDO::PARAM_INT);
        $servicio=null;

        try {
            $stmt->execute();
            if ($s=$stmt->fetch()) {
                $servicio=new Servicio($s["nombre"],$s["descripcion"],$s["precio"],$s["categoria"],$s["ubicacion"],$s["id_cliente"],$s["id_servicio"]);
            }
        } catch (PDOException $e) {
            error_log("Error en ServicioModel->get($id_servicio): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $servicio;
    }
    public function insert($servicio){
        $sql="INSERT INTO servicio (nombre,descripcion,precio,categoria,ubicacion,id_cliente) VALUES (:nombre,:descripcion,:precio,:categoria,:ubicacion,:id_cliente)";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(":nombre",$servicio->getNombre(),PDO::PARAM_STR);
        $stmt->bindValue(":descripcion",$servicio->getDescripcion(),PDO::PARAM_STR);
        $stmt->bindValue(":precio",$servicio->getPrecio(),PDO::PARAM_STR);
        $stmt->bindValue(':categoria',$servicio->getCategoria(),PDO::PARAM_STR);
        $stmt->bindValue(':ubicacion',$servicio->getUbicacion(),PDO::PARAM_STR);
        $stmt->bindValue(':id_cliente',$servicio->getId_cliente(),PDO::PARAM_INT);
        $resultado=false;

        try {
            $resultado=$stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en ServicioModel->insert($servicio): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }
    public function update($servicio,$id_servicio){
        $sql="UPDATE servicio SET 
        nombre=:nombre,
        descripcion=:descripcion,
        precio=:precio,
        categoria=:categoria,
        ubicacion=:ubicacion,
        id_cliente=:id_cliente
        WHERE id_servicio=:id_servicio";

        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(":nombre",$servicio->getNombre(),PDO::PARAM_STR);
        $stmt->bindValue(":descripcion",$servicio->getDescripcion(),PDO::PARAM_STR);
        $stmt->bindValue(":precio",$servicio->getPrecio(),PDO::PARAM_STR);
        $stmt->bindValue(':categoria',$servicio->getCategoria(),PDO::PARAM_STR);
        $stmt->bindValue(':ubicacion',$servicio->getUbicacion(),PDO::PARAM_STR);
        $stmt->bindValue(':id_cliente',$servicio->getId_cliente(),PDO::PARAM_INT);
        $stmt->bindValue(':id_servicio',$id_servicio,PDO::PARAM_INT);
        $resultado=false;

        try {
            $stmt->execute();
            $resultado=$stmt->rowCount() == 1;
        } catch (PDOException $e) {
            error_log("Error en ServicioModel->update($servicio,$id_servicio): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }
    public function delete($id_servicio){
        $sql="DELETE FROM  servicio WHERE id_servicio=:id_servicio";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id_servicio',$id_servicio,PDO::PARAM_INT);
        $resultado=false;

        try {
            $resultado=$stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en ServicioModel->delete($id_servicio): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }
}