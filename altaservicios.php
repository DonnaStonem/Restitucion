<?php
// Parámetros de conexión
$host = 'localhost'; // O la dirección de tu servidor de base de datos // Puerto por defecto de PostgreSQL
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
    $nomservicio = $_POST['nomservicio'];
    $tipo = $_POST['tipo'];
    $derechos = $_POST['derechos'];
    $unidadmed = $_POST['unidadmed'];
    $precio = $_POST['precio'];

    // Insertamos los datos en la base de datos
    $query = "INSERT INTO servicios (nomservicio, tipo, derechos, unidadmed, precio) 
              VALUES (:nomservicio, :tipo, :derechos, :unidadmed, :precio)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nomservicio', $nomservicio);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':derechos', $derechos);
    $stmt->bindParam(':unidadmed', $unidadmed);
    $stmt->bindParam(':precio', $precio);

    try {
        $stmt->execute();
        echo "<p>El servicio se ha dado de alta correctamente.</p>";
    } catch (PDOException $e) {
        echo "<p>Error al insertar los datos: " . $e->getMessage() . "</p>";
    }
}
?>
