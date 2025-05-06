<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        try {
            $tasks = $request->user()->tasks()->latest()->get();

            return response()->json([
                'tasks' => $tasks
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch tasks.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Converts is_completed to boolean like "true" / "false" / "1" / "0" will be parsed to only true or false
            $request->merge([
                'is_completed' => filter_var($request->is_completed, FILTER_VALIDATE_BOOLEAN)
            ]);

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'is_completed' => 'nullable|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation error.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $task = $request->user()->tasks()->create([
                'title' => $request->title,
                'is_completed' => $request->is_completed,
            ]);

            return response()->json([
                'message' => 'Task created successfully.',
                'task' => $task
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create task.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $task = $request->user()->tasks()->find($id);

            if (!$task) {
                return response()->json(['message' => 'Task not found.'], 404);
            }

            // Converts is_completed to boolean like "true" / "false" / "1" / "0" will be parsed to only true or false
            $request->merge([
                'is_completed' => filter_var($request->is_completed, FILTER_VALIDATE_BOOLEAN)
            ]);

            $validator = Validator::make($request->all(), [
                'title' => 'sometimes|required|string|max:255',
                'is_completed' => 'nullable|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation error.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $task->update($request->only(['title', 'is_completed']));

            return response()->json([
                'message' => 'Task updated successfully.',
                'task' => $task
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update task.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $task = $request->user()->tasks()->find($id);

            if (!$task) {
                return response()->json(['message' => 'Task not found.'], 404);
            }

            $task->delete();

            return response()->json([
                'message' => 'Task deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete task.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
