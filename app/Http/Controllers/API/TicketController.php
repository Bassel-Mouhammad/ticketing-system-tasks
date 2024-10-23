<?php

namespace App\Http\Controllers\API;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminata\Response;
use App\http\controllers\API\Exception;
use Exception as GlobalException;

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
                "data " => $tickets
            ], 200);
        } catch (GlobalException $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $ticket = new Ticket();
            $ticket->title = $data['title'];
            $ticket->description = $data['description'];
            $ticket->status_id = $data['status_id'];
            $ticket->deadline = $data['deadline'];
            $ticket->assigned_user_id = $data['assigned_user_id'];
            $ticket->user_id = $data['user_id'];
            $ticket->save();

            // Sync assigned users
            $ticket->assignedUsers()->sync($data['assigned_users'] ?? []);

            return response()->json([
                "msg" => "Ticket created successfully",
                "success" => true,
                "data " => $ticket
            ], 201);
        } catch (GlobalException $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ], 500);
        }
    }


    // Method to get a specific ticket by ID
    public function show($id)
    {
        // Find the ticket by ID or return a 404 error if not found
        $ticket = Ticket::with('status', 'user', 'assignedUsers')->find($id);

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }

        // Return the ticket data as JSON
        return response()->json([
            'success' => true,
            'data' => $ticket
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Find the ticket by ID or return a 404 error if not found
            $ticket = Ticket::findOrFail($id);

            // Update ticket properties directly from the request
            $ticket->title = $request->title;
            $ticket->description = $request->description;
            $ticket->status_id = $request->status_id;
            $ticket->assigned_user_id = $request->assigned_user_id; // This can be null
            $ticket->deadline = $request->deadline;

            // Save the updated ticket
            $ticket->save();


            // Return a successful response with the updated ticket
            return response()->json([
                "msg" => "Ticket updated successfully",
                "success" => true,
                "data" => $ticket
            ], 200);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error message
            return response()->json([
                "msg" => $e->getMessage(),
                "success" => false,
                "data" => []
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
