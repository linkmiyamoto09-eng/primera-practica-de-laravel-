<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Condensed:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="auth-container">
        <div class="auth-left">
            <h2>inicio de sesion</h2>
            <br>
            <div class="auth-card">
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" class="input-control" required>
                    
                    <label>Contraseña</label>
                    <input type="password" name="password" class="input-control" required>
                    
                    <button type="submit" class="btn" style="width: 100%;">Ingresar</button>
                </form>
            </div>
        </div>
        <div class="auth-right">
            <h1>sistema docente</h1>
        </div>
    </div>
</body>
</html>