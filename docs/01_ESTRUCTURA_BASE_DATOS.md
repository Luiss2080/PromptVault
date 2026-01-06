# 01 - Estructura de Base de Datos

## Información General

**Base de Datos:** promptvault  
**Motor:** MySQL 8.0+  
**Usuario:** root  
**Contraseña:** (vacía)  
**Charset:** utf8mb4_unicode_ci

---

## Tablas Implementadas

### 1. users
Usuarios del sistema con autenticación Laravel Breeze.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint unsigned PK | Identificador único |
| role_id | bigint unsigned FK | Rol del usuario (default: 2) |
| name | varchar(255) | Nombre completo |
| email | varchar(255) UNIQUE | Email del usuario |
| password | varchar(255) | Contraseña hasheada |
| cuenta_activa | boolean | Si la cuenta está activa (default: true) |
| ultimo_acceso | timestamp | Último login del usuario |
| email_verified_at | timestamp | Verificación de email |
| remember_token | varchar(100) | Token para "recordarme" |
| created_at, updated_at | timestamp | Auditoría |

**Índices:**
- PRIMARY KEY (id)
- UNIQUE (email)
- FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT

---

### 2. roles
Roles del sistema con niveles de acceso.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint unsigned PK | Identificador único |
| nombre | varchar(50) UNIQUE | admin, user, collaborator, guest |
| descripcion | varchar(255) | Descripción del rol |
| nivel_acceso | int | Nivel numérico (1-100) |
| created_at, updated_at | timestamp | Auditoría |

**Roles Predefinidos:**
1. `admin` - Administrador (nivel 100)
2. `user` - Usuario estándar (nivel 10)
3. `collaborator` - Colaborador (nivel 15)
4. `guest` - Acceso externo (nivel 1)

---

### 3. permisos
Permisos específicos del sistema organizados por módulos.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint unsigned PK | Identificador único |
| nombre | varchar(100) UNIQUE | Ej: prompts.crear, usuarios.editar |
| descripcion | varchar(255) | Descripción del permiso |
| modulo | varchar(50) | usuarios, prompts, versiones, etc. |
| created_at, updated_at | timestamp | Auditoría |

**Módulos del Sistema:**
- usuarios
- prompts
- versiones
- categorias
- etiquetas
- actividades
- estadisticas
- exportar
- busqueda

---

### 4. role_permiso
Tabla pivot para asignar permisos a roles (N:M).

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint unsigned PK | Identificador único |
| role_id | bigint unsigned FK | Rol |
| permiso_id | bigint unsigned FK | Permiso |
| created_at, updated_at | timestamp | Auditoría |

**Constraints:**
- UNIQUE(role_id, permiso_id)
- FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
- FOREIGN KEY (permiso_id) REFERENCES permisos(id) ON DELETE CASCADE

---

