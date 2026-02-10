<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    //
    public function index(Request $request)
{
    $user = auth()->user();

    $query = Task::query();

    if ($user->role === 'member') {
        $query->where(function($q) use ($user){
            $q->where('created_by', $user->id)
              ->orWhere('assigned_to', $user->id);
        });
    }

    if ($request->status) $query->where('status', $request->status);

    return $query->get();
}

public function store(Request $request)
{
    $request->validate([
        'title'=>'required',
        'assigned_to'=>'nullable|exists:users,id'
    ]);

    if ($request->assigned_to) {
        $user = User::findOrFail($request->assigned_to);
        if ($user->tenant_id !== app('tenant')->id) {
            return response()->json(['error'=>'Cross tenant assignment forbidden'], 403);
        }
    }

    $task = Task::create([
        'title'=>$request->title,
        'description'=>$request->description,
        'status'=>$request->status ?? 'pending',
        'due_date'=>$request->due_date,
        'assigned_to'=>$request->assigned_to,
        'tenant_id'=>app('tenant')->id,
        'created_by'=>auth()->id()
    ]);

    return $task;
}


}