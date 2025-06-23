<?php

namespace App\Livewire;

use App\Http\Traits\HelperTrait;
use App\Models\Task;
use App\Models\Platform;
use Livewire\Component;

class Welcome extends Component
{
    use HelperTrait;
    public $tasks;
    public $popularPlatforms;

    public function mount()
    {
        $this->tasks = Task::with('user')
            ->where('is_active', true)
            ->latest()
            ->take(10)
            ->get()
            ->map(function($task) {
                $platform = $task->platform ? $task->platform->name : 'Uncategorized';
                $task->platform = $platform;
                $task->estimated_time = $this->getTimeConversion($task->expected_completion_minutes);
                   
                return $task;
            });

        // Get popular platforms with their job counts
        $this->popularPlatforms = Platform::withCount(['tasks' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderByDesc('tasks_count')
            ->take(8)
            ->get()
            ->map(function($platform) {
                return [
                    'name' => $platform->name,
                    'image' => $platform->image,
                    'color' => $platform->color ?? $this->getDefaultColor($platform->name),
                    'jobs_count' => $platform->tasks_count
                ];
            });
    }

    private function getDefaultColor($platformName)
    {
        $colors = [
            'Design & Creative' => 'blue',
            'Writing & Translation' => 'green',
            'Development & IT' => 'purple',
            'Marketing & Sales' => 'orange',
            'Customer Support' => 'red',
            'Data Entry & Admin' => 'indigo',
            'Video & Animation' => 'yellow',
            'Translation' => 'pink'
        ];

        return $colors[$platformName] ?? 'gray';
    }

    public function render()
    {
       return view('livewire.welcome');
    }
}
