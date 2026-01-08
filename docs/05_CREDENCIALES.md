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

### Usuario Estándar

```
Email: user@promptvault.com
Contraseña: password
Rol: User
Permisos: Usuario estándar - Gestión de prompts propios
```

### Colaborador

```
Email: colaborador@promptvault.com
Contraseña: password
Rol: Collaborator
Permisos: Usuario + Edición de prompts compartidos
```

### Invitado

```
Email: invitado@promptvault.com
Contraseña: password
Rol: Guest
Permisos: Acceso limitado - Solo lectura de prompts públicos
```

### Usuarios Adicionales de Prueba

#### Usuarios Estándar (User - Nivel 10)

| Nombre | Email | Contraseña | Área |
|--------|-------|------------|------|
| Carlos Martínez | carlos@dev.com | password | Programación |
| Ana López | ana@escritora.com | password | Redacción |
| Pedro Sánchez | pedro@ingeniero.com | password | Ingeniería |
| María García | maria@marketing.com | password | Marketing |
| Luis Rodríguez | luis@arquitecto.com | password | Arquitectura |
| Jorge Ramírez | jorge@analista.com | password | Análisis |
| Roberto Díaz | roberto@consultor.com | password | Consultoría |
| Isabel Moreno | isabel@investigadora.com | password | Investigación |

#### Colaboradores (Collaborator - Nivel 15)

| Nombre | Email | Contraseña | Área |
|--------|-------|------------|------|
| Colaborador Demo | colaborador@promptvault.com | password | General |
| Carmen Torres | carmen@educadora.com | password | Educación |
| Laura Fernández | laura@disenadora.com | password | Diseño |

## Resumen de Usuarios por Rol

| Rol | Nivel | Cantidad | Permisos |
|-----|-------|----------|----------|
| Admin | 100 | 1 | Acceso total al sistema |
| Collaborator | 15 | 3 | Gestión de prompts propios + Edición de compartidos |
| User | 10 | 9 | Gestión de prompts propios |
| Guest | 1 | 1 | Solo lectura de prompts públicos |
| **Total** | - | **14** | - |

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
