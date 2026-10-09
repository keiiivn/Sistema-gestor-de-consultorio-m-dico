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

--C6. CTE en dos pasos (patrón P6)

-- Paso 1: Identificar a los pacientes que SÍ tienen consultas
WITH pacientes_con_consultas AS (
    SELECT DISTINCT id_paciente 
    FROM "Consultas"
)
-- Paso 2: Seleccionar a los pacientes que no están en la lista anterior
SELECT 
    p.id_paciente, 
    p.nombre, 
    p.fecha_registro
FROM "Pacientes" p
LEFT JOIN pacientes_con_consultas c ON p.id_paciente = c.id_paciente
WHERE c.id_paciente IS NULL;

-- C7. Tendencia en el tiempo sobre su tabla grande (patrón P3 con date_trunc)
SELECT 
    DATE_TRUNC('month', fecha) AS mes,
    COUNT(id_consulta) AS total_consultas
FROM "Consultas"
GROUP BY mes
ORDER BY mes;

-- C8. Reto (opcional; obligatorio como segunda consulta en equipos de cuatro): función de ventana
SELECT 
    p.nombre,
    DATE_TRUNC('month', c.fecha) AS mes,
    COUNT(c.id_consulta) AS total_consultas,
    RANK() OVER (
        PARTITION BY DATE_TRUNC('month', c.fecha) 
        ORDER BY COUNT(c.id_consulta) DESC
    ) AS lugar
FROM "Consultas" c
JOIN "Pacientes" p ON p.id_paciente = c.id_paciente
GROUP BY p.id_paciente, p.nombre, DATE_TRUNC('month', c.fecha)
ORDER BY mes, lugar;



## Diagnóstico 7 oct

### Veredictos y Columnas Candidatas

* **C1 (JOIN de tres o más tablas):**
  * **Veredicto:** **Requiere índice.** Los cruces de tablas realizan escaneos secuenciales (`Seq Scan`) en la tabla transaccional debido a la falta de índices en las llaves foráneas.
  * **Columnas candidatas:** `"Consultas".id_paciente`, `"Pacientes".id_medico`

* **C2 (Registros padre sin actividad - LEFT JOIN):**
  * **Veredicto:** **Requiere índice.** Acelera el cruce anti-join entre pacientes y consultas, además de optimizar el filtro por nombre.
  * **Columnas candidatas:** `"Consultas".id_paciente`, `"Pacientes".nombre`

* **C3 (Agregación con GROUP BY y HAVING):**
  * **Veredicto:** **Requiere índice.** La agregación y conteo por paciente exige leer miles de filas en memoria; un índice resuelve la agrupación directamente desde la clave.
  * **Columnas candidatas:** `"Consultas".id_paciente`

* **C4 (Subconsulta en WHERE - NOT EXISTS):**
  * **Veredicto:** **Requiere índice.** Evaluar la inexistencia de registros en la tabla hija requiere búsquedas logarítmicas $O(\log n)$ para evitar recorridos completos por cada paciente.
  * **Columnas candidatas:** `"Consultas".id_paciente`

* **C5 (Subconsulta EXISTS):**
  * **Veredicto:** **Requiere índice.** Permite al planificador detener la búsqueda en el primer acierto (`Index Scan`) sin escanear la tabla entera.
  * **Columnas candidatas:** `"Consultas".id_paciente`

* **C6 (CTE en dos pasos):**
  * **Veredicto:** **Requiere índice.** El paso de extracción de IDs únicos (`SELECT DISTINCT id_paciente`) sobre la tabla grande se resuelve de forma casi instantánea mediante un índice.
  * **Columnas candidatas:** `"Consultas".id_paciente`

* **C7 (Tendencia en el tiempo sobre tabla grande):**
  * **Veredicto:** **No requiere índice.** Procesa el 100% de los registros para agrupar por mes y utiliza `DATE_TRUNC`, por lo que el `Seq Scan` es la opción más rápida.
  * **Columnas candidatas:** Ninguna

* **C8 (Función de ventana / RANK):**
  * **Veredicto:** **Requiere índice.** Optimiza el `JOIN` con pacientes y acelera la ordenación y particionado temporal.
  * **Columnas candidatas:** `"Consultas".id_paciente`, `"Consultas".fecha`




# Resultados de Optimización por Índice - 8 Oct

## Índice: `consultas_id_paciente_idx`

| Métrica | Detalle |
| :--- | :--- |
| **Consulta** | C5 |
| **Antes** | Hash Join · 468 buffers · 346.568 ms |
| **Después** | Nested Loop Semi Join + Index Only Scan · 1057 buffers · 1.420 ms |
| **Veredicto** | **Se queda.** El tiempo bajó considerablemente y PostgreSQL comenzó a utilizar el índice. |

---

## Índice: `consultas_paciente_fecha_idx`

| Métrica | Detalle |
| :--- | :--- |
| **Consulta** | C8 |
| **Antes** | Hash Join · 468 buffers · 17.250 ms |
| **Después** | Incremental Sort + WindowAgg · 474 buffers · 16.8 ms |
| **Veredicto** | **Se borra.** La mejora fue mínima y el plan siguió realizando ordenamientos y agregaciones sobre la mayor parte de los registros. |

---

## Índice: `consultas_id_paciente_c3_idx`

| Métrica | Detalle |
| :--- | :--- |
| **Consulta** | C3 |
| **Antes** | Sort · 471 buffers · 303.824 ms |
| **Después** | Sort + HashAggregate + Hash Join · 471 buffers · 11.959 ms |
| **Veredicto** | **Se queda.** Aunque el plan cambió poco, el tiempo de ejecución disminuyó significativamente. |
