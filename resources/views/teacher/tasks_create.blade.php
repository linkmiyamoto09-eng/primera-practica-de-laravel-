@extends('layouts.app')

@section('content')
<h2>Crear Nueva Tarea</h2>

<form action="{{ route('teacher.tasks.store') }}" method="POST" style="max-width: 500px; margin-top: 20px;">
    @csrf
    <label>Título de la Tarea</label>
    <input type="text" name="title" class="input-control" required>

    <label>Descripción / Especificaciones</label>
    <textarea name="description" class="input-control" rows="4" required></textarea>

    <label>Tipo de Tarea</label>
    <select name="type" class="input-control" required>
        <option value="tareas en casa">Tareas en casa</option>
        <option value="actividades">Actividades</option>
        <option value="exposiciones">Exposiciones</option>
    </select>

    <label>Fecha de Entrega</label>
    <input type="date" name="due_date" class="input-control" required>

    <button type="submit" class="btn">Asignar Tarea</button>
</form>
@endsection