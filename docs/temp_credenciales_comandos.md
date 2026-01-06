# 04 - Credenciales y Comandos

## Credenciales de Acceso

### Base de Datos
```
Host: 127.0.0.1
Puerto: 3306
Base de datos: promptvault
Usuario: root
Contraseña: (sin contraseña)
```

### Usuarios de Prueba

**Administrador:**
```
Email: admin@promptvault.com
Contraseña: password
Rol: Admin (acceso total)
```

**Usuario Demo:**
```
Email: user@promptvault.com
Contraseña: password
Rol: User (usuario estándar)
```

**Usuarios Adicionales:**
```
carlos@dev.com - password (Programador)
ana@escritora.com - password (Redactora)
pedro@ingeniero.com - password (Ingeniero)
maria@marketing.com - password (Marketing)
laura@disenadora.com - password (Diseñadora - Colaboradora)
carmen@educadora.com - password (Educadora - Colaboradora)
```

## Comandos Útiles

### Migraciones
```bash
# Ejecutar migraciones
php artisan migrate

# Revertir última migración
php artisan migrate:rollback

# Recrear BD desde cero con datos
php artisan migrate:fresh --seed

# Ver estado de migraciones
php artisan migrate:status
```

### Base de Datos
```bash
# Acceder a MySQL
mysql -u root promptvault

# Ver todas las tablas
mysql -u root promptvault -e "SHOW TABLES;"

# Contar registros
mysql -u root promptvault -e "SELECT COUNT(*) FROM prompts;"

# Ejecutar seeders
php artisan db:seed
php artisan db:seed --class=PromptSeeder
```

### Desarrollo
```bash
# Iniciar servidor
php artisan serve

# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Ver rutas
php artisan route:list --except-vendor

# Crear controlador
php artisan make:controller NombreController

# Crear modelo
php artisan make:model Nombre

# Crear migración
php artisan make:migration create_tabla_table
```

### Tinker (Consola Interactiva)
```bash
# Iniciar Tinker
php artisan tinker

# Ejemplos de uso:
>>> User::count()
>>> Prompt::with('categoria')->first()
>>> DB::table('prompts')->where('es_favorito', true)->get()
```

### NPM (Frontend)
```bash
# Instalar dependencias
npm install

# Compilar assets (desarrollo)
npm run dev

# Compilar assets (producción)
npm run build

# Watch mode
npm run dev -- --watch
```

## Configuración Laravel

### Archivo .env (configuración actual)
```env
APP_NAME=PromptVault
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=promptvault
DB_USERNAME=root
DB_PASSWORD=
```

### Rutas Principales
```
GET  /dashboard - Dashboard principal
GET  /prompts - Listar prompts
POST /prompts - Crear prompt
GET  /prompts/{id} - Ver prompt
PUT  /prompts/{id} - Actualizar prompt
DELETE /prompts/{id} - Eliminar prompt
POST /prompts/{id}/favorito - Toggle favorito
GET  /prompts/{id}/historial - Ver historial
```

## Verificación Rápida

```bash
# Verificar conexión BD
php artisan tinker
>>> DB::connection()->getPdo();

# Contar todos los registros
mysql -u root promptvault -e "
SELECT 'users' as tabla, COUNT(*) as registros FROM users
UNION ALL SELECT 'prompts', COUNT(*) FROM prompts
UNION ALL SELECT 'versiones', COUNT(*) FROM versiones;"
```
