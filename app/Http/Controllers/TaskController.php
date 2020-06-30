<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use JWTAuth;

class TaskController extends Controller
{
    protected $user;

    public function __construct(){
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        $tasks = $this->user->tasks()->get(['id', 'title', 'details', 'created_by'])->toArray();

        return $tasks;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'details' => 'required'
        ]);

        $task = new Task();
        $task->title = $request->title;
        $task->details = $request->details;

        if($this->user->tasks()->save($task)){
            return response()->json([
               'status' => true,
               'task' => $task
            ]);
        }
        else{
            return response()->json([
               'status' => false,
               'message' => 'Ops, task could not be saved'
            ], 500);
        }
    }

    public function show(Task $task)
    {
        //
    }

    public function edit(Task $task)
    {
        //
    }

    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'title' => 'required',
            'details' => 'required'
        ]);

        $task->title = $request->title;
        $task->details = $request->details;

        if($this->user->tasks()->save($task)){
            return response()->json([
                'status' => true,
                'task' => $task
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Ops, task could not be updated'
            ], 500);
        }
    }

    public function destroy(Task $task)
    {
        if($task->delete()){
            return response()->json([
               'status' => true,
               'task' => $task
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Ops, task could not be deleted'
            ]);
        }
    }
}
