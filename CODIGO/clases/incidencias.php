<?php

require_once  "conexion.php";


class incidencias extends conexion
{

    public function incidencias()
    {
        parent::__construct();
    }

    /*******************GETTER******************* */
    public function get_incidencias()
    {
        $lista = $this->conect->query("SELECT * FROM Incidencias ORDER BY niveldeprioridad");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }


    /**
     * Datos comletos
     */
    public function get_incidencias_datos()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, c.ciclo, i.niveldeprioridad, i.estado, t.tipo_incidencia 
        FROM Incidencias i, Aula a , Tipo_Incidencia t, ciclo c
        WHERE a.ID_Aula = i.ID_Aula AND t.id_tipo_incidencia = i.id_tipo_incidencia AND c.id_ciclo = i.id_ciclo 
        ORDER BY i.niveldeprioridad DESC");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    /**
     * Datos comletos por fecha mas reciente
     */
    public function get_incidencias_datos_recientes()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, c.ciclo, i.niveldeprioridad, i.estado, t.tipo_incidencia 
        FROM Incidencias i, Aula a , Tipo_Incidencia t, ciclo c
        WHERE a.ID_Aula = i.ID_Aula AND t.id_tipo_incidencia = i.id_tipo_incidencia AND c.id_ciclo = i.id_ciclo 
        ORDER BY i.fecha DESC");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    /**
     * Datos comletos por fecha mas antigua
     */
    public function get_incidencias_datos_antiguas()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, c.ciclo, i.niveldeprioridad, i.estado, t.tipo_incidencia 
        FROM Incidencias i, Aula a , Tipo_Incidencia t, ciclo c
        WHERE a.ID_Aula = i.ID_Aula AND t.id_tipo_incidencia = i.id_tipo_incidencia AND c.id_ciclo = i.id_ciclo 
        ORDER BY i.fecha ASC");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    /**
     * Datos por profesor
     */
    public function get_incidencias_por_profesor($profe)
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i, Aula a, Tipo_Incidencia t, Profesor p, Ciclo c
        WHERE a.ID_Aula = i.ID_Aula 
        AND t.id_tipo_incidencia = i.id_tipo_incidencia 
        AND p.ID_Profe = i.ID_Profe 
        AND c.id_ciclo = i.id_ciclo
        AND i.estado != 'Solucionado'
        AND p.ID_Profe = (SELECT ID_profe FROM profesor WHERE correo LIKE '%".$profe."%')
        ORDER BY i.fecha DESC;");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    /**
     *  Datos por incidencia sin ansignar (sin nivel de prioridad)
     */
    public function get_incidencias_sin_asignar()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i, Aula a, Tipo_Incidencia t, Profesor p, Ciclo c
        WHERE a.ID_Aula = i.ID_Aula 
        AND t.id_tipo_incidencia = i.id_tipo_incidencia 
        AND p.ID_Profe = i.ID_Profe 
        AND c.id_ciclo = i.id_ciclo 
        AND i.niveldeprioridad IS NULL;");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    /**
     *  Datos por incidencia prioridad baja
     */
    public function get_incidencias_prioridad_baja()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i, Aula a, Tipo_Incidencia t, Profesor p, Ciclo c
        WHERE a.ID_Aula = i.ID_Aula 
        AND t.id_tipo_incidencia = i.id_tipo_incidencia 
        AND p.ID_Profe = i.ID_Profe 
        AND c.id_ciclo = i.id_ciclo 
        AND i.niveldeprioridad = 1;");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

     /**
     *  Datos por incidencia prioridad media
     */
    public function get_incidencias_prioridad_media()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i, Aula a, Tipo_Incidencia t, Profesor p, Ciclo c
        WHERE a.ID_Aula = i.ID_Aula 
        AND t.id_tipo_incidencia = i.id_tipo_incidencia 
        AND p.ID_Profe = i.ID_Profe 
        AND c.id_ciclo = i.id_ciclo 
        AND i.niveldeprioridad = 2;");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

     /**
     *  Datos por incidencia prioridad alta
     */
    public function get_incidencias_prioridad_alta()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i, Aula a, Tipo_Incidencia t, Profesor p, Ciclo c
        WHERE a.ID_Aula = i.ID_Aula 
        AND t.id_tipo_incidencia = i.id_tipo_incidencia 
        AND p.ID_Profe = i.ID_Profe 
        AND c.id_ciclo = i.id_ciclo 
        AND i.niveldeprioridad = 3;");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    /**
     *  Datos por incidencia en proceso
     */
    public function get_incidencias_en_proceso()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i, Aula a, Tipo_Incidencia t, Profesor p, Ciclo c
        WHERE a.ID_Aula = i.ID_Aula 
        AND t.id_tipo_incidencia = i.id_tipo_incidencia 
        AND p.ID_Profe = i.ID_Profe 
        AND c.id_ciclo = i.id_ciclo 
        AND i.estado IS 'Creada';");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    /**
     *  Datos por incidencia en solucionado
     */
    public function get_incidencias_en_solucionado()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i, Aula a, Tipo_Incidencia t, Profesor p, Ciclo c
        WHERE a.ID_Aula = i.ID_Aula 
        AND t.id_tipo_incidencia = i.id_tipo_incidencia 
        AND p.ID_Profe = i.ID_Profe 
        AND c.id_ciclo = i.id_ciclo 
        AND i.estado IS 'Solucionado';");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }


