<?php
require_once  "conexion.php";

class ciclo extends conexion
{
    public function ciclo()
    {
        parent::__construct();
    }

    public function get_ciclo()
    {
        $lista = $this->conect->query("SELECT * FROM ciclo");
        $ciclo = $lista->fetch_all(MYSQLI_ASSOC);
        return $ciclo;
    }

    public function insertar_ciclo($ciclo, $turno)
    {
        $id = rand(0, 99);
        while(comprobar_id_ciclo($id))
        {
            $id = rand(0, 99);
            $sql = "INSERT INTO ciclo (id_ciclo, ciclo, turno) VALUES (?, ?, ?)";
            $stmt = $this->conect->prepare($sql);
            $stmt->bind_param("iss", $id, $ciclo, $turno);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function comprobar_id_ciclo($id)
    {
        $sql = "SELECT COUNT(*) AS count FROM ciclo WHERE id_ciclo = ?";
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

    public function borrar_ciclo($id)
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