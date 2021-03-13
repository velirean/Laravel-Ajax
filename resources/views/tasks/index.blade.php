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
@endsection
