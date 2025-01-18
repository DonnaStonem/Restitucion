<?php
// Parámetros de conexión
$host = 'localhost'; // O la dirección de tu servidor de base de datos
$dbname = 'prueba';
$user = 'postgres';
$password = '3DuarDo11.';

// Establecer conexión con la base de datos
try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    // Establecer el modo de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Comprobamos si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibimos los datos del formulario
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $servicios = $_POST['servicios'];
    $tipos_servicios = $_POST['tipos_servicios'];
    $horario = $_POST['horario'];
    $contacto = $_POST['contacto'];
    $capacidad = $_POST['capacidad'];
    $fecha_deteccion = $_POST['fecha_deteccion'];

    // Insertamos los datos en la base de datos
    $query = "INSERT INTO actores (nombre, direccion, tipo, descripcion, servicios, tipos_servicios, horario, contacto, capacidad, fecha_deteccion) 
              VALUES (:nombre, :direccion, :tipo, :descripcion, :servicios, :tipos_servicios, :horario, :contacto, :capacidad, :fecha_deteccion)";
    
    $stmt = $pdo->prepare($query);
    
    // Vinculamos los parámetros
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':servicios', $servicios);
    $stmt->bindParam(':tipos_servicios', $tipos_servicios);
    $stmt->bindParam(':horario', $horario);
    $stmt->bindParam(':contacto', $contacto);
    $stmt->bindParam(':capacidad', $capacidad);
    $stmt->bindParam(':fecha_deteccion', $fecha_deteccion);

    try {
        // Ejecutar la consulta
        $stmt->execute();
        echo "<p>El actor se ha registrado correctamente.</p>";
    } catch (PDOException $e) {
        echo "<p>Error al insertar los datos: " . $e->getMessage() . "</p>";
    }
}
?>

