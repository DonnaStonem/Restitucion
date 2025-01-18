<?php
// Conexión a la base de datos
$host = 'localhost'; // O tu host de base de datos
$dbname = 'prueba';
$user = 'postgres';
$password = '3DuarDo11.';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
    exit;
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos de las medidas
    $curp = $_POST['curp'];
    $Nommedida = $_POST['Nommedida'];
    $estrategia = $_POST['estrategia'];
    $descripcion = $_POST['descripcion'];
    $tipmedida = $_POST['tipmedida'];
    $urgente = ($_POST['urgente'] == 'si') ? true : false;
    $especial = ($_POST['especial'] == 'si') ? true : false;
    $temporal = ($_POST['temporal'] == 'si') ? true : false;
    $unidad_medida = $_POST['unidad_medida'];
    $meta = $_POST['meta'];

    // Recibir datos de las acciones
    $Nomaccion = $_POST['Nomaccion'];
    $descripcion_accion = $_POST['descripcion_accion'];
    $fecha_accion = $_POST['fecha_accion'];
    $hora_accion = $_POST['hora_accion'];
    $responsable = $_POST['responsable'];
    $involucrados = $_POST['involucrados'];
    $progreso_accion = $_POST['progreso_accion'];

    // Manejo de archivo (si es que se sube uno)
    $evidencia_accion = null;
    if (isset($_FILES['evidencia_accion']) && $_FILES['evidencia_accion']['error'] == UPLOAD_ERR_OK) {
        $evidencia_accion = file_get_contents($_FILES['evidencia_accion']['tmp_name']);
    }

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO medidas_acciones 
            (curp,Nommedida, estrategia, descripcion, tipmedida, urgente, especial, temporal, unidad_medida, meta,
             Nomaccion, descripcion_accion, fecha_accion, hora_accion, responsable, involucrados, evidencia_accion, progreso_accion)
            VALUES 
            (:curp, :Nommedida, :estrategia, :descripcion, :tipmedida, :urgente, :especial, :temporal, :unidad_medida, :meta,
             :Nomaccion, :descripcion_accion, :fecha_accion, :hora_accion, :responsable, :involucrados, :evidencia_accion, :progreso_accion)";

    $stmt = $pdo->prepare($sql);

    // Enlazar los parámetros
    $stmt->bindParam(':curp', $curp);
    $stmt->bindParam(':Nommedida', $Nommedida);
    $stmt->bindParam(':estrategia', $estrategia);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':tipmedida', $tipmedida);
    $stmt->bindParam(':urgente', $urgente, PDO::PARAM_BOOL);
    $stmt->bindParam(':especial', $especial, PDO::PARAM_BOOL);
    $stmt->bindParam(':temporal', $temporal, PDO::PARAM_BOOL);
    $stmt->bindParam(':unidad_medida', $unidad_medida);
    $stmt->bindParam(':meta', $meta);
    $stmt->bindParam(':Nomaccion', $Nomaccion);
    $stmt->bindParam(':descripcion_accion', $descripcion_accion);
    $stmt->bindParam(':fecha_accion', $fecha_accion);
    $stmt->bindParam(':hora_accion', $hora_accion);
    $stmt->bindParam(':responsable', $responsable);
    $stmt->bindParam(':involucrados', $involucrados);
    $stmt->bindParam(':evidencia_accion', $evidencia_accion, PDO::PARAM_LOB);
    $stmt->bindParam(':progreso_accion', $progreso_accion);

    // Ejecutar la consulta
    try {
        $stmt->execute();
        echo "Formulario enviado correctamente.";
    } catch (PDOException $e) {
        echo "Error al insertar los datos: " . $e->getMessage();
    }
}
?>
