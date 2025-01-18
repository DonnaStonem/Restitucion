<?php
// Conexión a la base de datos PostgreSQL
$host = "localhost";
$dbname = "prueba";
$user = "postgres";
$password = "3DuarDo11.";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

// Verifica la conexión
if (!$conn) {
    die("Error de conexión: " . pg_last_error());
}

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibe los datos del formulario
    $nombre = pg_escape_string($conn, $_POST['nombre']);
    $apellido_p = pg_escape_string($conn, $_POST['apellido_p']);
    $apellido_m = pg_escape_string($conn, $_POST['apellido_m']);
    $curp = pg_escape_string($conn, $_POST['curp']);
    $derecho_vulnerado = pg_escape_string($conn, $_POST['derecho_vulnerado']);
    $restitucion = pg_escape_string($conn, $_POST['restitucion']);
    $rehabilitacion = pg_escape_string($conn, $_POST['rehabilitacion']);
    $compensacion = pg_escape_string($conn, $_POST['compensacion']);
    $satisfaccion = pg_escape_string($conn, $_POST['satisfaccion']);
    $no_repeticion = pg_escape_string($conn, $_POST['no_repeticion']);

    // Inserta los datos en la tabla
    $query = "INSERT INTO niños_derechos_vulnerados 
              (nombre, apellido_p, apellido_m, curp, derecho_vulnerado, restitucion, rehabilitacion, compensacion, satisfaccion, no_repeticion)
              VALUES ('$nombre', '$apellido_p', '$apellido_m', '$curp', '$derecho_vulnerado', '$restitucion', '$rehabilitacion', '$compensacion', '$satisfaccion', '$no_repeticion')";

    // Ejecuta la consulta
    $result = pg_query($conn, $query);

    // Verifica si la inserción fue exitosa
    if ($result) {
        echo "Datos guardados correctamente.";
    } else {
        echo "Error al guardar los datos: " . pg_last_error($conn);
    }
}

// Cierra la conexión
pg_close($conn);
?>
