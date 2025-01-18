<?php
// Configuración de conexión a la base de datos
$host = "localhost";
$dbname = "prueba";
$user = "postgres";
$password = "3DuarDo11.";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recibir datos del formulario
        $fecha = $_POST['fecha'];
        $ciudad_localidad = $_POST['ciudad_localidad'];
        $narracion_sucedido = $_POST['narracion_sucedido'];
        $referencias_ubicacion = $_POST['referencias_ubicacion'];
        $nombre_nna = $_POST['nombre_nna'];
        $edad_nna = $_POST['edad_nna'];
        $nombre_responsable = $_POST['nombre_responsable'];
        $ocupacion_responsable = $_POST['ocupacion_responsable'];
        $parentesco_nna = $_POST['parentesco_nna'];
        $tipo_vivienda = $_POST['tipo_vivienda'];
        $sosten_economico = $_POST['sosten_economico'];
        $nna_nacionalidad = ($_POST['nna_nacionalidad'] === "si") ? true : false;

        // Insertar datos en la tabla
        $sql = "INSERT INTO diagnosticos_iniciales (
            fecha, ciudad_localidad, narracion_sucedido, referencias_ubicacion, 
            nombre_nna, edad_nna, nombre_responsable, ocupacion_responsable, 
            parentesco_nna, tipo_vivienda, sosten_economico, nna_nacionalidad
        ) VALUES (
            :fecha, :ciudad_localidad, :narracion_sucedido, :referencias_ubicacion, 
            :nombre_nna, :edad_nna, :nombre_responsable, :ocupacion_responsable, 
            :parentesco_nna, :tipo_vivienda, :sosten_economico, :nna_nacionalidad
        )";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':fecha' => $fecha,
            ':ciudad_localidad' => $ciudad_localidad,
            ':narracion_sucedido' => $narracion_sucedido,
            ':referencias_ubicacion' => $referencias_ubicacion,
            ':nombre_nna' => $nombre_nna,
            ':edad_nna' => $edad_nna,
            ':nombre_responsable' => $nombre_responsable,
            ':ocupacion_responsable' => $ocupacion_responsable,
            ':parentesco_nna' => $parentesco_nna,
            ':tipo_vivienda' => $tipo_vivienda,
            ':sosten_economico' => $sosten_economico,
            ':nna_nacionalidad' => $nna_nacionalidad
        ]);

        echo "Diagnóstico guardado exitosamente.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
