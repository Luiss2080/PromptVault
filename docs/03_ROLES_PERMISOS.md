# 03 - Sistema de Roles y Permisos

## Arquitectura de Control de Acceso

### Modelo RBAC (Role-Based Access Control)

**Estructura:**
```
USER → ROLE → PERMISOS
```

Un usuario tiene un rol, y ese rol tiene múltiples permisos asignados.

---

## Roles del Sistema

### 1. Admin (Administrador)
**ID:** 1  
**Nivel de Acceso:** 100  
**Descripción:** Control total del sistema

#### Permisos
**TODOS** los 40 permisos del sistema, incluyendo:

**Gestión de Usuarios:**
- Ver listado de usuarios
- Crear nuevos usuarios
- Editar usuarios existentes
- Eliminar usuarios
- Activar/desactivar cuentas
- Asignar o cambiar roles
- Restablecer contraseñas

**Gestión Global de Prompts:**
- Ver todos los prompts del sistema
- Editar cualquier prompt (modo auditoría)
- Eliminar cualquier prompt
- Moderar prompts públicos

**Administración del Sistema:**
- Gestión global de categorías
- Acceso al historial global de actividades
- Ver estadísticas globales
- Exportar datos globales

**🔐 Restricción Clave:**
- No edita prompts privados de otros usuarios salvo en modo auditoría

---

### 2. User (Usuario Estándar)
**ID:** 2  
**Nivel de Acceso:** 10  
**Descripción:** Usuario registrado principal del sistema

#### Permisos Asignados (20 permisos)

**Gestión de Prompts Propios:**
- ✅ `prompts.ver_propios` - Ver sus propios prompts
- ✅ `prompts.crear` - Crear nuevos prompts
- ✅ `prompts.editar_propios` - Editar sus prompts
- ✅ `prompts.eliminar_propios` - Eliminar sus prompts
- ✅ `prompts.compartir` - Compartir con otros
- ✅ `prompts.marcar_favorito` - Marcar favoritos
- ✅ `prompts.marcar_publico` - Publicar prompts

**Versionado:**
- ✅ `versiones.ver` - Ver historial de versiones
- ✅ `versiones.crear` - Crear nuevas versiones
- ✅ `versiones.restaurar` - Restaurar versiones anteriores
- ✅ `versiones.comparar` - Comparar versiones

**Organización:**
- ✅ `categorias.ver` - Ver categorías
- ✅ `etiquetas.ver` - Ver etiquetas
- ✅ `etiquetas.crear` - Crear nuevas etiquetas

**Actividad y Estadísticas:**
- ✅ `actividades.ver_propias` - Ver su historial
- ✅ `estadisticas.ver_propias` - Ver sus estadísticas

**Búsqueda y Exportación:**
- ✅ `busqueda.basica` - Búsquedas básicas
- ✅ `busqueda.avanzada` - Filtros avanzados
- ✅ `exportar.propios` - Exportar sus datos

**🔐 Restricción Clave:**
- No puede modificar prompts de otros usuarios
- Solo ve prompts públicos o compartidos con él

---

### 3. Collaborator (Colaborador)
**ID:** 3  
**Nivel de Acceso:** 15  
**Descripción:** Usuario con permisos ampliados sobre prompts compartidos

#### Permisos Asignados (21 permisos)

**Incluye TODOS los permisos de User +:**
- ✅ `prompts.editar_compartidos` - Editar prompts compartidos con permisos

**Funcionalidades Adicionales:**
- Editar prompts compartidos con acceso `puede_editar`
- Crear nuevas versiones sobre prompts compartidos
- Restaurar versiones de prompts compartidos
- Ver historial de prompts compartidos

**🔐 Restricción Clave:**
- No puede eliminar prompts que no le pertenecen
- Solo edita si el compartido tiene tipo_acceso = 'puede_editar'

---

### 4. Guest (Usuario Externo)
**ID:** 4  
**Nivel de Acceso:** 1  
**Descripción:** Acceso sin cuenta mediante token compartido

#### Permisos Asignados (1 permiso)
- ✅ `prompts.ver_propios` - Solo el prompt compartido por token

