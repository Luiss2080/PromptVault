# 04 - Datos de Ejemplo

## Resumen de Registros

La base de datos contiene datos de ejemplo en español de diferentes áreas de trabajo.

| Tabla | Registros | Descripción |
|-------|-----------|-------------|
| users | 12 | Usuarios del sistema |
| roles | 4 | Roles del sistema |
| permisos | 40 | Permisos por módulo |
| categorias | 6 | Categorías de prompts |
| etiquetas | 20 | Etiquetas para clasificación |
| prompts | 10 | Prompts de ejemplo |
| versiones | 10 | Historial de versiones |
| compartidos | 10 | Prompts compartidos |
| actividades | 10 | Log de actividades |
| sesiones_prompts | 10 | Preferencias de usuarios |

## Categorías Predefinidas

1. **Programación** (#3B82F6 - Azul)
   - Prompts para desarrollo de software, código, debugging

2. **Redacción** (#10B981 - Verde)
   - Escritura creativa, copywriting, documentación

3. **Análisis de datos** (#F59E0B - Naranja)
   - Análisis, interpretación y visualización

4. **Marketing** (#EC4899 - Rosa)
   - Estrategias de marketing y publicidad

5. **Educación** (#8B5CF6 - Púrpura)
   - Enseñanza y aprendizaje

6. **Diseño** (#EF4444 - Rojo)
   - Diseño gráfico, UI/UX

## Ejemplos de Prompts

### Programación
- **Revisar código Python** - Análisis y mejoras de código
- **Crear API REST Laravel** - Generador de APIs
- **Tests unitarios automáticos** - Testing con PHPUnit

### Redacción
- **Redactar informe técnico** - Estructura profesional
- **Manual de usuario** - Documentación técnica

### Marketing
- **Estrategia redes sociales** - Planificación de contenido

### Educación
- **Plan de clase interactivo** - Planificación educativa

### Análisis de Datos
- **Análisis de datos ventas** - Insights y tendencias

### Diseño
- **Diseño de interfaz web** - Wireframes y mockups

## Etiquetas Disponibles

ChatGPT, Claude, Gemini, Copilot, Python, JavaScript, PHP, Laravel, React, Vue, SQL, API, Testing, Debug, Optimización, SEO, Social Media, Email, Blog, Tutorial

## Seeders Ejecutados

Los siguientes seeders poblan la base de datos:

1. **RoleSeeder** - Crea los 4 roles
2. **PermisoSeeder** - Crea 40 permisos y asignaciones
3. **CategoriaSeeder** - Crea 6 categorías
4. **EtiquetaSeeder** - Crea 20 etiquetas
5. **UserSeeder** - Crea 10 usuarios adicionales
6. **PromptSeeder** - Crea 10 prompts de ejemplo
7. **VersionSeeder** - Crea historial de versiones
8. **CompartidoSeeder** - Crea registros de compartidos
9. **ActividadSeeder** - Crea log de actividades
10. **SesionPromptSeeder** - Crea preferencias de usuarios
