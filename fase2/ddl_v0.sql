
CREATE TABLE "Usuarios" (
    id_usuario BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(50) NOT NULL
);


CREATE TABLE "Medicos" (
    id_medico BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    cedula VARCHAR(50) UNIQUE NOT NULL,
    id_usuario BIGINT UNIQUE,
    CONSTRAINT fk_medicos_usuarios 
        FOREIGN KEY (id_usuario) REFERENCES "Usuarios"(id_usuario) 
        ON DELETE SET NULL ON UPDATE CASCADE
);


CREATE TABLE "Pacientes" (
    id_paciente BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    sexo CHAR(1),
    telefono VARCHAR(20),
    fecha_registro TIMESTAMPTZ DEFAULT NOW(),
    alergias TEXT,
    antecedentes TEXT,
    ultima_consulta TIMESTAMPTZ,
    id_medico BIGINT,
    CONSTRAINT fk_pacientes_medicos 
        FOREIGN KEY (id_medico) REFERENCES "Medicos"(id_medico) 
        ON DELETE SET NULL ON UPDATE CASCADE
);


CREATE TABLE "Consultas" (
    id_consulta BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    motivo TEXT NOT NULL,
    signos_vitales TEXT,
    revision_fisica TEXT,
    fecha TIMESTAMPTZ DEFAULT NOW(),
    diagnostico TEXT,
    resultados TEXT,
    edad INT,
    altura NUMERIC(5, 2),
    peso NUMERIC(5, 2),
    id_paciente BIGINT NOT NULL,
    CONSTRAINT fk_consultas_pacientes 
        FOREIGN KEY (id_paciente) REFERENCES "Pacientes"(id_paciente) 
        ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE "Recetas" (
    id_receta BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    indicaciones TEXT NOT NULL,
    fecha TIMESTAMPTZ DEFAULT NOW(),
    id_consulta BIGINT NOT NULL,
    CONSTRAINT fk_recetas_consultas 
        FOREIGN KEY (id_consulta) REFERENCES "Consultas"(id_consulta) 
        ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE "Estudios" (
    id_estudio BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre_archivo VARCHAR(255) NOT NULL,
    ruta_archivo VARCHAR(500) NOT NULL,
    fecha TIMESTAMPTZ DEFAULT NOW(),
    id_consulta BIGINT NOT NULL,
    CONSTRAINT fk_estudios_consultas 
        FOREIGN KEY (id_consulta) REFERENCES "Consultas"(id_consulta) 
        ON DELETE CASCADE ON UPDATE CASCADE
);