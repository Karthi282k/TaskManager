@extends('layouts.app')

@section('title', 'All Task')

@section('content')
    <h2 class="mb-4">Task Manager</h2>

    <a href="/tasks/create" class="btn btn-primary mb-3">Add Task</a>

    <!-- Filters -->
    <div class="mb-3">
    <a href="{{ route('tasks.index') }}"
       class="btn {{ request('filter') ? 'btn-outline-primary' : 'btn-primary' }}">
        All Tasks
    </a>
    <a href="{{ route('tasks.index', ['filter' => 'completed']) }}"
       class="btn {{ request('filter') === 'completed' ? 'btn-success' : 'btn-outline-success' }}">
        Completed
    </a>
    <a href="{{ route('tasks.index', ['filter' => 'pending']) }}"
       class="btn {{ request('filter') === 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
        Non-Completed
    </a>
    </div>


    <ul id="task-list" class="list-group">
        @foreach ($tasks as $task)
            <li class="list-group-item d-flex justify-content-between align-items-center task-item" 
                data-id="{{ $task->id }}" 
                data-status="{{ $task->is_completed ? 'completed' : 'pending' }}">

                <span>
                    <input type="checkbox" class="toggle-task" data-id="{{ $task->id }}" 
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
        // Function to toggle task completion
        document.querySelectorAll('.toggle-task').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const id = this.dataset.id;
                fetch(`/tasks/${id}/toggle`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => location.reload());
            });
        });

        // Function to filter tasks
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                let filter = this.dataset.filter;
                document.querySelectorAll('.task-item').forEach(item => {
                    if (filter === 'all' || item.dataset.status === filter) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Enable task reordering
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
