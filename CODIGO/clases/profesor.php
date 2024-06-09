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
        $sql = "SELECT nombre FROM Profesor WHERE correo = ? OR SUBSTRING_INDEX(correo, '@', 1) = ?";
        $stmt = $this->conect->prepare($sql);
        $stmt->bind_param("ss", $correo, $correo);
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

    /***********COMPROBAR si existe PROFESOR************* */
    public function comprobar_correo_contrasena_con_arroba($correo, $password)
    {
        $sql = "SELECT clave_acceso FROM profesor WHERE correo = ?";
        $stmt = $this->conect->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_password = $row['clave_acceso'];
            if (password_verify($password, $stored_password)) {
                return true; 
            } elseif ($password === $stored_password) {
                return true; 
            } else {
                return false; 
            }
        } else {
            return false; 
        }
    }

    public function comprobar_correo_contrasena_sin_arroba($correo, $password)
    {
        $sql = "SELECT clave_acceso FROM profesor WHERE SUBSTRING_INDEX(correo, '@', 1) = ?";
        $stmt = $this->conect->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_password = $row['clave_acceso'];
            if (password_verify($password, $stored_password)) {
                return true; 
            } elseif ($password === $stored_password) {
                return true; 
            } else {
                return false; 
            }
        } else {
            return false; 
        }
    }

public function comprobar_correo_o_usuario_existe($correo)
{
    $sql = "SELECT correo FROM profesor WHERE SUBSTRING_INDEX(correo, '@', 1) = ? OR correo = ?";
    $stmt = $this->conect->prepare($sql);
    $stmt->bind_param("ss", $correo, $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return 'true'; // El correo existe
    } else {
        return 'false'; // El correo no existe
    }
}
/******************************************************************************************/ 

    public function insertar_profesor($nombre, $correo, $password, $dep)
    {
        do {
            $id = rand(10000, 99999);
        } while ($this->comprobar_id_profe($id));
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO profesor (ID_Profe, nombre, correo, clave_acceso, dep) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conect->prepare($sql);
        $stmt->bind_param("isssi", $id, $nombre, $correo, $hashed_password, $dep);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al ejecutar la declaración preparada: " . $stmt->error . "\n"; // Registro del error
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
        if ($count > 0){
            return true; 
        } else{
            return false; 
        }
    }

public function borrar_profesor($usu)
{
    $sql = "DELETE FROM profesor WHERE SUBSTRING_INDEX(correo, '@', 1) = ? OR correo = ?";
    $stmt = $this->conect->prepare($sql);
    $stmt->bind_param("ss", $usu, $usu);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
    /******************************/

    public function updatecontraseña($pass, $user)
    {
        $sql = "UPDATE profesor SET clave_acceso = ? WHERE correo LIKE ?";
        $stmt = $this->conect->prepare($sql);
        $user = $user . '%';
        $stmt->bind_param("ss", $pass, $user);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>