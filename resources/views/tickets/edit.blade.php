@extends('layouts.app')

@section('title', 'Edit Ticket')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Edit Ticket</h1>

    <form action="{{ route('tickets.update', $ticket) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $ticket->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="4" required>{{ old('description', $ticket->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status_id" class="form-label">Status</label>
            <select class="form-select" name="status_id" id="status_id" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}" {{ $status->id == $ticket->status_id ? 'selected' : '' }}>{{ ucfirst($status->name) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Assigned User</label>
            <select class="form-select" name="user_id" id="user_id" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $ticket->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="date" class="form-control" name="deadline" id="deadline" value="{{ $ticket->deadline }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Ticket</button>
    </form>
</div>
@endsection
