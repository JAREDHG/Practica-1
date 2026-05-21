<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Attachment;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\StorePostWithAttachmentsRequest;
use App\Services\FileService;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    // Muestra el formulario para crear un post
    public function create()
    {
        return view('posts.create');
    }

    // Muestra un post específico y sus archivos
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function store(StorePostWithAttachmentsRequest $request)
    {
        // Creamos el post enlazado automáticamente al ID del usuario autenticado
        $post = auth()->user()->posts()->create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'published_at' => $request->published_at,
        ]);

        // Si el request trae etiquetas, usamos attach() para insertarlas en la tabla pivote
        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }

        // PRÁCTICA 3: Si hay archivos adjuntos, los procesamos con el FileService
        if ($request->hasFile('attachments')) {
            $fileService = new FileService();
            foreach ($request->file('attachments') as $file) {
                $fileService->storeAttachment($file, $post->id);
            }
        }

        return redirect()->route('posts.show', $post)
                         ->with('success', 'Post creado exitosamente con archivos');
    }

    public function update(StorePostRequest $request, Post $post)
    {
        // Autorización: Verifica si el usuario tiene permiso para editar este post
        Gate::authorize('update', $post); 

        // Actualizamos usando únicamente los datos validados
        $post->update($request->validated()); 
        
        // Usamos sync() para actualizar la tabla pivote borrando las etiquetas viejas y poniendo las nuevas
        $post->tags()->sync($request->tags); 

        return redirect()->route('posts.show', $post)
                         ->with('success', 'Post actualizado'); 
    }

    // PRÁCTICA 3: Método para eliminar un archivo adjunto (Renombrado para coincidir con la ruta)
    public function destroyAttachment(Attachment $attachment)
    {
        // Autorización: Verificamos permiso sobre el post padre del archivo
        Gate::authorize('delete', $attachment->post);
        
        $fileService = new FileService();
        $fileService->deleteAttachment($attachment);
        
        return redirect()->back()->with('success', 'Archivo eliminado');
    }

    // Método original para eliminar el post completo (Práctica 2)
    public function destroy($id)
    {
        // Lógica de borrado del post...
    }
}