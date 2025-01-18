<?php
// Conexión a la base de datos
$host = "localhost";
$dbname = "prueba";
$user = "postgres";
$password = "3DuarDo11.";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

// Verifica la conexión
if (!$conn) {
    die("Error de conexión: " . pg_last_error());
}

// Verificar si se recibió la solicitud de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Validar que el usuario y la contraseña no estén vacíos
    if (empty($username) || empty($password)) {
        echo "Por favor ingrese usuario y contraseña.";
        exit;
    }

    // Consultar la tabla 'usuarios' para verificar las credenciales utilizando parámetros
    $query = "SELECT * FROM usuarios WHERE curp = $1 AND password = $2";
    $result = pg_query_params($conn, $query, array($username, $password));

    if (pg_num_rows($result) > 0) {
        // Si las credenciales son correctas, redirigir según el rol
        session_start();
        $_SESSION['role'] = $role; // Guardar el rol en la sesión

        switch ($role) {
            case 'psicologo':
                header('Location: PSICOLOGO/Inicio Psicologia.html');
                break;
            case 'trabajador-social':
                header('Location: TRABAJADOR SOCIAL/Inicio Trabajador Social.html');
                break;
            case 'abogado':
                header('Location: ABOGADO/inicioAbogados.html');
                break;
            case 'capital-humano':
                header('Location: CAPITAL HUMANO/iniciocapitalhumano.html');
                break;
            case 'medico':
                header('Location: MEDICO/iniciomedico.html');
                break;
            case 'director':
                header('Location: DIRECTOR/inicioDirector.html');
                break;
            default:
                echo "Rol no válido.";
                break;
        }
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
pg_close($conn);
?>
