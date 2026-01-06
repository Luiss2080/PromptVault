# 05 - Credenciales de Acceso

## Base de Datos MySQL

```
Host: 127.0.0.1
Puerto: 3306
Base de datos: promptvault
Usuario: root
Contraseña: (sin contraseña)
```

## Usuarios del Sistema

### Administrador

```
Email: admin@promptvault.com
Contraseña: password
Rol: Admin
Permisos: Acceso total al sistema
```

### Usuario Demo

```
Email: user@promptvault.com
Contraseña: password
Rol: User
Permisos: Usuario estándar
```

### Usuarios Adicionales de Prueba

| Email | Contraseña | Rol | Área |
|-------|------------|-----|------|
| carlos@dev.com | password | User | Programación |
| ana@escritora.com | password | User | Redacción |
| pedro@ingeniero.com | password | User | Ingeniería |
| maria@marketing.com | password | User | Marketing |
| luis@arquitecto.com | password | User | Arquitectura |
| carmen@educadora.com | password | Collaborator | Educación |
| jorge@analista.com | password | User | Análisis |
| laura@disenadora.com | password | Collaborator | Diseño |
| roberto@consultor.com | password | User | Consultoría |
| isabel@investigadora.com | password | User | Investigación |

## Configuración Laravel

### Archivo .env

```env
APP_NAME=PromptVault
APP_ENV=local
APP_KEY=base64:FqhKh7d1t9jmS67i8YBbjoWrJ00sZMFHfWUOnHe2O+E=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=promptvault
DB_USERNAME=root
DB_PASSWORD=
```

## Acceso a la Aplicación

```
URL: http://localhost/PromptVault/public
Dashboard: http://localhost/PromptVault/public/dashboard
Login: http://localhost/PromptVault/public/login
```

## Notas de Seguridad

⚠️ **IMPORTANTE:** Estas credenciales son solo para desarrollo local. En producción:

- Cambiar todas las contraseñas
- Usar contraseñas seguras
- Configurar variables de entorno adecuadas
- Activar autenticación de dos factores
- Restringir acceso a la base de datos