    /**
     *  Datos por incidencia en pediente
     */
    public function get_incidencias_en_pediente()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i, Aula a, Tipo_Incidencia t, Profesor p, Ciclo c
        WHERE a.ID_Aula = i.ID_Aula 
        AND t.id_tipo_incidencia = i.id_tipo_incidencia 
        AND p.ID_Profe = i.ID_Profe 
        AND c.id_ciclo = i.id_ciclo 
        AND i.estado IS 'Pendiente';");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

     /**
     *  Datos por incidencia por aula
     */
    public function get_incidencias_por_aula($aula)
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i, Aula a, Tipo_Incidencia t, Profesor p, Ciclo c
        WHERE a.ID_Aula = i.ID_Aula 
        AND t.id_tipo_incidencia = i.id_tipo_incidencia 
        AND p.ID_Profe = i.ID_Profe 
        AND c.id_ciclo = i.id_ciclo 
        AND i.estado IS 'Pendiente'
        AND a.Nombre_aula = '$aula';");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    /**
     *  Datos por incidencia por tipo incidencia
     */
    public function get_incidencias_por_tipo($tipo)
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i, Aula a, Tipo_Incidencia t, Profesor p, Ciclo c
        WHERE a.ID_Aula = i.ID_Aula 
        AND t.id_tipo_incidencia = i.id_tipo_incidencia 
        AND p.ID_Profe = i.ID_Profe 
        AND c.id_ciclo = i.id_ciclo 
        AND i.estado IS 'Pendiente'
        AND t.tipo_incidencia = '$tipo';");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }


    /**
     *  Datos por incidencia por profe
     */
    public function get_incidencias_por_profe_fil($profe)
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i, Aula a, Tipo_Incidencia t, Profesor p, Ciclo c
        WHERE a.ID_Aula = i.ID_Aula 
        AND t.id_tipo_incidencia = i.id_tipo_incidencia 
        AND p.ID_Profe = i.ID_Profe 
        AND c.id_ciclo = i.id_ciclo 
        AND i.estado IS 'Pendiente'
        AND p.ID_Profe = '$profe';");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }


/****************************UPDATES******************************************* */
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
/******************************************************************************************* */



/*****************************************INSERTS******************************************** */
    

    public function comprobar_id_incidencia($id)
    {
        $sql = "SELECT COUNT(*) AS count FROM Incidencias WHERE id_incidencia = ?";
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

    public function insertar_incidencia($fecha ,$id_aula, $descripcion, $id_tipo_incidencia, $id_profe, $id_ciclo, $estado)
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do 
        {
            $IDaleatorio = $id_tipo_incidencia . substr(str_shuffle($caracteres), 0, 5);
        } 
        while ($this->comprobar_id_incidencia($IDaleatorio));

            $sql = "INSERT INTO Incidencias (id_incidencia, fecha, descripcion, id_ciclo, ID_Aula, ID_Profe,  id_tipo_incidencia, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conect->prepare($sql);
            $stmt->bind_param("sssisiss",$IDaleatorio, $fecha, $descripcion, $id_ciclo, $id_aula, $id_profe, $id_tipo_incidencia, $estado);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        
    }

    public function borrar_incidencia($id)
    {
        if ($this->comprobar_id($id)) 
        {
            $sql = "DELETE FROM Incidencias WHERE id_incidencia = ?";
            $stmt = $this->conect->prepare($sql);
            $stmt->bind_param("s", $id);
            if ($stmt->execute()) 
            {
                return true; 
            } else 
            {
                return false; 
            }
        }
         else 
        {
            
            return false;
        }
    }

    /****************************************CORREO*********************************************/

    public function enviarCorreo($remitente, $destinatario, $asunto, $mensaje) {
        // Cabeceras del correo
        $cabeceras = 'From: ' . $remitente . "\r\n" .
                     'Reply-To: ' . $remitente . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();
        
        // Envío del correo
        if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
            return true; // Correo enviado correctamente
        } else {
            return false; // Error al enviar el correo
        }
    }


}