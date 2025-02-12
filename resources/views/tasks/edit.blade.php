@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <h2 class="mb-4">Edit Task</h2>

    <form action="/tasks/{{ $task->id }}/update" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required>{{ $task->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Task</button>
        <a href="/" class="btn btn-secondary">Back</a>
    </form>
@endsection
