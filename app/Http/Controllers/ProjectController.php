<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', auth()->id())->with('tasks')->get();
        return ProjectResource::collection($projects);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $data['user_id'] = auth()->id();
            $project = Project::create($data);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error'=>$exception->getMessage()]);
        }
        return new ProjectResource($project);
    }

    public function delete(Project $project)
    {
        $tasks = Task::where('project_id', $project->id)->get();
        if ($tasks) {
            foreach ($tasks as $task) {
                $task->delete();
            }
        }
        try {
            DB::beginTransaction();
            $project->delete();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['e'=>$exception->getMessage()]);
        }
        return response([]);
    }

    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    public function update(Project $project, UpdateRequest $request)
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $project->update($data);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['e'=>$exception->getMessage()]);
        }
        return response([]);
    }
}
