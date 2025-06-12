# 🧩 3DWorld - Gestor de recursos para impresión 3D

Aplicación web desarrollada como Trabajo de Fin de Grado para la gestión integral de recursos relacionados con la impresión 3D dentro de un entorno empresarial. Permite controlar usuarios, impresoras, estaciones de trabajo, filamentos y modelos 3D de forma centralizada, colaborativa y eficiente.

## 🚀 Características principales

- Gestión de empresas y usuarios
- Solicitudes para unirse a empresas
- Estaciones de trabajo y distribución de impresoras
- Asignación dinámica de filamentos a impresoras
- Control de uso y estado de cada impresora
- Catálogo de modelos 3D con sistema de likes
- Interfaz moderna, responsiva y accesible
- Sistema de roles y permisos (admin/miembro)

## 🧱 Tecnologías utilizadas

### Backend
- Laravel 12 (PHP 8+)
- MySQL
- Eloquent ORM
- Laravel Breeze + Sanctum (autenticación)
- Spatie Laravel Permission (gestión de roles)

### Frontend
- Inertia.js
- Vue.js
- Tailwind CSS
- Vite.js
- Alpine.js (para interacciones sencillas)

## 🧭 Estructura general

├── app/
│ ├── Http/
│ ├── Models/
│ ├── Policies/
│ └── ...
├── resources/
│ ├── js/ → Componentes Vue.js
│ └── views/ → Plantillas Blade para Inertia
├── database/
│ ├── migrations/
│ └── seeders/
├── routes/
│ └── web.php
├── public/
├── vite.config.js
└── ...

bash
Copiar
Editar

## 🛠️ Requisitos

- PHP >= 8.2
- Composer
- Node.js y npm
- MySQL
- Laravel CLI

## 🧪 Instalación

```bash
git clone https://github.com/tuusuario/3dWorld.git
cd 3dWorld

# Instalar dependencias backend
composer install

# Instalar dependencias frontend
npm install && npm run build

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Crear la base de datos y correr migraciones
php artisan migrate --seed

# Levantar servidor
php artisan serve
