<?php 

class Conexion
{
    protected $conect;

    public function __construct()
    {
        // Intenta conectarte a la base de datos
        $this->conect = new mysqli("localhost", "admindb", "admin", "incidencias_tic");

        // Verifica si la conexión falló
        if($this->conect->connect_errno) {
            echo "Fallo al conectar con la BBDD MySql: ". $this->conect->connect_error;
            error_log("Error de conexión a MySQL: " . $this->conect->connect_error); // Escribir en el log de errores
            return;
        } 

        // Establecer el conjunto de caracteres
        if (!$this->conect->set_charset('utf8')) {
            echo "Error al cargar el conjunto de caracteres utf8: ". $this->conect->error;
            error_log("Error al cargar el conjunto de caracteres utf8: " . $this->conect->error); // Escribir en el log de errores
        }
    }
    
    // Método para obtener la conexión, si es necesario
    public function getConect()
    {
        return $this->conect;
    }
}

// Prueba de conexión
$conexion = new Conexion();
?>