**Características:**
- Acceso temporal mediante token UUID
- No requiere login ni cuenta
- Sesión limitada por fecha de expiración
- Permisos según tipo_acceso del compartido:
  - `solo_lectura`: Solo puede ver
  - `puede_copiar`: Puede copiar contenido
  - `puede_editar`: Puede editar (si está habilitado)

**🔐 Restricción Clave:**
- No puede navegar el sistema
- Solo accede al recurso específico del token

---

## Matriz de Permisos Completa

### Módulo: Usuarios
| Permiso | Admin | User | Collaborator | Guest |
|---------|-------|------|--------------|-------|
| usuarios.ver | ✅ | ❌ | ❌ | ❌ |
| usuarios.crear | ✅ | ❌ | ❌ | ❌ |
| usuarios.editar | ✅ | ❌ | ❌ | ❌ |
| usuarios.eliminar | ✅ | ❌ | ❌ | ❌ |
| usuarios.activar | ✅ | ❌ | ❌ | ❌ |
| usuarios.cambiar_rol | ✅ | ❌ | ❌ | ❌ |
| usuarios.restablecer_password | ✅ | ❌ | ❌ | ❌ |

### Módulo: Prompts
| Permiso | Admin | User | Collaborator | Guest |
|---------|-------|------|--------------|-------|
| prompts.ver_propios | ✅ | ✅ | ✅ | ✅ |
| prompts.ver_todos | ✅ | ❌ | ❌ | ❌ |
| prompts.crear | ✅ | ✅ | ✅ | ❌ |
| prompts.editar_propios | ✅ | ✅ | ✅ | ❌ |
| prompts.editar_compartidos | ✅ | ❌ | ✅ | ❌ |
| prompts.editar_todos | ✅ | ❌ | ❌ | ❌ |
| prompts.eliminar_propios | ✅ | ✅ | ✅ | ❌ |
| prompts.eliminar_todos | ✅ | ❌ | ❌ | ❌ |
| prompts.compartir | ✅ | ✅ | ✅ | ❌ |
| prompts.marcar_favorito | ✅ | ✅ | ✅ | ❌ |
| prompts.marcar_publico | ✅ | ✅ | ✅ | ❌ |
| prompts.moderar | ✅ | ❌ | ❌ | ❌ |

### Módulo: Versiones
| Permiso | Admin | User | Collaborator | Guest |
|---------|-------|------|--------------|-------|
| versiones.ver | ✅ | ✅ | ✅ | ❌ |
| versiones.crear | ✅ | ✅ | ✅ | ❌ |
| versiones.restaurar | ✅ | ✅ | ✅ | ❌ |
| versiones.comparar | ✅ | ✅ | ✅ | ❌ |

### Módulo: Categorías
| Permiso | Admin | User | Collaborator | Guest |
|---------|-------|------|--------------|-------|
| categorias.ver | ✅ | ✅ | ✅ | ❌ |
| categorias.crear | ✅ | ❌ | ❌ | ❌ |
| categorias.editar | ✅ | ❌ | ❌ | ❌ |
| categorias.eliminar | ✅ | ❌ | ❌ | ❌ |

### Módulo: Etiquetas
| Permiso | Admin | User | Collaborator | Guest |
|---------|-------|------|--------------|-------|
| etiquetas.ver | ✅ | ✅ | ✅ | ❌ |
| etiquetas.crear | ✅ | ✅ | ✅ | ❌ |
| etiquetas.editar | ✅ | ❌ | ❌ | ❌ |
| etiquetas.eliminar | ✅ | ❌ | ❌ | ❌ |

### Módulo: Actividades
| Permiso | Admin | User | Collaborator | Guest |
|---------|-------|------|--------------|-------|
| actividades.ver_propias | ✅ | ✅ | ✅ | ❌ |
| actividades.ver_todas | ✅ | ❌ | ❌ | ❌ |

### Módulo: Estadísticas
| Permiso | Admin | User | Collaborator | Guest |
|---------|-------|------|--------------|-------|
| estadisticas.ver_propias | ✅ | ✅ | ✅ | ❌ |
| estadisticas.ver_globales | ✅ | ❌ | ❌ | ❌ |

