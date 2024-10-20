@extends('layouts.app')

@section('title', 'Ticket Details')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Ticket Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ID: {{ $ticket->id }} - {{ $ticket->title }}</h5>
            <p class="card-text"><strong>Description:</strong> {{ $ticket->description }}</p>
            <p class="card-text"><strong>Status:</strong> {{ ucfirst(optional($ticket->status)->name) }}</p>
            <p class="card-text"><strong>Assigned User:</strong> {{ optional($ticket->user)->name }}</p>
            <p class="card-text"><strong>Deadline:</strong> {{ $ticket->deadline ?? 'No deadline' }}</p>
            <p class="card-text"><strong>Created At:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}</p>
            <p class="card-text"><strong>Updated At:</strong> {{ $ticket->updated_at->format('Y-m-d H:i') }}</p>

            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
