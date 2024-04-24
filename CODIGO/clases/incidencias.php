<?php

require "conexion.php";

class incidencias extends conexion
{

    public function incidencias()
    {
        parent::__construct();
    }

    public function get_incidencias()
    {
        $lista = $this->conect->query("SELECT * FROM Incidencias ORDER BY niveldeprioridad");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    public function get_incidencias_datos()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.niveldeprioridad, i.estado, t.tipo_incidencia 
        FROM Incidencias i, Aula a , Tipo_Incidencia t
        WHERE a.ID_Aula = i.ID_Aula AND t.id_tipo_incidencia = i.id_tipo_incidencia 
        ORDER BY i.niveldeprioridad DESC");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    public function get_incidencias_por_profesor($profe)
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe
     FROM Incidencias i, Aula a , Tipo_Incidencia t, Profesor p
     WHERE a.ID_Aula = i.ID_Aula AND t.id_tipo_incidencia = i.id_tipo_incidencia AND p.ID_Profe = i.ID_Profe AND  p.ID_Profe = (SELECT ID_profe FROM profesor WHERE nombre = '".$profe."')
     ORDER BY i.niveldeprioridad DESC;");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    public function update_incidencia_estado($id_incidencia, $nuevo_estado)
    {
        $sql = "UPDATE Incidencias SET estado = ? WHERE id_incidencia = ?";

        $stmt = $this->conect->prepare($sql);

        $stmt->bind_param("ss", $nuevo_estado, $id_incidencia);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function update_incidencia_prioridad($id_incidencia, $nueva_prioridad)
    {
        
        $sql = "UPDATE Incidencias SET niveldeprioridad = ? WHERE id_incidencia = ?";

        $stmt = $this->conect->prepare($sql);

        $stmt->bind_param("ss", $nueva_prioridad, $id_incidencia);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


}