### Módulo: Exportar
| Permiso | Admin | User | Collaborator | Guest |
|---------|-------|------|--------------|-------|
| exportar.propios | ✅ | ✅ | ✅ | ❌ |
| exportar.globales | ✅ | ❌ | ❌ | ❌ |

### Módulo: Búsqueda
| Permiso | Admin | User | Collaborator | Guest |
|---------|-------|------|--------------|-------|
| busqueda.basica | ✅ | ✅ | ✅ | ❌ |
| busqueda.avanzada | ✅ | ✅ | ✅ | ❌ |
| busqueda.global | ✅ | ❌ | ❌ | ❌ |

---

## Implementación en Código

### Verificar Permiso en Controlador
```php
public function update(Request $request, Prompt $prompt)
{
    // Verificar permiso usando Policy
    $this->authorize('update', $prompt);
    
    // O verificar permiso específico
    if (!Auth::user()->tienePermiso('prompts.editar_propios')) {
        abort(403, 'No tienes permiso para editar prompts');
    }
    
    // Lógica de actualización...
}
```

### Verificar Permiso en Vistas Blade
```php
@can('update', $prompt)
    <a href="{{ route('prompts.edit', $prompt) }}">Editar</a>
@endcan

@if(Auth::user()->tienePermiso('prompts.eliminar_propios'))
    <button>Eliminar</button>
@endif
```

### Métodos Helper en User Model
```php
// Verificar rol
Auth::user()->esAdmin(); // true/false
Auth::user()->esUsuario(); // true/false
Auth::user()->esColaborador(); // true/false

// Verificar permiso único
Auth::user()->tienePermiso('prompts.crear');

// Verificar alguno de estos permisos
Auth::user()->tieneAlgunoDeEstosPermisos([
    'prompts.editar_propios',
    'prompts.editar_compartidos'
]);

// Verificar todos estos permisos
Auth::user()->tieneTodosEstosPermisos([
    'prompts.ver_propios',
    'prompts.crear'
]);
```

---

## Reglas de Negocio Especiales

### Edición de Prompts
```
1. Propietario siempre puede editar
2. Admin puede editar todos (modo auditoría)
3. Collaborator puede editar si:
   - Prompt está compartido con él
   - tipo_acceso = 'puede_editar'
```

### Visualización de Prompts
```
1. Prompts públicos: visible para todos autenticados
2. Prompts privados: solo propietario
3. Prompts compartidos: según email_destinatario
4. Admin: puede ver todos (auditoría)
```

### Compartir con Externos
```
1. Se genera token UUID único
2. Se define fecha_expiracion
3. tipo_acceso determina permisos:
   - solo_lectura: solo vista
   - puede_copiar: puede copiar contenido
   - puede_editar: puede crear versiones (opcional)
4. No requiere cuenta de usuario
```

---

## Escalabilidad del Sistema

### Agregar Nuevo Permiso
1. Insertar en tabla `permisos`
2. Asignar a roles deseados en `role_permiso`
3. Implementar verificación en código

### Agregar Nuevo Rol
1. Insertar en tabla `roles` con nivel_acceso
2. Asignar permisos en `role_permiso`
3. Usuarios pueden ser asignados a este rol

**Ejemplo:**
```sql
-- Crear rol "Moderator" (nivel 50)
INSERT INTO roles (nombre, descripcion, nivel_acceso)
VALUES ('moderator', 'Moderador de contenido', 50);

-- Asignar permisos específicos
INSERT INTO role_permiso (role_id, permiso_id)
SELECT 5, id FROM permisos
WHERE nombre IN ('prompts.ver_todos', 'prompts.moderar');
```

---

## Auditoría y Seguridad

### Registro de Cambios de Permisos
- Toda asignación/remoción de roles se registra en `actividades`
- Cambios de permisos de roles se auditan

### Protección contra Escalación de Privilegios
- Solo Admin puede cambiar roles
- No se puede auto-asignar rol de Admin
- Validación de permisos en cada request

### Rate Limiting
- Límites de intentos de login
- Protección contra fuerza bruta
- Tokens de compartir con expiración
