# Hotel Maya Bay - Sistema de Reservaciones y Traslados (Laravel 13)

Este proyecto consiste en el sitio web dinámico para el **Hotel Maya Bay**, construido con el framework **Laravel 13**. Incluye lógica de persistencia de datos relacionales, un robusto sistema de validaciones en español y un algoritmo transaccional inteligente para automatizar el agendamiento doble de habitaciones (40 habitaciones en total) y transporte de enlace (flota de 3 camionetas).

Para consultar la documentación técnica completa, diccionario de datos, diagrama Entidad-Relación y guía de endpoints, por favor revisa el archivo:
👉 **[DOCUMENTACION.md](file:///Users/ernestobautista/Downloads/Hotel1.1/DOCUMENTACION.md)**

---

## 🛠️ Tecnologías Utilizadas

* **Framework Backend:** Laravel 13.x (PHP 8.4+)
* **Base de Datos:** SQLite por defecto para desarrollo local (`database/database.sqlite`), con script SQL compatible para MySQL/MariaDB en `database/hotel_maya_bay.sql`.
* **Diseño y Estilos:** HTML5, CSS3 Nativo (`public/css/estilo.css`) y componentes responsivos mediante **Bootstrap 5**.

---

## 📂 Estructura Principal del Proyecto

Los archivos principales del proyecto se distribuyen de la siguiente manera:

```text
Hotel1.1/
  ├── app/
  │   ├── Http/Controllers/
  │   │   └── BookingController.php      <-- Controlador principal (Lógica de reservas dobles e inventarios)
  │   └── Models/
  │       ├── Habitacion.php             <-- Modelo de Habitación (40 en total)
  │       ├── Camioneta.php              <-- Modelo de Camioneta (3 en total)
  │       ├── ReservaHabitacion.php      <-- Modelo de Reserva de Habitación
  │       └── ReservaTraslado.php        <-- Modelo de Reserva de Traslado
  ├── database/
  │   ├── migrations/                    <-- Esquemas de tablas relacionales
  │   ├── seeders/                       <-- Sembradores para habitaciones y camionetas
  │   ├── database.sqlite                <-- Archivo físico de la Base de Datos SQLite local
  │   └── hotel_maya_bay.sql             <-- Script SQL inicial para XAMPP/phpMyAdmin
  ├── public/
  │   ├── css/
  │   │   └── estilo.css                  <-- Estilos personalizados del sitio
  │   └── img/                            <-- Recursos e imágenes
  ├── resources/views/
  │   ├── layouts/
  │   │   └── app.blade.php               <-- Layout base común (Bootstrap y navegación)
  │   ├── index.blade.php                 <-- Página de Inicio
  │   ├── sobre-nosotros.blade.php        <-- Sección "Sobre Nosotros"
  │   ├── habitaciones.blade.php          <-- Catálogo con disponibilidad dinámica hoy
  │   ├── transporte.blade.php            <-- Servicios de traslado y flota
  │   ├── reservas.blade.php              <-- Formulario de reserva con validaciones
  │   └── admin.blade.php                 <-- Panel administrativo
  └── routes/
      └── web.php                         <-- Definición de rutas y endpoints
```

---

## 🚀 Instalación y Puesta en Marcha

Sigue estos sencillos pasos para ejecutar el proyecto en tu entorno local:

### 1. Descargar dependencias
Abre tu terminal en la carpeta raíz del proyecto y ejecuta:
```bash
composer install
```

### 2. Configurar entorno
Duplica el archivo de configuración `.env`:
```bash
cp .env.example .env
```
Por defecto, el archivo `.env` está configurado para usar SQLite (`DB_CONNECTION=sqlite`). Si deseas utilizar MySQL (por ejemplo, con XAMPP), configura las credenciales de base de datos en tu `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_maya_bay
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Generar la clave de la aplicación
```bash
php artisan key:generate
```

### 4. Inicializar Base de Datos (Migraciones y Sembrado)
Crea las tablas relacionales y siembra el inventario de 40 habitaciones y 3 camionetas ejecutando:
```bash
php artisan migrate:fresh --seed
```
*También puedes hacerlo ingresando desde el navegador a la ruta de inicialización automática:*
👉 `http://localhost:8000/instalar-bd-secreta`

### 5. Compilar assets de frontend (Bootstrap/Vite)
```bash
npm install
npm run build
```

### 6. Levantar Servidor Local
Inicia el servidor local de Laravel:
```bash
php artisan serve
```
Abre tu navegador e ingresa a: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 📝 Reglas de Negocio y Lógica de Agendamiento Doble

1. **Habitaciones (40 en total):**
   * **15 Estándar** (Habitación 101 a 115) - $120.00
   * **15 Familiar** (Habitación 201 a 215) - $180.00
   * **10 Premium/Suites** (Suite 301 a 310) - $280.00
   * El sistema busca una habitación libre para las fechas seleccionadas evitando cualquier cruce de reservas preexistentes.
2. **Camionetas (3 de traslado):**
   * Placa `ABC-123` (capacidad de 6 pasajeros)
   * Placa `DEF-456` (capacidad de 8 pasajeros)
   * Placa `GHI-789` (capacidad de 10 pasajeros)
   * Si el huésped marca "Desea traslado", el sistema valida que la suma de pasajeros de los servicios ya agendados en ese mismo horario más los pasajeros solicitados no supere la capacidad máxima de cada camioneta. Asigna de forma automática el transporte disponible.
3. **Validaciones en Español:**
   * Nombre completo (solo letras y espacios).
   * Correo (debe terminar en `.com`).
   * Teléfono (debe tener exactamente 10 dígitos numéricos).
   * Rango de fechas coherente (check-in >= hoy y check-out > check-in).
