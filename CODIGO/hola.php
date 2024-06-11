<?php
require "clases/profesor.php";
   
        $profe = new profesor();
        if($profe->get_nombre_profesor("jesus.utrilla1") != null)
        {
            echo $profe->get_nombre_profesor("jesus.utrilla1");
        }
        else
        {
            echo "exit";
        }

?>