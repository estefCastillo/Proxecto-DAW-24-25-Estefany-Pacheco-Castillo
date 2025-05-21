<?php
include_once("Model.php");

class Empresa extends ModelObject{
    public ?int $id_empresa;
    public string $nombre_empresa;
    public string $correo;
    public string $contrasena;
    public string $telefono;
    public string $direccion;

    public function __construct($nombre_empresa,$correo,$contrasena,$telefono,$direccion,$id_empresa=null) {
        $this->id_empresa = $id_empresa;
        $this->nombre_empresa=$nombre_empresa;
        $this->correo=$correo;
        $this->contrasena=$contrasena;
        $this->telefono=$telefono;
        $this->direccion=$direccion;
    }

    public static function fromjson($json)
    {
        $data=json_decode($json);
        return new Empresa($data->nombre_empresa,$data->correo,$data->contrasena,$data->telefono,$data->direccion,$data->id_empresa??null);
    }

    public function toJson()
    {
        return json_encode($this,JSON_PRETTY_PRINT);
    }

    /**
     * Get the value of id_empresa
     */ 
    public function getId_empresa()
    {
        return $this->id_empresa;
    }

    /**
     * Set the value of id_empresa
     *
     * @return  self
     */ 
    public function setId_empresa($id_empresa)
    {
        $this->id_empresa = $id_empresa;

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

class EmpresaModel extends Model{
    public function getAll(){
        $sql="SELECT * FROM empresas";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $empresas = [];

        try {
            $stmt->execute();
            $resultado=$stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $r) {
                $empresa=new Empresa($r["nombre_empresa"],$r["correo"],$r["contrasena"],$r["telefono"],$r["direccion"],$r["id_empresa"]);
                $empresas[]=$empresa;
            }
        } catch (PDOException $e) {
            error_log("Error en EmpresaModel->getAll(): " . $e->getMessage());
        } finally {
            $stmt=null;
            $pdo=null;
        }
        return $empresas;
    }
   
    public function get($id_empresa){
        $sql="SELECT * FROM  empresas WHERE id_empresa=:id_empresa";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id_empresa',$id_empresa,PDO::PARAM_INT);
        $empresa=null;

        try {
            $stmt->execute();
            if ($s=$stmt->fetch()) {
                $empresa=new Empresa($s["nombre_empresa"],$s["correo"],$s["contrasena"],$s["telefono"],$s["direccion"],$s["id_empresa"]);
            }
        } catch (PDOException $e) {
            error_log("Error en EmpresaModel->get($id_empresa): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $empresa;
    }

    public function insert($empresa){
        $sql="INSERT INTO empresas (nombre_empresa,correo,contrasena,telefono,direccion) VALUES (:nombre_empresa,:correo,:contrasena,:telefono,:direccion)";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(":nombre_empresa",$empresa->getNombre_empresa(),PDO::PARAM_STR);
        $stmt->bindValue(":correo",$empresa->getCorreo(),PDO::PARAM_STR);
        $stmt->bindValue(":contrasena",$empresa->getContrasena(),PDO::PARAM_STR);
        $stmt->bindValue(':telefono',$empresa->getTelefono(),PDO::PARAM_STR);
        $stmt->bindValue(':direccion',$empresa->getDireccion(),PDO::PARAM_STR);
        $resultado=false;

        try {
            $resultado=$stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en EmpresaModel->insert($empresa): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }

    public function update($empresa,$id_empresa){
        $sql="UPDATE empresas SET 
        nombre_empresa=:nombre_empresa,
        correo=:correo,
        contrasena=:contrasena,
        telefono=:telefono,
        direccion=:direccion
        WHERE id_empresa=:id_empresa";

        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':nombre_empresa',$empresa->getNombre_empresa(),PDO::PARAM_STR);
        $stmt->bindValue(':correo',$empresa->getCorreo(),PDO::PARAM_STR);
        $stmt->bindValue(':contrasena',$empresa->getContrasena(),PDO::PARAM_STR);
        $stmt->bindValue(':telefono',$empresa->getTelefono(),PDO::PARAM_STR);
        $stmt->bindValue(':direccion',$empresa->getDireccion(),PDO::PARAM_STR);
        $stmt->bindValue(':id_empresa',$id_empresa,PDO::PARAM_INT);
        $resultado=false;

        try {
            $stmt->execute();
            $resultado=$stmt->rowCount() == 1;
        } catch (PDOException $e) {
            error_log("Error en EmpresaModel->update($empresa,$id_empresa): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }

    public function delete($id_empresa){
        $sql="DELETE FROM  empresas WHERE id_empresa=:id_empresa";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':id_empresa',$id_empresa,PDO::PARAM_INT);
        $resultado=false;

        try {
            $resultado=$stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en EmpresaModel->delete($id_empresa): " . $e->getMessage());
        } finally{
            $stmt=null;
            $pdo=null;
        }
        return $resultado;
    }

    public function findbyEmail($correo){
        $sql="SELECT * FROM empresas WHERE correo=:correo";
        $pdo=self::getConnection();
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(":correo",$correo,PDO::PARAM_STR);
        $empresa=null;

        try {
            $stmt->execute();
            if ($s=$stmt->fetch()) {
                $empresa=new Empresa($s["nombre_empresa"],$s["correo"],$s["contrasena"],$s["telefono"],$s["direccion"],$s["id_empresa"]);
            }
        } catch (PDOException $e) {
            error_log("Error en EmpresaModel->($correo): " . $e->getMessage());
        }finally{
            $stmt=null;
            $pdo=null;
        }
        return $empresa;
    }
}

