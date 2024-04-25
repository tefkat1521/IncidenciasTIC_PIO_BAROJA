<?php
session_start();
if(isset ($_SESSION['usuario']))
{


    require "clases/incidencias.php";
    require "clases/aulas.php";
    require "clases/ciclo.php";
    require "clases/profesor.php";
    require "clases/tipo_incidencia.php";

    echo "user: " .$_SESSION['usuario'];

    if(isset($_POST["hecho"]))
    {
        
        $fecha = date("Y-m-d");
        $objeto_profesor = new profesor();
        $id_profesor = $objeto_profesor->get_id_profesor($_SESSION['usuario']);
        echo " ".$id_profesor;
        echo " ".$fecha;
        $incidencias = new Incidencias();
        $incidencias->insertar_incidencia($fecha, $_POST["aula"], $_POST["descripcion"], $_POST["tipo"], $id_profesor, $_POST["ciclo"], "Pendiente");

    }
?>

<?php

    $aulas = new aula();
    $array_aula = $aulas->get_aula();
    
    $ciclo = new ciclo();
    $array_ciclo = $ciclo->get_ciclo();

    $Tipo_Incidencia = new Tipo_Incidencia();
    $array_tipos = $Tipo_Incidencia->get_Tipo_Incidencia();

?>

<form method="post" action="insertarINCprueba3.php">
    <label>Ciclo</label>
    <br>
    <select name="ciclo" required>
    <?php
        foreach($array_ciclo as $ciclo)
        {
            echo "<option value='".$ciclo['id_ciclo']."'>".$ciclo['ciclo']."</option>";
        }
    ?>
    </select>

        <br><br>
    <label>Aula</label>
    <br>
    <select name="aula" required>
    <?php
        foreach($array_aula as $aula)
        {
            echo "<option value='".$aula['ID_Aula']."'>".$aula['Nombre_aula']."</option>";
        }
    ?>
    </select>

    <br><br>
    <label>Tipo de Incidencia</label>
    <br>
    <select name="tipo" required>
    <?php
        foreach($array_tipos as $tipo)
        {
            echo "<option value='".$tipo['id_tipo_incidencia']."'>".$tipo['tipo_incidencia']."</option>";
        }
    ?>
    </select>

    <br><br>
    <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea><br>
    
        <input type="submit" name="hecho" value="CREAR">
</form>

<a href="index.html">Volver</a>
<?php
}
else
{
    echo "no hay user en sesion";
    echo '<a href="index.html">Volver</a>';
} 
?>