<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Panel Administrativo</h2>
        
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Posts</h5>
                        <p class="card-text fs-2">{{ $total_posts }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Usuarios</h5>
                        <p class="card-text fs-2">{{ $total_users }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Comentarios</h5>
                        <p class="card-text fs-2">{{ $total_comments }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3>Auditoría Reciente</h3>
                <table class="table table-striped table-bordered mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Usuario</th>
                            <th>Modelo</th>
                            <th>Acción</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_audits as $audit)
                            <tr>
                                <td>{{ $audit->user_name }}</td>
                                <td>{{ $audit->model_type }}</td>
                                <td>
                                    <span class="badge bg-{{ $audit->action == 'delete' ? 'danger' : ($audit->action == 'create' ? 'success' : 'info') }}">
                                        {{ strtoupper($audit->action) }}
                                    </span>
                                </td>
                                <td>{{ $audit->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Sin registros</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>