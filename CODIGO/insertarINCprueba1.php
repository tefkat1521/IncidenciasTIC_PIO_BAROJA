<html>
<head>
<title>Inserccion Prueba 1</title>
</head>
<body>
    <H1>INSERTA UNA INCIDENCIA</H1>

<?php
    $conexion = mysqli_connect("localhost","root","","incidencias_tic");
    mysqli_select_db($conexion,"incidencias_tic") or die ("No se puede seleccionar la BD");

	// $conexion = mysqli_connect("localhost","root","","ropa");
	// mysqli_select_db($conexion,"ropa") or die ("No se puede seleccionar la BD");

    if(isset($_POST["hecho"]))
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $IDaleatorio = $_POST['tipo_inc'].substr(str_shuffle($caracteres), 0, 5);
        

        $query = "INSERT into incidencias VALUES
        ('". $IDaleatorio ."' , '". date("Y-m-d") ."','". $_POST['descripcion']."' ,".$_POST['aula'].", ".$_POST['profesor'].", '".$_POST['tipo_inc']."', 'Pendiente')";


        mysqli_query($conexion, $query);
        if (mysqli_connect_errno()) {
            printf("<p>Conexión fallida: %s</p>", mysqli_connect_error());
            exit();}

        // header("Location: insertarINCprueba1.php"); // redirige a la página del supermercado después de establecer la cookie
        // exit();
        echo "Hecho!";
    }
    else
    {
      
    // /* Lazo la consulta sobre la BD*/	
    //     $resultado = mysqli_query($conexion, "select * from pantalon");
        
    // /* para detectar errores*/
    //     if (mysqli_connect_errno()) {
    //         printf("<p>Conexión fallida: %s</p>", mysqli_connect_error());
    //         exit();
    //     }
    // }

    // /* Devuelve el número de filas del resultado */
    //     $numr = mysqli_num_rows($resultado);


    // ?>


    
        <?php
        $conexion = mysqli_connect("localhost","root","","incidencias_tic");
        mysqli_select_db($conexion,"incidencias_tic") or die ("No se puede seleccionar la BD");
        if (mysqli_connect_errno()) {
            printf("<p>Conexión fallida: %s</p>", mysqli_connect_error());
            exit();}
        $Profes = mysqli_query($conexion, "select * from profesor");
        $NM = mysqli_num_rows($Profes);
        $Aulas = mysqli_query($conexion, "select * from aula");
        $NA = mysqli_num_rows($Aulas);
        $Tipo = mysqli_query($conexion, "select * from tipo_incidencia");
        $NT = mysqli_num_rows($Tipo); 
        ?>

    <form method="post" action="insertarINCprueba1.php">
        
        <label>PROFESOR</label><!--esto vendra recogido por coockies o sesion-->
        <select name="profesor" required>
            <option value="" selected disabled>Selecciona un profe</option> 
            <?php
                if ($NM > 0) {
                    while ($pro = mysqli_fetch_array($Profes, MYSQLI_ASSOC)) {
                ?>
                        <option value='<?php echo $pro["ID_Profe"]; ?>'><?php echo $pro["nombre"]; ?></option>
                <?php
                    }
                }
                ?>
        </select>
                <br>
        <label>AULA</label><!--esto vendra recogido por coockies o sesion-->
        <select name="aula" required>
            <option value="" selected disabled>Selecciona un aula</option> 
            <?php
                if ($NA > 0) {
                    while ($aul = mysqli_fetch_array($Aulas, MYSQLI_ASSOC)) {
                ?>
                        <option value='<?php echo $aul["ID_Aula"]; ?>'><?php echo $aul["Nombre_aula"]; ?></option>
                <?php
                    }
                }
                ?>
        </select>
                <br>
        <label>Tipo incidencia</label><!--esto vendra recogido por coockies o sesion-->
        <select name="tipo_inc" required>
            <option value="" selected disabled>Selecciona tipo</option> 
            <?php
                if ($NT > 0) {
                    while ($tip = mysqli_fetch_array($Tipo, MYSQLI_ASSOC)) {
                ?>
                        <option value='<?php echo $tip["id_tipo_incidencia"]; ?>'><?php echo $tip["tipo_incidencia"]; ?></option>
                <?php
                    }
                }
                ?>
        </select>


                <br>
        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea><br>
    

        <input type="submit" name="hecho" value="Insertar">
    </form>
        <?php } ?>
    </body>
    </html>

