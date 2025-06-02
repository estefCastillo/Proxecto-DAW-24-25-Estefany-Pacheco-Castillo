<?php
include_once("Model.php");

class Servicio extends ModelObject
{
    public ?int $id_servicio;
    public string $nombre;
    public string $descripcion;
    public float $precio;
    public string $tipo_precio;
    public string $imagen;
    public string $categoria;
    public string $ubicacion;
    public int $id_empresa;


    public function __construct($nombre, $descripcion, $precio, $tipo_precio, $imagen, $categoria, $ubicacion, $id_empresa, $id_servicio = null)
    {
        $this->id_servicio = $id_servicio;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->tipo_precio = $tipo_precio;
        $this->imagen = $imagen;
        $this->categoria = $categoria;
        $this->ubicacion = $ubicacion;
        $this->id_empresa = $id_empresa;
    }
    //Crea un objeto Servicio a partir de un json
    public static function fromjson($json)
    {
        $data = json_decode($json);
        return new Servicio($data->nombre, $data->descripcion, $data->precio, $data->tipo_precio, $data->imagen, $data->categoria, $data->ubicacion, $data->id_empresa, $data->id_servicio ?? null);
    }

    //Convierte a json un objeto Servicio
    public function toJson()
    {
        return json_encode($this, JSON_PRETTY_PRINT);
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
     * Get the value of tipo_precio
     */
    public function getTipo_precio()
    {
        return $this->tipo_precio;
    }

    /**
     * Set the value of tipo_precio
     *
     * @return  self
     */
    public function setTipo_precio($tipo_precio)
    {
        $this->tipo_precio = $tipo_precio;

        return $this;
    }

    /**
     * Get the value of imagen
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set the value of imagen
     *
     * @return  self
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

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
}

class ServicioModel extends Model
{
    //Obtiene todas los servicios
    public function getAll()
    {
        $sql = "SELECT * FROM servicios";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $servicios = [];

        try {
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $r) {
                $servicio = new Servicio($r["nombre"], $r["descripcion"], $r["precio"], $r["tipo_precio"], $r["imagen"], $r["categoria"], $r["ubicacion"], $r["id_empresa"], $r["id_servicio"]);
                $servicios[] = $servicio;
            }
        } catch (PDOException $e) {
            error_log("Error en ServicioModel->getAll(): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $servicios;
    }

    //Obtiene un servicio según su id
    public function get($id_servicio)
    {
        $sql = "SELECT * FROM  servicios WHERE id_servicio=:id_servicio";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_servicio', $id_servicio, PDO::PARAM_INT);
        $servicio = null;

        try {
            $stmt->execute();
            if ($s = $stmt->fetch()) {
                $servicio = new Servicio($s["nombre"], $s["descripcion"], $s["precio"], $s["tipo_precio"], $s["imagen"], $s["categoria"], $s["ubicacion"], $s["id_empresa"], $s["id_servicio"]);
            }
        } catch (PDOException $e) {
            error_log("Error en ServicioModel->get($id_servicio): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $servicio;
    }

    //Añade un servicio
    public function insert($servicio)
    {
        $sql = "INSERT INTO servicios (nombre,descripcion,precio,tipo_precio,imagen,categoria,ubicacion,id_empresa) VALUES (:nombre,:descripcion,:precio,:tipo_precio,:imagen,:categoria,:ubicacion,:id_empresa)";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":nombre", $servicio->getNombre(), PDO::PARAM_STR);
        $stmt->bindValue(":descripcion", $servicio->getDescripcion(), PDO::PARAM_STR);
        $stmt->bindValue(":precio", $servicio->getPrecio(), PDO::PARAM_STR);
        $stmt->bindValue(':tipo_precio', $servicio->getTipo_precio(), PDO::PARAM_STR);
        $stmt->bindValue(':imagen', $servicio->getImagen(), PDO::PARAM_STR);
        $stmt->bindValue(':categoria', $servicio->getCategoria(), PDO::PARAM_STR);
        $stmt->bindValue(':ubicacion', $servicio->getUbicacion(), PDO::PARAM_STR);
        $stmt->bindValue(':id_empresa', $servicio->getId_empresa(), PDO::PARAM_INT);
        $resultado = false;

        try {
            $resultado = $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en ServicioModel->insert($servicio): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $resultado;
    }

    //Modifica los datos de un servicio según su id y con los datos del objeto obtenido
    public function update($servicio, $id_servicio)
    {
        $sql = "UPDATE servicios SET 
        nombre=:nombre,
        descripcion=:descripcion,
        precio=:precio,
        tipo_precio=:tipo_precio,
        imagen=:imagen,
        categoria=:categoria,
        ubicacion=:ubicacion,
        id_empresa=:id_empresa
        WHERE id_servicio=:id_servicio";

        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":nombre", $servicio->getNombre(), PDO::PARAM_STR);
        $stmt->bindValue(":descripcion", $servicio->getDescripcion(), PDO::PARAM_STR);
        $stmt->bindValue(":precio", $servicio->getPrecio(), PDO::PARAM_STR);
        $stmt->bindValue(':tipo_precio', $servicio->getTipo_precio(), PDO::PARAM_STR);
        $stmt->bindValue(':imagen', $servicio->getImagen(), PDO::PARAM_STR);
        $stmt->bindValue(':categoria', $servicio->getCategoria(), PDO::PARAM_STR);
        $stmt->bindValue(':ubicacion', $servicio->getUbicacion(), PDO::PARAM_STR);
        $stmt->bindValue(':id_empresa', $servicio->getId_empresa(), PDO::PARAM_INT);
        $stmt->bindValue(':id_servicio', $id_servicio, PDO::PARAM_INT);
        $resultado = false;

        try {
            $stmt->execute();
            $resultado = $stmt->rowCount() == 1;
        } catch (PDOException $e) {
            error_log("Error en ServicioModel->update($servicio,$id_servicio): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $resultado;
    }

    //Elimina un servicio según su id
    public function delete($id_servicio)
    {
        $sql = "DELETE FROM  servicios WHERE id_servicio=:id_servicio";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_servicio', $id_servicio, PDO::PARAM_INT);
        $resultado = false;

        try {
            $resultado = $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en ServicioModel->delete($id_servicio): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $resultado;
    }

    //Obtiene todas las categorías encontradas en los servicios
    public function getCategories()
    {
        $sql = "SELECT DISTINCT categoria FROM servicios";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $categorias = [];
        try {
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $r) {
                $categorias[] = $r["categoria"];
            }
        } catch (PDOException $e) {
            error_log("Error en ServicioModel->getCategories(): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $categorias;
    }
}
