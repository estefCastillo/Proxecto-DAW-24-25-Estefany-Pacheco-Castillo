<?php
include_once("Model.php");

class Reserva extends ModelObject
{
    public ?int $id_reserva;
    public int $id_usuario;
    public int $id_servicio;
    public string $fecha;
    public float $cantidad;
    public string $estado;
    public float $precio_total;

    public function __construct($id_usuario, $id_servicio, $fecha, $cantidad, $estado, $precio_total, $id_reserva = null)
    {
        $this->id_reserva = $id_reserva;
        $this->id_usuario = $id_usuario;
        $this->id_servicio = $id_servicio;
        $this->fecha = $fecha;
        $this->cantidad = $cantidad;
        $this->estado = $estado;
        $this->precio_total = $precio_total;
    }

    //Crea un objeto Reserva a partir de un json
    public static function fromjson($json)
    {
        $data = json_decode($json);
        return new Reserva($data->id_usuario, $data->id_servicio, $data->fecha, $data->cantidad, $data->estado, $data->precio_total, $data->id_reserva ?? null);
    }

    //Convierte a json un objeto Reserva
    public function toJson()
    {
        return json_encode($this, JSON_PRETTY_PRINT);
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
     * Get the value of cantidad
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set the value of cantidad
     *
     * @return  self
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

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
    /**
     * Get the value of precio_total
     */
    public function getPrecio_total()
    {
        return $this->precio_total;
    }

    /**
     * Set the value of precio_total
     *
     * @return  self
     */
    public function setPrecio_total($precio_total)
    {
        $this->precio_total = $precio_total;

        return $this;
    }
}
class ReservaModel extends Model
{
    //Obtiene las reservas de un usuario
    public function getAllbyUser($id_usuario)
    {
        $sql = "SELECT * FROM reservas WHERE id_usuario = :id_usuario";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $reservas = [];

        try {
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $s) {
                $reserva = new Reserva($s["id_usuario"], $s["id_servicio"], $s["fecha"], $s["cantidad"], $s["estado"],$s["precio_total"], $s["id_reserva"]);
                $reservas[] = $reserva;
            }
        } catch (PDOException $e) {
            error_log("Error en ReservaModel->getAllByUser($id_usuario): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $reservas;
    }

    //Obtiene todas las reservas que tiene una empresa 
    public function getAllByEmpresa($id_empresa)
    {
        $pdo = self::getConnection();
        $sqlUpdate = "UPDATE reservas r
                  JOIN servicios s ON r.id_servicio = s.id_servicio
                  SET r.estado = 'realizada'
                  WHERE s.id_empresa = :id_empresa
                    AND r.fecha < CURDATE()
                    AND r.estado = 'pendiente'";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindValue(':id_empresa', $id_empresa, PDO::PARAM_INT);
        $stmtUpdate->execute();

        $sql = "SELECT r.id_reserva, r.id_usuario, r.id_servicio, r.fecha, r.cantidad, r.estado, r.precio_total
        FROM reservas r
        JOIN servicios s ON r.id_servicio = s.id_servicio
        WHERE s.id_empresa = :id_empresa";


        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_empresa', $id_empresa, PDO::PARAM_INT);
        $reservas = [];
        try {
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultado as $r) {
                $reserva = new Reserva($r["id_usuario"], $r["id_servicio"], $r["fecha"], $r["cantidad"], $r["estado"],$r["precio_total"], $r["id_reserva"]);
                $reservas[] = $reserva;
            }
        } catch (PDOException $e) {
            error_log("Error en ReservaModel->getAllByEmpresa($id_empresa): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $reservas;
    }

    //Añade una nueva reserva
    public function insert($reserva)
    {
        $sql = "INSERT INTO reservas (id_usuario,id_servicio,fecha,cantidad,estado,precio_total) VALUES (:id_usuario,:id_servicio,:fecha,:cantidad,:estado,:precio_total)";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_usuario', $reserva->getId_usuario(), PDO::PARAM_INT);
        $stmt->bindValue(':id_servicio', $reserva->getId_servicio(), PDO::PARAM_INT);
        $stmt->bindValue(':fecha', $reserva->getFecha(), PDO::PARAM_STR);
        $stmt->bindValue(':cantidad', $reserva->getCantidad(), PDO::PARAM_STR);
        $stmt->bindValue(':estado', $reserva->getEstado(), PDO::PARAM_STR);
        $stmt->bindValue(':precio_total', $reserva->getPrecio_total(), PDO::PARAM_STR);

        $resultado = false;

        try {
            $resultado = $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en ReservaModel->insert($reserva): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $resultado;
    }

    //Elimina una reserva según su id y el id de usuario
    public function deletebyUser($id_usuario, $id_reserva)
    {
        $sql = "DELETE FROM  reservas WHERE id_usuario = :id_usuario AND id_reserva=:id_reserva";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindValue(':id_reserva', $id_reserva, PDO::PARAM_INT);
        $resultado = false;

        try {
            $resultado = $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en ReservaModel->deletebyUser($id_usuario,$id_reserva): " . $e->getMessage());
        } finally {
            $stmt = null;
            $pdo = null;
        }
        return $resultado;
    }
}
