@extends('layouts.app')

@section('content')
<h2>Gestión de Alumnos</h2>

<div style="display: flex; gap: 20px; margin-top: 20px;">
    <!-- Captura Individual -->
    <div style="flex:1; border: 1px solid var(--border-color); padding: 15px; border-radius: 12px;">
        <h3>Registro Individual</h3>
        <form action="{{ route('teacher.students.store') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Nombre completo" class="input-control" required>
            <input type="email" name="email" placeholder="Correo" class="input-control" required>
            <input type="password" name="password" placeholder="Contraseña" class="input-control" required>
            <button type="submit" class="btn">Registrar</button>
        </form>
    </div>

    <!-- Carga Masiva -->
    <div style="flex:1; border: 1px solid var(--border-color); padding: 15px; border-radius: 12px;">
        <h3>Carga Masiva (Formato: Nombre,Email,Password)</h3>
        <form action="{{ route('teacher.students.bulk') }}" method="POST">
            @csrf
            <textarea name="csv_data" class="input-control" rows="4" placeholder="Juan Perez,juan@escuela.edu,123456" required></textarea>
            <button type="submit" class="btn btn-secondary">Procesar Lista</button>
        </form>
    </div>
</div>

<h3 style="margin-top: 30px;">Lista de Alumnos</h3>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->is_active ? 'Activo' : 'Inactivo' }}</td>
            <td>
                <form action="{{ route('teacher.students.toggle', $student->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">{{ $student->is_active ? 'Desactivar' : 'Activar' }}</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection