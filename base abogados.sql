CREATE TABLE nna (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_nna VARCHAR(255),
    genero_nna VARCHAR(50),
    fecha_nacimiento DATE,
    nacionalidad_nna VARCHAR(100),
    direccion_nna TEXT,
    numero_documento VARCHAR(50),
    estado_salud TEXT,
    nombre_tutor VARCHAR(255),
    parentesco_tutor VARCHAR(100),
    telefono_tutor VARCHAR(20),
    email_tutor VARCHAR(100),
    direccion_tutor TEXT,
    tipo_abuso TEXT,
    fecha_incidente DATE,
    ubicacion_incidente TEXT,
    descripcion_incidente TEXT
);
