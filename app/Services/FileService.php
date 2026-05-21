<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Attachment;

class FileService
{
    public function storeAttachment(UploadedFile $file, $postId)
    {
        // Generamos un nombre único usando el timestamp y un ID aleatorio
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        // Guardamos físicamente el archivo en la carpeta 'posts/{ID_DEL_POST}'
        $path = $file->storeAs('posts/' . $postId, $filename, 'public');

        // Registramos el archivo en la base de datos
        return Attachment::create([
            'post_id' => $postId,
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $path
        ]);
    }

    public function deleteAttachment(Attachment $attachment)
    {
        // Borramos el archivo físico del disco público
        Storage::disk('public')->delete($attachment->path);
        // Borramos el registro de la base de datos
        $attachment->delete();
    }

    public function getFileUrl(Attachment $attachment)
    {
        return asset('storage/' . $attachment->path);
    }
}