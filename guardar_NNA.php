<?php
// Configuración de la conexión a la base de datos
$host = "localhost";
$dbname = "prueba";
$user = "postgres";
$password = "3DuarDo11.";

try {
    // Crear conexión
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar la consulta SQL
    $sql = "INSERT INTO solicitudes (
                lugar_solicitud, fecha_solicitud, quien_realiza_solicitud,
                nombre, primer_apellido, segundo_apellido, edad, nacimiento,
                enfermedades, telefono_movil, telefono_fijo, calle, codigo_postal,
                numero_exterior, numero_interior, colonia, localidad, delegacion,
                entidad_federativa, relato_hechos
            ) VALUES (
                :lugar_solicitud, :fecha_solicitud, :quien_realiza_solicitud,
                :nombre, :primer_apellido, :segundo_apellido, :edad, :nacimiento,
                :enfermedades, :telefono_movil, :telefono_fijo, :calle, :codigo_postal,
                :numero_exterior, :numero_interior, :colonia, :localidad, :delegacion,
                :entidad_federativa, :relato_hechos
            )";

    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bindParam(':lugar_solicitud', $_POST['lugar_solicitud']);
    $stmt->bindParam(':fecha_solicitud', $_POST['fecha_solicitud']);
    $stmt->bindParam(':quien_realiza_solicitud', $_POST['quien_realiza_solicitud']);
    $stmt->bindParam(':nombre', $_POST['nombre']);
    $stmt->bindParam(':primer_apellido', $_POST['primer_apellido']);
    $stmt->bindParam(':segundo_apellido', $_POST['segundo_apellido']);
    $stmt->bindParam(':edad', $_POST['edad']);
    $stmt->bindParam(':nacimiento', $_POST['nacimiento']);
    $stmt->bindParam(':enfermedades', $_POST['quien_realiza_solicitud']); // Cambiar nombre en formulario si aplica
    $stmt->bindParam(':telefono_movil', $_POST['telefono_movil']);
    $stmt->bindParam(':telefono_fijo', $_POST['telefono_fijo']);
    $stmt->bindParam(':calle', $_POST['calle']);
    $stmt->bindParam(':codigo_postal', $_POST['codigo_postal']);
    $stmt->bindParam(':numero_exterior', $_POST['numero_exterior']);
    $stmt->bindParam(':numero_interior', $_POST['numero_interior']);
    $stmt->bindParam(':colonia', $_POST['colonia']);
    $stmt->bindParam(':localidad', $_POST['localidad']);
    $stmt->bindParam(':delegacion', $_POST['delegacion']);
    $stmt->bindParam(':entidad_federativa', $_POST['entidad_federativa']);
    $stmt->bindParam(':relato_hechos', $_POST['relato_hechos']);

    // Ejecutar la consulta
    $stmt->execute();

    echo "Datos guardados correctamente.";
} catch (PDOException $e) {
    echo "Error al guardar los datos: " . $e->getMessage();
}

?>
