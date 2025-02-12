@extends('layouts.app')

@section('title', 'All Task')

@section('content')
    <h2 class="mb-4">Task Manager</h2>

    <a href="/tasks/create" class="btn btn-primary mb-3">Add Task</a>

    <ul id="task-list" class="list-group">
        @foreach ($tasks as $task)
            <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $task->id }}">
                <span>
                    <input type="checkbox" onclick="toggleTask({{ $task->id }})"
                        {{ $task->is_completed ? 'checked' : '' }}>
                    {{ $task->title }} - {{ $task->description }}
                </span>
                <div>
                    <a href="/tasks/{{ $task->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                    <form action="/tasks/{{ $task->id }}/delete" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>

    <script>
        function toggleTask(id) {
            fetch(`/tasks/${id}/toggle`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(() => location.reload());
        }

        $(function() {
            $("#task-list").sortable({
                update: function(event, ui) {
                    let order = [];
                    $("#task-list li").each(function() {
                        order.push($(this).data("id"));
                    });
                    $.post("/tasks/reorder", {
                        order: order,
                        _token: "{{ csrf_token() }}"
                    });
                }
            }).disableSelection();
        });
    </script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection
