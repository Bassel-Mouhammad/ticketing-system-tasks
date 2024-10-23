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
        $tickets = Ticket::with('status', 'user', 'assignedUsers')
            ->orderBy('created_at', 'desc') // Sort by created_at in descending order
            ->get();


        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $statuses = Status::all();
        $users = User::all();
        return view('tickets.create', compact('statuses', 'users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
            'user_id' => 'required|exists:users,id',
            'deadline' => 'nullable|date',
        ]);

        Ticket::create($validatedData);

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
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
            'user_id' => 'required|exists:users,id',
            'deadline' => 'nullable|date',
        ]);

        $ticket->update($validatedData);

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }
}
