<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Auditoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Registro de Auditoría</h2>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver al Dashboard</a>
        </div>

        <table class="table table-hover table-bordered bg-white">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Modelo (ID)</th>
                    <th>Acción</th>
                    <th>Dirección IP</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($audits as $audit)
                    <tr>
                        <td>{{ $audit->id }}</td>
                        <td>{{ $audit->user_name }}</td>
                        <td>{{ $audit->model_type }} ({{ $audit->model_id }})</td>
                        <td>
                            <span class="badge bg-{{ $audit->action == 'delete' ? 'danger' : ($audit->action == 'create' ? 'success' : 'info') }}">
                                {{ strtoupper($audit->action) }}
                            </span>
                        </td>
                        <td>{{ $audit->ip_address }}</td>
                        <td>{{ $audit->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Sin registros de auditoría</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-4">
            {{ $audits->links() }}
        </div>
    </div>
</body>
</html>