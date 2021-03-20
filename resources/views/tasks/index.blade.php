@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Lista de tareas</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <input type="text" name="description" id="description">
            <input type="button" class="crear btn btn-primary" value="Crear">
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>description</th>
                        <th>¿pendiente?</th>
                        <th>terminar</th>
                        <th>borrar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>
                                {{$task->id}}
                            </td>
                            <td>
                                {{$task->description}}
                            </td>
                            <td id="status_{{$task->id}}">
                                {{$task->is_done ? 'No' : 'Sí'}}
                            </td>
                            <td>
                                <button id="{{$task->id}}" class="terminar btn btn-success" type="button" value="Terminar">Terminar</button>
                            </td>
                            <td>
                                <button id="{{$task->id}}" class="borrar btn btn-danger" type="button" value="Terminar">Borrar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('layout_end_body')
<script>
    $('.crear').on('click', function() {
        let theDescription = $('#description').val();
        $.ajax({
            url: '{{ route('tasks.store') }}',
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                description: theDescription
            }
        })
        .done(function(response) {
            $('#description').val('');
            let id_res = response.id;
            let description = response.description

            $('.table tbody').append('<tr><td>' + id_res  +'</td><td>'+ description +'</td><td id="status_' + id_res + '">Sí</td>'
                + '<td><button id="'+ response.id +'" class="terminar btn btn-success" type="button">Terminar</button></td>'
                + '<td><button id="'+ response.id +'" class="borrar btn btn-danger" type="button">Borrar</button></td>'
                + '</tr>')

        })
        .fail(function(jqXHR, response) {
            console.log('Fallido', response);
        });
    });

    $('table').on('click', '.terminar', function() {
        let idTask = this.id;
        let task_url = '{{ route('tasks.update', 0) }}';
        task_url = task_url.replace('0', idTask);

        $.ajax({
            url: task_url,
            method: 'PUT',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: idTask
            }
        })
        .done(function(response) {

            let id_status = '#status_' + response.id;
            $(id_status).text('No');
        })
        .fail(function(jqXHR, response) {
            console.log('Fallido', response);
        });
    });

    $('table').on('click', '.borrar', function() {
        let idTask = this.id;
        let task_url = '{{ route('tasks.destroy', 0) }}';
        task_url = task_url.replace('0', idTask);
        let id_status = '#status_' + idTask;
        //console.log(idTask)
        $.ajax({
            url: task_url,
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: idTask
            }
        })
        .done(function(response) {
            //console.log(id_status);
            $(id_status).parent().remove();
        })
        .fail(function(jqXHR, response) {
            console.log('Fallido', response);
        });
    });
</script>
@endpush
