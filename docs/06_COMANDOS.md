# 06 - Comandos Útiles

## Comandos de Migración

### Ejecutar migraciones

```bash
php artisan migrate
```

### Revertir última migración

```bash
php artisan migrate:rollback
```

### Revertir todas las migraciones

```bash
php artisan migrate:reset
```

### Refrescar base de datos (elimina y recrea)

```bash
php artisan migrate:fresh
```

### Migrar y sembrar en un solo comando

```bash
php artisan migrate:fresh --seed
```

## Comandos de Seeders

### Ejecutar todos los seeders

```bash
php artisan db:seed
```

### Ejecutar un seeder específico

```bash
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=PermisoSeeder
php artisan db:seed --class=CategoriaSeeder
php artisan db:seed --class=EtiquetaSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=PromptSeeder
```

## Comandos Laravel Artisan

### Servidor de desarrollo

```bash
php artisan serve
```

### Limpiar caché

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Crear controlador

```bash
php artisan make:controller NombreController
php artisan make:controller NombreController --resource
```

### Crear modelo

```bash
php artisan make:model Nombre
php artisan make:model Nombre -m  # Con migración
php artisan make:model Nombre -mf # Con migración y factory
```

### Crear migración

```bash
php artisan make:migration create_tabla_table
php artisan make:migration add_campo_to_tabla_table
```

### Crear seeder

```bash
php artisan make:seeder NombreSeeder
```

### Crear policy

```bash
php artisan make:policy NombrePolicy
```

### Ver rutas

```bash
php artisan route:list
```

### Modo mantenimiento

```bash
php artisan down
php artisan up
```

## Consultas MySQL

### Conectar a MySQL desde terminal

```bash
mysql -u root -p
```

### Seleccionar base de datos

```sql
USE promptvault;
```

### Ver todas las tablas

```sql
SHOW TABLES;
```

### Verificar registros en tablas

```sql
SELECT COUNT(*) FROM users;
SELECT COUNT(*) FROM prompts;
SELECT COUNT(*) FROM categorias;
SELECT COUNT(*) FROM etiquetas;
SELECT COUNT(*) FROM roles;
SELECT COUNT(*) FROM permisos;
```

### Ver estructura de tabla

```sql
DESCRIBE prompts;
DESCRIBE users;
```

### Ver datos de ejemplo

```sql
SELECT * FROM categorias;
SELECT * FROM roles;
SELECT id, name, email, role_id FROM users LIMIT 5;
SELECT id, titulo, categoria_id, user_id FROM prompts LIMIT 5;
```

### Limpiar todas las tablas

```sql
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE prompts;
TRUNCATE TABLE versiones;
TRUNCATE TABLE compartidos;
TRUNCATE TABLE actividades;
TRUNCATE TABLE etiqueta_prompt;
SET FOREIGN_KEY_CHECKS = 1;
```

### Eliminar y recrear base de datos

```sql
DROP DATABASE promptvault;
CREATE DATABASE promptvault CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Comandos de Composer

### Instalar dependencias

```bash
composer install
```

### Actualizar dependencias

```bash
composer update
```

### Dump autoload

```bash
composer dump-autoload
```

## Comandos NPM (Frontend)

### Instalar dependencias

```bash
npm install
```

### Compilar assets en desarrollo

```bash
npm run dev
```

### Compilar assets en producción

```bash
npm run build
```

### Watch para desarrollo

```bash
npm run watch
```

## Comandos de Testing

### Ejecutar todos los tests

```bash
php artisan test
```

### Ejecutar tests específicos

```bash
php artisan test --filter NombreTest
```

### Con cobertura

```bash
php artisan test --coverage
```

## Comandos de Mantenimiento

### Optimizar aplicación

```bash
php artisan optimize
```

### Generar key de aplicación

```bash
php artisan key:generate
```

### Crear link de storage

```bash
php artisan storage:link
```

### Limpiar logs

```bash
rm storage/logs/*.log
```

## Comandos Git (opcional)

### Inicializar repositorio

```bash
git init
git add .
git commit -m "Initial commit"
```

### Ver estado

```bash
git status
```

### Crear rama

```bash
git checkout -b feature/nueva-funcionalidad
```
