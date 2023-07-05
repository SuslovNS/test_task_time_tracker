<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        foreach ($this->tasks as $task) {
            $start = Carbon::parse($task->begin_time);
            $end = Carbon::parse($task->stop_time);
            $duration[] = $start->diffForHumans($end);
        }
//        $first = Carbon::createFromTimeString('00:00:00');
//        foreach ($duration as $dur) {
//            $first->add($dur)->diffInMinutes();
//        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'duration' => $duration,
        ];
    }
}
