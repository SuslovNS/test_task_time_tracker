<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $duration = [];
        $totalTime = CarbonInterval::create(0,0,0,0,0,0,0);
        foreach ($this->tasks as $task) {
            if ($task->stop_time) {
                $start = Carbon::parse($task->begin_time);
                $end = Carbon::parse($task->stop_time);
                $duration[] = $end->diffAsCarbonInterval($start);
            }
            if ($task->begin_time and !$task->stop_time){
                $duration[] = Carbon::now(new DateTimeZone('Europe/Moscow'))->diffAsCarbonInterval($task->begin_time);
            }
        }
        foreach ($duration as $dur) {
            $totalTime->add($dur);
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'duration' => $totalTime->cascade()->forHumans(),
        ];
    }
}
