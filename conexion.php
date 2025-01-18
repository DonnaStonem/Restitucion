<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbabogados";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos JSON de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si los datos JSON están definidos
if (isset($data['nombre_nna'])) {
    $nombre_nna = $data['nombre_nna'];
    $genero_nna = $data['genero_nna'];
    $fecha_nacimiento = $data['fecha_nacimiento'];
    $nacionalidad_nna = $data['nacionalidad_nna'];
    $direccion_nna = $data['direccion_nna'];
    $numero_documento = $data['numero_documento'];
    $estado_salud = $data['estado_salud'];
    $nombre_tutor = $data['nombre_tutor'];
    $parentesco_tutor = $data['parentesco_tutor'];
    $telefono_tutor = $data['telefono_tutor'];
    $email_tutor = $data['email_tutor'];
    $direccion_tutor = $data['direccion_tutor'];
    $tipo_abuso = $data['tipo_abuso'];
    $fecha_incidente = $data['fecha_incidente'];
    $ubicacion_incidente = $data['ubicacion_incidente'];
    $descripcion_incidente = $data['descripcion_incidente'];

    // Preparar y ejecutar la consulta SQL para insertar los datos
    $sql = "INSERT INTO nna (nombre_nna, genero_nna, fecha_nacimiento, nacionalidad_nna, direccion_nna, numero_documento, estado_salud, nombre_tutor, parentesco_tutor, telefono_tutor, email_tutor, direccion_tutor, tipo_abuso, fecha_incidente, ubicacion_incidente, descripcion_incidente) 
            VALUES ('$nombre_nna', '$genero_nna', '$fecha_nacimiento', '$nacionalidad_nna', '$direccion_nna', '$numero_documento', '$estado_salud', '$nombre_tutor', '$parentesco_tutor', '$telefono_tutor', '$email_tutor', '$direccion_tutor', '$tipo_abuso', '$fecha_incidente', '$ubicacion_incidente', '$descripcion_incidente')";

    if ($conn->query($sql) === TRUE) {
        echo "Datos guardados con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No se recibieron datos.";
}

// Cerrar la conexión
$conn->close();
?>
