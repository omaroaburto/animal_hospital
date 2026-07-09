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
