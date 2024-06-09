<?php
require_once  "conexion.php";

class aula extends conexion
{
    public function aula()
    {
        parent::__construct();
    }

    public function get_aula()
    {
        $lista = $this->conect->query("SELECT * FROM aula");
        $aula = $lista->fetch_all(MYSQLI_ASSOC);
        return $aula;
    }

    public function insertar_aula($nombre, $num_aula)
    {
        $id = rand(0, 99);
        while(comprobar_id_aula($id))
        {
            $id = rand(0, 99);
            $sql = "INSERT INTO aula (ID_Aula, Nombre_aula, Num_Aula) VALUES (?, ?, ?)";
            $stmt = $this->conect->prepare($sql);
            $stmt->bind_param("isd", $id, $nombre, $num_aula);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function comprobar_id_aula($id)
    {
        $sql = "SELECT COUNT(*) AS count FROM aula WHERE ID_Aula = ?";
        $stmt = $this->conect->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        if ($count > 0) {
            return true; 
        } else {
            return false; 
        }
    }

    public function borrar_aula($id)
    {
        if ($this->comprobar_id_aula($id)) { 
            $sql = "DELETE FROM aula WHERE ID_Aula = ?";
            $stmt = $this->conect->prepare($sql);
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                return true; 
            } else {
                return false; 
            }
        } else {
            return false;
        }
    }
}

?>