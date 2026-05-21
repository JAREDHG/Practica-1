<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Llamamos al RoleSeeder primero para que existan los roles
        $this->call([RoleSeeder::class]);

        // Crear usuario admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Asignar rol admin
        $adminRole = Role::where('name', 'admin')->first();
        $admin->roles()->attach($adminRole);

        // Crear más usuarios
        $users = User::factory(10)->create();

        // Asignar rol de editor a 5 usuarios al azar
        $editorRole = Role::where('name', 'editor')->first();
        $users->random(5)->each(function ($user) use ($editorRole) {
            $user->roles()->attach($editorRole);
        });

        // Crear categorías
        $categories = Category::factory(5)->create();

        // Crear posts [cite: 530]
        Post::factory(50)->make()->each(function ($post) use ($users, $categories) {
            // Asignamos un autor y categoría aleatoria antes de guardar
            $post->user_id = $users->random()->id;
            $post->category_id = $categories->random()->id;
            $post->save();

            // Agregar tags aleatorios
            $tags = Tag::factory(3)->create();
            $post->tags()->attach($tags); 

            // Agregar comentarios
            Comment::factory(5)->create([
                'post_id' => $post->id,
                'user_id' => $users->random()->id // El autor del comentario
            ]);
        });
    }
}