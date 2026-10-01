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