### 5. categorias
Categorías para organizar prompts temáticamente.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint unsigned PK | Identificador único |
| nombre | varchar(100) | Nombre de la categoría |
| descripcion | text | Qué tipo de prompts contiene |
| color | varchar(7) | Color HEX para UI (default: #3B82F6) |
| created_at, updated_at | timestamp | Auditoría |

**Categorías Predefinidas:**
1. Programación (#3B82F6)
2. Redacción (#10B981)
3. Análisis de datos (#F59E0B)
4. Marketing (#EC4899)
5. Educación (#8B5CF6)
6. Diseño (#EF4444)

---

### 6. etiquetas
Palabras clave para clasificación granular de prompts.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint unsigned PK | Identificador único |
| nombre | varchar(50) UNIQUE | Nombre de la etiqueta |
| created_at, updated_at | timestamp | Auditoría |

**Ejemplos:** ChatGPT, Claude, Python, Laravel, Testing, SEO, etc.

---

### 7. prompts
Tabla principal del sistema - Instrucciones para IA.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint unsigned PK | Identificador único |
| user_id | bigint unsigned FK | Propietario del prompt |
| categoria_id | bigint unsigned FK NULL | Categoría del prompt |
| titulo | varchar(100) | Nombre descriptivo |
| contenido | text | Texto completo del prompt |
| descripcion | text NULL | Para qué sirve este prompt |
| fecha_creacion | timestamp | Cuándo se creó |
| ia_destino | varchar(50) NULL | ChatGPT, Claude, Gemini, etc. |
| es_favorito | boolean | Marcado como favorito (default: false) |
| es_publico | boolean | Visible por otros (default: false) |
| version_actual | int | Número de versión actual (default: 1) |
| veces_usado | int | Contador de usos (default: 0) |
| fecha_modificacion | timestamp NULL | Última modificación |
| created_at, updated_at | timestamp | Auditoría |

**Constraints:**
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
- FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL

---

### 8. etiqueta_prompt
Tabla pivot para relación N:M entre prompts y etiquetas.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint unsigned PK | Identificador único |
| etiqueta_id | bigint unsigned FK | Etiqueta |
| prompt_id | bigint unsigned FK | Prompt |
| created_at, updated_at | timestamp | Auditoría |

**Constraints:**
- UNIQUE(etiqueta_id, prompt_id)
- FOREIGN KEY (etiqueta_id) REFERENCES etiquetas(id) ON DELETE CASCADE
- FOREIGN KEY (prompt_id) REFERENCES prompts(id) ON DELETE CASCADE

---

### 9. versiones
Historial de cambios de prompts.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint unsigned PK | Identificador único |
| prompt_id | bigint unsigned FK | Prompt versionado |
| numero_version | int | Número secuencial (1, 2, 3...) |
| contenido | text | Contenido de esta versión |
| contenido_anterior | text NULL | Contenido antes del cambio |
| motivo_cambio | text NULL | Por qué se modificó |
| fecha_version | timestamp | Cuándo se creó esta versión |
| created_at, updated_at | timestamp | Auditoría |

**Constraints:**
- FOREIGN KEY (prompt_id) REFERENCES prompts(id) ON DELETE CASCADE

---

### 10. compartidos
Registro de prompts compartidos (internos y externos).

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint unsigned PK | Identificador único |
| token | char(36) UUID NULL UNIQUE | Token para acceso externo |
| tipo_acceso | enum | solo_lectura, puede_copiar, puede_editar |
| fecha_expiracion | timestamp NULL | Caducidad del acceso |
| requiere_autenticacion | boolean | Si necesita login (default: false) |
| veces_accedido | int | Contador de accesos (default: 0) |
| ultimo_acceso | timestamp NULL | Último acceso al recurso |
| prompt_id | bigint unsigned FK | Prompt compartido |
| nombre_destinatario | varchar(100) | Con quién se compartió |
| email_destinatario | varchar(100) | Email del destinatario |
| fecha_compartido | timestamp | Cuándo se compartió |
| notas | text NULL | Comentarios |
| created_at, updated_at | timestamp | Auditoría |

**Constraints:**
- FOREIGN KEY (prompt_id) REFERENCES prompts(id) ON DELETE CASCADE

---

### 11. actividades
Log de auditoría de acciones en el sistema.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint unsigned PK | Identificador único |
| prompt_id | bigint unsigned FK | Prompt relacionado |
| user_id | bigint unsigned FK | Usuario que realizó la acción |
| accion | varchar(50) | Tipo de acción |
| descripcion | text NULL | Detalle de la acción |
| fecha | timestamp | Cuándo ocurrió |
| created_at, updated_at | timestamp | Auditoría |

**Acciones Comunes:**
- creado, editado, eliminado
- compartido, usado
- marcado_favorito, desmarcado_favorito
- restaurado

**Constraints:**
- FOREIGN KEY (prompt_id) REFERENCES prompts(id) ON DELETE CASCADE
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE

---

### 12. sesiones_prompts
Persistencia de preferencias de usuario.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint unsigned PK | Identificador único |
| user_id | bigint unsigned FK UNIQUE | Usuario |
| filtros_activos | json NULL | Filtros aplicados |
| busquedas_recientes | json NULL | Historial de búsquedas |
| vista_preferida | enum | grid, lista |
| columnas_visibles | json NULL | Columnas visibles |
| orden_preferido | varchar(50) | reciente, titulo, uso, modificacion |
| fecha_expiracion | timestamp NULL | Caducidad de sesión |
| created_at, updated_at | timestamp | Auditoría |

**Constraints:**
- UNIQUE (user_id)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE

---

## Resumen de Relaciones

```
users (1) -----> (N) prompts
users (N) -----> (1) roles
users (1) -----> (N) actividades
users (1) -----> (1) sesiones_prompts

roles (N) -----> (M) permisos [role_permiso]

prompts (1) -----> (N) versiones
prompts (1) -----> (N) compartidos
prompts (1) -----> (N) actividades
prompts (N) -----> (1) categorias
prompts (N) -----> (M) etiquetas [etiqueta_prompt]
```

---

## Estadísticas Actuales

| Tabla | Registros |
|-------|-----------|
| users | 12 |
| roles | 4 |
| permisos | 40 |
| categorias | 6 |
| etiquetas | 20 |
| prompts | 10 |
| versiones | 10 |
| compartidos | 10 |
| actividades | 10 |
| sesiones_prompts | 10 |
| etiqueta_prompt | 29 |
| role_permiso | ~80 |

**Total de tablas:** 20 (incluyendo system tables de Laravel)  
**Total de registros de datos:** ~210+
