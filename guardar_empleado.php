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
    // Obtención de datos del formulario
    $nombre = $_POST['nombre'];
    $apellido_p = $_POST['apellido_p'];
    $apellido_m = $_POST['apellido_m'];
    $curp = $_POST['curp'];
    $rfc = $_POST['rfc'];
    $sexo = $_POST['sexo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $password = $_POST['password']; // Guardar la contraseña sin encriptar
    $rol = $_POST['rol'];
    $grado_estudios = $_POST['grado_estudios'];

    // Procesar archivos subidos (foto, cédula profesional y título)
    if ($_FILES['foto']['error'] == 0) {
        $foto_perfil = base64_encode(file_get_contents($_FILES['foto']['tmp_name']));
    } else {
        die("Error al cargar la foto de perfil.");
    }

    if ($_FILES['cedula_profesional']['error'] == 0) {
        $cedula_profesional = base64_encode(file_get_contents($_FILES['cedula_profesional']['tmp_name']));
    } else {
        die("Error al cargar la cédula profesional.");
    }

    if ($_FILES['titulo']['error'] == 0) {
        $titulo = base64_encode(file_get_contents($_FILES['titulo']['tmp_name']));
    } else {
        die("Error al cargar el título.");
    }

    // Verificar que CURP y contraseña no se repitan
    $query_check = "SELECT COUNT(*) AS count FROM empleados WHERE curp = '$curp' OR password = '$password'";
    $result_check = pg_query($conn, $query_check);
    $row_check = pg_fetch_assoc($result_check);

    if ($row_check['count'] > 0) {
        die("Error: El CURP o la contraseña ya están registrados.");
    }

    // Consulta SQL para insertar los datos en la tabla general de empleados
    $query = "INSERT INTO empleados (nombre, apellido_p, apellido_m, curp, rfc, sexo, fecha_nacimiento, password, foto_perfil, rol, cedula_profesional, grado_estudios, titulo) 
              VALUES ('$nombre', '$apellido_p', '$apellido_m', '$curp', '$rfc', '$sexo', '$fecha_nacimiento', '$password', '$foto_perfil', '$rol', '$cedula_profesional', '$grado_estudios', '$titulo') 
              RETURNING id, nombre";

    // Ejecutar la consulta
    $result = pg_query($conn, $query);

    // Verificar si la inserción fue exitosa
    if ($result) {
        $row = pg_fetch_assoc($result);
        $id_empleado = $row['id']; // ID del empleado recién insertado
        $nombre_empleado = $row['nombre']; // Nombre del empleado recién insertado

        // Asignar el ID del empleado al ID del usuario
        $id_usuario = $id_empleado;

        /* Mostrar los datos recién insertados
        echo "<h3>Empleado Registrado:</h3>";
        echo "<p>ID: " . $id_empleado . "</p>";
        echo "<p>Nombre: " . $nombre_empleado . "</p>";
        echo "<p>Apellido Paterno: " . $apellido_p . "</p>";
        echo "<p>Apellido Materno: " . $apellido_m . "</p>";
        echo "<p>CURP: " . $curp . "</p>";
        echo "<p>RFC: " . $rfc . "</p>";
        echo "<p>Sexo: " . $sexo . "</p>";
        echo "<p>Fecha de Nacimiento: " . $fecha_nacimiento . "</p>";
        echo "<p>Grado de Estudios: " . $grado_estudios . "</p>";*/

        // Inserción en la tabla específica según el rol
        $tabla_rol = "";
        switch ($rol) {
            case "Trabajador Social":
                $tabla_rol = "trabajadores_sociales";
                break;
            case "Abogado":
                $tabla_rol = "abogados";
                break;
            case "Psicologo":
                $tabla_rol = "psicologos";
                break;
            case "Medico":
                $tabla_rol = "medicos";
                break;
            case "Director":
                $tabla_rol = "directores";
                break;
            default:
                echo "Rol no válido.";
                exit;
        }

        // Inserción en la tabla del rol correspondiente
        $query_rol = "INSERT INTO $tabla_rol (id_empleado, id_usuario, nombre) VALUES ('$id_empleado', '$id_usuario', '$nombre_empleado')";
        $result_rol = pg_query($conn, $query_rol);

        if ($result_rol) {
            echo "Empleado registrado correctamente en la tabla de $tabla_rol.";
        } else {
            echo "Error al registrar el empleado en la tabla de $tabla_rol: " . pg_last_error($conn);
        }

        // Verificar si se puede formar una nueva célula de trabajo
        $query_social = "SELECT id_empleado FROM trabajadores_sociales 
                         WHERE id_empleado NOT IN (SELECT id_trabajador_social FROM celulas_trabajo) 
                         LIMIT 1";
        $query_abogado = "SELECT id_empleado FROM abogados 
                          WHERE id_empleado NOT IN (SELECT id_abogado FROM celulas_trabajo) 
                          LIMIT 1";
        $query_psicologo = "SELECT id_empleado FROM psicologos 
                            WHERE id_empleado NOT IN (SELECT id_psicologo FROM celulas_trabajo) 
                            LIMIT 1";
        $query_medico = "SELECT id_empleado FROM medicos 
                         WHERE id_empleado NOT IN (SELECT id_medico FROM celulas_trabajo) 
                         LIMIT 1";
        $query_director = "SELECT id_empleado FROM directores 
                           WHERE id_empleado NOT IN (SELECT id_director FROM celulas_trabajo) 
                           LIMIT 1";

        $id_social = pg_fetch_result(pg_query($conn, $query_social), 0, 0);
        $id_abogado = pg_fetch_result(pg_query($conn, $query_abogado), 0, 0);
        $id_psicologo = pg_fetch_result(pg_query($conn, $query_psicologo), 0, 0);
        $id_medico = pg_fetch_result(pg_query($conn, $query_medico), 0, 0);
        $id_director = pg_fetch_result(pg_query($conn, $query_director), 0, 0);

        // Si existen todos los roles disponibles, formar la célula de trabajo
        if ($id_social && $id_abogado && $id_psicologo && $id_medico && $id_director) {
            // Formar una nueva célula de trabajo
            $query_celula = "INSERT INTO celulas_trabajo (id_trabajador_social, id_abogado, id_psicologo, id_medico, id_director, numero_celula)
                             VALUES ('$id_social', '$id_abogado', '$id_psicologo', '$id_medico', '$id_director', 
                             (SELECT COALESCE(MAX(numero_celula), 0) + 1 FROM celulas_trabajo))";

            if (pg_query($conn, $query_celula)) {
                echo "Nueva célula de trabajo formada correctamente.";
            } else {
                echo "Error al formar la célula de trabajo: " . pg_last_error($conn);
            }
        } else {
            echo "No se pueden formar nuevas células de trabajo, faltan roles disponibles.";
        }
    } else {
        echo "Error al registrar el empleado: " . pg_last_error($conn);
    }
    $query_usuarios = "INSERT INTO usuarios (id, password, curp, rol) 
    SELECT id, password, curp, rol FROM empleados WHERE id = '$id_empleado'";
$result_usuarios = pg_query($conn, $query_usuarios);

if ($result_usuarios) {
echo "Datos del empleado insertados correctamente en la tabla 'usuarios'.";
} else {
echo "Error al insertar los datos en la tabla 'usuarios': " . pg_last_error($conn);
}
    // Cerrar la conexión a la base de datos
    pg_close($conn);
}
?>
