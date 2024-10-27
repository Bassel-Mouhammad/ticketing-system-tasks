<?php

namespace App\Http\Controllers\API;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Fetch all tickets with relationships to statuses, users, and assigned users
            $tickets = Ticket::with('status', 'user', 'assignedUsers')->get();
            return response()->json([
                "msg" => "All data retrieved successfully",
                "success" => true,
                "data" => $tickets
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status_id' => 'required|exists:statuses,id',
                'user_id' => 'required|exists:users,id',
                'assigned_users' => 'array', // Optional: ensure it's an array if present
                'assigned_users.*' => 'exists:users,id', // Ensure each user ID is valid
                'deadline' => 'nullable|date',
            ]);

            // Create a new ticket
            $ticket = Ticket::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'status_id' => $data['status_id'],
                'user_id' => $data['user_id'],
                'deadline' => $data['deadline'],
            ]);

            // Sync assigned users
            $ticket->assignedUsers()->sync($data['assigned_users'] ?? []);

            return response()->json([
                "msg" => "Ticket created successfully",
                "success" => true,
                "data" => $ticket
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Method to get a specific ticket by ID
    public function show($id)
    {
        try {
            // Find the ticket by ID or return a 404 error if not found
            $ticket = Ticket::with('status', 'user', 'assignedUsers')->findOrFail($id);

            // Return the ticket data as JSON
            return response()->json([
                'success' => true,
                'data' => $ticket
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Find the ticket by ID or return a 404 error if not found
            $ticket = Ticket::findOrFail($id);

            // Validate incoming request data
            $data = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'status_id' => 'sometimes|required|exists:statuses,id',
                'assigned_users' => 'array',
                'assigned_users.*' => 'exists:users,id',
                'deadline' => 'sometimes|nullable|date',
            ]);

            // Update ticket properties if provided
            $ticket->update(array_filter($data)); // Only update fields that are not null

            // Sync assigned users
            if (isset($data['assigned_users'])) {
                $ticket->assignedUsers()->sync($data['assigned_users']);
            }

            // Return a successful response with the updated ticket
            return response()->json([
                "msg" => "Ticket updated successfully",
                "success" => true,
                "data" => $ticket
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->delete();

            return response()->json([
                "msg" => "Ticket deleted successfully",
                "success" => true
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
