<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Docente</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Condensed:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="layout-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div>
                <h2>Sistema Docente</h2>
                <hr style="margin: 15px 0;">
                <nav>
                    @if(auth()->user()->isTeacher())
                        <p><a href="{{ route('teacher.dashboard') }}" class="btn" style="width:100%; margin-bottom:8px;">Tareas</a></p>
                        <p><a href="{{ route('teacher.students') }}" class="btn btn-secondary" style="width:100%; margin-bottom:8px;">Alumnos</a></p>
                    @else
                        <p><a href="{{ route('student.dashboard') }}" class="btn" style="width:100%; margin-bottom:8px;">Mis Tareas</a></p>
                    @endif
                </nav>
            </div>
            <div>
                <button id="theme-toggle" class="btn btn-secondary" style="width:100%; margin-bottom: 8px;">Modo Oscuro</button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="width:100%;">Cerrar Sesión</button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="main-wrapper">
            <header class="header-panel">
                <h3>Bienvenido, {{ auth()->user()->name }}</h3>
                <span class="badge">{{ auth()->user()->role === 'teacher' ? 'Docente' : 'Alumno' }}</span>
            </header>

            <main class="content-panel">
                @if(session('success'))
                    <div style="padding: 10px; background: var(--lavender-2); border-radius: 8px; margin-bottom: 15px;">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div style="padding: 10px; background: var(--almond-silk); border-radius: 8px; margin-bottom: 15px;">
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="footer-panel">
                <small>Gestión Escolar &copy; 2026</small>
            </footer>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>