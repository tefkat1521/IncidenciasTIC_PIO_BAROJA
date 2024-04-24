<?php
require "conexion.php";

class aula extends conexion
{

    public function aula()
    {
        parent::__construct();
    }

    public function get_aula()
    {
        $lista = $this->conect->query("SELECT * FROM aula");

        $aula = $lista->fetch_all(MYSQLI_ASSOC);

        return $aula;
    }
}
?>