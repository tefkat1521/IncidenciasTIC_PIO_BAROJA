<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "incidencias_tic");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta SQL
$sql = "SELECT * FROM departamento";

// Ejecutar la consulta
$resultado = $conexion->query($sql);

// Crear un nuevo documento XML
$xml = new SimpleXMLElement('<registros/>');

// Recorrer los resultados y agregarlos al documento XML
while ($fila = $resultado->fetch_assoc()) {
    $registro = $xml->addChild('registro');
    foreach ($fila as $campo => $valor) {
        $registro->addChild($campo, $valor);
    }
}

// Guardar el documento XML en un archivo
$xml->asXML('departamentos.xml');

// Cerrar la conexión
$conexion->close();

echo "Archivo XML generado exitosamente.";
?>
