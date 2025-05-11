<?php
include_once("Model.php");

class Cliente extends ModelObject{
    public ?int $id_cliente;
    public string $nombre_empresa;
    public string $correo;
    public string $contrasena;
    public string $telefono;
    public string $direccion;

    public function __construct($nombre_empresa,$correo,$contrasena,$telefono,$direccion,$id_cliente=null) {
        $this->id_cliente = $id_cliente;
        $this->nombre_empresa=$nombre_empresa;
        $this->correo=$correo;
        $this->contrasena=$contrasena;
        $this->telefono=$telefono;
        $this->direccion=$direccion;
    }

    public static function fromjson($json)
    {
        $data=json_decode($json);
        return new Cliente($data->nombre_empresa,$data->correo,$data->contrasena,$data->telefono,$data->direccion,$data->id_cliente??null);
    }

    public function toJson()
    {
        return json_encode($this,JSON_PRETTY_PRINT);
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

    /**
     * Get the value of nombre_empresa
     */ 
    public function getNombre_empresa()
    {
        return $this->nombre_empresa;
    }

    /**
     * Set the value of nombre_empresa
     *
     * @return  self
     */ 
    public function setNombre_empresa($nombre_empresa)
    {
        $this->nombre_empresa = $nombre_empresa;

        return $this;
    }
    /**
     * Get the value of correo
     */ 
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set the value of correo
     *
     * @return  self
     */ 
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get the value of contrasena
     */ 
    public function getContrasena()
    {
        return $this->contrasena;
    }

    /**
     * Set the value of contrasena
     *
     * @return  self
     */ 
    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;

        return $this;
    }

    /**
     * Get the value of telefono
     */ 
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     *
     * @return  self
     */ 
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of direccion
     */ 
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set the value of direccion
     *
     * @return  self
     */ 
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }
}

class ClienteModel extends Model{
    public function getAll(){
        $sql="SELECT * FROM cliente";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $clientes = [];

        try {
            $stmt->execute();
            $resultado=$stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $r) {
                $cliente=new Cliente($r["nombre_empresa"],$r["correo"],$r["contrasena"],$r["telefono"],$r["direccion"],$r["id_cliente"]);
                $clientes[]=$cliente;
            }
        } catch (PDOException $e) {
            error_log("Error en ClienteModel->getAll(): " . $e->getMessage());
        } finally {
            $stmt=null;
            $pdo=null;
        }
        return $clientes;
    }
   
    public function get($id_cliente){
        $sql="SELECT * FROM  cliente WHERE id_cliente=:id_cliente";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id_cliente',$id_cliente,PDO::PARAM_INT);
        $cliente=null;

        try {
            $stmt->execute();
            if ($s=$stmt->fetch()) {
                $cliente=new Cliente($s["nombre_empresa"],$s["correo"],$s["contrasena"],$s["telefono"],$s["direccion"],$s["id_cliente"]);
            }
        } catch (PDOException $e) {
            error_log("Error en ClienteModel->get($id_cliente): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $cliente;
    }

    public function insert($cliente){
        $sql="INSERT INTO cliente (nombre_empresa,correo,contrasena,telefono,direccion) VALUES (:nombre_empresa,:correo,:contrasena,:telefono,:direccion)";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(":nombre_empresa",$cliente->getNombre_empresa(),PDO::PARAM_STR);
        $stmt->bindValue(":correo",$cliente->getCorreo(),PDO::PARAM_STR);
        $stmt->bindValue(":contrasena",$cliente->getContrasena(),PDO::PARAM_STR);
        $stmt->bindValue(':telefono',$cliente->getTelefono(),PDO::PARAM_STR);
        $stmt->bindValue(':direccion',$cliente->getDireccion(),PDO::PARAM_STR);
        $resultado=false;

        try {
            $resultado=$stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en ClienteModel->insert($cliente): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }

    public function update($cliente,$id_cliente){
        $sql="UPDATE cliente SET 
        nombre_empresa=:nombre_empresa,
        correo=:correo,
        contrasena=:contrasena,
        telefono=:telefono,
        direccion=:direccion
        WHERE id_cliente=:id_cliente";

        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':nombre_empresa',$cliente->getNombre_empresa(),PDO::PARAM_STR);
        $stmt->bindValue(':correo',$cliente->getCorreo(),PDO::PARAM_STR);
        $stmt->bindValue(':contrasena',$cliente->getContrasena(),PDO::PARAM_STR);
        $stmt->bindValue(':telefono',$cliente->getTelefono(),PDO::PARAM_STR);
        $stmt->bindValue(':direccion',$cliente->getDireccion(),PDO::PARAM_STR);
        $stmt->bindValue(':id_cliente',$id_cliente,PDO::PARAM_INT);
        $resultado=false;

        try {
            $stmt->execute();
            $resultado=$stmt->rowCount() == 1;
        } catch (PDOException $e) {
            error_log("Error en ClienteModel->update($cliente,$id_cliente): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }

    public function delete($id_cliente){
        $sql="DELETE FROM  cliente WHERE id_cliente=:id_cliente";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id_cliente',$id_cliente,PDO::PARAM_INT);
        $resultado=false;

        try {
            $resultado=$stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en ClienteModel->delete($id_cliente): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }

}