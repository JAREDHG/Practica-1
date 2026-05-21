# Sistema Administrativo de Blog con Roles y Auditoría

Este proyecto es un sistema web completo desarrollado en **Laravel 12**. Incluye autenticación segura, gestión de roles (Admin, Editor, Viewer), un sistema de publicaciones con carga de archivos, y un panel administrativo con bitácora de auditoría.

## 🛠️ Tecnologías utilizadas
* PHP 8.2+
* Laravel 12 (con Laravel Breeze)
* MySQL / MariaDB
* Bootstrap / TailwindCSS

## 🚀 Instrucciones de Instalación

Sigue estos pasos para ejecutar el proyecto en tu entorno local:

1. **Clonar el repositorio:**
   ```bash
   git clone [TU_ENLACE_DE_GITHUB_AQUI]
   cd practica1-autenticacion
   ```

2. **Instalar dependencias:**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Configurar el entorno:**
   * Copia el archivo de ejemplo para crear tu propio entorno:
     ```bash
     cp .env.example .env
     ```
   * Abre el archivo `.env` y configura tus credenciales de base de datos (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

4. **Generar la llave de la aplicación y enlazar el almacenamiento:**
   ```bash
   php artisan key:generate
   php artisan storage:link
   ```

5. **Migrar y poblar la base de datos:**
   *(Esto creará las tablas, los roles, datos de prueba y el usuario administrador por defecto)*
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Levantar el servidor local:**
   ```bash
   php artisan serve
   ```

## 🔐 Credenciales de Acceso (Admin)
Una vez levantado el servidor, puedes acceder al panel administrativo navegando a la ruta `/admin/dashboard` e ingresando con las siguientes credenciales de prueba:
* **Correo:** `admin@example.com`
* **Contraseña:** `password123`