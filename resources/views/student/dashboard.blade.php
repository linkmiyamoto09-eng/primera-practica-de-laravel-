@extends('layouts.app')

@section('content')
@if(isset($notifications) && $notifications->count() > 0)
    <div style="border: 1px solid var(--border-color); padding: 10px; border-radius: 8px; margin-bottom: 20px;">
        <h4>Notificaciones</h4>
        <ul>
            @foreach($notifications as $notif)
                <li>{{ $notif->message }}</li>
            @endforeach
        </ul>
        <form action="{{ route('student.notifications.read') }}" method="POST" style="margin-top: 5px;">
            @csrf
            <button type="submit" class="btn btn-secondary" style="font-size: 0.8rem;">Marcar como leídas</button>
        </form>
    </div>
@endif

<h2>Mis Tareas y Evidencias</h2>

<table>
    <thead>
        <tr>
            <th>Tarea</th>
            <th>Tipo</th>
            <th>Fecha Límite</th>
            <th>Mi Evidencia</th>
            <th>Calificación</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        @php $sub = $submissions->get($task->id); @endphp
        <tr>
            <td>
                <strong>{{ $task->title }}</strong><br>
                <small>{{ $task->description }}</small>
            </td>
            <td><span class="badge">{{ $task->type }}</span></td>
            <td>{{ $task->due_date->format('d/m/Y 23:59') }}</td>
            <td>
                @if($sub)
                    <a href="{{ asset('storage/' . $sub->file_path) }}" target="_blank" class="btn btn-secondary">Ver PDF</a>
                @else
                    <span class="badge" style="background: var(--almond-silk)">Sin entrega</span>
                @endif
            </td>
            <td>
                @if($sub && $sub->is_published)
                    <strong>{{ $sub->score }} / 10</strong>
                @else
                    <small>Pendiente de publicación</small>
                @endif
            </td>
            <td>
                @if(!$task->isExpired())
                    <form action="{{ route('student.tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" accept="application/pdf" required style="font-size: 0.8rem; margin-bottom: 5px;">
                        <button type="submit" class="btn">{{ $sub ? 'Reemplazar PDF' : 'Subir PDF' }}</button>
                    </form>
                @else
                    <span class="badge">Tiempo agotado</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection