<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            // Módulo: Usuarios
            ['nombre' => 'usuarios.ver', 'descripcion' => 'Ver listado de usuarios', 'modulo' => 'usuarios'],
            ['nombre' => 'usuarios.crear', 'descripcion' => 'Crear nuevos usuarios', 'modulo' => 'usuarios'],
            ['nombre' => 'usuarios.editar', 'descripcion' => 'Editar usuarios existentes', 'modulo' => 'usuarios'],
            ['nombre' => 'usuarios.eliminar', 'descripcion' => 'Eliminar usuarios', 'modulo' => 'usuarios'],
            ['nombre' => 'usuarios.activar', 'descripcion' => 'Activar/desactivar cuentas', 'modulo' => 'usuarios'],
            ['nombre' => 'usuarios.cambiar_rol', 'descripcion' => 'Asignar o cambiar roles', 'modulo' => 'usuarios'],
            ['nombre' => 'usuarios.restablecer_password', 'descripcion' => 'Restablecer contraseñas', 'modulo' => 'usuarios'],

            // Módulo: Prompts
            ['nombre' => 'prompts.ver_propios', 'descripcion' => 'Ver sus propios prompts', 'modulo' => 'prompts'],
            ['nombre' => 'prompts.ver_todos', 'descripcion' => 'Ver todos los prompts del sistema', 'modulo' => 'prompts'],
            ['nombre' => 'prompts.crear', 'descripcion' => 'Crear nuevos prompts', 'modulo' => 'prompts'],
            ['nombre' => 'prompts.editar_propios', 'descripcion' => 'Editar sus propios prompts', 'modulo' => 'prompts'],
            ['nombre' => 'prompts.editar_compartidos', 'descripcion' => 'Editar prompts compartidos con permisos', 'modulo' => 'prompts'],
            ['nombre' => 'prompts.editar_todos', 'descripcion' => 'Editar cualquier prompt del sistema', 'modulo' => 'prompts'],
            ['nombre' => 'prompts.eliminar_propios', 'descripcion' => 'Eliminar sus propios prompts', 'modulo' => 'prompts'],
            ['nombre' => 'prompts.eliminar_todos', 'descripcion' => 'Eliminar cualquier prompt', 'modulo' => 'prompts'],
            ['nombre' => 'prompts.compartir', 'descripcion' => 'Compartir prompts con otros', 'modulo' => 'prompts'],
            ['nombre' => 'prompts.marcar_favorito', 'descripcion' => 'Marcar prompts como favoritos', 'modulo' => 'prompts'],
            ['nombre' => 'prompts.marcar_publico', 'descripcion' => 'Marcar prompts como públicos', 'modulo' => 'prompts'],
            ['nombre' => 'prompts.moderar', 'descripcion' => 'Moderar prompts públicos', 'modulo' => 'prompts'],

            // Módulo: Versiones
            ['nombre' => 'versiones.ver', 'descripcion' => 'Ver historial de versiones', 'modulo' => 'versiones'],
            ['nombre' => 'versiones.crear', 'descripcion' => 'Crear nuevas versiones', 'modulo' => 'versiones'],
            ['nombre' => 'versiones.restaurar', 'descripcion' => 'Restaurar versiones anteriores', 'modulo' => 'versiones'],
            ['nombre' => 'versiones.comparar', 'descripcion' => 'Comparar versiones', 'modulo' => 'versiones'],

            // Módulo: Categorías
            ['nombre' => 'categorias.ver', 'descripcion' => 'Ver categorías', 'modulo' => 'categorias'],
            ['nombre' => 'categorias.crear', 'descripcion' => 'Crear nuevas categorías', 'modulo' => 'categorias'],
            ['nombre' => 'categorias.editar', 'descripcion' => 'Editar categorías', 'modulo' => 'categorias'],
            ['nombre' => 'categorias.eliminar', 'descripcion' => 'Eliminar categorías', 'modulo' => 'categorias'],

            // Módulo: Etiquetas
            ['nombre' => 'etiquetas.ver', 'descripcion' => 'Ver etiquetas', 'modulo' => 'etiquetas'],
            ['nombre' => 'etiquetas.crear', 'descripcion' => 'Crear nuevas etiquetas', 'modulo' => 'etiquetas'],
            ['nombre' => 'etiquetas.editar', 'descripcion' => 'Editar etiquetas', 'modulo' => 'etiquetas'],
            ['nombre' => 'etiquetas.eliminar', 'descripcion' => 'Eliminar etiquetas', 'modulo' => 'etiquetas'],

            // Módulo: Actividades
            ['nombre' => 'actividades.ver_propias', 'descripcion' => 'Ver su propio historial', 'modulo' => 'actividades'],
            ['nombre' => 'actividades.ver_todas', 'descripcion' => 'Ver historial global (auditoría)', 'modulo' => 'actividades'],

            // Módulo: Estadísticas
            ['nombre' => 'estadisticas.ver_propias', 'descripcion' => 'Ver sus propias estadísticas', 'modulo' => 'estadisticas'],
            ['nombre' => 'estadisticas.ver_globales', 'descripcion' => 'Ver estadísticas globales', 'modulo' => 'estadisticas'],

            // Módulo: Exportar
            ['nombre' => 'exportar.propios', 'descripcion' => 'Exportar sus propios datos', 'modulo' => 'exportar'],
            ['nombre' => 'exportar.globales', 'descripcion' => 'Exportar datos globales', 'modulo' => 'exportar'],

            // Módulo: Búsqueda
            ['nombre' => 'busqueda.basica', 'descripcion' => 'Realizar búsquedas básicas', 'modulo' => 'busqueda'],
            ['nombre' => 'busqueda.avanzada', 'descripcion' => 'Usar filtros avanzados', 'modulo' => 'busqueda'],
            ['nombre' => 'busqueda.global', 'descripcion' => 'Buscar en toda la plataforma', 'modulo' => 'busqueda'],
        ];

        foreach ($permisos as $permiso) {
            DB::table('permisos')->insert([
                'nombre' => $permiso['nombre'],
                'descripcion' => $permiso['descripcion'],
                'modulo' => $permiso['modulo'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Asignar permisos a roles
        $this->asignarPermisosARoles();
    }

    private function asignarPermisosARoles()
    {
        // Admin: todos los permisos
        $todosPermisos = DB::table('permisos')->pluck('id');
        foreach ($todosPermisos as $permisoId) {
            DB::table('role_permiso')->insert([
                'role_id' => 1, // admin
                'permiso_id' => $permisoId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Usuario Estándar
        $permisosUser = [
            'prompts.ver_propios', 'prompts.crear', 'prompts.editar_propios', 'prompts.eliminar_propios',
            'prompts.compartir', 'prompts.marcar_favorito', 'prompts.marcar_publico',
            'versiones.ver', 'versiones.crear', 'versiones.restaurar', 'versiones.comparar',
            'categorias.ver', 'etiquetas.ver', 'etiquetas.crear',
            'actividades.ver_propias', 'estadisticas.ver_propias',
            'exportar.propios', 'busqueda.basica', 'busqueda.avanzada',
        ];
        $this->asignarPermisosPorNombre(2, $permisosUser);

        // Colaborador: incluye todos los de user + editar compartidos
        $permisosCollaborator = array_merge($permisosUser, [
            'prompts.editar_compartidos',
        ]);
        $this->asignarPermisosPorNombre(3, $permisosCollaborator);

        // Guest: solo lectura limitada
        $permisosGuest = [
            'prompts.ver_propios', // Solo el prompt compartido
        ];
        $this->asignarPermisosPorNombre(4, $permisosGuest);
    }

    private function asignarPermisosPorNombre($roleId, $nombresPermisos)
    {
        foreach ($nombresPermisos as $nombrePermiso) {
            $permiso = DB::table('permisos')->where('nombre', $nombrePermiso)->first();
            if ($permiso) {
                DB::table('role_permiso')->insert([
                    'role_id' => $roleId,
                    'permiso_id' => $permiso->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
