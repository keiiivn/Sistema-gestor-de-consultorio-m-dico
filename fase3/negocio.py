import sqlite3
import xml.etree.ElementTree as ET

from fastapi import FastAPI, HTTPException, Response
from pydantic import BaseModel

app = FastAPI(title="API de mi negocio")

BD = "negocio.db"


def conectar():
    conexion = sqlite3.connect(BD)
    conexion.row_factory = sqlite3.Row
    return conexion


def preparar_bd():
    conexion = conectar()
    # CAMBIO 1: la tabla y sus columnas
    conexion.execute("""
        CREATE TABLE IF NOT EXISTS producto (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL,
            precio REAL NOT NULL,
            existencias INTEGER NOT NULL
        )
    """)
    total = conexion.execute("SELECT COUNT(*) FROM producto").fetchone()[0]
    if total == 0:
        # CAMBIO 2: los datos de ejemplo
        conexion.executemany(
            "INSERT INTO producto (nombre, precio, existencias) VALUES (?, ?, ?)",
            [
                ("Audífonos", 499.0, 20),
                ("Teclado", 650.5, 12),
                ("Mouse", 299.9, 35),
            ],
        )
    conexion.commit()
    conexion.close()


preparar_bd()


# CAMBIO 3: los datos que se piden al crear o actualizar
class DatosProducto(BaseModel):
    nombre: str
    precio: float
    existencias: int


@app.get("/")
def inicio():
    return {"mensaje": "La API de mi negocio funciona"}


# R de CRUD (leer todos)
@app.get("/productos")
def listar_productos():
    conexion = conectar()
    # CAMBIO 4: las columnas del SELECT
    filas = conexion.execute(
        "SELECT id, nombre, precio, existencias FROM producto"
    ).fetchall()
    conexion.close()
    return [dict(fila) for fila in filas]


# R de CRUD (leer uno)
@app.get("/productos/{producto_id}")
def obtener_producto(producto_id: int):
    conexion = conectar()
    # CAMBIO 4: las columnas del SELECT
    fila = conexion.execute(
        "SELECT id, nombre, precio, existencias FROM producto WHERE id = ?",
        (producto_id,),
    ).fetchone()
    conexion.close()
    if fila is None:
        raise HTTPException(status_code=404, detail="No encontrado")
    return dict(fila)


# C de CRUD (crear)
@app.post("/productos", status_code=201)
def crear_producto(datos: DatosProducto):
    conexion = conectar()
    # CAMBIO 5: columnas y valores del INSERT
    cursor = conexion.execute(
        "INSERT INTO producto (nombre, precio, existencias) VALUES (?, ?, ?)",
        (datos.nombre, datos.precio, datos.existencias),
    )
    conexion.commit()
    nuevo_id = cursor.lastrowid
    conexion.close()
    return {"id": nuevo_id, **datos.model_dump()}


# U de CRUD (actualizar)
@app.put("/productos/{producto_id}")
def actualizar_producto(producto_id: int, datos: DatosProducto):
    conexion = conectar()
    # CAMBIO 6: columnas y valores del UPDATE
    cursor = conexion.execute(
        "UPDATE producto SET nombre = ?, precio = ?, existencias = ? WHERE id = ?",
        (datos.nombre, datos.precio, datos.existencias, producto_id),
    )
    conexion.commit()
    cambiadas = cursor.rowcount
    conexion.close()
    if cambiadas == 0:
        raise HTTPException(status_code=404, detail="No encontrado")
    return {"id": producto_id, **datos.model_dump()}


# D de CRUD (eliminar)
@app.delete("/productos/{producto_id}")
def eliminar_producto(producto_id: int):
    conexion = conectar()
    cursor = conexion.execute("DELETE FROM producto WHERE id = ?", (producto_id,))
    conexion.commit()
    borradas = cursor.rowcount
    conexion.close()
    if borradas == 0:
        raise HTTPException(status_code=404, detail="No encontrado")
    return {"mensaje": f"Registro {producto_id} eliminado"}


# Reto: la misma lista, pero en XML
@app.get("/productos-xml")
def listar_productos_xml():
    conexion = conectar()
    filas = conexion.execute("SELECT * FROM producto").fetchall()
    conexion.close()
    raiz = ET.Element("productos")
    for fila in filas:
        registro = ET.SubElement(raiz, "producto")
        for columna in fila.keys():
            ET.SubElement(registro, columna).text = str(fila[columna])
    xml_texto = ET.tostring(raiz, encoding="unicode")
    return Response(content=xml_texto, media_type="application/xml")