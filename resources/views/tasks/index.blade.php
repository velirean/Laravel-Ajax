@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Lista de tareas</h1>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <a class="btn btn-default" href="{{ route('tasks.create') }}">
            Crea una tarea
        </a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripción</th>
                    <th>¿Pendiente?</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr>
                    <td> {{ $task->id }} </td>
                    <td> {{ $task->description }}</td>
                    <td> {{ $task->is_done ? 'No' : 'Sí' }} </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
