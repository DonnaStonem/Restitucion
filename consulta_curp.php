<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta por CURP</title>
</head>
<body>
    <h1>Consulta de Datos por CURP</h1>

    <form method="POST" action="">
        <label for="curp">CURP:</label>
        <input type="text" name="curp" id="curp" required>
        <button type="submit">Buscar</button>
    </form>

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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $curp = pg_escape_string($conn, $_POST['curp']);
        
        // Consulta en la tabla niños_derechos_vulnerados
        $query_ninos = "SELECT * FROM niños_derechos_vulnerados WHERE curp = '$curp'";
        $result_ninos = pg_query($conn, $query_ninos);

        if (pg_num_rows($result_ninos) > 0) {
            echo "<h2>Datos del Niño:</h2>";
            while ($row = pg_fetch_assoc($result_ninos)) {
                echo "<p><strong>Nombre:</strong> " . $row['nombre'] . " " . $row['apellido_p'] . " " . $row['apellido_m'] . "</p>";
                echo "<p><strong>Curp:</strong> " . $row['curp'] . "</p>";
                echo "<p><strong>Derecho Vulnerado:</strong> " . $row['derecho_vulnerado'] . "</p>";
                echo "<p><strong>Restitución:</strong> " . $row['restitucion'] . "</p>";
                echo "<p><strong>Rehabilitación:</strong> " . $row['rehabilitacion'] . "</p>";
                echo "<p><strong>Compensación:</strong> " . $row['compensacion'] . "</p>";
                echo "<p><strong>Satisfacción:</strong> " . $row['satisfaccion'] . "</p>";
                echo "<p><strong>No repetición:</strong> " . $row['no_repeticion'] . "</p>";
            }
        } else {
            echo "<p>No se encontraron datos para el CURP proporcionado en la tabla niños_derechos_vulnerados.</p>";
        }

        // Consulta en la tabla medidas_acciones
        $query_acciones = "SELECT * FROM medidas_acciones WHERE curp = '$curp'";
        $result_acciones = pg_query($conn, $query_acciones);

        if (pg_num_rows($result_acciones) > 0) {
            echo "<h2>Medidas y Acciones:</h2>";
            while ($row = pg_fetch_assoc($result_acciones)) {
                echo "<p><strong>Medida:</strong> " . @$row['Nommedida'] . "</p>";
                echo "<p><strong>Estrategia:</strong> " . $row['estrategia'] . "</p>";
                echo "<p><strong>Descripción:</strong> " . $row['descripcion'] . "</p>";
                echo "<p><strong>Tipo de medida:</strong> " . $row['tipmedida'] . "</p>";
                echo "<p><strong>Urgente:</strong> " . ($row['urgente'] ? 'Sí' : 'No') . "</p>";
                echo "<p><strong>Especial:</strong> " . ($row['especial'] ? 'Sí' : 'No') . "</p>";
                echo "<p><strong>Temporal:</strong> " . ($row['temporal'] ? 'Sí' : 'No') . "</p>";
                echo "<p><strong>Unidad de medida:</strong> " . $row['unidad_medida'] . "</p>";
                echo "<p><strong>Meta:</strong> " . $row['meta'] . "</p>";
                echo "<p><strong>Acción:</strong> " . @$row['Nomaccion'] . "</p>";
                echo "<p><strong>Descripción de la acción:</strong> " . $row['descripcion_accion'] . "</p>";
                echo "<p><strong>Fecha de la acción:</strong> " . $row['fecha_accion'] . "</p>";
                echo "<p><strong>Hora de la acción:</strong> " . $row['hora_accion'] . "</p>";
                echo "<p><strong>Responsable:</strong> " . $row['responsable'] . "</p>";
                echo "<p><strong>Involucrados:</strong> " . $row['involucrados'] . "</p>";
                echo "<p><strong>Progreso:</strong> " . $row['progreso_accion'] . "</p>";
            }
        } else {
            echo "<p>No se encontraron datos para el CURP proporcionado en la tabla medidas_acciones.</p>";
        }
    }

    // Cierra la conexión
    pg_close($conn);
    ?>
</body>
</html>
