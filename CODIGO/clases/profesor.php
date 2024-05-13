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
        $sql = "SELECT ID_Profe FROM Profesor WHERE correo LIKE ?";
        $stmt = $this->conect->prepare($sql);
    
        // Crear el patrón de coincidencia
        $profe_like = "%$profe%";
    
        $stmt->bind_param("s", $profe_like);
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
    


    public function get_nombre_profesor($correo)
    {
        $sql = "SELECT nombre FROM Profesor WHERE correo = ?";
        $stmt = $this->conect->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) 
        {
            $row = $result->fetch_assoc();
            return $row['nombre'];
        } 
        else 
        {
            return null;
        }
    }


    public function insertar_profesor($nombre, $correo, $password, $dep)
    {
        do {
            $id = rand(10000, 99999);
        } while ($this->comprobar_id_profe($id));
    
        $sql = "INSERT INTO profesor (ID_Profe, nombre, correo, clave_acceso, dep) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conect->prepare($sql);
        $stmt->bind_param("isssi", $id, $nombre, $correo, $password, $dep);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    

    public function comprobar_id_profe($id)
    {
        $sql = "SELECT COUNT(*) AS count FROM Profesor WHERE ID_Profe = ?";
        $stmt = $this->conect->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        if ($count > 0) 
        {
            return true; 
        } else 
        {
            return false; 
        }
    }

    public function borrar_profesor($id)
    {
        
        if ($this->comprobar_id_profesor($id)) 
        {
            $sql = "DELETE FROM profesor WHERE ID_Profe = ?";
            $stmt = $this->conect->prepare($sql);
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                return true; // Borrado exitoso
            } else {
                return false; // Error al borrar el profesor
            }
        } else {
            // El profesor con el ID dado no existe
            return false;
        }
    }
    
}
?>