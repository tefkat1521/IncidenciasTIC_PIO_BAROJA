<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/src/Exception.php';
require '../vendor/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/src/SMTP.php';

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
        FROM Incidencias i
        JOIN Aula a ON a.ID_Aula = i.ID_Aula
        JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia
        LEFT JOIN ciclo c ON c.id_ciclo = i.id_ciclo
        ORDER BY i.niveldeprioridad DESC, i.fecha DESC");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    /**
     * Datos comletos por fecha mas reciente
     */
    public function get_incidencias_datos_recientes()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, c.ciclo, i.niveldeprioridad, i.estado, t.tipo_incidencia 
        FROM Incidencias i
        JOIN Aula a ON a.ID_Aula = i.ID_Aula
        JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia
        LEFT JOIN ciclo c ON c.id_ciclo = i.id_ciclo
        WHERE i.estado != 'Solucionado'
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
        FROM Incidencias i
        JOIN Aula a ON a.ID_Aula = i.ID_Aula
        JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia
        LEFT JOIN ciclo c ON c.id_ciclo = i.id_ciclo
        WHERE i.estado != 'Solucionado'
        ORDER BY i.fecha ASC");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    /**
     * Datos por profesor
     */
    public function get_incidencias_por_profesor($profe)
    {
        $stmt = $this->conect->prepare("
        SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.niveldeprioridad, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo 
        FROM Incidencias i
        JOIN Aula a ON a.ID_Aula = i.ID_Aula 
        JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia 
        JOIN Profesor p ON p.ID_Profe = i.ID_Profe 
        LEFT JOIN Ciclo c ON c.id_ciclo = i.id_ciclo 
        WHERE i.estado != 'Solucionado' 
        AND p.correo LIKE ?
        ORDER BY i.fecha DESC");

        $like_profe = "%$profe%";
        $stmt->bind_param("s", $like_profe);
        $stmt->execute();
        $result = $stmt->get_result();
        $incidencias = $result->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }


    /**
     *  Datos por incidencia sin ansignar (sin nivel de prioridad)
     */
    public function get_incidencias_sin_asignar()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.niveldeprioridad, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i
        JOIN Aula a ON a.ID_Aula = i.ID_Aula
        JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia
        JOIN Profesor p ON p.ID_Profe = i.ID_Profe
        LEFT JOIN Ciclo c ON c.id_ciclo = i.id_ciclo
        WHERE i.estado != 'Solucionado'
        AND i.niveldeprioridad IS NULL
        ORDER BY i.fecha ASC;");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    /**
     *  Datos por incidencia prioridad baja
     */
    public function get_incidencias_prioridad_baja()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.niveldeprioridad, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i
        JOIN Aula a ON a.ID_Aula = i.ID_Aula
        JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia
        JOIN Profesor p ON p.ID_Profe = i.ID_Profe
        LEFT JOIN Ciclo c ON c.id_ciclo = i.id_ciclo
        WHERE i.estado != 'Solucionado'
        AND i.niveldeprioridad = 1
        ORDER BY i.fecha ASC;");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

     /**
     *  Datos por incidencia prioridad media
     */
    public function get_incidencias_prioridad_media()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.niveldeprioridad, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i
        JOIN Aula a ON a.ID_Aula = i.ID_Aula
        JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia
        JOIN Profesor p ON p.ID_Profe = i.ID_Profe
        LEFT JOIN Ciclo c ON c.id_ciclo = i.id_ciclo
        WHERE i.estado != 'Solucionado'
        AND i.niveldeprioridad = 2
        ORDER BY i.fecha ASC;");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

     /**
     *  Datos por incidencia prioridad alta
     */
    public function get_incidencias_prioridad_alta()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.niveldeprioridad, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i
        JOIN Aula a ON a.ID_Aula = i.ID_Aula
        JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia
        JOIN Profesor p ON p.ID_Profe = i.ID_Profe
        LEFT JOIN Ciclo c ON c.id_ciclo = i.id_ciclo
        WHERE i.estado != 'Solucionado'
        AND i.niveldeprioridad = 3
        ORDER BY i.fecha ASC;");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    /**
     *  Datos por incidencia en proceso
     */
    public function get_incidencias_en_proceso()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.niveldeprioridad, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i
        JOIN Aula a ON a.ID_Aula = i.ID_Aula
        JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia
        JOIN Profesor p ON p.ID_Profe = i.ID_Profe
        LEFT JOIN Ciclo c ON c.id_ciclo = i.id_ciclo
        WHERE i.estado = 'En_proceso'
        ORDER BY i.niveldeprioridad DESC;");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

    /**
     *  Datos por incidencia en solucionado
     */
    public function get_incidencias_en_solucionado()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.niveldeprioridad, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i
        JOIN Aula a ON a.ID_Aula = i.ID_Aula
        JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia
        JOIN Profesor p ON p.ID_Profe = i.ID_Profe
        LEFT JOIN Ciclo c ON c.id_ciclo = i.id_ciclo
        WHERE i.estado = 'Solucionado'
        ORDER BY i.fecha ASC;");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }


    /**
     *  Datos por incidencia en pediente ,creada,
     */
    public function get_incidencias_en_pediente()
    {
        $lista = $this->conect->query("SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.niveldeprioridad, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
        FROM Incidencias i
        JOIN Aula a ON a.ID_Aula = i.ID_Aula
        JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia
        JOIN Profesor p ON p.ID_Profe = i.ID_Profe
        LEFT JOIN Ciclo c ON c.id_ciclo = i.id_ciclo
        WHERE i.estado = 'Creada'
        ORDER BY i.fecha ASC;");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

     /**
     *  Datos por incidencia por aula
     */
    public function get_incidencias_por_aula($aula)
    {
        $stmt = $this->conect->prepare("
            SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.niveldeprioridad, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
            FROM Incidencias i
            JOIN Aula a ON a.ID_Aula = i.ID_Aula
            JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia
            JOIN Profesor p ON p.ID_Profe = i.ID_Profe
            LEFT JOIN Ciclo c ON c.id_ciclo = i.id_ciclo
            WHERE i.estado = 'Pendiente'
            AND a.Nombre_aula = ?");
        $stmt->bind_param("s", $aula);
        $stmt->execute();
        $result = $stmt->get_result();
        $incidencias = $result->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }


    /**
     *  Datos por incidencia por tipo incidencia
     */
    public function get_incidencias_por_tipo($tipo)
    {
        $stmt = $this->conect->prepare("
            SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.niveldeprioridad, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
            FROM Incidencias i
            JOIN Aula a ON a.ID_Aula = i.ID_Aula
            JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia
            JOIN Profesor p ON p.ID_Profe = i.ID_Profe
            LEFT JOIN Ciclo c ON c.id_ciclo = i.id_ciclo
            WHERE i.estado = 'Pendiente'
            AND t.tipo_incidencia = ?");
        $stmt->bind_param("s", $tipo);
        $stmt->execute();
        $result = $stmt->get_result();
        $incidencias = $result->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }


    public function get_incidencia_por_id($id_incidencia)
    {
        $stmt = $this->conect->prepare("
            SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.niveldeprioridad, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
            FROM Incidencias i
            JOIN Aula a ON a.ID_Aula = i.ID_Aula 
            JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia 
            JOIN Profesor p ON p.ID_Profe = i.ID_Profe 
            JOIN Ciclo c ON c.id_ciclo = i.id_ciclo 
            WHERE i.id_incidencia = ?");

        $stmt->bind_param("i", $id_incidencia);
        $stmt->execute();
        $result = $stmt->get_result();
        $incidencia = $result->fetch_assoc();
        $stmt->close();
        return $incidencia;
    }



    /**
     *  Datos por incidencia por profe
     */
    public function get_incidencias_por_profe_fil($profe)
    {
        $stmt = $this->conect->prepare("
            SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.niveldeprioridad, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe, c.ciclo
            FROM Incidencias i
            JOIN Aula a ON a.ID_Aula = i.ID_Aula
            JOIN Tipo_Incidencia t ON t.id_tipo_incidencia = i.id_tipo_incidencia
            JOIN Profesor p ON p.ID_Profe = i.ID_Profe
            LEFT JOIN Ciclo c ON c.id_ciclo = i.id_ciclo
            WHERE i.estado = 'Pendiente'
            AND p.ID_Profe = ?");
        $stmt->bind_param("s", $profe);
        $stmt->execute();
        $result = $stmt->get_result();
        $incidencias = $result->fetch_all(MYSQLI_ASSOC);
    
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

    public function update_incidencia_estado_y_prioridad($id_incidencia, $nuevo_estado, $nueva_prioridad)
    {
        $sql = "UPDATE Incidencias SET estado = ?, niveldeprioridad = ? WHERE id_incidencia = ?";

        $stmt = $this->conect->prepare($sql);

        $stmt->bind_param("sis", $nuevo_estado, $nueva_prioridad, $id_incidencia);

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
            $stmt->bind_param("sssiiiss",$IDaleatorio, $fecha, $descripcion, $id_ciclo, $id_aula, $id_profe, $id_tipo_incidencia, $estado);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        
    }

    public function insertar_incidencia2($fecha ,$id_aula, $descripcion, $id_tipo_incidencia, $id_profe, $estado)
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do 
        {
            $IDaleatorio = $id_tipo_incidencia . substr(str_shuffle($caracteres), 0, 5);
        } 
        while ($this->comprobar_id_incidencia($IDaleatorio));

            $sql = "INSERT INTO Incidencias (id_incidencia, fecha, descripcion, ID_Aula, ID_Profe,  id_tipo_incidencia, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conect->prepare($sql);
            $stmt->bind_param("sssiiss",$IDaleatorio, $fecha, $descripcion, $id_aula, $id_profe, $id_tipo_incidencia, $estado);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        
    }

    public function borrar_incidencia($id)
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

    /****************************************CORREO*********************************************/

    public function enviarCorreo($id) {
   
        $mail = new PHPMailer(true);

        $stmt = $this->conect->prepare("
        SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, p.ID_Profe, p.correo
        FROM Incidencias i
        JOIN Aula a ON a.ID_Aula = i.ID_Aula
        JOIN Profesor p ON p.ID_Profe = i.ID_Profe 
        WHERE i.id_incidencia = ?");

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $incidencia = $result->fetch_assoc();
        $fecha = new DateTime($incidencia["fecha"]);
        $fechaFormateada = $fecha->format('d-m-Y');
        $correo = $incidencia["correo"];
        echo "<script>console.log(".$correo.");</script>";
        

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'incidenciasticpb@gmail.com'; // Tu correo de Gmail
            $mail->Password = 'sgft xhvl cdir ygwd'; // Tu contraseña de Gmail o App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remitente y destinatarios
            $mail->setFrom('incidenciasticpb@gmail.com', 'IncidenciasTIC');
            $mail->addAddress($correo, 'Profesor'); // Correo y nombre del destinatario

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Incidencia Resuelta';
            $mail->Body    = '
            <html> 
            <head> 
            <title>Prueba de correo</title> 
            </head> 
            <body> 
            
            <p> 
            La incidencia con id <b>"'.$id.'"</b> registrada el dia <b>"'.$fechaFormateada.'"</b> en el aula <b>'.$incidencia["Nombre_aula"].'</b> y descripción:<br><br>
            <b>'.$incidencia["descripcion"].'</b>.<br><br>
            Ha sido resuelta.
            </p> 
            </body> 
            </html>
            ';
            $mail->AltBody = 'Incidencia Resuelta';

            $mail->send();
            
        } catch (Exception $e) {
            echo "<script>console.log(Error al enviar el correo: {$mail->ErrorInfo})</script>";
        }
        $stmt->close();
    }


}