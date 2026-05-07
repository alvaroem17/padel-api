# Padel API

API REST para gestionar reservas de canchas de pádel. Permite a los usuarios registrarse, autenticarse, consultar disponibilidad de canchas y realizar reservas.

## 📋 Descripción

**Padel API** es una API construida con Laravel que proporciona un sistema completo para la gestión de canchas de pádel y reservas. Permite:

- ✅ Autenticación y registro de usuarios
- ✅ Gestión de canchas (crear, actualizar, listar, eliminar)
- ✅ Consultar disponibilidad de canchas
- ✅ Crear y gestionar reservas
- ✅ Autenticación segura con Sanctum

## 🚀 Requisitos

- PHP 8.2+
- Composer
- MySQL/PostgreSQL
- Node.js (para assets)

## 📦 Instalación

1. **Clonar el repositorio**
```bash
git clone <repositorio>
cd padel-api
```

2. **Instalar dependencias**
```bash
composer install
npm install
```

3. **Configurar variables de entorno**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar base de datos**
```bash
# Editar .env con tus credenciales
DB_DATABASE=padel_db
DB_USERNAME=root
DB_PASSWORD=
```

5. **Ejecutar migraciones**
```bash
php artisan migrate
php artisan db:seed
```

6. **Iniciar servidor**
```bash
php artisan serve
```

La API estará disponible en `http://localhost:8000`

## � Documentación Interactiva

Una vez que tengas el servidor en ejecución, puedes acceder a la **documentación interactiva de los endpoints** visitando:

```
http://localhost:8000/docs/api
```

Aquí encontrarás todos los endpoints disponibles con:
- 📝 Descripción detallada de cada endpoint
- 📋 Parámetros requeridos y opcionales
- 💡 Ejemplos de request y response
- 🔐 Información sobre autenticación
- ✅ Pruebas directas desde el navegador

## 📁 Estructura del proyecto

- `app/Models` - Modelos de base de datos
- `app/Http/Controllers/Api` - Controllers de la API
- `app/Services` - Lógica de negocio
- `app/Dtos` - Data Transfer Objects
- `routes/api.php` - Rutas de la API
- `database/migrations` - Migraciones de BD
- `database/seeders` - Seeders

## 🧪 Testing

```bash
php artisan test
```

## 📄 Licencia

MIT

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
