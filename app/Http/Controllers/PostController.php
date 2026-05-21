<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function store(StorePostRequest $request)
    {
        // Creamos el post enlazado automáticamente al ID del usuario autenticado
        $post = auth()->user()->posts()->create([
            'title' => $request->title, //
            'content' => $request->content, //
            'category_id' => $request->category_id, //
            'published_at' => $request->published_at, //
        ]);

        // Si el request trae etiquetas, usamos attach() para insertarlas en la tabla pivote
        if ($request->has('tags')) { //
            $post->tags()->attach($request->tags); //
        }

        return redirect()->route('posts.show', $post) //
                         ->with('success', 'Post creado exitosamente'); //
    }

    public function update(StorePostRequest $request, Post $post)
    {
        // Autorización: Verifica si el usuario tiene permiso para editar este post
        Gate::authorize('update', $post); 

        // Actualizamos usando únicamente los datos validados
        $post->update($request->validated()); //
        
        // Usamos sync() para actualizar la tabla pivote borrando las etiquetas viejas y poniendo las nuevas
        $post->tags()->sync($request->tags); //

        return redirect()->route('posts.show', $post) //
                         ->with('success', 'Post actualizado'); //
    }
}