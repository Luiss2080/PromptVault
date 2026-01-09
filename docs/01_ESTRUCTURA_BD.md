# 01 - Estructura de Base de Datos

**PromptVault - Sistema de Gestión de Prompts de IA**

---

## Información General

- **Base de Datos:** MySQL 8.0+
- **Nombre BD:** `promptvault`
- **Charset:** utf8mb4_unicode_ci
- **Motor:** InnoDB

---

## Tablas Principales

### 1. users
Usuarios del sistema con autenticación Laravel Breeze.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | PK, autoincremental |
| role_id | bigint | FK a roles (default: 2) |
| name | varchar(255) | Nombre del usuario |
| email | varchar(255) | Email único |
| password | varchar(255) | Contraseña hasheada |
| cuenta_activa | boolean | Estado de la cuenta |
| ultimo_acceso | timestamp | Último login |
| foto_perfil | varchar(255) | Ruta de la foto de perfil |
| email_verified_at | timestamp | Verificación email |
| remember_token | varchar(100) | Token sesión persistente |

**Relaciones:**
- Pertenece a: `roles`
- Tiene muchos: `prompts`, `actividades`
- Tiene uno: `sesiones_prompts`

---

### 2. roles
Roles del sistema con niveles de acceso jerárquicos.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | PK |
| nombre | varchar(50) | Nombre único del rol |
| descripcion | varchar(255) | Descripción del rol |
| nivel_acceso | int | Nivel numérico (1-100) |

**Roles Predefinidos:**
- **admin** (100): Control total del sistema
- **collaborator** (15): Usuario con permisos ampliados
- **user** (10): Usuario estándar registrado
- **guest** (1): Acceso externo por token

---

### 3. permisos
Permisos específicos organizados por módulos.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | PK |
| nombre | varchar(100) | Nombre único (ej: prompts.crear) |
| descripcion | varchar(255) | Descripción del permiso |
| modulo | varchar(50) | Módulo al que pertenece |

**Módulos:** usuarios, prompts, versiones, categorias, etiquetas, actividades, estadisticas, exportar, busqueda

---

### 4. role_permiso
Tabla pivot para relación N:M entre roles y permisos.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | PK |
| role_id | bigint | FK a roles |
| permiso_id | bigint | FK a permisos |

**Constraint:** UNIQUE(role_id, permiso_id)

---

### 5. categorias
Categorías temáticas para organizar prompts.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | PK |
| nombre | varchar(100) | Nombre de la categoría |
| descripcion | text | Descripción del tipo de prompts |
| color | varchar(7) | Color HEX para UI |

---

### 6. etiquetas
Palabras clave para búsqueda rápida (tags).

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | PK |
| nombre | varchar(50) | Nombre único de la etiqueta |

---

### 7. etiqueta_prompt
Tabla pivot para relación N:M entre prompts y etiquetas.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | PK |
| etiqueta_id | bigint | FK a etiquetas |
| prompt_id | bigint | FK a prompts |

**Constraint:** UNIQUE(etiqueta_id, prompt_id)

---

### 8. prompts
Tabla principal de prompts de IA.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | PK |
| user_id | bigint | FK a users (propietario) |
| categoria_id | bigint | FK a categorias (nullable) |
| titulo | varchar(100) | Título del prompt |
| contenido | text | Texto del prompt |
| descripcion | text | Para qué sirve este prompt |
| fecha_creacion | timestamp | Fecha de creación |
| ia_destino | varchar(50) | IA optimizada (ChatGPT, Claude, etc) |
| es_favorito | boolean | Marcador de favorito |
| es_publico | boolean | Visibilidad pública |
| version_actual | int | Número de versión actual |
| veces_usado | int | Contador de usos |
| fecha_modificacion | timestamp | Última modificación |

---

### 9. versiones
Historial de cambios de prompts.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | PK |
| prompt_id | bigint | FK a prompts |
| numero_version | int | Número secuencial (1, 2, 3...) |
| contenido | text | Contenido de esta versión |
| contenido_anterior | text | Texto antes del cambio |
| motivo_cambio | text | Por qué se modificó |
| fecha_version | timestamp | Cuándo se creó esta versión |

---

### 10. compartidos
Registro de prompts compartidos (internos y externos).

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | PK |
| prompt_id | bigint | FK a prompts |
| token | uuid | Token para acceso externo (nullable) |
| tipo_acceso | enum | solo_lectura, puede_copiar, puede_editar |
| fecha_expiracion | timestamp | Expiración del acceso |
| requiere_autenticacion | boolean | Si requiere login |
| nombre_destinatario | varchar(100) | Con quién se compartió |
| email_destinatario | varchar(100) | Email del destinatario |
| notas | text | Comentarios sobre el compartido |
| veces_accedido | int | Contador de accesos |
| ultimo_acceso | timestamp | Última vez que se accedió |
| fecha_compartido | timestamp | Cuándo se compartió |

---

### 11. actividades
Log de auditoría de acciones en el sistema.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | PK |
| prompt_id | bigint | FK a prompts |
| user_id | bigint | FK a users |
| accion | varchar(50) | Tipo de acción |
| descripcion | text | Descripción detallada |
| fecha | timestamp | Cuándo ocurrió |

**Acciones comunes:** creado, editado, eliminado, compartido, usado, marcado_favorito, restaurado

---

### 12. sesiones_prompts
Persistencia de preferencias y sesión de usuario.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | PK |
| user_id | bigint | FK a users (unique) |
| filtros_activos | json | Filtros aplicados |
| busquedas_recientes | json | Historial de búsquedas |
| vista_preferida | enum | grid, lista |
| columnas_visibles | json | Columnas visibles |
| orden_preferido | varchar(50) | Orden preferido |
| fecha_expiracion | timestamp | Expiración de sesión |

---

## Índices y Constraints

### Foreign Keys
- `users.role_id` → `roles.id` [RESTRICT]
- `prompts.user_id` → `users.id` [CASCADE]
- `prompts.categoria_id` → `categorias.id` [SET NULL]
- `versiones.prompt_id` → `prompts.id` [CASCADE]
- `compartidos.prompt_id` → `prompts.id` [CASCADE]
- `actividades.prompt_id` → `prompts.id` [CASCADE]
- `actividades.user_id` → `users.id` [CASCADE]
- `sesiones_prompts.user_id` → `users.id` [CASCADE]

### Unique Constraints
- `users.email`
- `roles.nombre`
- `permisos.nombre`
- `etiquetas.nombre`
- `compartidos.token`
- `sesiones_prompts.user_id`
- `etiqueta_prompt(etiqueta_id, prompt_id)`
- `role_permiso(role_id, permiso_id)`

---

**Total de Tablas:** 12 tablas principales + 5 tablas Laravel (cache, jobs, sessions, etc.)
