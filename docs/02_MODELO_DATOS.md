# 02 - Modelo de Datos y Relaciones

## Diagrama Entidad-Relación

### Entidades Principales

#### 1. PROMPT (Entidad Central)
**Propósito:** Almacenar instrucciones/plantillas para IAs

**Atributos:**
- `id`: Identificador único autogenerado
- `titulo`: Nombre descriptivo (máx. 100 caracteres)
- `contenido`: Texto completo del prompt
- `descripcion`: Para qué sirve este prompt
- `categoria_id`: FK a Categoría
- `ia_destino`: IA para la que está optimizado
- `es_favorito`: Booleano para marcar favoritos
- `es_publico`: Si puede ser visto por otros
- `veces_usado`: Contador de usos
- `fecha_creacion`: Timestamp de creación
- `fecha_modificacion`: Timestamp de última edición
- `version_actual`: Número de versión actual

**Responsabilidades (Métodos en Modelo):**
```php
- mostrarInformacion(): Muestra todos los datos
- incrementarUso(): Aumenta contador veces_usado
- marcarFavorito(): Cambia estado de favorito
- copiarAlPortapapeles(): Copia contenido para usar
```

---

#### 2. CATEGORIA
**Propósito:** Clasificación temática de prompts

**Atributos:**
- `id`: Identificador único
- `nombre`: Nombre de la categoría (ej: "Programación")
- `descripcion`: Qué tipo de prompts contiene
- `color`: Color HEX para identificación visual

**Ejemplos Implementados:**
- Programación → Prompts de código, debugging, APIs
- Redacción → Documentos, informes, manuales
- Análisis de datos → Estadísticas, visualizaciones
- Marketing → Estrategias, contenido, redes sociales
- Educación → Planes de clase, materiales educativos
- Diseño → UI/UX, wireframes, mockups

---

#### 3. ETIQUETA
**Propósito:** Palabras clave para búsqueda rápida

**Atributos:**
- `id`: Identificador único
- `nombre`: Palabra clave única (máx. 50 caracteres)

**Ejemplos:** ChatGPT, Claude, Python, JavaScript, Laravel, Testing, API, SEO

---

#### 4. VERSION
**Propósito:** Historial de cambios de un prompt

**Atributos:**
- `id`: Identificador único
- `prompt_id`: FK al prompt original
- `numero_version`: Número secuencial (1, 2, 3...)
- `contenido`: Texto en esta versión
- `contenido_anterior`: Texto antes del cambio
- `motivo_cambio`: Por qué se modificó
- `fecha_version`: Cuándo se creó esta versión

**Flujo de Versionado:**
1. Se crea prompt → versión 1 automática
2. Se edita contenido → versión 2 con contenido_anterior
3. Se puede restaurar cualquier versión → crea nueva versión

---

#### 5. COMPARTIDO
**Propósito:** Registro de con quién se ha compartido un prompt

**Atributos:**
- `id`: Identificador único
- `prompt_id`: FK al prompt compartido
- `nombre_destinatario`: Con quién se compartió
- `email_destinatario`: Email del destinatario
- `fecha_compartido`: Cuándo se compartió
- `notas`: Comentarios sobre por qué se compartió
- `token`: UUID para acceso externo (opcional)
- `tipo_acceso`: solo_lectura | puede_copiar | puede_editar
- `fecha_expiracion`: Caducidad del token
- `requiere_autenticacion`: Si necesita login

**Tipos de Compartido:**

**Interno (entre usuarios registrados):**
- Comparte entre emails de usuarios del sistema
- Puede asignar permisos de edición
- No requiere token

**Externo (usuarios no registrados):**
- Genera token UUID único
- Acceso temporal con fecha de expiración
- Puede requerir autenticación opcional
- Contador de veces accedido

---

#### 6. ACTIVIDAD
**Propósito:** Log de acciones realizadas (auditoría)

