<?php

require_once  "conexion.php";


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
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, c.ciclo, i.niveldeprioridad, i.estado, t.tipo_incidencia 
        FROM Incidencias i, Aula a , Tipo_Incidencia t, ciclo c
        WHERE a.ID_Aula = i.ID_Aula AND t.id_tipo_incidencia = i.id_tipo_incidencia AND c.id_ciclo = i.id_ciclo 
        ORDER BY i.niveldeprioridad DESC");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    public function get_incidencias_por_profesor($profe)
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i, Aula a, Tipo_Incidencia t, Profesor p, Ciclo c
        WHERE a.ID_Aula = i.ID_Aula 
        AND t.id_tipo_incidencia = i.id_tipo_incidencia 
        AND p.ID_Profe = i.ID_Profe 
        AND c.id_ciclo = i.id_ciclo 
        AND p.ID_Profe = (SELECT ID_profe FROM profesor WHERE nombre = '".$profe."')
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


    public function insertar_incidencia($fecha ,$id_aula, $descripcion, $id_tipo_incidencia, $id_profe, $id_ciclo, $estado)
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $IDaleatorio = $id_tipo_incidencia.substr(str_shuffle($caracteres), 0, 5);

        $sql = "INSERT INTO Incidencias (id_incidencia, fecha, descripcion, id_ciclo, ID_Aula, ID_Profe,  id_tipo_incidencia, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        // $sql = "INSERT INTO Incidencias (id_incidencia, fecha, descripcion, id_ciclo, ID_Aula, ID_Profe,  id_tipo_incidencia, estado) 
        // VALUES (?, STR_TO_DATE(?, '%Y-%m-%d'), ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conect->prepare($sql);


       
        $stmt->bind_param("sssisiss",$IDaleatorio, $fecha, $descripcion, $id_ciclo, $id_aula, $id_profe, $id_tipo_incidencia, $estado);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }



}