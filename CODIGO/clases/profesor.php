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


    public function insertar_profesor($nombre ,$correo, $password, $dep)
    {
        $id = rand(10000, 99999);
        $sql = "INSERT INTO profesor (ID_Profe, nombre, correo, clave_acceso, dep) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conect->prepare($sql);
        $stmt->bind_param("isssi",$id, $nombre, $correo, $password, $dep);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>