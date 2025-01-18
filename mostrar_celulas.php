<?php
// Conexión a la base de datos
$host = "localhost";
$dbname = "prueba";
$user = "postgres";
$password = "3DuarDo11.";
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Error de conexión: " . pg_last_error());
}

// Consulta los datos de la tabla
$query = "SELECT * FROM celulas_trabajo";
$result = pg_query($conn, $query);

if (!$result) {
    die("Error al ejecutar la consulta: " . pg_last_error());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Células de Trabajo</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Listado de Células de Trabajo</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Trabajador Social</th>
                <th>Abogado</th>
                <th>Psicólogo</th>
                <th>Médico</th>
                <th>Director</th>
                <th>Número de Célula</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = pg_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['id_trabajador_social']; ?></td>
                    <td><?php echo $row['id_abogado']; ?></td>
                    <td><?php echo $row['id_psicologo']; ?></td>
                    <td><?php echo $row['id_medico']; ?></td>
                    <td><?php echo $row['id_director']; ?></td>
                    <td><?php echo $row['numero_celula']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php
    // Cerrar la conexión a la base de datos
    pg_close($conn);
    ?>
</body>
</html>