**Atributos:**
- `id`: Identificador único
- `prompt_id`: FK al prompt relacionado
- `user_id`: FK al usuario que realizó la acción
- `accion`: Tipo de acción realizada
- `descripcion`: Detalle de la acción
- `fecha`: Timestamp de la acción

**Acciones Registradas:**
- `creado`: Prompt creado
- `editado`: Contenido modificado
- `eliminado`: Prompt eliminado
- `compartido`: Compartido con alguien
- `usado`: Prompt copiado/utilizado
- `marcado_favorito`: Agregado a favoritos
- `desmarcado_favorito`: Removido de favoritos
- `restaurado`: Versión anterior restaurada

---

#### 7. ROLE (Sistema de Autorización)
**Propósito:** Definir roles de usuario

**Atributos:**
- `id`: Identificador único
- `nombre`: admin, user, collaborator, guest
- `descripcion`: Descripción del rol
- `nivel_acceso`: Nivel numérico (1-100)

---

#### 8. PERMISO (Sistema de Autorización)
**Propósito:** Permisos específicos del sistema

**Atributos:**
- `id`: Identificador único
- `nombre`: Formato: modulo.accion (ej: prompts.crear)
- `descripcion`: Qué permite hacer
- `modulo`: Módulo al que pertenece

---

#### 9. SESION_PROMPT
**Propósito:** Persistir preferencias de usuario

**Atributos:**
- `user_id`: FK usuario (único)
- `filtros_activos`: JSON con filtros aplicados
- `busquedas_recientes`: JSON historial búsquedas
- `vista_preferida`: grid | lista
- `orden_preferido`: reciente | titulo | uso | modificacion

---

## Relaciones Detalladas

### 1. Categoria → Prompt (1:N)
**Cardinalidad:** Una categoría tiene CERO o MÁS prompts

```
CATEGORIA (1) ──────┐
                    │
                    │ tiene
                    ↓
                 PROMPT (N)
```

**Implementación:**
```php
// Modelo Categoria
public function prompts(): HasMany {
    return $this->hasMany(Prompt::class);
}

// Modelo Prompt
public function categoria(): BelongsTo {
    return $this->belongsTo(Categoria::class);
}
```

---

### 2. Prompt → Version (1:N)
**Cardinalidad:** Un prompt tiene CERO o MÁS versiones

```
PROMPT (1) ──────┐
                 │
                 │ genera
                 ↓
              VERSION (N)
```

**Reglas de Negocio:**
- Al crear un prompt se crea automáticamente versión 1
- Al editar contenido se crea nueva versión
- Se guarda contenido anterior y motivo del cambio
- Se puede restaurar cualquier versión (crea nueva versión)

---

### 3. Prompt → Compartido (1:N)
**Cardinalidad:** Un prompt puede ser compartido con CERO o MÁS personas

```
PROMPT (1) ──────┐
                 │
                 │ compartido con
                 ↓
             COMPARTIDO (N)
```

**Flujo:**
1. Usuario comparte prompt con email destinatario
2. Si es externo, genera token UUID
3. Destinatario accede via token o email
4. Se registra fecha, notas y tipo de acceso

---

### 4. Prompt ↔ Etiqueta (N:M)
**Cardinalidad:** Muchos a muchos através de tabla intermedia

```
PROMPT (N) ─────┐         ┌───── ETIQUETA (M)
                │         │
                ↓         ↓
           ETIQUETA_PROMPT (Pivot)
```

**Implementación:**
```php
// Modelo Prompt
public function etiquetas(): BelongsToMany {
    return $this->belongsToMany(Etiqueta::class, 'etiqueta_prompt');
}

// Modelo Etiqueta
public function prompts(): BelongsToMany {
    return $this->belongsToMany(Prompt::class, 'etiqueta_prompt');
}
```

