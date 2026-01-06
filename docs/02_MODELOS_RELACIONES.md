# 02 - Modelos Eloquent y Relaciones

## Modelos Implementados

### User
**Ubicación:** `app/Models/User.php`

**Relaciones:**
- `role()` - BelongsTo Role
- `prompts()` - HasMany Prompt
- `actividades()` - HasMany Actividad
- `sesionPrompt()` - HasOne SesionPrompt

**Métodos Helper:**
```php
esAdmin(), esUsuario(), esColaborador(), esGuest()
tienePermiso($nombrePermiso)
puedeEditar(Prompt $prompt)
puedeVer(Prompt $prompt)
```

### Prompt
**Ubicación:** `app/Models/Prompt.php`

**Relaciones:**
- `user()` - BelongsTo User
- `categoria()` - BelongsTo Categoria
- `versiones()` - HasMany Version
- `compartidos()` - HasMany Compartido
- `actividades()` - HasMany Actividad
- `etiquetas()` - BelongsToMany Etiqueta

**Casts:**
```php
fecha_creacion: datetime
fecha_modificacion: datetime
es_favorito: boolean
es_publico: boolean
```

### Categoria
**Ubicación:** `app/Models/Categoria.php`

**Relaciones:**
- `prompts()` - HasMany Prompt

**Campos:** nombre, descripcion, color (hex)

### Etiqueta
**Ubicación:** `app/Models/Etiqueta.php`

**Relaciones:**
- `prompts()` - BelongsToMany Prompt (pivot: etiqueta_prompt)

### Version
**Ubicación:** `app/Models/Version.php`

**Relaciones:**
- `prompt()` - BelongsTo Prompt

**Campos:** numero_version, contenido, contenido_anterior, motivo_cambio

### Compartido
**Ubicación:** `app/Models/Compartido.php`

**Relaciones:**
- `prompt()` - BelongsTo Prompt

**Campos:** token (UUID), tipo_acceso, fecha_expiracion, veces_accedido

### Actividad
**Ubicación:** `app/Models/Actividad.php`

**Relaciones:**
- `prompt()` - BelongsTo Prompt
- `user()` - BelongsTo User

**Campos:** accion, descripcion, fecha

### Role
**Ubicación:** `app/Models/Role.php`

**Relaciones:**
- `users()` - HasMany User
- `permisos()` - BelongsToMany Permiso (pivot: role_permiso)

**Métodos:**
```php
tienePermiso($nombrePermiso)
```

### Permiso
**Ubicación:** `app/Models/Permiso.php`

**Relaciones:**
- `roles()` - BelongsToMany Role

**Campos:** nombre, descripcion, modulo

### SesionPrompt
**Ubicación:** `app/Models/SesionPrompt.php`

**Relaciones:**
- `user()` - BelongsTo User

**Casts JSON:**
```php
filtros_activos: array
busquedas_recientes: array
columnas_visibles: array
```

## Controladores

### PromptController
**Ubicación:** `app/Http/Controllers/PromptController.php`

**Métodos Resource:**
- index() - Listar con filtros y búsqueda
- create() - Formulario creación
- store() - Guardar nuevo prompt
- show() - Ver detalle
- edit() - Formulario edición
- update() - Actualizar prompt
- destroy() - Eliminar prompt

**Métodos Adicionales:**
- toggleFavorito() - Marcar/desmarcar favorito
- incrementarUso() - Contador de usos
- compartir() - Compartir con otros
- historial() - Ver actividades
- restaurarVersion() - Restaurar versión anterior

## Políticas de Autorización

**PromptPolicy:** `app/Policies/PromptPolicy.php`
- view: Propietario o público o admin
- update: Propietario o colaborador con permiso
- delete: Solo propietario
