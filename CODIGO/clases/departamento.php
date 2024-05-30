<?php
require_once  "conexion.php";



class departamento extends conexion
{

    public function departamento()
    {
        parent::__construct();
    }

    public function get_departamento()
    {
        $lista = $this->conect->query("SELECT * FROM departamento");

        $departamento = $lista->fetch_all(MYSQLI_ASSOC);

        return $departamento;
    }

    // public function insertar_departamento($nombre)
    // {
    //     $id = rand(10000, 99999);
    //     $sql = "INSERT INTO departamento (ID_Departamento, nombre) VALUES (?, ?)";

    //     $stmt = $this->conect->prepare($sql);
    //     $stmt->bind_param("is", $id, $nombre);

    //     if ($stmt->execute()) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // public function comprobar_id_departamento($id)
    // {
    //     $sql = "SELECT COUNT(*) AS count FROM departamento WHERE ID_Departamento = ?";
    //     $stmt = $this->conect->prepare($sql);
    //     $stmt->bind_param("i", $id);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     $row = $result->fetch_assoc();
    //     $count = $row['count'];
    //     if ($count > 0) {
    //         return true; // El departamento existe
    //     } else {
    //         return false; // El departamento no existe
    //     }
    // }

    // public function borrar_departamento($id)
    // {
    //     // Comprobar si el departamento con el ID dado existe antes de borrarlo
    //     if ($this->comprobar_id_departamento($id)) {
    //         // El departamento existe, proceder con el borrado
    //         $sql = "DELETE FROM departamento WHERE ID_Departamento = ?";
    //         $stmt = $this->conect->prepare($sql);
    //         $stmt->bind_param("i", $id);
    //         if ($stmt->execute()) {
    //             return true; // Borrado exitoso
    //         } else {
    //             return false; // Error al borrar el departamento
    //         }
    //     } else {
    //         // El departamento con el ID dado no existe
    //         return false;
    //     }
    // }
}
?>