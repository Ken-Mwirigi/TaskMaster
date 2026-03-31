<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
     //Create Task
     
    public function store(CreateTaskRequest $request) // Uses the Bouncer
    {
        // If we got here, the data is already valid!
        $task = Task::create($request->validated());

        return response()->json(['success' => true, 'data' => $task], 201);
    }

      //List Tasks
     
    public function index(Request $request)
    {
        // 1. Validate the query parameter
        $request->validate([
            'status' => 'nullable|in:pending,in_progress,done'
        ]);

        $query = Task::query();

        // 2. Filter if status is provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // 3. Sort the tasks according to the business rules.
        $tasks = $query
            ->orderByRaw("CASE 
                WHEN priority = 'high' THEN 1 
                WHEN priority = 'medium' THEN 2 
                ELSE 3 
            END")
            ->orderBy('due_date', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tasks
        ], 200);
    }

    
      //Update Task Status
    
    public function updateStatus(UpdateTaskStatusRequest $request, $id) //  Uses the Bouncer
    {
        $task = Task::findOrFail($id);
        $newStatus = $request->status;

        $flow = ['pending' => 'in_progress', 'in_progress' => 'done'];

        if (!isset($flow[$task->status]) || $flow[$task->status] !== $newStatus) {
            return response()->json([
                'success' => false,
                'error' => "Invalid status transition from {$task->status} to {$newStatus}."
            ], 422);
        }

        $task->update(['status' => $newStatus]);
        return response()->json(['success' => true, 'data' => $task], 200);
    }

    
     // 4. Delete Task 
    
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if ($task->status !== 'done') {
            return response()->json(['success' => false, 'message' => 'Only completed tasks can be deleted.'], 403);
        }

        $task->delete();
        return response()->json(['success' => true, 'message' => 'Task deleted'], 200);
    }

     //Daily Report 
    
    public function report(Request $request)
    {
        $request->validate(['date' => 'required|date']);
        $date = $request->input('date');

        $tasks = Task::whereDate('due_date', $date)->get();
        $summary = [
            'high' => ['pending' => 0, 'in_progress' => 0, 'done' => 0],
            'medium' => ['pending' => 0, 'in_progress' => 0, 'done' => 0],
            'low' => ['pending' => 0, 'in_progress' => 0, 'done' => 0],
        ];

        foreach ($tasks as $task) { $summary[$task->priority][$task->status]++; }

        return response()->json(['success' => true, 'date' => $date, 'summary' => $summary], 200);
    }
}