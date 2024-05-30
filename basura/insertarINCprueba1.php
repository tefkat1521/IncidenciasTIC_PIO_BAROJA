<html>
<head>
<title>Inserccion Prueba 1</title>
</head>
<body>
    <H1>INSERTA UNA INCIDENCIA</H1>

<?php
$conexion = mysqli_connect("localhost","root","","incidencias_tic");
mysqli_select_db($conexion,"incidencias_tic") or die ("No se puede seleccionar la BD");

if(isset($_POST["hecho"]))
{
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $IDaleatorio = $_POST['tipo_inc'].substr(str_shuffle($caracteres), 0, 5);
    
    $query = "INSERT into incidencias VALUES
    ('". $IDaleatorio ."', '". date("Y-m-d") ."','". $_POST['descripcion']."' , '".$_POST['ciclo']."' ,".$_POST['aula'].", ".$_POST['profesor'].", '".$_POST['tipo_inc']."',".$_POST['niveldeprioridad'].", 'Pendiente')";

    mysqli_query($conexion, $query);
    if (mysqli_connect_errno()) {
        printf("<p>Conexión fallida: %s</p>", mysqli_connect_error());
        exit();
    }

    echo "Hecho!";
}
else
{
    $Profes = mysqli_query($conexion, "SELECT * FROM profesor");
    $Aulas = mysqli_query($conexion, "SELECT * FROM aula");
    $Tipos = mysqli_query($conexion, "SELECT * FROM tipo_incidencia");
    $Ciclos = mysqli_query($conexion, "SELECT * FROM ciclo");

    ?>

    <form method="post" action="insertarINCprueba1.php">
        
        <label>PROFESOR</label>
        <select name="profesor" required>
            <option value="" selected disabled>Selecciona un profe</option> 
            <?php while ($pro = mysqli_fetch_assoc($Profes)) { ?>
                <option value='<?php echo $pro["ID_Profe"]; ?>'><?php echo $pro["nombre"]; ?></option>
            <?php } ?>
        </select><br>

        <label>AULA</label>
        <select name="aula" required>
            <option value="" selected disabled>Selecciona un aula</option> 
            <?php while ($aul = mysqli_fetch_assoc($Aulas)) { ?>
                <option value='<?php echo $aul["ID_Aula"]; ?>'><?php echo $aul["Nombre_aula"]; ?></option>
            <?php } ?>
        </select><br>

        <label>CICLO</label>
        <select name="ciclo" required>
            <option value="" selected disabled>Selecciona un ciclo</option> 
            <?php while ($ciclo = mysqli_fetch_assoc($Ciclos)) { ?>
                <option value='<?php echo $ciclo["id_ciclo"]; ?>'><?php echo $ciclo["ciclo"]; ?></option>
            <?php } ?>
        </select><br>

        <label>Tipo incidencia</label>
        <select name="tipo_inc" required>
            <option value="" selected disabled>Selecciona tipo</option> 
            <?php while ($tip = mysqli_fetch_assoc($Tipos)) { ?>
                <option value='<?php echo $tip["id_tipo_incidencia"]; ?>'><?php echo $tip["tipo_incidencia"]; ?></option>
            <?php } ?>
        </select><br>

        <label>Nivel de urgencia</label>
        <label><input type="radio" name="niveldeprioridad" value="1" required>1</label>
        <label><input type="radio" name="niveldeprioridad" value="2" required>2</label>
        <label><input type="radio" name="niveldeprioridad" value="3" required>3</label><br>

        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea><br>
    
        <input type="submit" name="hecho" value="Insertar">
    </form>
<?php } ?>
</body>
</html>