**Uso:**
```php
// Asignar etiquetas a prompt
$prompt->etiquetas()->attach([1, 2, 3]);

// Buscar prompts por etiqueta
$prompts = Prompt::whereHas('etiquetas', function($q) {
    $q->where('nombre', 'Laravel');
})->get();
```

---

### 5. Prompt → Actividad (1:N)
**Cardinalidad:** Un prompt genera CERO o MÁS registros de actividad

```
PROMPT (1) ──────┐
                 │
                 │ genera
                 ↓
             ACTIVIDAD (N)
```

**Propósito:** Auditoría completa de acciones sobre el prompt

---

### 6. User → Prompt (1:N)
**Cardinalidad:** Un usuario posee CERO o MÁS prompts

```
USER (1) ──────┐
               │
               │ posee
               ↓
            PROMPT (N)
```

---

### 7. Role ↔ Permiso (N:M)
**Cardinalidad:** Muchos a muchos através de role_permiso

```
ROLE (N) ─────┐         ┌───── PERMISO (M)
              │         │
              ↓         ↓
         ROLE_PERMISO (Pivot)
```

**Ejemplo:**
```php
// Verificar permiso de usuario
if (Auth::user()->tienePermiso('prompts.crear')) {
    // Puede crear prompts
}
```

---

## Flujos de Datos Principales

### Flujo 1: Crear Prompt
```
1. Usuario → crear prompt
2. Sistema → valida datos
3. Sistema → guarda en tabla prompts
4. Sistema → crea versión 1 automática
5. Sistema → asigna etiquetas (si hay)
6. Sistema → registra actividad "creado"
```

### Flujo 2: Editar Prompt
```
1. Usuario → edita contenido
2. Sistema → detecta cambio de contenido
3. Sistema → incrementa version_actual
4. Sistema → crea nueva versión con:
   - contenido nuevo
   - contenido_anterior
   - motivo_cambio
5. Sistema → actualiza prompt
6. Sistema → registra actividad "editado"
```

### Flujo 3: Compartir Prompt
```
1. Usuario → comparte con email
2. Sistema → verifica si es usuario registrado
3. SI es registrado:
   - Crea registro en compartidos (sin token)
   - Destinatario puede ver en su listado
4. SI es externo:
   - Genera token UUID único
   - Crea registro con fecha_expiracion
   - Envía enlace con token
5. Sistema → registra actividad "compartido"
```

### Flujo 4: Buscar Prompts
```
1. Usuario → ingresa criterios:
   - Palabra clave
   - Categoría
   - IA destino
   - Etiqueta
   - Favoritos
2. Sistema → construye query con filtros
3. Sistema → aplica ordenamiento preferido
4. Sistema → retorna resultados paginados
5. Sistema → guarda búsqueda en sesion
```

---

## Integridad Referencial

### ON DELETE CASCADE
**Aplicado a:**
- `prompts.user_id` → Si se elimina usuario, se eliminan sus prompts
- `versiones.prompt_id` → Si se elimina prompt, se eliminan sus versiones
- `compartidos.prompt_id` → Se eliminan registros de compartidos
- `actividades.prompt_id` → Se elimina historial de actividades
- `etiqueta_prompt` → Se eliminan relaciones

### ON DELETE SET NULL
**Aplicado a:**
- `prompts.categoria_id` → Si se elimina categoría, prompts quedan sin categoría

### ON DELETE RESTRICT
**Aplicado a:**
- `users.role_id` → No se puede eliminar rol si tiene usuarios asignados

---

## Índices y Optimización

### Índices Únicos
- `users.email`
- `roles.nombre`
- `permisos.nombre`
- `etiquetas.nombre`
- `compartidos.token`
- `sesiones_prompts.user_id`

### Índices Compuestos Únicos
- `etiqueta_prompt(etiqueta_id, prompt_id)`
- `role_permiso(role_id, permiso_id)`

### Índices de Foreign Keys
Automáticos en todas las relaciones para optimizar JOINs
