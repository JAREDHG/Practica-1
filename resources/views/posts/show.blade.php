<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $post->title }}</title>
</head>
<body>
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <hr>

    <h3>Archivos Adjuntos:</h3>
    <ul>
        @foreach($post->attachments as $attachment)
            <li class="attachment-item" style="margin-bottom: 10px;">
                <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank">
                    {{ $attachment->original_name }} ({{ number_format($attachment->size / 1024, 2) }} KB)
                </a>

                <form action="{{ route('attachments.destroy', $attachment) }}" method="POST" style="display:inline; margin-left: 10px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar este archivo?')">Eliminar</button>
                </form>
            </li>
        @endforeach
    </ul>

    <br>
    <a href="{{ route('dashboard') }}">Volver al Dashboard</a>
</body>
</html>