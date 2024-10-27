<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Status;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        // Fetch all tickets sorted by the creation date (latest first)
        $tickets = Ticket::with('status', 'user')->orderBy('created_at', 'desc')->get();

        // Categorize tickets by status
        $openTickets = $tickets->where('status_id', 1); // Assuming 1 is for Open
        $inProgressTickets = $tickets->where('status_id', 2); // Assuming 2 is for In Progress
        $closedTickets = $tickets->where('status_id', 3); // Assuming 3 is for Closed

        return view('tickets.index', compact('openTickets', 'inProgressTickets', 'closedTickets'));
    }


    public function create()
    {
        $statuses = Status::all();
        $users = User::all();
        return view('tickets.create', compact('statuses', 'users'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
            'assigned_users' => 'array|nullable',
            'assigned_users.*' => 'exists:users,id', // Validate each assigned user ID
            'deadline' => 'nullable|date',
        ]);

        // Create the ticket
        $ticket = Ticket::create($validatedData);

        // Attach assigned users if they exist
        if (isset($validatedData['assigned_users'])) {
            $ticket->assignedUsers()->sync($validatedData['assigned_users']);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }


    public function show($id)
    {
        // Retrieve the ticket by ID, including relationships
        $ticket = Ticket::with('status', 'user', 'assignedUsers')->find($id);

        // Check if the ticket exists
        if (!$ticket) {
            return redirect()->route('tickets.index')->with('error', 'Ticket not found');
        }

        // Return the view with the ticket data
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $statuses = Status::all();
        $users = User::all();
        return view('tickets.edit', compact('ticket', 'statuses', 'users'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
            'user_id' => 'required|exists:users,id',
            'assigned_users' => 'array', // Allow multiple assigned users
            'assigned_users.*' => 'exists:users,id', // Validate each assigned user ID
            'deadline' => 'nullable|date',
        ]);

        // Update the ticket properties
        $ticket->update($validatedData);

        // Sync assigned users
        $ticket->assignedUsers()->sync($validatedData['assigned_users'] ?? []);

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }
}
