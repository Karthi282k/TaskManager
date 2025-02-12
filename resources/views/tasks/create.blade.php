@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
    <h2 class="mb-4">Add New Task</h2>
    <form action="/tasks" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Create Task</button>
        <a href="/" class="btn btn-secondary">Back</a>
    </form>
@endsection
