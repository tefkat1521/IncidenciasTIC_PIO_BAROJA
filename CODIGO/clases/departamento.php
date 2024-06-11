<?php
require_once  "conexion.php";

class departamento extends conexion
{
    public function departamento()
    {
        parent::__construct();
    }

    public function get_departamento()
    {
        $lista = $this->conect->query("SELECT * FROM Departamento");

        $departamento = $lista->fetch_all(MYSQLI_ASSOC);

        return $departamento;
    }
}
?>