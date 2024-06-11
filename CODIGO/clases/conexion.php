<?php 

class Conexion
{
    protected $conect;

    public function __construct()
    {
        $this->conect = new mysqli("localhost","root",'',"incidencias_tic");
        if($this->conect->connect_errno) {
            echo "Fallo al conectar con la BBDD MySql: ". $this->conect->connect_errno;
            return;
        } 
        $this->conect->set_charset('utf8');
    }
    
}
?>