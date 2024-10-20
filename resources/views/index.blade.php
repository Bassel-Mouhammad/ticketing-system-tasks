@extends('layouts.app')

@section('title', 'Tickets Dashboard')

@section('content')
<h1 class="text-center mb-4">Tickets Dashboard</h1>
<div class="row">
    <!-- Open Tickets Column -->
    <div class="col-md-4">
        <h3 class="text-success">Open Tickets (Pending)</h3>
        @if($tickets->where('status.name', 'pending')->isEmpty())
            <p>No open tickets at the moment.</p>
        @else
            @foreach ($tickets->where('status.name', 'pending') as $ticket)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">ID: {{ $ticket->id }} - {{ $ticket->title }}</h5>
                        <p class="card-text"><strong>Description:</strong> {{ $ticket->description }}</p>

                        <!-- Ensure status is not null -->
                        <p class="card-text"><strong>Status:</strong>
                            <span class="badge bg-success">{{ ucfirst(optional($ticket->status)->name) ?? 'Unknown' }}</span>
                        </p>

                        <!-- Ensure user is not null -->
                        <p class="card-text"><strong>Created By:</strong> {{ optional($ticket->user)->name ?? 'Unknown' }}</p>

                        <p class="card-text"><strong>Assigned Users:</strong>
                            @if($ticket->assignedUsers->isNotEmpty())
                                @foreach ($ticket->assignedUsers as $assignedUser)
                                    <span class="badge bg-primary">{{ $assignedUser->name }}</span>
                                @endforeach
                            @else
                                <span>No assigned users</span>
                            @endif
                        </p>

                        <p class="card-text"><strong>Deadline:</strong> {{ $ticket->deadline ?? 'No deadline' }}</p>
                        <p class="card-text"><strong>Created At:</strong> {{ $ticket->created_at ? $ticket->created_at->format('Y-m-d H:i') : 'Not available' }}</p>
                        <p class="card-text"><strong>Updated At:</strong> {{ $ticket->updated_at ? $ticket->updated_at->format('Y-m-d H:i') : 'Not available' }}</p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- In Progress Tickets Column -->
    <div class="col-md-4">
        <h3 class="text-warning">In Progress Tickets</h3>
        @if($tickets->where('status.name', 'ongoing')->isEmpty())
            <p>No in progress tickets at the moment.</p>
        @else
            @foreach ($tickets->where('status.name', 'ongoing') as $ticket)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">ID: {{ $ticket->id }} - {{ $ticket->title }}</h5>
                        <p class="card-text"><strong>Description:</strong> {{ $ticket->description }}</p>

                        <!-- Ensure status is not null -->
                        <p class="card-text"><strong>Status:</strong>
                            <span class="badge bg-warning">{{ ucfirst(optional($ticket->status)->name) ?? 'Unknown' }}</span>
                        </p>

                        <!-- Ensure user is not null -->
                        <p class="card-text"><strong>Created By:</strong> {{ optional($ticket->user)->name ?? 'Unknown' }}</p>

                        <p class="card-text"><strong>Assigned Users:</strong>
                            @if($ticket->assignedUsers->isNotEmpty())
                                @foreach ($ticket->assignedUsers as $assignedUser)
                                    <span class="badge bg-primary">{{ $assignedUser->name }}</span>
                                @endforeach
                            @else
                                <span>No assigned users</span>
                            @endif
                        </p>

                        <p class="card-text"><strong>Deadline:</strong> {{ $ticket->deadline ?? 'No deadline' }}</p>
                        <p class="card-text"><strong>Created At:</strong> {{ $ticket->created_at ? $ticket->created_at->format('Y-m-d H:i') : 'Not available' }}</p>
                        <p class="card-text"><strong>Updated At:</strong> {{ $ticket->updated_at ? $ticket->updated_at->format('Y-m-d H:i') : 'Not available' }}</p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Closed Tickets Column -->
    <div class="col-md-4">
        <h3 class="text-secondary">Closed Tickets (Finished)</h3>
        @if($tickets->where('status.name', 'finished')->isEmpty())
            <p>No closed tickets at the moment.</p>
        @else
            @foreach ($tickets->where('status.name', 'finished') as $ticket)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">ID: {{ $ticket->id }} - {{ $ticket->title }}</h5>
                        <p class="card-text"><strong>Description:</strong> {{ $ticket->description }}</p>

                        <!-- Ensure status is not null -->
                        <p class="card-text"><strong>Status:</strong>
                            <span class="badge bg-secondary">{{ ucfirst(optional($ticket->status)->name) ?? 'Unknown' }}</span>
                        </p>

                        <!-- Ensure user is not null -->
                        <p class="card-text"><strong>Created By:</strong> {{ optional($ticket->user)->name ?? 'Unknown' }}</p>

                        <p class="card-text"><strong>Assigned Users:</strong>
                            @if($ticket->assignedUsers->isNotEmpty())
                                @foreach ($ticket->assignedUsers as $assignedUser)
                                    <span class="badge bg-primary">{{ $assignedUser->name }}</span>
                                @endforeach
                            @else
                                <span>No assigned users</span>
                            @endif
                        </p>

                        <p class="card-text"><strong>Deadline:</strong> {{ $ticket->deadline ?? 'No deadline' }}</p>
                        <p class="card-text"><strong>Created At:</strong> {{ $ticket->created_at ? $ticket->created_at->format('Y-m-d H:i') : 'Not available' }}</p>
                        <p class="card-text"><strong>Updated At:</strong> {{ $ticket->updated_at ? $ticket->updated_at->format('Y-m-d H:i') : 'Not available' }}</p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
