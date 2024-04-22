
<form method="post" action="insertarINCprueba1.php">
          
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