
-- =============================================================================
-- ESQUEMA DE BASE DE DATOS - SISTEMA MÉDICO
-- Autores: kevincin, Saul y Marquito
-- Motor: PostgreSQL
-- Descripción: Creación de tablas e integridad referencial para el módulo
--              de gestión de usuarios, médicos, pacientes, consultas y estudios.
-- =============================================================================

--------------------------------------------------------------------------------
-- 1. MÓDULO DE AUTENTICACIÓN Y ROLES
--------------------------------------------------------------------------------

-- Tabla: Usuarios
-- Almacena las credenciales y roles para el acceso al sistema.
CREATE TABLE "Usuarios" (
    id_usuario BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(50) NOT NULL
);

-- Tabla: Medicos
-- Relación 1:1 o 1:N opcional con Usuarios para otorgar perfil médico.
CREATE TABLE "Medicos" (
    id_medico BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    cedula VARCHAR(50) UNIQUE NOT NULL,
    id_usuario BIGINT UNIQUE,
    CONSTRAINT fk_medicos_usuarios 
        FOREIGN KEY (id_usuario) REFERENCES "Usuarios"(id_usuario) 
        ON DELETE SET NULL ON UPDATE CASCADE
);

--------------------------------------------------------------------------------
-- 2. MÓDULO DE PACIENTES Y EXPEDIENTE
--------------------------------------------------------------------------------

-- Tabla: Pacientes
-- Información general y clínica básica asignada a un médico tratante.
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

--------------------------------------------------------------------------------
-- 3. MÓDULO DE CONSULTAS, RECETAS Y ESTUDIOS
--------------------------------------------------------------------------------

-- Tabla: Consultas
-- Historial de atenciones médicas por paciente.
CREATE TABLE "Consultas" (
    id_consulta BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    motivo TEXT NOT NULL,
    signos_vitales TEXT,
    revision_fisica TEXT,
    fecha TIMESTAMPTZ DEFAULT NOW(),
    diagnostico TEXT,
    resultados TEXT,
    edad INT,
    altura NUMERIC(5, 2), -- Formato en metros/cm según el estándar
    peso NUMERIC(5, 2),   -- Formato en kilogramos
    id_paciente BIGINT NOT NULL,
    CONSTRAINT fk_consultas_pacientes 
        FOREIGN KEY (id_paciente) REFERENCES "Pacientes"(id_paciente) 
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla: Recetas
-- Indicaciones y prescripciones derivadas de una consulta específica.
CREATE TABLE "Recetas" (
    id_receta BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    indicaciones TEXT NOT NULL,
    fecha TIMESTAMPTZ DEFAULT NOW(),
    id_consulta BIGINT NOT NULL,
    CONSTRAINT fk_recetas_consultas 
        FOREIGN KEY (id_consulta) REFERENCES "Consultas"(id_consulta) 
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla: Estudios
-- Archivos adjuntos y documentos asociados a una consulta médica.
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
