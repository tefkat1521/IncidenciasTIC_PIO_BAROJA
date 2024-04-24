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

    public function get_incidencias_por_profesor($profe)
    {
        $lista = $this->conect->query("SELECT * FROM Incidencias WHERE ID_Profe = (SELECT ID_Profe FROM profesor WHERE nombre = '".$profe."')");

        $incidencias = $lista->fetch_all(MYSQLI_ASSOC);

        return $incidencias;
    }

}