# 01 - Esquema de Base de Datos

## Información General

- **Base de Datos:** promptvault
- **Motor:** MySQL 8.0+
- **Usuario:** root (sin contraseña)
- **Charset:** utf8mb4_unicode_ci

## Tablas Principales

### users
Usuarios del sistema con autenticación Laravel Breeze.

```sql
id, role_id, name, email, password, cuenta_activa, ultimo_acceso
```

**Total registros:** 12 usuarios

### roles
Sistema de roles para control de acceso.

```sql
id, nombre, descripcion, nivel_acceso
```

**Roles:** admin (100), user (10), collaborator (15), guest (1)

### permisos
Permisos específicos por módulo.

```sql
id, nombre, descripcion, modulo
```

**Total registros:** 40 permisos en 9 módulos

### categorias
Clasificación temática de prompts.

```sql
id, nombre, descripcion, color
```

**Categorías:** Programación, Redacción, Análisis de datos, Marketing, Educación, Diseño

### etiquetas
Palabras clave para búsqueda rápida.

```sql
id, nombre (único)
```

**Total registros:** 20 etiquetas

### prompts
Entidad principal del sistema.

```sql
id, user_id, categoria_id, titulo, contenido, descripcion,
fecha_creacion, ia_destino, es_favorito, es_publico,
version_actual, veces_usado, fecha_modificacion
```

**Total registros:** 10 prompts de ejemplo

### versiones
Historial de cambios de prompts.

```sql
id, prompt_id, numero_version, contenido, contenido_anterior,
motivo_cambio, fecha_version
```

**Total registros:** 10 versiones

### compartidos
Registro de prompts compartidos (interno/externo).

```sql
id, prompt_id, token, tipo_acceso, fecha_expiracion,
nombre_destinatario, email_destinatario, notas,
veces_accedido, ultimo_acceso
```

**Tipos de acceso:** solo_lectura, puede_copiar, puede_editar

### actividades
Log de auditoría del sistema.

```sql
id, prompt_id, user_id, accion, descripcion, fecha
```

**Acciones:** creado, editado, eliminado, compartido, usado, marcado_favorito, restaurado

### sesiones_prompts
Persistencia de preferencias de usuario.

```sql
id, user_id, filtros_activos, busquedas_recientes,
vista_preferida, orden_preferido, fecha_expiracion
```

## Relaciones Clave

```
users (1) -----> (N) prompts
users (N) -----> (1) roles
roles (N) -----> (M) permisos

prompts (1) -----> (N) versiones
prompts (1) -----> (N) compartidos
prompts (1) -----> (N) actividades
prompts (N) -----> (1) categorias
prompts (N) -----> (M) etiquetas
```

## Tablas Pivot

- **role_permiso:** Asigna permisos a roles
- **etiqueta_prompt:** Asigna etiquetas a prompts

## Foreign Keys

Todas las relaciones tienen constraints ON DELETE:
- CASCADE: Elimina registros relacionados
- SET NULL: Permite valores nulos
- RESTRICT: Previene eliminación si hay referencias
