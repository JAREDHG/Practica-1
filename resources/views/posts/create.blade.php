<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Post</title>
</head>
<body>
    <h1>Crear un nuevo Post</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div>
            <label for="title">Título:</label><br>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required>
            @error('title') <span style="color: red;">{{ $message }}</span> @enderror
        </div>
        <br>

        <div>
            <label for="content">Contenido:</label><br>
            <textarea name="content" id="content" rows="5" required>{{ old('content') }}</textarea>
            @error('content') <span style="color: red;">{{ $message }}</span> @enderror
        </div>
        <br>

        <div>
            <label for="category_id">ID de Categoría (Ingresa 1):</label><br>
            <input type="number" name="category_id" id="category_id" value="1" required>
            @error('category_id') <span style="color: red;">{{ $message }}</span> @enderror
        </div>
        <br>

        <div>
            <label for="attachments">Archivos adjuntos (Máx 5):</label><br>
            <input type="file" name="attachments[]" id="attachments" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
            @error('attachments') <div style="color: red;">{{ $message }}</div> @enderror
            @error('attachments.*') <div style="color: red;">{{ $message }}</div> @enderror
        </div>
        <br>

        <button type="submit">Crear Post</button>
    </form>
</body>
</html>