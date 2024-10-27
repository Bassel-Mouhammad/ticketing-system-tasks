@extends('layouts.app')

@section('title', 'Tickets List')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Tickets List</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Create New Ticket</a>

    <div class="row">
        <div class="col-md-4">
            <h4>Open Tickets (Pending)</h4>
            @foreach ($openTickets as $ticket)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">ID: {{ $ticket->id }} - {{ $ticket->title }}</h5>
                        <p class="card-text">{{ Str::limit($ticket->description, 50) }}</p>
                        <p class="card-text"><strong>Status:</strong> {{ ucfirst(optional($ticket->status)->name) }}</p>
                        <p class="card-text"><strong>Assigned User:</strong> {{ optional($ticket->user)->name }}</p>
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-info">Details</a>
                        <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-md-4">
            <h4>In Progress Tickets</h4>
            @foreach ($inProgressTickets as $ticket)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">ID: {{ $ticket->id }} - {{ $ticket->title }}</h5>
                        <p class="card-text">{{ Str::limit($ticket->description, 50) }}</p>
                        <p class="card-text"><strong>Status:</strong> {{ ucfirst(optional($ticket->status)->name) }}</p>
                        <p class="card-text"><strong>Assigned User:</strong> {{ optional($ticket->user)->name }}</p>
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-info">Details</a>
                        <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-md-4">
            <h4>Closed Tickets (Finished)</h4>
            @foreach ($closedTickets as $ticket)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">ID: {{ $ticket->id }} - {{ $ticket->title }}</h5>
                        <p class="card-text">{{ Str::limit($ticket->description, 50) }}</p>
                        <p class="card-text"><strong>Status:</strong> {{ ucfirst(optional($ticket->status)->name) }}</p>
                        <p class="card-text"><strong>Assigned User:</strong> {{ optional($ticket->user)->name }}</p>
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-info">Details</a>
                        <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
