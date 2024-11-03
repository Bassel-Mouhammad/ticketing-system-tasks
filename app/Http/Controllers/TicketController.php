<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $tickets = Ticket::with(['status', 'user', 'assignedUsers'])
            ->orderBy('created_at', 'desc')
            ->get();

        $openTickets = $tickets->where('status_id', 1);
        $inProgressTickets = $tickets->where('status_id', 2);
        $closedTickets = $tickets->where('status_id', 3);

        return view('tickets.index', compact('openTickets', 'inProgressTickets', 'closedTickets'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $statuses = Status::all();
        $users = User::all();
        return view('tickets.create', compact('statuses', 'users'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
            'assigned_users' => 'array|nullable',
            'assigned_users.*' => 'exists:users,id',
            'deadline' => 'nullable|date',
        ]);

        $ticket = Ticket::create($validatedData);

        if (isset($validatedData['assigned_users'])) {
            $ticket->assignedUsers()->sync($validatedData['assigned_users']);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $ticket = Ticket::with('status', 'user', 'assignedUsers')->find($id);

        if (!$ticket) {
            return redirect()->route('tickets.index')->with('error', 'Ticket not found');
        }

        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $statuses = Status::all();
        $users = User::all();
        return view('tickets.edit', compact('ticket', 'statuses', 'users'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
            'user_id' => 'required|exists:users,id',
            'assigned_users' => 'array',
            'assigned_users.*' => 'exists:users,id',
            'deadline' => 'nullable|date',
        ]);

        $ticket->update($validatedData);
        $ticket->assignedUsers()->sync($validatedData['assigned_users'] ?? []);

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }
}
