@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2>Panel de Tareas</h2>
    <a href="{{ route('teacher.tasks.create') }}" class="btn">Crear Tarea</a>
</div>

<table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Tipo</th>
            <th>Fecha Entrega Límite</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->title }}</td>
            <td><span class="badge">{{ $task->type }}</span></td>
            <td>{{ $task->due_date->format('d/m/Y H:i') }}</td>
            <td>
                @if($task->is_cancelled)
                    <span class="badge" style="background: var(--almond-silk)">Cancelada</span>
                @elseif($task->isExpired())
                    <span class="badge">Vencida</span>
                @else
                    <span class="badge" style="background: var(--lavender)">Activa</span>
                @endif
            </td>
            <td>
                <a href="{{ route('teacher.tasks.show', $task->id) }}" class="btn btn-secondary">Ver Estado</a>
                @if(!$task->is_cancelled)
                    <form action="{{ route('teacher.tasks.cancel', $task->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Cancelar tarea?')">Cancelar</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection