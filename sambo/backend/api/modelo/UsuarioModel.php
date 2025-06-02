<?php
include_once("Model.php");

class Usuario extends ModelObject
{
    public ?int $id_usuario;
    public string $nombre;
    public string $correo;
    public string $contrasena;
    public string $rol;

    public function __construct($nombre, $correo, $contrasena, $rol = "usuario", $id_usuario = null)
    {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->rol = $rol;
    }

    //Crea un objeto Usuario a partir de un json
    public static function fromjson($json)
    {
        $data = json_decode($json);
        return new Usuario($data->nombre, $data->correo, $data->contrasena, $data->rol ?? "usuario", $data->id_usuario ?? null);
    }

    //Convierte a json un objeto Usuario
    public function toJson()
    {
        return json_encode($this, JSON_PRETTY_PRINT);
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
     * Get the value of rol
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set the value of rol
     *
     * @return  self
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }
}

class UsuarioModel extends Model
{
    //Obtiene todos los usuarios
    public function getAll()
    {
        $sql = "SELECT * FROM usuarios";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $usuarios = [];

        try {
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $r) {
                $usuario = new Usuario($r["nombre"], $r["correo"], $r["contrasena"], $r["rol"], $r["id_usuario"]);
                $usuarios[] = $usuario;
            }
        } catch (PDOException $e) {
            error_log("Error en UsuarioModel->getAll(): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $usuarios;
    }

    //Obtiene un usuario según su id
    public function get($id_usuario)
    {
        $sql = "SELECT * FROM  usuarios WHERE id_usuario=:id_usuario";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $usuario = null;

        try {
            $stmt->execute();
            if ($s = $stmt->fetch()) {
                $usuario = new Usuario($s["nombre"], $s["correo"], $s["contrasena"], $s["rol"], $s["id_usuario"]);
            }
        } catch (PDOException $e) {
            error_log("Error en UsuarioModel->get($id_usuario): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $usuario;
    }

    //Añade un usuario
    public function insert($usuario)
    {
        $sql = "INSERT INTO usuarios (nombre,correo,contrasena,rol) VALUES (:nombre,:correo,:contrasena,:rol)";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":nombre", $usuario->getNombre(), PDO::PARAM_STR);
        $stmt->bindValue(":correo", $usuario->getCorreo(), PDO::PARAM_STR);
        $stmt->bindValue(":contrasena", $usuario->getContrasena(), PDO::PARAM_STR);
        $stmt->bindValue(":rol", $usuario->getRol(), PDO::PARAM_STR);
        $resultado = false;

        try {
            $resultado = $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en UsuarioModel->insert($usuario): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $resultado;
    }

    //Modifica los datos de un usuario según su id y a través de los datos del objeto obtenido
    public function update($usuario, $id_usuario)
    {
        $sql = "UPDATE usuarios SET 
        nombre=:nombre,
        correo=:correo,
        contrasena=:contrasena,
        rol=:rol
        WHERE id_usuario=:id_usuario";

        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nombre', $usuario->getNombre(), PDO::PARAM_STR);
        $stmt->bindValue(':correo', $usuario->getCorreo(), PDO::PARAM_STR);
        $stmt->bindValue(':contrasena', $usuario->getContrasena(), PDO::PARAM_STR);
        $stmt->bindValue(":rol", $usuario->getRol(), PDO::PARAM_STR);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $resultado = false;

        try {
            $stmt->execute();
            $resultado = $stmt->rowCount() == 1;
        } catch (PDOException $e) {
            error_log("Error en UsuarioModel->update($usuario,$id_usuario): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $resultado;
    }

    //Elimina un usuario según su id
    public function delete($id_usuario)
    {
        $sql = "DELETE FROM  usuarios WHERE id_usuario=:id_usuario";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $resultado = false;

        try {
            $resultado = $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en UsuarioModel->delete($id_usuario): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $resultado;
    }

    //Encuentra un usuario según su correo
    public function findbyEmail($correo)
    {
        $sql = "SELECT * FROM usuarios WHERE correo=:correo";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":correo", $correo, PDO::PARAM_STR);
        $usuario = null;

        try {
            $stmt->execute();
            if ($s = $stmt->fetch()) {
                $usuario = new Usuario($s["nombre"], $s["correo"], $s["contrasena"], $s["rol"], $s["id_usuario"]);
            }
        } catch (PDOException $e) {
            error_log("Error en UsuarioModel->($correo): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $usuario;
    }
}
