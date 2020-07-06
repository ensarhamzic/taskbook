<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class taskController extends Controller
{
    public function store(Request $request) {
        $id = $request->listId;
        $name = $request->listName;
        if(auth()->user()->lists->pluck('id')->contains($id)){
            $task = Task::create([
                'list_id' => $id,
                'name' => $name,
                'completed' => 0
            ]);
            return [$task->id, $task->name];
        }
    }
}
