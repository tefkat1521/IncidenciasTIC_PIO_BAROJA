<?php
require "conexion.php";

class ciclo extends conexion
{

    public function ciclo()
    {
        parent::__construct();
    }

    public function get_ciclo()
    {
        $lista = $this->conect->query("SELECT * FROM ciclo");

        $ciclo = $lista->fetch_all(MYSQLI_ASSOC);

        return $ciclo;
    }
}
?>