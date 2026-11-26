# Consultorio Villita

Aplicación web para la gestión de un consultorio médico. Incluye una landing pública y un panel administrativo con acceso para administración, médico y recepción.

## Requisitos

- PHP 8.3 o superior con las extensiones `pdo_pgsql`, `mbstring`, `openssl`, `fileinfo`, `xml`, `ctype` y `tokenizer`.
- Composer 2.
- Node.js 20.19 o superior y npm.
- Acceso a la base de datos PostgreSQL de Supabase.

> Node.js 18 no es compatible con Vite 8. Se recomienda Node.js 22.

No es necesario instalar MySQL ni MariaDB.

## Instalación

```bash
git clone https://github.com/keiiivn/Sistema-gestor-de-consultorio-m-dico.git
cd Sistema-gestor-de-consultorio-m-dico/ProyectoIntegrador/ConsultorioVillita

composer install
cp .env.example .env
```

Edita `.env` con las credenciales que te proporcione el responsable del proyecto:

```dotenv
DB_HOST=...
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=...
DB_PASSWORD=...
DB_SSLMODE=require
```

Después genera la clave de la aplicación, instala los assets y levanta el servidor:

```bash
php artisan key:generate
npm ci
npm run build
php artisan serve
```

La aplicación estará disponible en <http://localhost:8000>.

## Base de datos compartida

La base de Supabase ya está migrada y contiene los datos de demostración.

**No ejecutes `php artisan migrate:fresh` ni `php artisan migrate --seed` sobre la base compartida.** Tampoco uses `composer run setup`, porque ese comando ejecuta migraciones.

Si la base se reinicia o necesitas una base propia vacía, entonces sí puedes ejecutar una sola vez:

```bash
php artisan migrate --seed
```

Ten en cuenta que los datos son compartidos: cualquier cambio que hagas en la base también afecta a las demás personas que la estén usando.

## Credenciales de demostración

| Rol | Usuario | Contraseña |
| --- | --- | --- |
| Administración | `admin` | `admin123` |
| Médica | `dra.mendez` | `medico123` |
| Recepción | `recepcion` | `recepcion123` |

## Pruebas

```bash
php artisan test --compact
```

Las pruebas usan SQLite en memoria y no modifican la base de Supabase.

## Archivos de estudios

Los estudios de ejemplo incluidos en el repositorio permiten probar las descargas sin configurar almacenamiento externo.

Los archivos que se suban desde la aplicación se guardan localmente en `storage/app/private`, por lo que no se comparten entre computadoras.

## Problemas comunes

- **No se encuentra el archivo en el manifiesto de Vite:** ejecuta `npm run build`.
- **`could not find driver`:** instala la extensión `pdo_pgsql` de PHP.
- **No conecta con Supabase:** verifica las credenciales, el estado del proyecto en Supabase y tu conexión a internet.
- **Cambios de estilos que no aparecen:** ejecuta `npm run build` o levanta `npm run dev` en otra terminal.

## Estructura principal

- `app/Http/Controllers`: controladores del sitio público y del panel.
- `app/Models`: modelos de la base de datos.
- `database/migrations`: estructura de la base de datos.
- `database/seeders`: datos de demostración.
- `resources/views`: vistas Blade.
- `routes/web.php`: rutas de la aplicación.
- `tests`: pruebas automatizadas.
