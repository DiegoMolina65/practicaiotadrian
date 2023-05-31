<?php
class Jugador {
    private $conn;
    private $table_name = "jugadores";

    public $id;
    public $nombre;
    public $edad;
    public $posicion;
    public $equipo;
    public $nacionalidad;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, edad=:edad, posicion=:posicion, equipo=:equipo, nacionalidad=:nacionalidad";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->edad = htmlspecialchars(strip_tags($this->edad));
        $this->posicion = htmlspecialchars(strip_tags($this->posicion));
        $this->equipo = htmlspecialchars(strip_tags($this->equipo));
        $this->nacionalidad = htmlspecialchars(strip_tags($this->nacionalidad));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":edad", $this->edad);
        $stmt->bindParam(":posicion", $this->posicion);
        $stmt->bindParam(":equipo", $this->equipo);
        $stmt->bindParam(":nacionalidad", $this->nacionalidad);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nombre=:nombre, edad=:edad, posicion=:posicion, equipo=:equipo, nacionalidad=:nacionalidad WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->edad = htmlspecialchars(strip_tags($this->edad));
        $this->posicion = htmlspecialchars(strip_tags($this->posicion));
        $this->equipo = htmlspecialchars(strip_tags($this->equipo));
        $this->nacionalidad = htmlspecialchars(strip_tags($this->nacionalidad));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":edad", $this->edad);
        $stmt->bindParam(":posicion", $this->posicion);
        $stmt->bindParam(":equipo", $this->equipo);
        $stmt->bindParam(":nacionalidad", $this->nacionalidad);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
