@extends('layouts.app')

@section('content')
<h2>{{ $task->title }}</h2>
<p><strong>Tipo:</strong> {{ $task->type }} | <strong>Límite:</strong> {{ $task->due_date->format('d/m/Y 23:59') }}</p>
<p style="margin-top: 10px;">{{ $task->description }}</p>

<h3 style="margin-top: 25px;">Estatus de Entregas</h3>

<table>
    <thead>
        <tr>
            <th>Alumno</th>
            <th>Estatus</th>
            <th>Evidencia</th>
            <th>Calificación (1-10)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        @php $sub = $submissions->get($student->id); @endphp
        <tr>
            <td>{{ $student->name }}</td>
            <td>
                @if($sub)
                    <span class="badge" style="background: var(--lavender)">Entregado</span>
                @else
                    <span class="badge" style="background: var(--almond-silk)">Pendiente</span>
                @endif
            </td>
            <td>
                @if($sub)
                    <a href="{{ asset('storage/' . $sub->file_path) }}" target="_blank" class="btn btn-secondary">PDF</a>
                @else
                    -
                @endif
            </td>
            <td>
                @if($sub)
                    @if($task->isExpired())
                        <form action="{{ route('teacher.submissions.grade', $sub->id) }}" method="POST" style="display:flex; gap: 5px;">
                            @csrf
                            <input type="number" name="score" min="1" max="10" value="{{ $sub->score }}" class="input-control" style="width: 70px; margin-bottom: 0;" required>
                            <button type="submit" class="btn">Guardar</button>
                        </form>
                    @else
                        <span>Disponible al vencer fecha</span>
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection