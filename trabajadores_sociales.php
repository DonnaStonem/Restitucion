<?php
$host = "localhost";
$dbname = "prueba";
$user = "postgres";
$password = "3DuarDo11.";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Error de conexión: " . pg_last_error());
}

$query = "SELECT id, nombre, apellido_p, apellido_m FROM empleados WHERE rol = 'Trabajador Social'";
$result = pg_query($conn, $query);

if (!$result) {
    die("Error en la consulta: " . pg_last_error($conn));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabajadores Sociales</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Trabajadores Sociales</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Célula de Trabajo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $celula = 1; // Contador para las células
                while ($row = pg_fetch_assoc($result)) {
                    $id = $row['id'];
                    $nombreCompleto = $row['nombre'] . " " . $row['apellido_p'] . " " . $row['apellido_m'];
                    echo "<tr>
                            <td>$id</td>
                            <td>$nombreCompleto</td>
                            <td>Célula $celula</td>
                          </tr>";
                    $celula++; // Incrementa la célula
                }
                pg_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
