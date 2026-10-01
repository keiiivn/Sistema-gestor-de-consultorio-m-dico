--C1. JOIN de tres o más tablas (patrón P1)
SELECT
    p.nombre AS paciente,
    c.fecha,
    c.diagnostico,
    m.cedula AS cedula_medico
FROM "Consultas" c
JOIN "Pacientes" p
    ON p.id_paciente = c.id_paciente
JOIN "Medicos" m
    ON m.id_medico = p.id_medico
LIMIT 20;

-- C2. Registros padre sin actividad (patrón P2 o P5)
SELECT 
    p.id_paciente, 
    p.nombre, 
    p.fecha_registro
FROM "Pacientes" p
LEFT JOIN "Consultas" c ON p.id_paciente = c.id_paciente
WHERE c.id_consulta IS NULL;


-- C3. Agregación con GROUP BY y HAVING (patrón P3)
SELECT
	p.id_paciente,
	p.nombre,
	COUNT(c.id_consulta) AS total_consultas
FROM "Pacientes" p
JOIN "Consultas" c
	ON p.id_paciente = c.id_paciente
GROUP BY p.id_paciente, p.nombre
HAVING COUNT(c.id_consulta) > 100
ORDER BY total_consultas DESC;

-- C4. Subconsulta en WHERE (patrón P4)

SELECT 
    id_paciente, 
    nombre, 
    fecha_registro
FROM "Pacientes" p
WHERE NOT EXISTS (
    SELECT 1 
    FROM "Consultas" c 
    WHERE c.id_paciente = p.id_paciente
);

--C5. EXISTS o NOT EXISTS (patrón P5)
SELECT
    p.id_paciente,
    p.nombre
FROM "Pacientes" p
WHERE EXISTS (
    SELECT 1
    FROM "Consultas" c
    WHERE c.id_paciente = p.id_paciente
);
