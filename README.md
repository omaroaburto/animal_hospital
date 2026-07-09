## Comandos Artisan

| Comando | Descripción |
|---------|-------------|
| `php artisan storage:clean-all-drivers` | Limpia uno o varios proveedores de almacenamiento (Local, Google Drive, Cloudflare R2/S3 y Cloudinary), elimina todas las imágenes, ejecuta `migrate:fresh` y posteriormente `db:seed`, dejando el entorno completamente restaurado para desarrollo. |
| `php artisan make:domain {domain} {type} {name}` | Genera automáticamente artefactos dentro de un dominio siguiendo la arquitectura del proyecto. Soporta modelos, controladores, actions, requests, policies, services, resources, enums, middleware, notifications, exceptions y factories. |

### Ejemplos

| Acción | Comando |
|--------|---------|
| Crear un modelo | `php artisan make:domain Client model Client` |
| Crear una Action | `php artisan make:domain Client action CreateClient` |
| Crear un Service | `php artisan make:domain Client service ClientService` |
| Crear un Request | `php artisan make:domain Client request StoreClient` |
| Crear un Controller | `php artisan make:domain Client controller Client` |
| Crear una Policy | `php artisan make:domain Client policy Client` |
| Crear un Resource | `php artisan make:domain Client resource Client` |
| Crear una Collection | `php artisan make:domain Client collection Client` |
| Crear un Enum | `php artisan make:domain Client enum ClientStatus` |
| Crear un Middleware | `php artisan make:domain Client middleware EnsureClientIsActive` |
| Crear una Notification | `php artisan make:domain Client notification ClientCreated` |
| Crear una Exception | `php artisan make:domain Client exception ClientNotFound` |
| Crear una Factory | `php artisan make:domain Client factory Client` |



# Comando de mantenimiento del proyecto

El proyecto incluye un comando Artisan que permite restaurar completamente el entorno de desarrollo. Este comando elimina las imágenes almacenadas en los diferentes proveedores de almacenamiento, reinicia la base de datos y ejecuta nuevamente todos los seeders.

> **⚠️ Advertencia**
>
> Este comando elimina permanentemente los archivos almacenados y borra toda la base de datos mediante `migrate:fresh`.
>
> **Utilícelo únicamente en entornos de desarrollo o pruebas.**

---

# Uso

```bash
php artisan storage:clean-all-drivers
```

Al ejecutarlo se mostrará un menú interactivo para seleccionar qué almacenamiento desea limpiar.

---

# Opciones disponibles

| Opción | Descripción |
|:-------:|-------------|
| **1** | Limpia todos los drivers (`public`, `google`, `s3` y `cloudinary`). |
| **2** | Limpia únicamente el almacenamiento local (`public`). |
| **3** | Limpia únicamente Google Drive. |
| **4** | Limpia únicamente Cloudflare R2 / Amazon S3. |
| **5** | Limpia únicamente Cloudinary. |

---

# Flujo de ejecución

El comando realiza automáticamente los siguientes pasos:

| Paso | Acción |
|------|--------|
| 1 | Solicita el almacenamiento que se desea limpiar. |
| 2 | Solicita una confirmación antes de eliminar la información. |
| 3 | Elimina todas las imágenes almacenadas. |
| 4 | Recrea automáticamente las carpetas vacías. |
| 5 | Ejecuta `php artisan migrate:fresh`. |
| 6 | Ejecuta `php artisan db:seed`. |
| 7 | Finaliza dejando el proyecto completamente restaurado. |

---

# Carpetas limpiadas

Actualmente el comando elimina el contenido de las siguientes carpetas:

| Carpeta | Descripción |
|----------|-------------|
| `avatars` | Imágenes de perfil de los usuarios. |
| `pets` | Fotografías de las mascotas registradas. |
| `medical_images` | Imágenes relacionadas con historiales médicos, exámenes o diagnósticos. |

Después de eliminar su contenido, las carpetas son creadas nuevamente para mantener la estructura del proyecto.

---

# Drivers soportados

| Driver | Descripción |
|---------|-------------|
| `public` | Almacenamiento local de Laravel (`storage/app/public`). |
| `google` | Google Drive. |
| `s3` | Cloudflare R2 o Amazon S3. |
| `cloudinary` | Cloudinary. |

---

# Ejemplo

```text
¿Qué almacenamiento deseas vaciar por completo antes de resetear la base de datos?

  [1] Todos los drivers (Limpieza Total de la App)
  [2] Solo Local (Disco público)
  [3] Solo Google Drive
  [4] Solo Cloudflare R2 / S3
  [5] Solo Cloudinary

> 1

⚠️ ¡ATENCIÓN! Se eliminarán los archivos físicos y se borrará toda la base de datos para volver a ejecutar los seeders.

¿Deseas continuar? (yes/no) [no]:
> yes

1. Iniciando vaciado de directorios...
2. Reseteando la base de datos...
3. Sembrando datos de prueba...

🚀 ¡Todo el entorno ha sido restaurado con éxito!
```

---

# ¿Qué hace internamente?

Este comando ejecuta automáticamente las siguientes operaciones:

```bash
php artisan migrate:fresh
php artisan db:seed
```

Además elimina todos los archivos de imágenes de los drivers seleccionados y recrea las carpetas vacías para dejar el sistema listo para trabajar nuevamente.



# 🏥 Animal Hospital - Gestión de Almacenamiento de Imágenes

Este módulo proporciona una arquitectura flexible basada en el patrón *Strategy* para la carga, almacenamiento y eliminación de archivos de imágenes (como avatares de usuarios, fotos de mascotas, registros médicos, etc.) a través de 4 drivers distintos.

---

## 🚀 Configuración del archivo `.env`

Copia este bloque de configuración en tu archivo `.env`. Para alternar entre proveedores de almacenamiento, simplemente edita la variable `IMAGE_DRIVER`.

```env
# Driver activo actual. Opciones: local | google | s3 | cloudinary
IMAGE_DRIVER=local

APP_URL=http://localhost:8000

# 1. DRIVER: LOCAL
# Sin credenciales adicionales. Guarda en 'storage/app/public/avatars'.

# 2. DRIVER: GOOGLE DRIVE
GOOGLE_DRIVE_CLIENT_ID=tu_client_id_de_google.apps.googleusercontent.com
GOOGLE_DRIVE_CLIENT_SECRET=tu_client_secret_clave_privada
GOOGLE_DRIVE_REFRESH_TOKEN=tu_refresh_token_perpetuo
GOOGLE_DRIVE_FOLDER_ID=id_de_la_carpeta_raiz_en_tu_drive_opcional

# 3. DRIVER: CLOUDFLARE R2 / AWS S3
AWS_ACCESS_KEY_ID=tu_access_key_id_de_cloudflare_r2
AWS_SECRET_ACCESS_KEY=tu_secret_access_key_secreta
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=animal-hospital
AWS_ENDPOINT=https://tu_account_id.r2.cloudflarestorage.com
AWS_URL=https://pub-tu_id_publico.r2.dev

# 4. DRIVER: CLOUDINARY
CLOUDINARY_URL=cloudinary://tu_api_key:tu_api_secret@tu_cloud_name
CLOUDINARY_CLOUD_NAME=tu_cloud_name
CLOUDINARY_API_KEY=tu_api_key
CLOUDINARY_API_SECRET=tu_api_secret
