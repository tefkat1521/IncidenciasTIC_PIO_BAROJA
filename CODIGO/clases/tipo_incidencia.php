<?php
require_once  "conexion.php";



class Tipo_Incidencia extends conexion
{

    public function Tipo_Incidencia()
    {
        parent::__construct();
    }

    public function get_Tipo_Incidencia()
    {
        $lista = $this->conect->query("SELECT * FROM Tipo_Incidencia");

        $Tipo_Incidencia = $lista->fetch_all(MYSQLI_ASSOC);

        return $Tipo_Incidencia;
    }
}
?>