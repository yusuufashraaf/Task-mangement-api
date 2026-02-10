<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

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

}