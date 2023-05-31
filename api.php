<?php
header("Content-Type: application/json");

include_once 'database.php';
include_once 'jugador.php';

$database = new Database();
$db = $database->getConnection();

$jugador = new Jugador($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id !== null) {
            $jugador->id = $id;
            $result = $jugador->readOne();
        } else {
            $result = $jugador->readAll();
        }
        echo json_encode($result);
        break;

    case 'POST':
        // Crear un nuevo jugador
        $data = json_decode(file_get_contents("php://input"));
        
        $jugador->nombre = $data->nombre;
        $jugador->edad = $data->edad;
        $jugador->posicion = $data->posicion;
        $jugador->equipo = $data->equipo;
        $jugador->nacionalidad = $data->nacionalidad;
        
        if ($jugador->create()) {
            echo json_encode(array("message" => "Jugador creado con éxito."));
        } else {
            echo json_encode(array("message" => "No se pudo crear el jugador."));
        }
        break;        

    case 'PUT':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id !== null) {
            $data = json_decode(file_get_contents("php://input"));

            $jugador->id = $id;
            $jugador->nombre = $data->nombre;
            $jugador->edad = $data->edad;
            $jugador->posicion = $data->posicion;
            $jugador->equipo = $data->equipo;
            $jugador->nacionalidad = $data->nacionalidad;

            if ($jugador->update()) {
                echo json_encode(array("message" => "Jugador actualizado con éxito."));
            } else {
                echo json_encode(array("message" => "No se pudo actualizar el jugador."));
            }
        } else {
            echo json_encode(array("message" => "ID de jugador no especificado."));
        }
        break;

    case 'DELETE':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id !== null) {
            $jugador->id = $id;
            if ($jugador->delete()) {
                echo json_encode(array("message" => "Jugador eliminado con éxito."));
            } else {
                echo json_encode(array("message" => "No se pudo eliminar el jugador."));
            }
        } else {
            echo json_encode(array("message" => "ID de jugador no especificado."));
        }
        break;

    default:
        echo json_encode(array("message" => "Método no válido."));
        break;
}
?>
