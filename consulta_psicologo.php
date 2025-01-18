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
    // Obtener el ID del psicólogo desde el formulario
    $id_psicologo = $_POST['id_psicologo'];

    // Consulta SQL para obtener la célula de trabajo donde pertenece el psicólogo
    $query = "SELECT * FROM celulas_trabajo WHERE id_psicologo = $1";
    $result = pg_query_params($conn, $query, array($id_psicologo));

    // Verificar si la consulta devuelve resultados
    if (pg_num_rows($result) > 0) {
        // Mostrar los resultados
        echo "<h2>Detalles de la Célula de Trabajo:</h2>";
        while ($row = pg_fetch_assoc($result)) {
            echo "<p><strong>Célula Número:</strong> " . $row['numero_celula'] . "</p>";
            echo "<p><strong>ID Psicólogo:</strong> " . $row['id_psicologo'] . "</p>";
            echo "<p><strong>ID Trabajador Social:</strong> " . $row['id_trabajador_social'] . "</p>";
            echo "<p><strong>ID Abogado:</strong> " . $row['id_abogado'] . "</p>";
            echo "<p><strong>ID Médico:</strong> " . $row['id_medico'] . "</p>";
            echo "<p><strong>ID Director:</strong> " . $row['id_director'] . "</p>";
        }
    } else {
        echo "<p>No se encontraron resultados para el ID del Psicólogo: $id_psicologo</p>";
    }
}

// Cerrar la conexión a la base de datos
pg_close($conn);
?>
