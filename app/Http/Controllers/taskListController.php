<?php

namespace App\Http\Controllers;

use App\TaskList;
use App\User;
use Illuminate\Http\Request;

class taskListController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'name' => "string|required|max:25",
        ]);
        $user = auth()->user()->id;
        $newTaskList = TaskList::create([
            'user_id' => $user,
            'name' => $validated['name']
        ]);

        $newTaskListId = $newTaskList['id'];

        return [$validated['name'], $newTaskListId];
    }

    public function show(Request $request) {
        $id = $request->listId;
        if(auth()->user()->lists->pluck('id')->contains($id)){
            $list = TaskList::find($id);
            return $list->tasks;
        }
    }

    public function delete(Request $request) {
        $id = $request->deleteId;
        if(auth()->user()->lists->pluck('id')->contains($id)) {
            TaskList::find($id)->delete();
            return $id;
        }
    }
}
