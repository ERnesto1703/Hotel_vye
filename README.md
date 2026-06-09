# Hotel Maya Bay - Sistema de Reservaciones (Laravel)

Este proyecto consiste en el sitio web dinámico para el **Hotel Maya Bay**, migrado desde un sitio estático a una aplicación web completa construida con el framework **Laravel 11**. Incluye lógica de persistencia de datos, un robusto sistema de validaciones en español y un algoritmo inteligente para gestionar el inventario y disponibilidad de habitaciones en tiempo real.

---

## 🛠️ Tecnologías Utilizadas

* **Framework Backend:** Laravel 11 (PHP 8.5+)
* **Base de Datos:** SQLite (Motor ligero y autocontenido en `database/database.sqlite`)
* **Motor de Plantillas:** Laravel Blade (Vistas dinámicas y reutilización de estructura)
* **Frontend:** HTML5, CSS3 Nativo (Diseño responsivo y adaptado para dispositivos móviles)

---

## 📂 Estructura del Proyecto

Los archivos principales del proyecto se distribuyen de la siguiente manera:

```text
Hotel1.1/
  ├── app/
  │   ├── Http/Controllers/
  │   │   └── BookingController.php      <-- Controlador principal (Validación, lógica e inventario)
  │   └── Models/
  │       ├── Room.php                    <-- Modelo de Habitación (Relación con Bookings)
  │       └── Booking.php                 <-- Modelo de Reserva
  ├── database/
  │   ├── migrations/
  │   │   ├── *_create_rooms_table.php    <-- Esquema de la tabla de habitaciones
  │   │   └── *_create_bookings_table.php <-- Esquema de la tabla de reservas
  │   ├── seeders/
  │   │   ├── RoomSeeder.php              <-- Sembrador para 30 habitaciones iniciales
  │   │   └── DatabaseSeeder.php          <-- Registro principal de seeders
  │   └── database.sqlite                 <-- Archivo físico de la Base de Datos SQLite
  ├── public/
  │   ├── css/
  │   │   └── estilo.css                  <-- Estilos globales de la web
  │   └── img/                            <-- Imágenes del hotel (incluye assets premium generados)
  ├── resources/views/
  │   ├── layouts/
  │   │   └── app.blade.php               <-- Estructura base común (Navegación y Footer)
  │   ├── index.blade.php                 <-- Página de Inicio (Home)
  │   ├── sobre-nosotros.blade.php        <-- Página "Sobre Nosotros"
  │   ├── habitaciones.blade.php          <-- Catálogo con disponibilidad dinámica
  │   ├── transporte.blade.php            <-- Servicios de traslado y flota
  │   └── reservas.blade.php              <-- Formulario de reserva con errores de validación
  └── routes/
      └── web.php                         <-- Definición de rutas URL
```

---

## 🚀 Instalación y Puesta en Marcha

Para ejecutar este proyecto en tu entorno local por primera vez, sigue estos pasos:

### 1. Requisitos Previos
Asegúrate de tener instalados en tu Mac:
* **PHP** (versión 8.2 o superior)
* **Composer** (gestor de dependencias de PHP)

### 2. Instalar Dependencias
Abre tu terminal en la carpeta raíz del proyecto y ejecuta:
```bash
composer install
```

### 3. Configurar Entorno
El archivo de entorno `.env` ya viene configurado para usar SQLite. Si necesitas regenerar la clave de la aplicación o reconfigurarlo, asegúrate de que contenga:
```env
APP_NAME="Hotel Maya Bay"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
```

### 4. Crear Base de Datos y Sembrar Datos (Seeding)
Genera la base de datos vacía, crea las tablas y siembra las 30 habitaciones ejecutando:
```bash
php artisan migrate:fresh --seed
```

### 5. Iniciar Servidor de Desarrollo
Levanta el servidor local de Laravel:
```bash
php artisan serve
```
Una vez iniciado, abre tu navegador y visita:
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 📝 Validaciones del Formulario de Reserva

El formulario cuenta con reglas de validación muy estrictas y configuradas con mensajes explicativos en español:

* **Nombre Completo (`guest_name`):** Obligatorio. Utiliza expresiones regulares para permitir únicamente letras y espacios (bloquea cualquier número o símbolo especial).
* **Correo Electrónico (`guest_email`):** Obligatorio. Debe tener formato de email válido y terminar estrictamente en `.com`.
* **Número de Teléfono (`guest_phone`):** Obligatorio. Debe constar de **exactamente 10 dígitos numéricos** (no admite letras, espacios ni símbolos como `+` o `-` para simplificar la persistencia).
* **Rango de Fechas:** 
  * El check-in debe ser igual o posterior al día de hoy.
  * El check-out debe ser posterior al check-in (evita reservas invertidas o de 0 noches).

---

## 🛏️ Inventario y Lógica de Disponibilidad

El hotel gestiona un inventario inicial fijo de **30 habitaciones** físicas (10 de cada categoría) creadas a través de `RoomSeeder`:
* **Habitaciones Estándar:** Habitaciones de la 101 a la 110.
* **Habitaciones Familiar:** Habitaciones de la 201 a la 210.
* **Suites Premium:** Suites de la 301 a la 310.

### Algoritmo de Disponibilidad en Tiempo Real:
1. **Asignación Libre de Cruces:** Cuando un usuario intenta reservar, el sistema verifica las 10 habitaciones correspondientes a la categoría elegida. Se comprueba si las fechas solicitadas se solapan con reservas preexistentes (`check_in < check_out_solicitado` y `check_out > check_in_solicitado`). Si encuentra una habitación libre de solapamientos, confirma la reserva asociándola a esa habitación.
2. **Cálculo de Siguiente Fecha Disponible:** Si las 10 habitaciones de una categoría están ocupadas hoy, la interfaz en `habitaciones.blade.php` cambia automáticamente el estado a **"Ocupado hoy"**. Internamente, el controlador realiza un recorrido inteligente buscando la fecha de finalización de la reserva activa más próxima de todas las habitaciones del tipo afectado para indicarle al cliente cuándo se liberará la primera habitación (ej. *"Siguiente disponible: DD/MM/AAAA"*).

---

## 📊 Consulta a la Base de Datos

Si deseas verificar el contenido de las tablas de base de datos (`rooms` o `bookings`), tienes tres métodos sencillos:

### 1. Laravel Tinker (Terminal)
Entra a la terminal interactiva de Laravel:
```bash
php artisan tinker
```
Ejecuta comandos de Eloquent:
```php
// Ver todas las reservaciones
App\Models\Booking::all();

// Ver todas las habitaciones y sus tipos
App\Models\Room::all();
```

### 2. Extensión "SQLite Viewer" en VS Code
Si utilizas VS Code, instala la extensión **SQLite Viewer**. Luego, simplemente haz clic en el archivo `database/database.sqlite` en tu explorador de archivos para ver y filtrar los datos de forma visual.

### 3. Clientes Gráficos Externos
Puedes descargar herramientas gratuitas como **TablePlus** o **DB Browser for SQLite** y arrastrar el archivo `database/database.sqlite` para explorar las tablas a través de una interfaz SQL tradicional.
