<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario de prueba 1
        $user1 = User::create([
            'name'     => 'Ana García',
            'email'    => 'ana@test.com',
            'password' => Hash::make('password'),
        ]);

        // Usuario de prueba 2 (para verificar que el filtro funcione)
        $user2 = User::create([
            'name'     => 'Carlos López',
            'email'    => 'carlos@test.com',
            'password' => Hash::make('password'),
        ]);

        // Categorías
        $categorias = Categoria::insert([
            ['nombre' => 'Soporte técnico',  'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Recursos Humanos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Administración',   'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Infraestructura',  'created_at' => now(), 'updated_at' => now()],
        ]);

        // Solicitudes de Ana
        Solicitud::create([
            'user_id'      => $user1->id,
            'categoria_id' => 1,
            'titulo'       => 'Mi computadora no enciende',
            'descripcion'  => 'Desde esta mañana la PC no inicia, muestra pantalla negra.',
            'estado'       => 'pendiente',
            'created_at'   => now()->subDays(3),
        ]);

        Solicitud::create([
            'user_id'      => $user1->id,
            'categoria_id' => 3,
            'titulo'       => 'Necesito acceso al sistema contable',
            'descripcion'  => 'Ingresé al área hace dos semanas y todavía no tengo acceso.',
            'estado'       => 'en proceso',
            'created_at'   => now()->subDays(1),
        ]);

        Solicitud::create([
            'user_id'      => $user1->id,
            'categoria_id' => 2,
            'titulo'       => 'Consulta sobre vacaciones',
            'descripcion'  => 'Quiero saber cuántos días de vacaciones me corresponden este año.',
            'estado'       => 'resuelto',
            'created_at'   => now()->subDays(10),
        ]);

        // Solicitudes de Carlos (no deben aparecer en el listado de Ana)
        Solicitud::create([
            'user_id'      => $user2->id,
            'categoria_id' => 4,
            'titulo'       => 'Falla en el servidor de archivos',
            'descripcion'  => 'No puedo acceder a la carpeta compartida del servidor.',
            'estado'       => 'pendiente',
        ]);

        Solicitud::create([
            'user_id'      => $user2->id,
            'categoria_id' => 1,
            'titulo'       => 'Problema con el correo corporativo',
            'descripcion'  => 'Los mails no se envían desde Outlook.',
            'estado'       => 'en proceso',
        ]);
    }
}
