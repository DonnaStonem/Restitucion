<?php
// Configuración de conexión a PostgreSQL
$host = "localhost";
$dbname = "prueba";
$user = "postgres";
$password = "3DuarDo11.";

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Preparar la consulta SQL
        $sql = "INSERT INTO tutores (
                    nombre_completo, sexo, fecha_nacimiento, curp, rfc, nivel_estudios,
                    situacion_economica, idiomas, identificaciones_oficiales, domicilio,
                    condiciones_domicilio, datos_contacto, es_migrante, es_refugiada,
                    habla_espanol, tiene_discapacidad, es_aislado, fue_desplazada,
                    pertenece_institucion, parentesco_victima, trabaja
                ) VALUES (
                    :nombre_completo, :sexo, :fecha_nacimiento, :curp, :rfc, :nivel_estudios,
                    :situacion_economica, :idiomas, :identificaciones_oficiales, :domicilio,
                    :condiciones_domicilio, :datos_contacto, :es_migrante, :es_refugiada,
                    :habla_espanol, :tiene_discapacidad, :es_aislado, :fue_desplazada,
                    :pertenece_institucion, :parentesco_victima, :trabaja
                )";

        $stmt = $conn->prepare($sql);

        // Vincular parámetros
        $stmt->execute([
            ':nombre_completo' => $_POST['nombre_completo'],
            ':sexo' => $_POST['sexo'],
            ':fecha_nacimiento' => $_POST['fecha_nacimiento'],
            ':curp' => $_POST['curp'],
            ':rfc' => $_POST['rfc'],
            ':nivel_estudios' => $_POST['nivel_estudios'],
            ':situacion_economica' => $_POST['situacion_economica'],
            ':idiomas' => $_POST['idiomas'],
            ':identificaciones_oficiales' => $_POST['identificaciones_oficiales'],
            ':domicilio' => $_POST['domicilio'],
            ':condiciones_domicilio' => $_POST['condiciones_domicilio'],
            ':datos_contacto' => $_POST['datos_contacto'],
            ':es_migrante' => $_POST['es_migrante'],
            ':es_refugiada' => $_POST['es_refugiada'],
            ':habla_espanol' => $_POST['habla_espanol'],
            ':tiene_discapacidad' => $_POST['tiene_discapacidad'],
            ':es_aislado' => $_POST['es_aislado'],
            ':fue_desplazada' => $_POST['fue_desplazada'],
            ':pertenece_institucion' => $_POST['pertenece_institucion'],
            ':parentesco_victima' => $_POST['parentesco_victima'],
            ':trabaja' => $_POST['trabaja']
        ]);

        echo "Datos guardados correctamente.";
    }
} catch (PDOException $e) {
    echo "Error al guardar los datos: " . $e->getMessage();
}
?>
