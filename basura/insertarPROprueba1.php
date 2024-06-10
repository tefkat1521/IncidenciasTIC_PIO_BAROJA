<?php
require "clases/profesor.php";
require "clases/departamento.php";

if(isset($_POST["hecho"]))
    { 
        $prof = new profesor();
        $prof->insertar_profesor($_POST["nombre"], $_POST["correo"], $_POST["pass"], $_POST["dept"]);
        if($prof)
        {
            echo "Insertado profesor: " . $_POST["nombre"];
        }
    }

    $deps = new departamento();
    $array_deps = $deps->get_departamento();
?>


<form action="insertarPROprueba1.php" method="post" id="loginform">


    <!--AGREGAR expresiones regulares-->
    <label>Nombre Completo</label> 
    <input type="text" name="nombre" required/>
    <br>
    <label>Correo</label> 
    <input type="text" name="correo" required/>
    <br>
    <label>Departamento</label> 
    <select name="dept" required>
        <?php
            foreach($array_deps as $depart)
            {
                echo "<option value='".$depart['dep']."'>".$depart['Nombre_dep']."</option>";
            }
        ?>
    </select>
<br></br>

    <label>Contraseña</label> 
    <input type="password" name="pass" required/>
    <br>
    <label>Repita la contraseña</label> 
    <input type="password" required/>

    <input type="submit" name="hecho" value="CREAR">

</form>