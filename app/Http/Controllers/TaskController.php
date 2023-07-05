<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index($id)
    {
        $tasks = Task::where('project_id', $id)->get();
        return TaskResource::collection($tasks);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $task = Task::create($data);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error'=>$exception->getMessage()]);
        }
        return new TaskResource($task);
    }

    public function delete($taskId)
    {
        $task = Task::whereId($taskId)->first();
        try {
            DB::beginTransaction();
            $task->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['e'=>$exception->getMessage()]);
        }
        return response([]);
    }

    public function show($proj, $taskId)
    {
        $task = Task::whereId($taskId)->first();
        return new TaskResource($task);
    }

    public function update($proj, $taskId, UpdateRequest $request)
    {
        $data = $request->validated();
        $task = Task::whereId($taskId)->first();
        try {
            DB::beginTransaction();
            $task->update($data);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['e'=>$exception->getMessage()]);
        }
        return response([]);
    }

    public function start($proj, $taskId)
    {
        $task = Task::whereId($taskId)->first();
        $now = Carbon::now();
        try {
            DB::beginTransaction();
            $task->update([
                'begin_time' => $now
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['e'=>$exception->getMessage()]);
        }
        return response()->json(['message'=> 'Task begin at ' . $now]);
    }

    public function pause($proj, $taskId)
    {
        $task = Task::whereId($taskId)->first();
        $now = Carbon::now();
        try {
            DB::beginTransaction();
            $task->update([
                'pause_time' => $now
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['e'=>$exception->getMessage()]);
        }
        return response()->json(['message'=> 'Task paused at ' . $now]);
    }

    public function stop($proj, $taskId)
    {
        $task = Task::whereId($taskId)->first();
        $now = Carbon::now();
        try {
            DB::beginTransaction();
            $task->update([
                'stop_time' => $now
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['e'=>$exception->getMessage()]);
        }
        return response()->json(['message'=> 'Task stoped at ' . $now]);
    }
}
