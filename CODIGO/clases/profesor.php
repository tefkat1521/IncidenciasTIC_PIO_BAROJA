<?php
require_once  "conexion.php";



class profesor extends conexion
{

    public function profesor()
    {
        parent::__construct();
    }

    public function get_id_profesor($profe)
    {
        $sql = "SELECT ID_Profe FROM Profesor WHERE nombre = ?";
        $stmt = $this->conect->prepare($sql);
        $stmt->bind_param("s", $profe);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) 
        {
            $row = $result->fetch_assoc();
            return $row['ID_Profe'];
        } 
        else 
        {
            return null;
        }
    }
}
?>